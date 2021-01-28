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
class Get_A_Quote_Admin {

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
	public function __construct( $plugin_name, $version ) {

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
		$screen        = get_current_screen();
		$valid_screens = array(
			'get-a-quote_page_gaq-config',
			'toplevel_page_gaq-settings-screen',
		);

		if ( isset( $screen->id ) ) {
			$pagescreen = $screen->id;

			if ( in_array( $pagescreen, $valid_screens, true ) ) {
				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/get-a-quote-admin.css', array(), $this->version, 'all' );
				wp_enqueue_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
				wp_enqueue_style( 'all-font-css', plugin_dir_url( __FILE__ ) . 'css/all.css', array(), $this->version, 'all' );
			}
		}

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/get-a-quote-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootsrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js.map', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'all-js', plugin_dir_url( __FILE__ ) . 'js/all.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootsrap-map', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register custom Columns for the post details.
	 *
	 * @since    1.0.0
	 */
	public function add_gaq_columns( $columns ) {

		$columns['post_type_email'] = esc_html__( 'Email', 'GAQ_TEXT_DOMAIN' );
		$columns['post_type_phone'] = esc_html__( 'phone', 'GAQ_TEXT_DOMAIN' );
		return $columns;
	}

	/**
	 * Register custom Columns for the post details.
	 *
	 * @since    1.0.0
	 */
	public function fill_gaq_columns( $column, $post_id ) {

		$details = get_post_meta( $post_id, 'quotes_meta', true );
		$details = json_decode( wp_json_encode( $details ), true );

		switch ( $column ) {

			case 'post_type_email':
				$email = ! empty( $details['fqemail'] ) ? $details['fqemail'] : '';
				echo esc_html( $email );
				break;

			case 'post_type_phone':
				$phone = ! empty( $details['fqphone'] ) ? $details['fqphone'] : '';
				echo esc_html( $phone );
				break;
		}
	}

	/**
	 * Register the meta box for Quote submissions.
	 *
	 * @since    1.0.0
	 */
	public function insert_gaq_metabox() {
		add_meta_box( 'mwb_gaq_meta_box', esc_html__( 'Quote Details', 'GAQ_TEXT_DOMAIN' ), array( $this, 'gaq_metabox_callback' ), 'quotes' );
	}

	/**
	 * Render Content for the meta box.
	 *
	 * @since    1.0.0
	 */
	public function gaq_metabox_callback() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/templates/meta-box/mwb-gaq-custom-meta-box.php';
	}

	/**
	 * Add/Update submission at admin panel.
	 *
	 * @since    1.0.0
	 */
	public function update_quote_callback() {

		if ( ! is_admin() ) {
			return;
		}
		// Return if doing autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Return if doing ajax.
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		// Return on post trash, quick-edit.
		if ( ! empty( $_GET['action'] ) && 'trash' === $_GET['action'] ) {
			return;
		}
		// Nonce verification.
		check_admin_referer( 'gaq_meta_box_nonce', 'gaq_meta_nonce' );

		// quotes post is updated here.
		if ( isset( $_POST['firstname'] ) ) {
			$post_update_meta                         = array();
			$post_id                                  = get_the_ID();
			$post_update_meta['ffname']               = ! empty( $_POST['firstname'] ) ? sanitize_text_field( wp_unslash( $_POST['firstname'] ) ) : '';
			$post_update_meta['fqlname']              = ! empty( $_POST['lastname'] ) ? sanitize_text_field( wp_unslash( $_POST['lastname'] ) ) : '';
			$post_update_meta['fqaddress']            = ! empty( $_POST['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address'] ) ) : '';
			$post_update_meta['fqcity']               = ! empty( $_POST['city'] ) ? sanitize_text_field( wp_unslash( $_POST['city'] ) ) : '';
			$post_update_meta['fqzipcode']            = ! empty( $_POST['zipcode'] ) ? sanitize_text_field( wp_unslash( $_POST['zipcode'] ) ) : '';
			$post_update_meta['fqstates']             = ! empty( $_POST['states'] ) ? sanitize_text_field( wp_unslash( $_POST['states'] ) ) : '';
			$post_update_meta['fqcountry']            = ! empty( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : '';
			$post_update_meta['fqemail']              = ! empty( $_POST['email'] ) ? sanitize_text_field( wp_unslash( $_POST['email'] ) ) : '';
			$post_update_meta['fqphone']              = ! empty( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
			$post_update_meta['fqbudget']             = ! empty( $_POST['budget'] ) ? sanitize_text_field( wp_unslash( $_POST['budget'] ) ) : '';
			$post_update_meta['fqadd']                = ! empty( $_POST['add'] ) ? sanitize_text_field( wp_unslash( $_POST['add'] ) ) : '';
			$post_update_meta['fqfilename']           = ! empty( $_POST['attachment'] ) ? sanitize_text_field( wp_unslash( $_POST['attachment'] ) ) : '';
			$post_update_meta['taxonomy_for_service'] = $this->gaq_helper->get_taxo( 'service' );
			$post_update_meta['taxonomy_for_status']  = $this->gaq_helper->get_taxo( 'status' );

			if ( ! empty( $post_update_meta ) ) {
				update_post_meta( $post_id, 'quotes_meta', $post_update_meta );
			}
		}
	}

	/**
	 * Quote Menu panel.
	 * to list menu and submenu on admin panel.
	 *
	 * @return void
	 */
	public function add_quote_menu() {

		// Add Main menu.
		add_menu_page(
			'Get A Quote',
			'Get A Quote',
			'manage_options',
			'gaq-settings-screen',
			array( $this, 'quote_config_screen' ),
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
			array( $this, 'quote_config_screen' )
		);

		// Add Sub-Menu( FAQ ).
		add_submenu_page(
			'gaq-settings-screen',
			'Get A Quote FAQ',
			'FAQ',
			'read',
			'gaq-faq',
			array( $this, 'quote_faq_screen' )
		);
	}

	/**
	 * Quote Sub-Menu panel Screen.
	 *
	 * @return void
	 */
	public function quote_config_screen() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/get-a-quote-config-display.php';
	}

