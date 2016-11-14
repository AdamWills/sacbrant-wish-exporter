<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://adamwills.io
 * @since             1.0.0
 * @package           Sacbrant_Wish_Exporter
 *
 * @wordpress-plugin
 * Plugin Name:       SacBrant WISH Exporter
 * Plugin URI:        https://sacbrant.ca
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Adam Wills
 * Author URI:        https://adamwills.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sacbrant-wish-exporter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sacbrant-wish-exporter-activator.php
 */
function activate_sacbrant_wish_exporter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sacbrant-wish-exporter-activator.php';
	Sacbrant_Wish_Exporter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sacbrant-wish-exporter-deactivator.php
 */
function deactivate_sacbrant_wish_exporter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sacbrant-wish-exporter-deactivator.php';
	Sacbrant_Wish_Exporter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sacbrant_wish_exporter' );
register_deactivation_hook( __FILE__, 'deactivate_sacbrant_wish_exporter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sacbrant-wish-exporter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sacbrant_wish_exporter() {

	$plugin = new Sacbrant_Wish_Exporter();
	$plugin->run();

}
run_sacbrant_wish_exporter();
