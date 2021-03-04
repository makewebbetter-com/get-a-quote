<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Get_a_quote
 *
 * @wordpress-plugin
 * Plugin Name:       Get-A-Quote
 * Plugin URI:        https://makewebbetter.com/product/get-a-quote/
 * Description:       Provides a quote option to request the type of services provided by their store, through the procedure of the form submission.
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       get-a-quote
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      4.9.5
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_get_a_quote_constants() {

	get_a_quote_constants( 'GET_A_QUOTE_VERSION', '1.0.0' );
	get_a_quote_constants( 'GET_A_QUOTE_DIR_PATH', plugin_dir_path( __FILE__ ) );
	get_a_quote_constants( 'GET_A_QUOTE_DIR_URL', plugin_dir_url( __FILE__ ) );
	get_a_quote_constants( 'GET_A_QUOTE_SERVER_URL', 'https://makewebbetter.com' );
	get_a_quote_constants( 'GET_A_QUOTE_ITEM_REFERENCE', 'get-a-quote' );
}


/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function get_a_quote_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-get-a-quote-activator.php
 */
function activate_get_a_quote() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-get-a-quote-activator.php';
	Get_a_quote_Activator::get_a_quote_activate();
	$mwb_gaq_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_gaq_active_plugin ) && ! empty( $mwb_gaq_active_plugin ) ) {
		$mwb_gaq_active_plugin['get-a-quote'] = array(
			'plugin_name' => __( 'get-a-quote', 'get-a-quote' ),
			'active' => '1',
		);
	} else {
		$mwb_gaq_active_plugin = array();
		$mwb_gaq_active_plugin['get-a-quote'] = array(
			'plugin_name' => __( 'get-a-quote', 'get-a-quote' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_gaq_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-get-a-quote-deactivator.php
 */
function deactivate_get_a_quote() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-get-a-quote-deactivator.php';
	Get_a_quote_Deactivator::get_a_quote_deactivate();
	$mwb_gaq_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_gaq_deactive_plugin ) && ! empty( $mwb_gaq_deactive_plugin ) ) {
		foreach ( $mwb_gaq_deactive_plugin as $mwb_gaq_deactive_key => $mwb_gaq_deactive ) {
			if ( 'get-a-quote' === $mwb_gaq_deactive_key ) {
				$mwb_gaq_deactive_plugin[ $mwb_gaq_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_gaq_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_get_a_quote' );
register_deactivation_hook( __FILE__, 'deactivate_get_a_quote' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-get-a-quote.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_get_a_quote() {
	define_get_a_quote_constants();

	$gaq_plugin_standard = new Get_a_quote();
	$gaq_plugin_standard->gaq_run();
	$GLOBALS['gaq_mwb_gaq_obj'] = $gaq_plugin_standard;

}
run_get_a_quote();


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'get_a_quote_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function get_a_quote_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=get_a_quote_menu' ) . '">' . __( 'Settings', 'get-a-quote' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}
