<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WPDesk_Apaczka_Shipping' ) ) {
	class WPDesk_Apaczka_Shipping extends WC_Shipping_Method {
		
		public $api = false;
		
		static $services = array();

		/**
		 * Constructor for your shipping class
		 *
		 * @access public
		 * @return void
		 */
		public function __construct( $instance_id = 0 ) {
			$this->instance_id 			     	= absint( $instance_id );
			$this->id                 			= 'apaczka';
			
			self::$services = array(					
				'UPS_K_STANDARD' 	=> __( 'UPS Standard', 'apaczka' ), 
				'DHLSTD'			=> __( 'DHL Standard', 'apaczka' ), 
				'KEX_EXPRESS'		=> __( 'K-EX Express', 'apaczka' ), 
				'DPD_CLASSIC'		=> __( 'DPD', 'apaczka' ), 
				'FEDEX'		=> __( 'FedEx', 'apaczka' ), 
				'TNT'		=> __( 'TNT', 'apaczka' ), 
				'POCZTA_POLSKA_E24'	=> __( 'Pocztex 24', 'apaczka' ),
			);
			
			$this->method_title       			= __( 'Apaczka', 'apaczka' );
			$this->method_description 			= __( 'Apaczka', 'apaczka' );
			$this->method_description = __(' Zarejestruj się na <a href="https://www.apaczka.pl/register.php?create_account_company&promo_code=WooCommerce" target="_blank">www.apaczka.pl &rarr;</a>', 'apaczka'); //
			/* woo 2.6 ?
			$this->supports              = array(
					'shipping-zones' 	=> false,
					'instance-settings' => true,
					'settings' 			=> false						
			);
			*/
			$this->enabled		    = $this->get_option( 'enabled' );
			$this->title            = $this->get_option( 'title' );
						
			$this->init();

			add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );

			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );
			
			add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'woocommerce_checkout_update_order_meta' ), 100, 2 );
			
			add_action( 'save_post', array( $this, 'save_post' ) );

		}

		/**
		 * Init your settings
		 *
		 * @access public
		 * @return void
		 */
		function init() {

			// Load the settings API
			$this->init_form_fields(); 
			$this->init_settings(); 

			// Define user set variables
			$this->title        		= $this->get_option( 'title' );
			$this->tax_status   		= $this->get_option( 'tax_status' );
			
			$this->login            	= $this->get_option( 'login' );
			$this->password         	= $this->get_option( 'password' );
			$this->api_key         		= $this->get_option( 'api_key' );							
			$this->test_mode         	= $this->get_option( 'test_mode' );
			
			$this->cost         		= $this->get_option( 'cost' );
			$this->cost_cod        		= $this->get_option( 'cost_cod' );

		}	
		
		/**
		 * Initialise Settings Form Fields
		 */
		public function init_form_fields() {
			$this->form_fields = include( 'settings-apaczka.php' );
			// 2.6 ?
			//$this->instance_form_fields = include( 'settings-apaczka.php' );
		}
		
		public function get_api() {
			if ( $this->api === false ) {
				if ( $this->login != '' && $this->password != '' && $this->api_key != ''  ) {
					$this->api = new apaczkaApi( $this->login, $this->password, $this->api_key, $this->test_mode == 'yes' );					
				}
			}
			return $this->api;
		}
		
		public function display_errors_config() {			
			$class = 'notice notice-error';
			try {
				$api = $this->get_api();
				//$countries = $api->getCountries();
				//print_r( $countries );
			}
			catch ( Exception $e ) {
				$message = __( 'Błąd połączenia z API Apaczka.', 'apaczka' );
				$message .=  ' ' . $e->getMessage();
				printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
				$api = false;
			}
			if ( $api !== false ) {
				try {
					$validate = $api->parse_return( $api->validateAuthData() );
					if ( $validate['return']['isValid'] != '1' ) {
						$message = __( 'Błąd połączenia z API Apaczka.', 'apaczka' );
						$message .=  ' ' . $validate['return']['result']['messages']['Message']['description'];
						//$message .=  ' ' . print_r($validate,true);
						printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
					}
				}
				catch ( Exception $e ) {
					$message = __( 'Błąd połączenia z API Apaczka.', 'apaczka' );
					$message .=  ' ' . $e->getMessage();
					printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
				}				
			}
		}
		
		public function generate_settings_html( $form_fields = array(), $echo = true ) {			
			parent::generate_settings_html( $form_fields );
			$this->display_errors_config();
		}
		
		public function add_meta_boxes( $post_type, $post ) {
			if ( $post->post_type == 'shop_order' ) {
				$order_id = $post->ID;
				$order = wc_get_order( $post->ID );
				$apaczka = get_post_meta($order_id, '_apaczka', true );
				if ( $apaczka == '' ) {
					$data = array(
							'service' 			=> $this->get_option( 'service', '' ),
							'package_width'		=> $this->get_option( 'package_width', '' ),
							'package_depth'		=> $this->get_option( 'package_depth', '' ),
							'package_height'	=> $this->get_option( 'package_height', '' ),
							'package_weight'	=> $this->get_option( 'package_weight', '' ),
							'package_contents'	=> $this->get_option( 'package_contents', '' ),
							'cod_amount'		=> '',
							'insurance'			=> $this->get_option( 'insurance', '' ),
							'pickup_date'		=> '',
							'pickup_hour_from'	=> $this->get_option( 'pickup_hour_from', '' ),
							'pickup_hour_to'	=> $this->get_option( 'pickup_hour_to', '' ),
					);
					if ( $order->payment_method == 'cod' ) {
						$data['cod_amount'] = $order->get_total();
						$data['insurance'] = 'yes';
					}
					$apaczka[1] = $data;						
				}
				if ( $apaczka != '' ) {
					foreach ( $apaczka as $id => $data ) { 
						add_meta_box( 
								'apaczka_' . $id,
								__('Apaczka', 'woocommerca-apaczka' ),
								array( $this, 'order_metabox' ),
								'shop_order',
								'side',
								'default',
								array( 'id' => $id, 'data' => $data )
						);
					}
				}
			}
		}
		
		public function order_metabox( $post, $metabox_data ) {
			self::order_metabox_content( $post, $metabox_data );
		}
		
		public static function order_metabox_content( $post, $metabox_data, $output = true ) {
			if ( ! $output ) ob_start();
		
			$order_id = $post->ID;
		
			$order = wc_get_order( $order_id );
		
			$apaczka = $metabox_data['args']['data'];
			$id = $metabox_data['args']['id'];
			
			$services = self::$services;
			
			$package_send = false;
			
			if ( isset( $apaczka['apaczka_order'] ) ) {
				$package_send = true;
				$url_waybill = admin_url('admin-ajax.php?action=apaczka&apaczka_action=get_waybill&security=' . wp_create_nonce('apaczka_ajax_nonce') . '&apaczka_order_id=' . $apaczka['apaczka_order']['id'] );
			}
			
			$options_hours = array(
			);
			for ( $h = 9; $h < 20; $h++ ) {
				$options_hours[$h . ':00'] = $h . ':00';
				if ( $h < 19 ) {
					$options_hours[$h . ':30'] = $h . ':30';
				}
			}
			
			wp_nonce_field( plugin_basename( __FILE__ ), 'apaczka_nonce' );
			include( 'views/html-order-metabox.php' );
			
			if ( ! $output ) {
				$out = ob_get_clean();
				return $out;
			}						
		}
		
		public function save_post( $post_id ) {
			// verify if this is an auto save routine.
			// If it is our form has not been submitted, so we dont want to do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times
			if ( ( isset ( $_POST['apaczka_nonce'] ) ) && ( ! wp_verify_nonce( $_POST['apaczka_nonce'], plugin_basename( __FILE__ ) ) ) ) return;
			// Check permissions
			if ( ( isset ( $_POST['post_type'] ) ) && ( 'shop_order' != $_POST['post_type'] )  ) {
				return;
			}
			// OK, we're authenticated: we need to find and save the data
			if ( isset ( $_POST['_apaczka'] ) ) {
				$apaczka_post = $_POST['_apaczka'];
				$_apaczka = get_post_meta( $post_id, '_apaczka', true );
				if ( $_apaczka != '' ) {
					foreach ( $_apaczka as $id => $data ) {
						if ( empty( $data['apaczka_order'] ) ) {
							$_apaczka[$id] = $apaczka_post[$id];
						}
					}
				}
				else {
					$_apaczka = $apaczka_post;
				}
				update_post_meta( $post_id, '_apaczka', $_apaczka );
			}
		}
		
		public function woocommerce_checkout_update_order_meta( $order_id, $posted ) {
			$order = new WC_Order( $order_id );
			$shippings = $order->get_shipping_methods();
			$apaczka = array();
			foreach ( $shippings as $id => $shipping ) {
				if ( $shipping['method_id'] ==  $this->id  || $shipping['method_id'] == $this->id . '_cod' ) {
					$data = array( 
							'service' 			=> $this->get_option( 'service', '' ),
							'package_width'		=> $this->get_option( 'package_width', '' ),
							'package_depth'		=> $this->get_option( 'package_depth', '' ),
							'package_height'	=> $this->get_option( 'package_height', '' ),
							'package_weight'	=> $this->get_option( 'package_weight', '' ),
							'package_contents'	=> $this->get_option( 'package_contents', '' ),
							'cod_amount'		=> '',
							'insurance'			=> $this->get_option( 'insurance', '' ),
							'pickup_date'		=> '',
							'pickup_hour_from'	=> $this->get_option( 'pickup_hour_from', '' ),
							'pickup_hour_to'	=> $this->get_option( 'pickup_hour_to', '' ),
					);										
					if ( $order->payment_method == 'cod' ) {
						$data['cod_amount'] = $order->get_total();
						$data['insurance'] = 'yes';
					}
					$apaczka[$id] = $data;
				}
			}
			if ( ! empty( $apaczka ) ) {
				update_post_meta( $order_id, '_apaczka', $apaczka );
			}
		}
		
		
		public static function ajax_create_package() {

			$ret = array( 'status' => 'ok' );

			$order_id = $_POST['order_id'];
			$order = wc_get_order( $order_id );
			$post = get_post( $order_id );
			$id = $_POST['id'];
			
			$_apaczka = get_post_meta( $order_id, '_apaczka', true );
			
			$data = $_apaczka[$id];
			
			$data['service']			= $_POST['service'];
			$data['package_width']		= $_POST['package_width'];
			$data['package_depth']		= $_POST['package_depth'];
			$data['package_height']		= $_POST['package_height'];
			$data['package_weight']		= $_POST['package_weight'];
			$data['package_contents']	= $_POST['package_contents'];			
			$data['cod_amount']			= $_POST['cod_amount'];
			$data['insurance']			= $_POST['insurance'];
			$data['pickup_date']		= $_POST['pickup_date'];
			$data['pickup_hour_from']	= $_POST['pickup_hour_from'];
			$data['pickup_hour_to']		= $_POST['pickup_hour_to'];
			
			if ( $data['cod_amount'] != '' ) {
				$data['insurance'] = 'yes';
			}
			
			$_apaczka[$id] = $data;
			
			update_post_meta( $order_id, '_apaczka', $_apaczka );
			
			$shipping_methods = WC()->shipping()->get_shipping_methods();
			if ( empty( $shipping_methods ) ) $shipping_methods = WC()->shipping()->load_shipping_methods();
			$shipping_method = $shipping_methods['apaczka'];

			$apaczka_order = new ApaczkaOrder();
			
			$apaczka_order->notificationDelivered = $apaczka_order->createNotification( false, false, true, false );
			$apaczka_order->notificationException = $apaczka_order->createNotification( false, false, true, false );
			$apaczka_order->notificationNew = $apaczka_order->createNotification( false, false, true, false );
			$apaczka_order->notificationSent = $apaczka_order->createNotification( false, false, true, false );
			
			// Zamowienie kuriera
			$apaczka_order->setPickup( 'COURIER', $data['pickup_hour_from'], $data['pickup_hour_to'], $data['pickup_date'] );
			
			$order_shipment = new ApaczkaOrderShipment( 'PACZ', $data['package_width'], $data['package_depth'], $data['package_height'], $data['package_weight'] );
			
			if ( $data['insurance'] == 'yes' ) {
				$order_shipment->addOrderOption( 'UBEZP' );
				$order_shipment->setShipmentValue( floatval( $order->get_total() ) * 100 );
			}
			
			
			$apaczka_order->referenceNumber = sprintf( __( 'Zamówienie %s', 'apaczka' ), $order->get_order_number() );
			
			$shipping_name = $order->shipping_company;
			$shipping_contact = '';
			if ( $shipping_name == '' ) {
				$shipping_name = $order->shipping_first_name . ' ' . $order->shipping_last_name;
				$shipping_contact = $order->shipping_first_name . ' ' . $order->shipping_last_name;
				
			}
			else {
				$shipping_contact = $order->shipping_first_name . ' ' . $order->shipping_last_name;
			}
			
			$apaczka_api = $shipping_method->get_api();
			
			$countries = $apaczka_api->getCountriesFromCache();
			
			$shipping_country_id = 0;
						
			if ( $order->shipping_address_1 || $order->shipping_address_2 ) {
				foreach ( $countries->return->countries->Country as $country  ) {
					if ( $country->code == $order->shipping_country ) {
						$shipping_country_id = $country->id;
					}
				}
				$shipping_name = $order->shipping_company;
				$shipping_contact = '';
				if ( $shipping_name == '' ) {
					$shipping_name = $order->shipping_first_name . ' ' . $order->shipping_last_name;
					$shipping_contact = $order->shipping_first_name . ' ' . $order->shipping_last_name;
						
				}
				else {
					$shipping_contact = $order->shipping_first_name . ' ' . $order->shipping_last_name;
				}
				$apaczka_order->setReceiverAddress(
						$shipping_name, $shipping_contact,
						$order->shipping_address_1,
						$order->shipping_address_2,
						$order->shipping_city,
						$shipping_country_id,
						$order->shipping_postcode,
						'',
						$order->billing_email,
						$order->billing_phone
						);
			}
			else {
				foreach ( $countries->return->countries->Country as $country  ) {
					if ( $country->code == $order->billing_country ) {
						$shipping_country_id = $country->id;
					}
				}
				$shipping_name = $order->billing_company;
				$shipping_contact = '';
				if ( $shipping_name == '' ) {
					$shipping_name = $order->billing_first_name . ' ' . $order->billing_last_name;
					$shipping_contact = $order->billing_first_name . ' ' . $order->billing_last_name;
						
				}
				else {
					$shipping_contact = $order->billing_first_name . ' ' . $order->billing_last_name;
				}
				$apaczka_order->setReceiverAddress(
						$shipping_name, $shipping_contact,
						$order->billing_address_1,
						$order->billing_address_2,
						$order->billing_city,
						$shipping_country_id,
						$order->billing_postcode,
						'',
						$order->billing_email,
						$order->billing_phone
						);
			}
			
			$apaczka_order->setSenderAddress(
					$shipping_method->get_option( 'sender_name' ), 
					$shipping_method->get_option( 'sender_contact_name' ), 
					$shipping_method->get_option( 'sender_address_line1' ), 
					$shipping_method->get_option( 'sender_address_line2' ), 
					$shipping_method->get_option( 'sender_city' ), 
					'0', /* PL */ 
					$shipping_method->get_option( 'sender_postal_code' ), 
					'', 
					$shipping_method->get_option( 'sender_email' ), 
					$shipping_method->get_option( 'sender_phone' )
			);			
			
			$apaczka_order->contents = $data['package_contents'];
			
			try {
				
				$apaczka_order->setServiceCode( $data['service'] );
				
				if ( $data['cod_amount'] != '' ) {
					$apaczka_order->setPobranie( $shipping_method->get_option( 'sender_account_number' ) , floatval( $data['cod_amount'] ) * 100 );
					$order_shipment->addOrderOption( 'UBEZP' );
					$order_shipment->setShipmentValue( floatval( $order->get_total() ) * 100 );					
				}				
				
				$apaczka_order->addShipment($order_shipment);
				
				$apaczka_response = $apaczka_api->placeOrder( $apaczka_order );			
				$apaczka_response = $apaczka_api->parse_return( $apaczka_response );
				$data['error_messages'] = '';
				if ( empty( $apaczka_response['return']['order'] ) || $apaczka_response['return']['order'] == '' ) {
					$messages = $apaczka_response['return']['result']['messages'];
					foreach ( $messages as $message ) {
						$data['error_messages'] .= $message['description'] . ', ';
					}
					$data['error_messages'] = trim( $data['error_messages'], ' ' );
					$data['error_messages'] = trim( $data['error_messages'], ',' );
				}
				else {
					$data['apaczka_order'] = $apaczka_response['return']['order'];
					$data['apaczka_order_number'] = $apaczka_response['return']['order']['orderNumber'];
				}
			
				$data['apaczka_response'] = $apaczka_response;
			}
			catch ( Exception $e ) {
				$data['error_messages'] = $e->getMessage();
			}
			
			$_apaczka[$id] = $data;
			
			$ret['apaczka_response'] = $apaczka_response; 
			
			update_post_meta( $order_id, '_apaczka', $_apaczka );
			
			$metabox_data = array( 'args' => array( 'id' => $id, 'data' => $data ) );

			if ( $ret['status'] == 'ok' ) {
				
				if ( $data['error_messages'] == '' ) {
					$order->add_order_note( __( 'Apaczka: przesyłka została utworzona', 'apaczka' ), false );
				}
				
				$metabox_content = array();								
				
				$ret['content'] = self::order_metabox_content( $post, $metabox_data, false );
			}
			echo json_encode( $ret );
			wp_die();
		}

		
		public static function ajax_get_waybill() {
			$apaczka_order_id = $_REQUEST['apaczka_order_id'];
			
			$shipping_methods = WC()->shipping()->get_shipping_methods();
			if ( empty( $shipping_methods ) ) $shipping_methods = WC()->shipping()->load_shipping_methods();
			$shipping_method = $shipping_methods['apaczka'];			
			
			$apaczka_api = $shipping_method->get_api();

			$waybill = $apaczka_api->getWaybillDocument( $apaczka_order_id );
			
			if ( isset( $waybill->return->waybillDocument ) ) {
				
				header( 'Content-type: application/pdf' );
				header( 'Content-Disposition: attachment; filename="apaczka_' . $apaczka_order_id . '.pdf"' );
				header( 'Content-Transfer-Encoding: binary' );
//				header( 'Content-Length: ' . filesize($file) );
//				header( 'Accept-Ranges: bytes' );
				
				echo $waybill->return->waybillDocument;
			}
			
			die();
		
		}

		function is_available( $package ) {
			
			if ( 'no' == $this->enabled ) {
				return false;
			}
				
			
			global $woocommerce;

            $is_available = true;
            
            if ( ( ( $woocommerce->customer->shipping_country <> 'PL') || ( $woocommerce->customer->get_country() <> 'PL' && empty( $woocommerce->customer->shipping_country ) ) ) ) {
                $is_available = false;
            }

            return apply_filters('woocommerce_shipping_' . $this->id . '_is_available', $is_available);
        }
		
		public function calculate_shipping( $package = array() ) {					
			$this->add_rate( array(
					'id'    		=> $this->id,
					'label' 		=> $this->title,
					'cost' 	 		=> $this->cost,
					'meta_data'		=> array( 
							'service' => $this->get_option( 'service' )
					)
			) );
			
			if ( isset( $this->cost_cod ) && $this->cost_cod != '' ) {
				$this->add_rate( array(
						'id'    		=> $this->id . '_cod',
						'label' 		=> $this->title . __(' (Za pobraniem)', 'apaczka' ),
						'cost' 	 		=> $this->cost_cod,
				) );				
			}
		}

	}
	
	class WPDesk_Apaczka_Shipping_COD extends WC_Shipping_Method {
		
		public function __construct( $instance_id = 0 ) {

			$this->instance_id 			     	= absint( $instance_id );
			$this->id                 			= 'apaczka_cod';
			
			$this->title 						= 'Apaczka (pobranie)';
			$this->enabled						= 'yes';
		
			$this->has_settings = false;
			
			$this->supports = array(
					'settings' => false
			);
		
		}
		
		public function set_title( $title ) {
			$this->title = $title;
		}
		
		public function calculate_shipping( $package = array() ) {
			
		}
		
	}
	
}
