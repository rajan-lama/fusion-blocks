<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://prosysthemes.com
 * @since             1.0.0
 * @package           Fusion_Blocks
 *
 * @wordpress-plugin
 * Plugin Name:       Fusion Blocks
 * Plugin URI:        http://prosystheme.com/wordpress-plugins/fusion-blocks-for-gutenberg
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0
 * Author:            Prosys Themes
 * Author URI:        http://prosysthemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fusion-blocks
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

if (! defined('FUSION_BLOCKS_VERSION')) {
    define('FUSION_BLOCKS_VERSION', '1.0.0');
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fusion-blocks-activator.php
 */
function activate_fusion_blocks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fusion-blocks-activator.php';
	Fusion_Blocks_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fusion-blocks-deactivator.php
 */
function deactivate_fusion_blocks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fusion-blocks-deactivator.php';
	Fusion_Blocks_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fusion_blocks' );
register_deactivation_hook( __FILE__, 'deactivate_fusion_blocks' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fusion-blocks.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fusion_blocks() {

	$plugin = new Fusion_Blocks();
	$plugin->run();

}
run_fusion_blocks();

/**
 * Gets this plugin's absolute directory path.
 *
 * @since  2.1.0
 * @ignore
 * @access private
 *
 * @return string
 */
function _get_plugin_directory() {
	return __DIR__;
}
/**
 * Gets this plugin's URL.
 *
 * @since  2.1.0
 * @ignore
 * @access private
 *
 * @return string
 */
function _get_plugin_url() {
	static $plugin_url;
	if ( empty( $plugin_url ) ) {
		$plugin_url = plugins_url( null, __FILE__ );
	}
	return $plugin_url;
}

// Enqueue JS and CSS.
include __DIR__ . '/includes/enqueue-scripts.php';