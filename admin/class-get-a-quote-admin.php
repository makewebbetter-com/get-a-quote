<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/admin
 * @author     Make Web Better <plugins@makewebbetter.com>
 */
class Get_A_Quote_Admin
{

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
     * @param string $plugin_name       The name of this plugin.
     * @param string $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name         = $plugin_name;
        $this->version             = $version;
        $this->gaq_helper          = Get_A_Quote_Helper::get_instance();
        $this->gaq_country_manager = GAQCountryManager::get_instance();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

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
        $screen        = get_current_screen();
        $valid_screens = array(
            'get-a-quote_page_gaq-config',
            'toplevel_page_gaq-settings-screen',
        );

        if (isset($screen->id)) {
            $pagescreen = $screen->id;

            if (in_array($pagescreen, $valid_screens, true)) {
                wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/get-a-quote-admin.css', array(), $this->version, 'all');
                wp_enqueue_style('bootstrap-css', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
                // wp_enqueue_style('all-font-css', plugin_dir_url(__FILE__) . 'css/all.css', array(), $this->version, 'all');
            }
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/get-a-quote-admin.js', array('jquery', 'sweetalert'), $this->version, false);
        wp_enqueue_script('sweetalert', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script('bootsrap-js', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js.map', array('jquery'), $this->version, false);
        wp_enqueue_script('all-js', plugin_dir_url(__FILE__) . 'js/all.js', array('jquery'), $this->version, false);
        wp_enqueue_script('bootsrap-map', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, false);
        wp_localize_script(
            $this->plugin_name,
            'ajax_form_edit',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('mwb_gaq_edit_form_nonce'),
            )
        );
        $terms_service = get_terms(
            array(
                'taxonomy'   => 'service',
                'hide_empty' => false,
            )
        );
        $terms_status = get_terms(
            array(
                'taxonomy'   => 'status',
                'hide_empty' => false,
            )
        );
        wp_localize_script(
            $this->plugin_name,
            'taxonomy_values',
            array(
                'service' => $terms_service,
                'status'  => $terms_status,
            )
        );
        $form_value = empty( get_option('mwb_gaq_save_form_data') ) ? '' : get_option('mwb_gaq_save_form_data') ;
        wp_localize_script(
            $this->plugin_name,
            'form_variables',
            array(
                'converted' => $form_value,
            )
        );
    }

    /**
     * Register custom Columns for the post details.
     *
     * @since    1.0.0
     */
    public function add_gaq_columns($columns)
    {
        unset($columns['title']);
        unset($columns['taxonomy-service']);
        unset($columns['taxonomy-status']);
        unset($columns['date']);
        $columns['post_type_name']   = esc_html__('First Name', 'GAQ_TEXT_DOMAIN');
        $value = get_option('mwb_gaq_taxonomies_options');
        if ($value['select_for_services'] == 'yes'){
            $columns['taxonomy-service'] = esc_html__('Quote Service', 'GAQ_TEXT_DOMAIN');
        }
        if ($value['select_for_status'] == 'yes'){
            $columns['taxonomy-status']  = esc_html__('Quote Status', 'GAQ_TEXT_DOMAIN');
        }
        $columns['post_type_email']  = esc_html__('Email', 'GAQ_TEXT_DOMAIN');
        $columns['post_type_phone']  = esc_html__('phone', 'GAQ_TEXT_DOMAIN');
        $columns['date']             = esc_html__('Date', 'GAQ_TEXT_DOMAIN');
        return $columns;
    }

    /**
     * fill_cols
     */
    public function fill_cols($actions, $post) {
        if ($post->post_type=='quotes') {
            unset($actions['inline hide-if-no-js']);
            unset($actions['view']);
        }
        return $actions;
    }

    /**
     * Register custom Columns for the post details.
     *
     * @since    1.0.0
     */
    public function fill_gaq_columns($column, $post_id)
    {
        // echo '<pre>'; print_r( $post_id ); echo '</pre>'; die();
        $details = get_post_meta($post_id, 'quotes_meta', true);
        $details = json_decode(wp_json_encode($details), true);

        switch ($column) {

            case 'post_type_email':
                $email = !empty($details['Email']) ? $details['Email'] : '';
                echo esc_html($email);
                break;
            case 'post_type_name':
                $fname = !empty($details['firstname']) ? $details['firstname'] : '';
                $address = '<a href="' . admin_url('post.php?post=' . $post_id . '&amp;action=edit') . '"
                ><strong>' . $fname . '</strong></a>';
                echo $address;
                break;
            case 'post_type_phone':
                $phone = !empty($details['Phone']) ? $details['Phone'] : '';
                echo esc_html($phone);
                break;
        }
    }

    /**
     * Register the meta box for Quote submissions.
     *
     * @since    1.0.0
     */
    public function insert_gaq_metabox()
    {
        add_meta_box('mwb_gaq_meta_box', esc_html__('Quote Details', 'GAQ_TEXT_DOMAIN'), array($this, 'gaq_metabox_callback'), 'quotes');
    }

    /**
     * Render Content for the meta box.
     *
     * @since    1.0.0
     */
    public function gaq_metabox_callback()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/templates/meta-box/mwb-gaq-custom-meta-box.php';
    }

    /**
     * Add/Update submission at admin panel.
     *
     * @since    1.0.0
     */
    public function update_quote_callback()
    {
        // quotes post is updated here.
        $details = $this->gaq_helper->detailed_post_array(get_the_ID());
        if (isset($_POST['firstname'])) {
            $post_update_meta                  = array();
            $post_id                           = get_the_ID();
            $post_update_meta['firstname']     = !empty($_POST['firstname']) ? sanitize_text_field(wp_unslash($_POST['firstname'])) : '';
            $post_update_meta['taxo_service']  = $this->gaq_helper->get_taxonomy('service');
            $post_update_meta['status_taxo']  = $this->gaq_helper->get_taxonomy('status');
            $post_update_meta['Cityname']      = !empty($_POST['Cityname']) ? sanitize_text_field(wp_unslash($_POST['Cityname'])) : '';
            $post_update_meta['Zipcode']       = !empty($_POST['Zipcode']) ? sanitize_text_field(wp_unslash($_POST['Zipcode'])) : '';
            $post_update_meta['State']        = !empty($_POST['State']) ? sanitize_text_field(wp_unslash($_POST['State'])) : '';
            $post_update_meta['Country']       = !empty($_POST['Country']) ? sanitize_text_field(wp_unslash($_POST['Country'])) : '';
            $post_update_meta['Email']         = !empty($_POST['Email']) ? sanitize_text_field(wp_unslash($_POST['Email'])) : '';
            $post_update_meta['Phone']         = !empty($_POST['Phone']) ? sanitize_text_field(wp_unslash($_POST['Phone'])) : '';
            $post_update_meta['Budget']        = !empty($_POST['Budget']) ? sanitize_text_field(wp_unslash($_POST['Budget'])) : '';
            $post_update_meta['Additional']    = !empty($_POST['Additional']) ? sanitize_text_field(wp_unslash($_POST['Additional'])) : '';
            $post_update_meta['filename']      = !empty($details['filename']) ? sanitize_text_field(wp_unslash($details['filename'])) : '';
            $post_update_meta['filelink']      = !empty($details['filelink']) ? sanitize_text_field(wp_unslash($details['filelink'])) : '';
            if (!empty($post_update_meta)) {
                update_post_meta($post_id, 'quotes_meta', $post_update_meta);
            }
        }
    }

    /**
     * Quote Menu panel.
     * to list menu and submenu on admin panel.
     *
     * @return void
     */
    public function add_quote_menu()
    {

        // Add Main menu.
        add_menu_page(
            'Get A Quote',
            'Get A Quote',
            'manage_options',
            'gaq-settings-screen',
            array($this, 'quote_config_screen'),
            'dashicons-twitch',
            56
        );

        // Add Sub-Menu( Settings ).
        add_submenu_page(
            'gaq-settings-screen',
            'Get A Quote Settings',
            'Configuration',
            'manage_options',
            'gaq-config',
            array($this, 'quote_config_screen')
        );

        // Add Sub-Menu( FAQ ).
        add_submenu_page(
            'gaq-settings-screen',
            'Get A Quote FAQ',
            'FAQ',
            'read',
            'gaq-faq',
            array($this, 'quote_faq_screen')
        );
    }

    /**
     * Quote Sub-Menu panel Screen.
     *
     * @return void
     */
    public function quote_config_screen()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/get-a-quote-config-display.php';
    }

