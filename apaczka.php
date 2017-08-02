<?php
/*
	Plugin Name: Apaczka.pl WooCommerce
	Plugin URI: https://wordpress.org/plugins/apaczka
	Description: Zintegruj WooCommerce z Apaczka.pl. Dzięki integracji, możesz skorzystać z promocyjnej oferty na usługi UPS, DHL, K-EX, DPD, TNT, FedEx i Pocztex 24.
	Version: 1.2.1
	Author: Inspire Labs
	Author URI: https://inspirelabs.pl/
	Text Domain: apaczka
	Domain Path: /languages/
	Tested up to: 4.7

	Copyright 2016 Inspire Labs sp. z o.o.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/


if (!defined('ABSPATH')) exit; // Exit if accessed directly


if (!class_exists('inspire_Plugin4')) {
    require_once('classes/inspire/plugin4.php');
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	class WPDesk_Apaczka_Plugin extends inspire_Plugin4 {

		protected $_pluginNamespace = 'apaczka';

		protected $shipping_methods = array();

		public function __construct()
		{
			parent::__construct();
			add_action('plugins_loaded', array( $this, 'init_apaczka' ), 1000 );
		}

		public function init_apaczka() {

			require_once('classes/apaczka-api.php');

			require_once('classes/shipping-method.php');

			require_once('classes/ajax.php');

			$this->shipping_methods['apaczka'] = new WPDesk_Apaczka_Shipping();
			$this->shipping_methods['apaczka_cod'] = new WPDesk_Apaczka_Shipping_COD();
			$this->shipping_methods['apaczka_cod']->set_title( $this->shipping_methods['apaczka']->title . __(' (Za pobraniem)', 'apaczka' ) );

			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'), 75 );

			add_action( 'admin_notices', array( $this, 'admin_notices' ) );

			add_filter( 'woocommerce_shipping_methods', array( $this, 'woocommerce_shipping_methods' ), 20, 1 );

		}

		public function woocommerce_shipping_methods( $methods ) {
			$methods['apaczka'] = $this->shipping_methods['apaczka'];
			$methods['apaczka_cod'] = $this->shipping_methods['apaczka_cod'];
			return $methods;
		}


		public function admin_notices() {
		}

		public function loadPluginTextDomain() {
			parent::loadPluginTextDomain();
			$ret = load_plugin_textdomain( 'apaczka', FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		public static function getTextDomain() {
			return 'apaczka';
		}

		function enqueue_admin_scripts() {
			wp_enqueue_style( 'woocommerce-apaczka-admin', $this->getPluginUrl() . 'assets/css/admin.css' );
		}

		function enqueue_scripts() {
		}

		function admin_footer() {
		}

		/**
		 * action_links function.
		 *
		 * @access public
		 * @param mixed $links
		 * @return void
		 */
		 public function linksFilter( $links ) {

		     $plugin_links = array(
		     		'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping&section=wpdesk_apaczka_shipping') . '">' . __( 'Ustawienia', 'apaczka' ) . '</a>',
		     		'<a href="mailto:bok@apaczka.pl">' . __( 'Kontakt z BOK', 'apaczka' ) . '</a>',
		     );

		     return array_merge( $plugin_links, $links );
        }
	}

	function wpdesk_apaczka_init() {
		$_GLOBALS['woocommerce_apaczka'] = new WPDesk_Apaczka_Plugin();
	}

	add_action( 'plugins_loaded', 'wpdesk_apaczka_init' );
}
