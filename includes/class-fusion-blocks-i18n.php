<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://prosystheme.com
 * @since      1.0.0
 *
 * @package    fusion_blocks
 * @subpackage fusion_blocks/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    fusion_blocks
 * @subpackage fusion_blocks/includes
 * @author     Prosys Theme <prosysthemes@gmail.com>
 */
class Fusion_Blocks_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fusion-blocks',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
