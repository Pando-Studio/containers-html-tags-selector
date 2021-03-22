<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pando-studio.com
 * @since             1.0.0
 * @package           Vc_Chtags
 *-
 * @wordpress-plugin
 * Plugin Name:       Containers HTML Tags Selector for WPBakery Page Builder
 * Plugin URI:        https://pando-studio.com
 * Description:       Increase the possibilities by choosing your own HTML tags for your containers. This extension need WPBarkery Page Builder to run.
 * Version:           1.0.0
 * Author:            Pando Studio
 * Author URI:        https://pando-studio.com
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vc-chtags
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
define( 'VC_CHTAGS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vc-chtags-activator.php
 */
function activate_vc_chtags() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vc-chtags-activator.php';
	Vc_Chtags_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vc-chtags-deactivator.php
 */
function deactivate_vc_chtags() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vc-chtags-deactivator.php';
	Vc_Chtags_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vc_chtags' );
register_deactivation_hook( __FILE__, 'deactivate_vc_chtags' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vc-chtags.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vc_chtags() {

	$plugin = new Vc_Chtags();
	$plugin->run();

}
run_vc_chtags();
