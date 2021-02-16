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
        wp_enqueue_script('sweetalert', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/get-a-quote-public.js', array('jquery'), $this->version, false);
        wp_localize_script(
            $this->plugin_name,
            'ajax_globals',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('mwb_gaq_security'),
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
        if (isset($_POST['action'])) {
            $result = $_POST;
            foreach ($result as $key => $value) {
                if ($key != 'action') {
                    $data[$key] = $value;
                }
            }
            if (isset($data['firstname'])) {
                $my_post_details = array(
                    'post_title'  => $data['firstname'],
                    'post_type'   => 'quotes',
                    'post_status' => 'publish',
                );
            }
            $post_id = wp_insert_post($my_post_details);

            //file upload procedure begin.
            if (isset($_FILES['Files']['name'])) {
                $err        = array();
                $file_name  = isset($_FILES['Files']['name']) ?
                    sanitize_textarea_field(wp_unslash($_FILES['Files']['name'])) : '';

                $file_tmp   = isset($_FILES['Files']['tmp_name']) ?
                    sanitize_textarea_field(wp_unslash($_FILES['Files']['tmp_name'])) : '';

                $file_type  = isset($_FILES['Files']['type']) ?
                    sanitize_textarea_field(wp_unslash($_FILES['Files']['type'])) : '';

                $file_ext   = wp_check_filetype(basename($file_name), null);

                $extensions = array( 'png', 'jpeg', 'jpg' );

                if (! empty($file_ext['ext'])) {
                    if (!in_array($file_ext['ext'], $extensions, true)) {
                        $err['ext'] = 'extension not allowed, please choose a pdf or docx file.';
                    }
                }
                $loc = '/wp-content/uploads/quote-submission';
                $log_dir = ABSPATH . '/wp-content/uploads/quote-submission';
                if (! is_dir($log_dir)) {
                    mkdir($log_dir, 0755, true);
                }
                if (empty($err)) {
                    $new_file_name = 'quote_' . $post_id . '.' . $file_ext['ext'];
                    $loc = $loc . '/' . $new_file_name;
                    $file_add  = $log_dir . '/' . $new_file_name;
                    move_uploaded_file($file_tmp, $file_add);
                    if (! empty($file_add)) {
                        $this->gaq_helper->create_attachment($post_id, $file_add);
                        $data['filename'] = $new_file_name;
                        $data['filelink'] = $loc;
                        $response = 'Success';
                        $email_activator = get_option('mwb_gaq_activate_email');
                        if ('on' === $email_activator) {
                            $mail = $this->gaq_helper->email_sending($p_id);
                        }
                    }
                } else {
                    $response = 'Failed';
                    print_r($err);
                }
            } //file upload procedure end.

            // Mail sending.
            if (isset($data['Email'])) {
                $email_activator = get_option('mwb_gaq_activate_email');
                if ('on' === $email_activator) {
                    $mail = $this->gaq_helper->email_sending($post_id);
                    $respo = 'mail sent';
                }
            } //mail sending end here

            //formdata pushing to DB.
            if (! empty($data)) {
                $data['status_taxo'] = 'pending';
                update_post_meta($post_id, 'quotes_meta', $data);
                $response = 'updated';
                $this->gaq_helper->set_taxonomy($post_id);
            }

            //ajax response here.
            // print_r($data);
            echo json_encode($response);
            wp_die();
        }
    }
    // End of class.
}
