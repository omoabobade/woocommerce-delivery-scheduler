<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              omoabobade.xyz
 * @since             1.0.0
 * @package           Woocommerce_Delivery_Scheduler
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Delivery Scheduler
 * Plugin URI:        https://github.com/omoabobade
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Abobade Kolawole
 * Author URI:        omoabobade.xyz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-delivery-scheduler
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-delivery-scheduler-activator.php
 */
function activate_woocommerce_delivery_scheduler() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-delivery-scheduler-activator.php';
	Woocommerce_Delivery_Scheduler_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-delivery-scheduler-deactivator.php
 */
function deactivate_woocommerce_delivery_scheduler() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-delivery-scheduler-deactivator.php';
	Woocommerce_Delivery_Scheduler_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_delivery_scheduler' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_delivery_scheduler' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-delivery-scheduler.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_delivery_scheduler() {

	$plugin = new Woocommerce_Delivery_Scheduler();
	$plugin->run();

}
run_woocommerce_delivery_scheduler();
