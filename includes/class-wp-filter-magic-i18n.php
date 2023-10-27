<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/hirenbhanderi/
 * @since      1.0.0
 *
 * @package    Wp_Filter_Magic
 * @subpackage Wp_Filter_Magic/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Filter_Magic
 * @subpackage Wp_Filter_Magic/includes
 * @author     Hiren Bhanderi <hirenbhanderi568@gmail.com>
 */
class Wp_Filter_Magic_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-filter-magic',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
