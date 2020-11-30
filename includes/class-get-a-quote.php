<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/includes
 * @author     Make Web Better <plugins@makewebbetter.com>
 */
class Get_A_Quote {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Get_A_Quote_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'GET_A_QUOTE_VERSION' ) ) {
			$this->version = GET_A_QUOTE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'get-a-quote';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Get_A_Quote_Loader. Orchestrates the hooks of the plugin.
	 * - Get_A_Quote_i18n. Defines internationalization functionality.
	 * - Get_A_Quote_Admin. Defines all hooks for the admin area.
	 * - Get_A_Quote_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-get-a-quote-loader.php';

		/**
		 * The class is responsible for global functions
		 *  
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-get-a-quote-global-functions.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-get-a-quote-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-get-a-quote-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-get-a-quote-public.php';

		$this->loader = new Get_A_Quote_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Get_A_Quote_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Get_A_Quote_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Get_A_Quote_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'manage_quotes_posts_columns', $plugin_admin, 'mwb_gaq_columns' );

		$mwb_gaq_enable_plugin = get_option( 'mwb_gaq_enable_plugin', Get_A_Quote_Helper :: enabling_default_value( 'enable' )  );


		$this->loader->add_filter( 'admin_menu', $plugin_admin, 'quote_panel' );
		if ( 'on' === $mwb_gaq_enable_plugin ) {
			//wp_mail( 'Shaileshkumardubey@makewebbetter.com', 'office', 'Working' );
			$mwb_gaq_taxonomies_option = get_option( 'mwb_gaq_taxonomies_options', Get_A_Quote_Helper :: enabling_default_value( 'taxonomy' ) );
			if ( 'yes' === $mwb_gaq_taxonomies_option['select_for_services'] ) {
				$this->loader->add_filter( 'init', $plugin_admin, 'gaq_register_taxonomy_service' ); }
			if ( 'yes' === $mwb_gaq_taxonomies_option['select_for_status'] ) {
				$this->loader->add_filter( 'init', $plugin_admin, 'gaq_register_taxonomy_quote_status' ); }
			$this->loader->add_filter( 'init', $plugin_admin, 'quote_post_type' );
		}
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'mwb_gaq_meta_inside' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'mwb_gaq_update_quote' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Get_A_Quote_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'shortcodes' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Get_A_Quote_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
