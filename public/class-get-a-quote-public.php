<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/public
 * @author     Make Web Better <plugins@makewebbetter.com>
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
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $gaq_helper;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->gaq_helper  = Get_A_Quote_Helper::get_instance();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Get_A_Quote_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Get_A_Quote_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/get-a-quote-public.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Get_A_Quote_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Get_A_Quote_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script( 'mwb_gaq_sweet_alert', plugin_dir_url( __FILE__ ) . 'js/sweet-alert.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/get-a-quote-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script(
            $this->plugin_name,
            'ajax_globals',
            array(
                'ajax_url'              => admin_url('admin-ajax.php'),
                'form_submission_nonce' => wp_create_nonce('mwb_gaq_security'),
            )
        );
        $form_value = empty( get_option('mwb_gaq_edit_form_data') ) ? '' : get_option('mwb_gaq_edit_form_data');
        wp_localize_script(
            $this->plugin_name,
            'php_vars',
            array(
                'converted' => $form_value,
            )
        );
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
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/get-a-quote-public-display.php';
    }

    /**
     * Triggers the states for selected country field.
     *
     * @since    1.0.0
     */
    public function trigger_form_submission() {

        // Nonce verification.
        check_ajax_referer( 'mwb_gaq_security', '_ajax_nonce' );

        $result = "Form Submission AJAX";
        echo json_encode($result);
            wp_die();
        // if ( ! empty( $_POST['action'] ) ) {

        //     $selected_country = ! empty( $_POST['selected_country'] ) ? sanitize_text_field( wp_unslash( $_POST['selected_country'] ) ) : '';

        //     $states = GAQCountryManager::get_instance()->country_states( $selected_country );

        //     if ( ! empty( $states ) && is_array( $states ) ) {
        //         $opt_html = '';
        //         foreach ($states as $key => $value) {
        //             $opt_html .= '<option value="' . $value . '">' . esc_html( $value ) . '</option>';
        //         }
        //         $result = array(
        //             'result' => 'true',
        //             'html'   => $opt_html,
        //         );
        //     } else {
        //         $result = array(
        //             'result' => 'false',
        //             'html'   => '',
        //         );
        //     }
        //     echo json_encode($result);
        //     wp_die();
        // }
    }
    // End of class.
}