    /**
     * Quote Sub-Menu panel Screen.
     *
     * @return void
     */
    public function quote_faq_screen()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/get-a-quote-faq-display.php';
    }

    /**
     * Gaq_register_taxonomy_service
     */
    public function register_default_taxonomy()
    {

        $labels = array(
            'name'              => esc_html__('Services', 'GAQ_TEXT_DOMAIN'),
            'singular_name'     => esc_html__('Service', 'GAQ_TEXT_DOMAIN'),
            'search_items'      => esc_html__('Search Services', 'GAQ_TEXT_DOMAIN'),
            'all_items'         => esc_html__('All Services', 'GAQ_TEXT_DOMAIN'),
            'parent_item'       => esc_html__('Parent Service', 'GAQ_TEXT_DOMAIN'),
            'parent_item_colon' => esc_html__('Parent Service:', 'GAQ_TEXT_DOMAIN'),
            'edit_item'         => esc_html__('Edit Service', 'GAQ_TEXT_DOMAIN'),
            'update_item'       => esc_html__('Update Service', 'GAQ_TEXT_DOMAIN'),
            'add_new_item'      => esc_html__('Add New Service', 'GAQ_TEXT_DOMAIN'),
            'new_item_name'     => esc_html__('New Service Name', 'GAQ_TEXT_DOMAIN'),
            'menu_name'         => esc_html__('Services', 'GAQ_TEXT_DOMAIN'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'service'),
        );

        register_taxonomy('service', 'quotes', $args);
        $register = array(
            array(
            'label'       => esc_html__('Quotation', 'GAQ_TEXT_DOMAIN'),
            'description' => esc_html__('Quote', 'GAQ_TEXT_DOMAIN'),
            ),
        );
        $this->gaq_helper->insert_default_quote_taxonomies($register, 'service');
    }

    /**
     * Register Quote status.
     */
    public function register_default_taxonomy_quote_status()
    {

        $labels = array(
            'name'              => esc_html__('Quote Status', 'GAQ_TEXT_DOMAIN'),
            'singular_name'     => esc_html__('Status', 'GAQ_TEXT_DOMAIN'),
            'search_items'      => esc_html__('Search Status', 'GAQ_TEXT_DOMAIN'),
            'all_items'         => esc_html__('All Status', 'GAQ_TEXT_DOMAIN'),
            'parent_item'       => esc_html__('Parent Status', 'GAQ_TEXT_DOMAIN'),
            'parent_item_colon' => esc_html__('Parent Status:', 'GAQ_TEXT_DOMAIN'),
            'edit_item'         => esc_html('Edit Status'),
            'update_item'       => esc_html__('Update Status', 'GAQ_TEXT_DOMAIN'),
            'add_new_item'      => esc_html__('Add New Status', 'GAQ_TEXT_DOMAIN'),
            'new_item_name'     => esc_html__('New Status Name', 'GAQ_TEXT_DOMAIN'),
            'menu_name'         => esc_html__('Quote Statuses', 'GAQ_TEXT_DOMAIN'),
        );
        $args   =
            array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'status'),
            );

        register_taxonomy('status', 'quotes', $args);

        $register = array(
            array(
            'label'       => esc_html__('Pending', 'GAQ_TEXT_DOMAIN'),
            'description' => esc_html__('Pending For Review', 'GAQ_TEXT_DOMAIN'),
            ),
        );
        $this->gaq_helper->insert_default_quote_taxonomies($register, 'status');
    }

    /**
     * Register Quote Post Type.
     *
     * @return void
     */
    public function register_post_type_quote()
    {

        $labels = array(
            'name'               => esc_html__('Quotes', 'GAQ_TEXT_DOMAIN'),
            'singular_name'      => esc_html__('Quote', 'GAQ_TEXT_DOMAIN'),
            'add_new'            => esc_html__('Add New', 'GAQ_TEXT_DOMAIN'),
            'add_new_item'       => esc_html__('Add New Quote', 'GAQ_TEXT_DOMAIN'),
            'edit_item'          => esc_html__('Edit Quote', 'GAQ_TEXT_DOMAIN'),
            'new_item'           => esc_html__('New Quote', 'GAQ_TEXT_DOMAIN'),
            'all_items'          => esc_html__('All Quotes', 'GAQ_TEXT_DOMAIN'),
            'view_item'          => esc_html__('View Quote', 'GAQ_TEXT_DOMAIN'),
            'search_items'       => esc_html__('Search Quotes', 'GAQ_TEXT_DOMAIN'),
            'not_found'          => esc_html__('No Quotes Found', 'GAQ_TEXT_DOMAIN'),
            'not_found_in_trash' => esc_html__('No Quotes Found In Trash', 'GAQ_TEXT_DOMAIN'),
            'menu_name'          => esc_html__('Quotes', 'GAQ_TEXT_DOMAIN'),
        );

        register_post_type(
            'quotes',
            array(
                'supports'            => array(''),
                'labels'              => array(
                    'name'          => esc_html__('Quotes', 'GAQ_TEXT_DOMAIN'),
                    'singular_name' => esc_html__('Quote', 'GAQ_TEXT_DOMAIN'),
                ),
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => 'gaq-settings-screen',
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 5,
                'menu_icon'           => 'dashicons-text-page',
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'post',
                'rewrite'             => array('slug' => 'quotes-submission'), // my custom slug.
            )
        );
    }
    /**
     * Trigger_edit_form_data
     * It is for  the edit form setting.
     */
    public function trigger_edit_form_data()
    {
        // Nonce verification.
        check_ajax_referer('mwb_gaq_edit_form_nonce', '_ajax_nonce');

        if (isset($_POST['action'])) {
            
            if (isset($_POST['datalist'])) {
                $resultf = $_POST['datalist'];
                update_option('mwb_gaq_edit_form_data', $resultf);
                $resultf = 'success';
                echo json_encode($resultf);
            }
            if (isset($_POST['savinglist'])) {
                $results = $_POST['savinglist'];
                update_option('mwb_gaq_save_form_data', $results);
                $results = 'form saved';
                echo json_encode($results);
            }
            if (isset($_POST['term_name']) && isset($_POST['taxonomy_name'])) {
                $resultt = wp_delete_term($_POST['term_name'], $_POST['taxonomy_name']);
                echo json_encode($resultt);
            }
            wp_die();
        }
    }
    // End of Class.
}
