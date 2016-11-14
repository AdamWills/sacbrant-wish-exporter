<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://adamwills.io
 * @since      1.0.0
 *
 * @package    Sacbrant_Wish_Exporter
 * @subpackage Sacbrant_Wish_Exporter/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sacbrant_Wish_Exporter
 * @subpackage Sacbrant_Wish_Exporter/includes
 * @author     Adam Wills <adam@adamwills.com>
 */
class Sacbrant_Wish_Exporter_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sacbrant-wish-exporter',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
