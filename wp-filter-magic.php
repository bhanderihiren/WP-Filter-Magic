<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/hirenbhanderi/
 * @since             1.0.0
 * @package           Wp_Filter_Magic
 *
 * @wordpress-plugin
 * Plugin Name:       WP Filter Magic
 * Plugin URI:        https://thoughtfultakes.com
 * Description:       When choosing a name, make sure it's unique, easy to remember, and relevant to the functionality of your WordPress plugin. You may also want to check the WordPress plugin repository to ensure the name is not already in use.
 * Version:           1.0.0
 * Author:            Hiren Bhanderi
 * Author URI:        https://profiles.wordpress.org/hirenbhanderi//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-filter-magic
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_FILTER_MAGIC_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-filter-magic-activator.php
 */
function activate_wp_filter_magic() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-filter-magic-activator.php';
	Wp_Filter_Magic_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-filter-magic-deactivator.php
 */
function deactivate_wp_filter_magic() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-filter-magic-deactivator.php';
	Wp_Filter_Magic_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_filter_magic' );
register_deactivation_hook( __FILE__, 'deactivate_wp_filter_magic' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-filter-magic.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_filter_magic() {

	$plugin = new Wp_Filter_Magic();
	$plugin->run();

}
run_wp_filter_magic();
