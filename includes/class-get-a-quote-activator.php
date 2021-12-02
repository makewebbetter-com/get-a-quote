<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Get_a_quote
 * @subpackage Get_a_quote/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Get_A_Quote_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function get_a_quote_activate() {

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		// Register the Default Page.
		self::insert_default_posts();
	}

	/**
	 * Register the Default Page.
	 *
	 * @since    1.0.0
	 */
	public static function insert_default_posts() {
		/**
		 * Search and Insert default quote page if not avaiable.
		 */
		$args       =
		array(
			'post_title'  => 'Quote Form',
			'post_type'   => 'page',
			'post_status' => 'publish',
			'meta_key'    => '_mwb_gaq_default_page',
		);
		$quote_page = get_posts( $args );

		if ( empty( $quote_page ) ) {
			$default_page = array(
				'post_title'   => esc_html__( 'Quote Form', 'GAQ_TEXT_DOMAIN' ),
				'post_status'  => 'publish',
				'post_content' => esc_html( '[gaq_form_fields]' ),
				'post_author'  => get_current_user_id(),
				'post_type'    => 'page',
				'meta_input'   => array(
					'_mwb_gaq_default_page'  => 'true',
				),
			);
			$page_id = wp_insert_post( $default_page );
			update_option( 'quote_page_id', $page_id );
		}
	}

}
