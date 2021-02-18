<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com
 * @since             1.0.0
 * @package           Get_A_Quote
 *
 * @wordpress-plugin
 * Plugin Name:       Get a Quote
 * Plugin URI:        https://wordpress.org/plugins/get-a-quote/
 * Description:       Provides a quote option to request the type of services provided by their store, through the procedure of the form submission. 
 * Version:           1.0.0
 * Author:            Make Web Better
 * Author URI:        https://makewebbetter.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       get-a-quote
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('GAQ_VERSION', '1.0.0');
define('GAQ_TEXT_DOMAIN', 'get-a-quote');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-get-a-quote-activator.php
 */
function activate_get_a_quote() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-get-a-quote-activator.php';
    Get_A_Quote_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-get-a-quote-deactivator.php
 */
function deactivate_get_a_quote() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-get-a-quote-deactivator.php';
    Get_A_Quote_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_get_a_quote');
register_deactivation_hook(__FILE__, 'deactivate_get_a_quote');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-get-a-quote.php';

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

    $plugin = new Get_A_Quote();
    $plugin->run();

}
run_get_a_quote();


/*****************************************
    Plugin External Urls Code
******************************************
*/
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'mwb_gaq_plugin_action_links');

/**
 * Add Settings link if premium version is not available.
 *
 * @since    1.0.0
 * @param    string $links link to admin arena of plugin.
 */
function mwb_gaq_plugin_action_links($links) {

    $settings_tab = sprintf('<a href="%s">%s</a>', esc_url(admin_url('admin.php?page=gaq-config')), esc_html__('Settings', 'GAQ_TEXT_DOMAIN'));
    $gopro_tab    = sprintf('<a target="_blank" style="background: #05d5d8; color: white; font-weight: 700; padding: 2px 5px; border: 1px solid #05d5d8; border-radius: 5px;" href="%s">%s</a>', esc_url('https://makewebbetter.com/'), esc_html__('GO PRO', 'GAQ_TEXT_DOMAIN'));

    $plugin_links = array(
        'settings_tab' => $settings_tab,
        'gopro_tab'    => $gopro_tab,
   );

    return array_merge($plugin_links, $links);
}
add_filter('plugin_row_meta', 'mwb_gaq_plugin_row_meta', 10, 2);

/**
 * Add custom links for getting premium version.
 *
 * @param   string $links link to index file of plugin.
 * @param   string $file index file of plugin.
 *
 * @since    1.0.0
 */
function mwb_gaq_plugin_row_meta($links, $file) {

    if (! empty($file) && strpos($file, 'get-a-quote.php') !== false) {

        $additional_links = array(
            esc_html__('Demo', 'GAQ_TEXT_DOMAIN')    => 'https://demo.makewebbetter.com/woocommerce-upsell-order-bump-offer/?utm_source=MWB-orderbump-home&utm_medium=MWB-home-page&utm_campaign=MWB-orderbump-home',
            esc_html__('Documentation', 'GAQ_TEXT_DOMAIN') => 'https://docs.makewebbetter.com/woocommerce-upsell-order-bump-offer/?utm_source=MWB-orderbump-home&utm_medium=MWB-home-page&utm_campaign=MWB-orderbump-home',
            esc_html__('Support', 'GAQ_TEXT_DOMAIN') => 'https://makewebbetter.com/submit-query/',
       );

        if (! empty($additional_links) && is_array($additional_links)) {
            $row_meta = array();
            foreach ($additional_links as $label => $url) {
                $row_meta[ strtolower($label) ] = sprintf('<a href="%s">%s</a>', esc_url($url), esc_html($label));
            }
        }

        return array_merge($links, $row_meta);
    }

    return (array) $links;
}
