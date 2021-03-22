<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/Pando-Studio/containers-html-tags-selector
 * @since      1.0.0
 *
 * @package    Vc_Chtags
 * @subpackage Vc_Chtags/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Vc_Chtags
 * @subpackage Vc_Chtags/includes
 * @author     Pando Studio <yacine@pando-studio.com>
 */
class Vc_Chtags_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'vc-chtags',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
