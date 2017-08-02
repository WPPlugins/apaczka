<div id="apaczka_panel_<?php echo $id; ?>" class="panel woocommerce_options_panel apaczka_panel">
	<div class="options_group">
		
		<?php
			$key = '_apaczka[' . $id . '][service]';
			$value = '';
			if ( isset( $apaczka['service'] ) ) {
				$value = $apaczka['service'];
			}
			
			$custom_attributes = array();
			
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
		
			woocommerce_wp_select( array(
					'id'                => $key,
					'label'             => __( 'Usługa ', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'number',
					'options' 			=> $services,
					'value'				=> $value,
					'custom_attributes' => $custom_attributes
			));
			
		?>
		
		<h4><?php _e( 'Wymiary [cm]', 'apaczka' ); ?></h4>
		
		<?php 
			$key = '_apaczka[' . $id . '][package_width]';
			$value = '';
			if ( isset( $apaczka['package_width'] ) ) {
				$value = $apaczka['package_width'];
			}
			
			$custom_attributes = array(
					'step' 	=> '1',
					'min'	=> '0',
			);
			
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_text_input( array(
					'id'                => $key,
					'label'             => __( 'Długość ', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'number',
					'custom_attributes' => $custom_attributes,
					'data_type'         => 'number',
					'value'				=> $value
			));
			
		?>
		
		<?php 
			$key = '_apaczka[' . $id . '][package_depth]';
			$value = '';
			if ( isset( $apaczka['package_depth'] ) ) {
				$value = $apaczka['package_depth'];
			}
			
			$custom_attributes = array(
					'step' 	=> '1',
					'min'	=> '0',
			);
			
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_text_input( array(
					'id'                => $key,
					'label'             => __( 'Szerokość ', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'number',
					'custom_attributes' => $custom_attributes,
					'data_type'         => 'number',
					'value'				=> $value
			));
			
		?>
		
		<?php 
			$key = '_apaczka[' . $id . '][package_height]';
			$value = '';
			if ( isset( $apaczka['package_height'] ) ) {
				$value = $apaczka['package_height'];
			}
			
			$custom_attributes = array(
					'step' 	=> '1',
					'min'	=> '0',
			);
				
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
				
			woocommerce_wp_text_input( array(
					'id'                => $key,
					'label'             => __( 'Wysokość ', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'number',
					'custom_attributes' => $custom_attributes,
					'data_type'         => 'number',
					'value'				=> $value
			));
			
		?>
		
		<h4><?php _e( 'Waga paczki [kg]', 'apaczka' ); ?></h4>

		<?php 
			$key = '_apaczka[' . $id . '][package_weight]';
			$value = '';
			if ( isset( $apaczka['package_weight'] ) ) {
				$value = $apaczka['package_weight'];
			}
			
			$custom_attributes = array(
					'step' 	=> '1',
					'min'	=> '0',
					'max'	=> '30',
					'step'	=> 'any'
			);
				
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_text_input( array(
					'id'                => $key,
					'label'             => __( 'Waga ', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'number',
					'custom_attributes' => $custom_attributes,
					'data_type'         => 'number',
					'value'				=> $value
			));
			
		?>
		
		<h4><?php _e( 'Zawartość', 'apaczka' ); ?></h4>

		<?php 
			$key = '_apaczka[' . $id . '][package_contents]';
			$value = '';
			if ( isset( $apaczka['package_contents'] ) ) {
				$value = $apaczka['package_contents'];
			}
			
			$custom_attributes = array();
				
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_text_input( array(
					'id'                => $key,
					'label'             => __( 'Zawartość ', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'text',
					'data_type'         => 'text',
					'value'				=> $value,
					'custom_attributes'	=> $custom_attributes
			));
			
		?>

		<h4><?php _e( 'Pobranie', 'apaczka' ); ?></h4>

		<?php 
			$key = '_apaczka[' . $id . '][cod_amount]';
			$value = '';
			if ( isset( $apaczka['cod_amount'] ) ) {
				$value = $apaczka['cod_amount'];
			}
			
			$custom_attributes = array(
					'step' 	=> '1',
					'min'	=> '0',
					'step'  => 'any',
			);
				
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_text_input( array(
					'id'                => $key,
					'label'             => __( 'Kwota pobrania', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'number',
					'custom_attributes' => $custom_attributes,
					'data_type'         => 'number',
					'value'				=> $value
			));
			
		?>

		<h4><?php _e( 'Ubezpieczenie', 'apaczka' ); ?></h4>
		
		<?php
			$key = '_apaczka[' . $id . '][insurance]';
			$value = '';
			if ( isset( $apaczka['insurance'] ) ) {
				$value = $apaczka['insurance'];
			}
		
			$custom_attributes = array();
				
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_select( array(
					'id'                => $key,
					'label'             => __( 'Ubezpieczenie', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'number',
					'options' 			=> array(
							'yes' 	=> __( 'Tak', 'apaczka' ),
							'no' 	=> __( 'Nie', 'apaczka' ),
					),
					'value'				=> $value,
					'custom_attributes'	=> $custom_attributes
			));
			
		?>

		<h4><?php _e( 'Odbiór', 'apaczka' ); ?></h4>
		
		<?php
			$key = '_apaczka[' . $id . '][pickup_date]';
			$value = date_i18n( 'Y-m-d', current_time( 'timestamp' ) ); 
			if ( isset( $apaczka['pickup_date'] ) && $apaczka['pickup_date'] != '' ) {
				$value = $apaczka['pickup_date'];
			}
		
			$custom_attributes = array(
					'pattern' 	=> '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])',
					'maxlength'	=> '10',
			);
				
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_text_input( array(
					'id'                => $key,
					'label'             => __( 'Data odbioru', 'apaczka' ),
					'desc_tip'          => false,
					'class'				=> 'date-picker',
					'type'              => 'text',
					'custom_attributes' => $custom_attributes,
					'data_type'         => 'number',
					'value'				=> $value
			));			
		?>

		<?php
			$key = '_apaczka[' . $id . '][pickup_hour_from]';
			$value = '';
			if ( isset( $apaczka['pickup_hour_from'] ) ) {
				$value = $apaczka['pickup_hour_from'];
			}
		
			$custom_attributes = array(
			);
				
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_select( array(
					'id'                => $key,
					'label'             => __( 'Od godziny', 'apaczka' ),
					'desc_tip'          => false,
					'type'              => 'number',
					'custom_attributes' => $custom_attributes,
					'options'			=> $options_hours,
					'value'				=> $value
			));			
		?>

		<?php
			$key = '_apaczka[' . $id . '][pickup_hour_to]';
			$value = '';
			if ( isset( $apaczka['pickup_hour_to'] ) ) {
				$value = $apaczka['pickup_hour_to'];
			}
		
			$custom_attributes = array(
					'min' 		=> '0',
					'max'		=> '24',
			);
				
			if ( $package_send ) {
				$custom_attributes['disabled'] = 'disabled';
			}
			
			woocommerce_wp_select( array(
					'id'                => $key,
					'label'             => __( 'Do godziny', 'apaczka' ),
					'desc_tip'          => false,					
					'custom_attributes' => $custom_attributes,
					'options'			=> $options_hours,
					'value'				=> $value
			));			
		?>
		
		<hr />
		
		<?php if ( $package_send == false ) : ?>
			<button class="button-primary apaczka_send" data-apaczka-id="<?php echo $id; ?>"><?php _e( 'Nadaj paczkę', 'apaczka' ); ?></button>
			<span style="float:none;" class="spinner"></span>
			<?php if ( isset( $apaczka['error_messages'] ) && $apaczka['error_messages'] != '' ) : ?>
				<hr />
				<div class="apaczka_error">
					<?php _e( 'Wystąpiły błędy:', 'apaczka' ); ?> <?php echo $apaczka['error_messages']; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php if ( $package_send == true ) : ?>
			<?php _e( 'Numer nadania:', 'apaczka' ); ?> <strong><?php echo $apaczka['apaczka_order']['id']; ?></strong><br/>
			<?php _e( 'List przewozowy:', 'apaczka' ); ?> <a target="_blank" href="<?php echo $url_waybill; ?>"><strong><?php echo $apaczka['apaczka_order']['orderNumber']; ?></strong></a><br/>
		<?php endif; ?>
<?php /* ?>
		<pre>
			<?php print_r( $apaczka ); ?>
		</pre>
<?php /* */ ?>
	</div>
</div>
<script type="text/javascript">
	jQuery(".apaczka_send").click(function() {
		//console.log('Nadaj');

		if ( ! jQuery(this).closest("form")[0].checkValidity() ) {
			jQuery(this).closest("form")[0].reportValidity();
			//console.log('not valid');
			return false;
		}
		
		jQuery(this).attr('disabled', true);
		jQuery(this).parent().find(".spinner").addClass('is-active');

		var apaczka_id = jQuery(this).attr('data-apaczka-id'); 

		//console.log(apaczka_id);
		//console.log(jQuery('select[name="_apaczka[' + apaczka_id + '][service]"').val());
		
		var data = 	{
				action				: 'apaczka',
				apaczka_action		: 'create_package',
				security			: apaczka_ajax_nonce,
				order_id			: <?php echo $order_id; ?>,
				id					: apaczka_id,			
				service				: jQuery('select[name="_apaczka[' + apaczka_id + '][service]"').val(),	
				package_width		: jQuery('input[name="_apaczka[' + apaczka_id + '][package_width]"').val(),
				package_depth		: jQuery('input[name="_apaczka[' + apaczka_id + '][package_depth]"').val(),
				package_height		: jQuery('input[name="_apaczka[' + apaczka_id + '][package_height]"').val(),
				package_weight		: jQuery('input[name="_apaczka[' + apaczka_id + '][package_weight]"').val(),
				package_contents	: jQuery('input[name="_apaczka[' + apaczka_id + '][package_contents]"').val(),
				cod_amount			: jQuery('input[name="_apaczka[' + apaczka_id + '][cod_amount]"').val(),
				insurance			: jQuery('select[name="_apaczka[' + apaczka_id + '][insurance]"').val(),
				pickup_date			: jQuery('input[name="_apaczka[' + apaczka_id + '][pickup_date]"').val(),
				pickup_hour_from	: jQuery('select[name="_apaczka[' + apaczka_id + '][pickup_hour_from]"').val(),
				pickup_hour_to		: jQuery('select[name="_apaczka[' + apaczka_id + '][pickup_hour_to]"').val(),
		};
		
		//console.log('Nadaj 2');
		//console.log(ajaxurl);
		//console.log(data);
		
		jQuery.post(ajaxurl, data, function(response) {
			//console.log(response);
			if ( response != 0 ) {
				response = JSON.parse(response);
				//console.log(response);
				if (response.status == 'ok' ) {
                	jQuery("#apaczka_panel_<?php echo $id; ?>").replaceWith(response.content);
                	return false;
				}
				else {
					//console.log(response);
					jQuery('#apaczka_error').html(response.message);
				}
			}
			else {
				//console.log('Invalid response.');
				jQuery('#apaczka_error').html('Invalid response.');
			}
			jQuery(this).parent().find(".spinner").removeClass('is-active');
			jQuery('#easypack_send_parcels').attr('disabled',false);
		});
		
		return false;
	});
</script>