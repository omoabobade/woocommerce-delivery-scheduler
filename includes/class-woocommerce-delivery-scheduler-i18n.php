<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       omoabobade.xyz
 * @since      1.0.0
 *
 * @package    Woocommerce_Delivery_Scheduler
 * @subpackage Woocommerce_Delivery_Scheduler/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Delivery_Scheduler
 * @subpackage Woocommerce_Delivery_Scheduler/includes
 * @author     Abobade Kolawole <kolawole.abobade@gmail.com>
 */
class Woocommerce_Delivery_Scheduler_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-delivery-scheduler',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
