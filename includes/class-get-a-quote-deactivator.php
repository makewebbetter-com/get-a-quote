<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Get_a_quote
 * @subpackage Get_a_quote/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Get_A_Quote_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function get_a_quote_deactivate() {
		$page_id = get_option( 'quote_page_id' );
		wp_delete_post( $page_id );
	}
}