	/**
	 * Quote Sub-Menu panel Screen.
	 *
	 * @return void
	 */
	public function quote_faq_screen() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/get-a-quote-faq-display.php';
	}

	/**
	 * Gaq_register_taxonomy_service
	 */
	public function register_default_taxonomy() {

		$labels = array(
			'name'              => esc_html__( 'Services', 'GAQ_TEXT_DOMAIN' ),
			'singular_name'     => esc_html__( 'Service', 'GAQ_TEXT_DOMAIN' ),
			'search_items'      => esc_html__( 'Search Services', 'GAQ_TEXT_DOMAIN' ),
			'all_items'         => esc_html__( 'All Services', 'GAQ_TEXT_DOMAIN' ),
			'parent_item'       => esc_html__( 'Parent Service', 'GAQ_TEXT_DOMAIN' ),
			'parent_item_colon' => esc_html__( 'Parent Service:', 'GAQ_TEXT_DOMAIN' ),
			'edit_item'         => esc_html__( 'Edit Service', 'GAQ_TEXT_DOMAIN' ),
			'update_item'       => esc_html__( 'Update Service', 'GAQ_TEXT_DOMAIN' ),
			'add_new_item'      => esc_html__( 'Add New Service', 'GAQ_TEXT_DOMAIN' ),
			'new_item_name'     => esc_html__( 'New Service Name', 'GAQ_TEXT_DOMAIN' ),
			'menu_name'         => esc_html__( 'Services', 'GAQ_TEXT_DOMAIN' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'service' ),
		);

		register_taxonomy( 'service', 'quotes', $args );

		/**
		 * Taxonomy registered. Now can add our custom ones.
		 */
		$args = array(
			array(
				'label'       => esc_html__( 'Service A', 'GAQ_TEXT_DOMAIN' ),
				'description' => esc_html__( 'A Type Service', 'GAQ_TEXT_DOMAIN' ),
				'slug'        => esc_html__( 'service-a', 'GAQ_TEXT_DOMAIN' ),
			),
			array(
				'label'       => esc_html__( 'Service B', 'GAQ_TEXT_DOMAIN' ),
				'description' => esc_html__( 'B Type Service', 'GAQ_TEXT_DOMAIN' ),
				'slug'        => esc_html__( 'service-b', 'GAQ_TEXT_DOMAIN' ),
			),
			array(
				'label'       => esc_html__( 'Service C', 'GAQ_TEXT_DOMAIN' ),
				'description' => esc_html__( 'C Type Service', 'GAQ_TEXT_DOMAIN' ),
				'slug'        => esc_html__( 'service-c', 'GAQ_TEXT_DOMAIN' ),
			),
		);

		$this->gaq_helper->insert_default_quote_taxonomies( $args );

	}

	/**
	 * Register Quote status.
	 */
	public function register_default_taxonomy_quote_status() {

		$labels = array(
			'name'              => esc_html__( 'Quote Status', 'GAQ_TEXT_DOMAIN' ),
			'singular_name'     => esc_html__( 'Status', 'GAQ_TEXT_DOMAIN' ),
			'search_items'      => esc_html__( 'Search Status', 'GAQ_TEXT_DOMAIN' ),
			'all_items'         => esc_html__( 'All Status', 'GAQ_TEXT_DOMAIN' ),
			'parent_item'       => esc_html__( 'Parent Status', 'GAQ_TEXT_DOMAIN' ),
			'parent_item_colon' => esc_html__( 'Parent Status:', 'GAQ_TEXT_DOMAIN' ),
			'edit_item'         => esc_html( 'Edit Status' ),
			'update_item'       => esc_html__( 'Update Status', 'GAQ_TEXT_DOMAIN' ),
			'add_new_item'      => esc_html__( 'Add New Status', 'GAQ_TEXT_DOMAIN' ),
			'new_item_name'     => esc_html__( 'New Status Name', 'GAQ_TEXT_DOMAIN' ),
			'menu_name'         => esc_html__( 'Quote Statuses', 'GAQ_TEXT_DOMAIN' ),
		);
		$args   =
		array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'status' ),
		);

		register_taxonomy( 'status', 'quotes', $args );

		/**
		 * Taxonomy registered. Now can add our custom ones.
		 */
		$args = array(
			array(
				'label'       => esc_html__( 'Viewing', 'GAQ_TEXT_DOMAIN' ),
				'description' => esc_html__( 'Under Inspection', 'GAQ_TEXT_DOMAIN' ),
				'slug'        => esc_html__( 'viewing', 'GAQ_TEXT_DOMAIN' ),
			),
			array(
				'label'       => esc_html__( 'Completed', 'GAQ_TEXT_DOMAIN' ),
				'description' => esc_html__( 'Completed And Returned', 'GAQ_TEXT_DOMAIN' ),
				'slug'        => esc_html__( 'completed', 'GAQ_TEXT_DOMAIN' ),
			),
			array(
				'label'       => esc_html__( 'Pending', 'GAQ_TEXT_DOMAIN' ),
				'description' => esc_html__( 'Pending For Review', 'GAQ_TEXT_DOMAIN' ),
				'slug'        => esc_html__( 'pending', 'GAQ_TEXT_DOMAIN' ),
			),
		);

		$this->gaq_helper->insert_default_quote_taxonomies( $args, 'status' );
	}

	/**
	 * Register Quote Post Type.
	 *
	 * @return void
	 */
	public function register_post_type_quote() {

		$labels = array(
			'name'               => esc_html__( 'Quotes', 'GAQ_TEXT_DOMAIN' ),
			'singular_name'      => esc_html__( 'Quote', 'GAQ_TEXT_DOMAIN' ),
			'add_new'            => esc_html__( 'Add New', 'GAQ_TEXT_DOMAIN' ),
			'add_new_item'       => esc_html__( 'Add New Quote', 'GAQ_TEXT_DOMAIN' ),
			'edit_item'          => esc_html__( 'Edit Quote', 'GAQ_TEXT_DOMAIN' ),
			'new_item'           => esc_html__( 'New Quote', 'GAQ_TEXT_DOMAIN' ),
			'all_items'          => esc_html__( 'All Quotes', 'GAQ_TEXT_DOMAIN' ),
			'view_item'          => esc_html__( 'View Quote', 'GAQ_TEXT_DOMAIN' ),
			'search_items'       => esc_html__( 'Search Quotes', 'GAQ_TEXT_DOMAIN' ),
			'not_found'          => esc_html__( 'No Quotes Found', 'GAQ_TEXT_DOMAIN' ),
			'not_found_in_trash' => esc_html__( 'No Quotes Found In Trash', 'GAQ_TEXT_DOMAIN' ),
			'menu_name'          => esc_html__( 'Quotes', 'GAQ_TEXT_DOMAIN' ),
		);

		register_post_type(
			'quotes',
			array(
				'supports'            => array( '' ),
				'labels'              => array(
					'name'          => esc_html__( 'Quotes', 'GAQ_TEXT_DOMAIN' ),
					'singular_name' => esc_html__( 'Quote', 'GAQ_TEXT_DOMAIN' ),
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
				'rewrite'             => array( 'slug' => 'quotes-submission' ), // my custom slug.
			)
		);
	}

	// End of Class.
}
