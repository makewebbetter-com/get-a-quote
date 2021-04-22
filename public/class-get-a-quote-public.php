<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/public
 */

session_start();

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace Get_A_Quote_Public.
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Get_A_Quote_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function gaq_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, GET_A_QUOTE_DIR_URL . 'public/src/scss/get-a-quote-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function gaq_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, GET_A_QUOTE_DIR_URL . 'public/src/js/get-a-quote-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'captcha', 'https://www.google.com/recaptcha/api.js', array(), time(), false );
		wp_localize_script(
			$this->plugin_name,
			'gaq_public_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'country_ajax' ),
				'form_nonce' => wp_create_nonce( 'form_data_nonce' ),
			)
		);
		$form_value = empty( get_option( 'mwb_gaq_edit_form_data' ) ) ? '' : get_option( 'mwb_gaq_edit_form_data' );
		wp_localize_script(
			$this->plugin_name,
			'php_vars',
			array(
				'converted' => $form_value,
				'redirect'  => get_option( 'select_for_redirection' ),
				'red_page'  => get_option( 'select_page_for_redirection' ),
			)
		);
		wp_enqueue_script( $this->plugin_name );
	}

	/**
	 * Register the required shortcodes.
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'gaq_form_fields', array( $this, 'quote_form_fields' ) );
	}

	/**
	 * Render the enabled fields.
	 *
	 * @since    1.0.0
	 */
	public function quote_form_fields() {
		$is_gaq_enable_plugin = get_option( 'gaq_enable_quote_form',);
		$data                 = get_option( 'mwb_gaq_edit_form_data' );
		if ( 'on' === $is_gaq_enable_plugin && '' !== $data ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/get-a-quote-public-display.php';
		} else {
			return '';
		}
	}
	// End class file.
}
