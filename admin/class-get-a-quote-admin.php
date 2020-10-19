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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', [ $this, 'quote_panel' ]);
		add_action( 'init', [ $this, 'quote_post_type' ]);
		add_action( 'init', [ $this, 'wporg_register_taxonomy_service' ]);
		add_action( 'init', [ $this, 'wporg_register_taxonomy_quote_status' ]);

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/get-a-quote-admin.css', array(), $this->version, 'all' );

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

	}
	public function quote_panel() {
		add_menu_page('quote page title', 'GET A QUOTE', 'manage_options', 'quote-options', 'wps_quote_func');
		add_submenu_page( 'quote-options', 'Settings page title', 'Settings', 'manage_options', 'quote-op-settings', 'wps_quote_func_settings');
		add_submenu_page( 'quote-options', 'form fields title', 'Form Fields', 'manage_options', 'quote-op-ff', 'wps_quote_func_ff');
		add_submenu_page( 'quote-options', 'FAQ page title', 'FAQ', 'manage_options', 'quote-op-faq', 'wps_quote_func_faq');
	}
	/**
	 * Wporg_custom_post_type
	 */
	public function quote_post_type() {
		register_post_type( 'wporg_quotes',
			array(
				'labels'      => array(
					'name'          => __( 'Quotes', 'textdomain' ),
					'singular_name' => __( 'Quote', 'textdomain' ),
				),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-text-page',
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
				'rewrite'     => array( 'slug' => 'Quotes' ), // my custom slug.
			)
		);
	}
	/**
	 * Wporg_register_taxonomy_service
	 */
	function wporg_register_taxonomy_service() {
		$labels = [
			'name'              => _x( 'Services', 'taxonomy general name' ),
			'singular_name'     => _x( 'Service', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Services' ),
			'all_items'         => __( 'All Services' ),
			'parent_item'       => __( 'Parent Service' ),
			'parent_item_colon' => __( 'Parent Service:' ),
			'edit_item'         => __( 'Edit Service' ),
			'update_item'       => __( 'Update Service' ),
			'add_new_item'      => __( 'Add New Service' ),
			'new_item_name'     => __( 'New Service Name' ),
			'menu_name'         => __( 'Services' ),
		];
		$args = [
			'hierarchical'      => true, // make it hierarchical (like categories).
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'service' ],
		];
		register_taxonomy( 'service', [ 'wporg_quotes' ], $args );
	}
	/**
	 * Wporg_register_taxonomy_quote_status
	 */
	function wporg_register_taxonomy_quote_status() {
		$labels = [
			'name'              => _x( 'Quote Status', 'taxonomy general name' ),
			'singular_name'     => _x( 'Status', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Status' ),
			'all_items'         => __( 'All Status' ),
			'parent_item'       => __( 'Parent Status' ),
			'parent_item_colon' => __( 'Parent Status:' ),
			'edit_item'         => __( 'Edit Status' ),
			'update_item'       => __( 'Update Status' ),
			'add_new_item'      => __( 'Add New Status' ),
			'new_item_name'     => __( 'New Status Name' ),
			'menu_name'         => __( 'Quote Statuses' ),
		];
		$args = [
			'hierarchical'      => true, // make it hierarchical (like categories).
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'Status' ],
		];
		register_taxonomy( 'Status', [ 'wporg_quotes' ], $args );
	}

}
