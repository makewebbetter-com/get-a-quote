<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/includes
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
 * @package    Get_a_quote
 * @subpackage Get_a_quote/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
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
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $gaq_onboard    To initializsed the object of class onboard.
	 */
	protected $gaq_onboard;

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

		$this->get_a_quote_dependencies();
		$this->get_a_quote_locale();

		if ( is_admin() ) {
			$this->get_a_quote_admin_hooks();
		} else {
			$this->get_a_quote_public_hooks();
		}
		$this->get_a_quote_common_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Get_A_Quote_Loader. Orchestrates the hooks of the plugin.
	 * - Get_A_Quote_I18n. Defines internationalization functionality.
	 * - Get_A_Quote_Admin. Defines all hooks for the admin area.
	 * - Get_A_Quote_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function get_a_quote_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-get-a-quote-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-get-a-quote-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-get-a-quote-admin.php';
			/**
			 * The class responsible for defining all actions that occur in the onboarding the site data
			 * in the admin side of the site.
			 */
			! class_exists( 'Makewebbetter_Onboarding_Helper' ) && require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-makewebbetter-onboarding-helper.php';
			$this->onboard = new Makewebbetter_Onboarding_Helper();

		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-get-a-quote-public.php';

		}

		// The class is responsible for the common hooks used between admin and public area.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-get-a-quote-common.php';

		// The class responsible for defining all helper function to manipulate with requests and data.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-get-a-quote-helper.php';

		// This class is responsible for the country-data-managing.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gaq-country-manager.php';

		$this->loader = new Get_A_Quote_Loader();

		$this->gaq_helper = Get_A_Quote_Helper::get_instance();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Get_A_Quote_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function get_a_quote_locale() {

		$plugin_i18n = new Get_A_Quote_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function get_a_quote_admin_hooks() {

		$gaq_plugin_admin = new Get_A_Quote_Admin( $this->gaq_get_plugin_name(), $this->gaq_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $gaq_plugin_admin, 'gaq_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $gaq_plugin_admin, 'gaq_admin_enqueue_scripts' );

		// Add settings menu for get-a-quote.
		$this->loader->add_action( 'admin_menu', $gaq_plugin_admin, 'gaq_options_page' );
		$this->loader->add_action( 'admin_menu', $gaq_plugin_admin, 'mwb_gaq_remove_default_submenu', 50 );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $gaq_plugin_admin, 'gaq_admin_submenu_page', 15 );
		$this->loader->add_filter( 'gaq_template_settings_array', $gaq_plugin_admin, 'gaq_admin_template_settings_page', 10 );
		$this->loader->add_filter( 'gaq_general_settings_array', $gaq_plugin_admin, 'gaq_admin_general_settings_page', 10 );
		$this->loader->add_filter( 'gaq_support_tab_settings_array', $gaq_plugin_admin, 'gaq_admin_support_settings_page', 10 );

		// Saving tab settings.
		$this->loader->add_action( 'admin_init', $gaq_plugin_admin, 'gaq_admin_save_tab_settings' );

		/*MY WORK ON NEW BOILER PLATE*/

		// to register submenu for faq.
		$this->loader->add_filter( 'mwb_gaq_plugin_standard_admin_settings_tabs', $gaq_plugin_admin, 'gaq_adding_tabs', 10 );
		$this->loader->add_filter( 'gaq_taxonomies_settings_array', $gaq_plugin_admin, 'gaq_admin_taxonomies_settings_page', 10 );
		$this->loader->add_filter( 'gaq_taxonomies_button_array', $gaq_plugin_admin, 'gaq_admin_taxonomies_button', 10 );
		$this->loader->add_filter( 'gaq_email_settings_array', $gaq_plugin_admin, 'gaq_admin_email_settings_page', 10 );

		// Add custom columns to show submission details and editing post row action.
		$this->loader->add_filter( 'manage_quotes_posts_columns', $gaq_plugin_admin, 'add_gaq_columns' );
		$this->loader->add_action( 'manage_quotes_posts_custom_column', $gaq_plugin_admin, 'fill_gaq_columns', 10, 2 );
		$this->loader->add_action( 'post_row_actions', $gaq_plugin_admin, 'fill_cols', 10, 2 );

		// Add Meta boxes to submission at admin panel.
		$this->loader->add_action( 'add_meta_boxes', $gaq_plugin_admin, 'insert_gaq_metabox' );

		// Add/Update submission at admin panel.
		$this->loader->add_action( 'save_post', $gaq_plugin_admin, 'update_quote_callback' );

		// onboarding hook.
		$this->loader->add_filter( 'mwb_helper_valid_frontend_screens', $gaq_plugin_admin, 'add_mwb_frontend_screens' );

		$this->loader->add_filter( 'mwb_deactivation_supported_slug', $gaq_plugin_admin, 'add_mwb_deactivation_screens' );

	}

	/**
	 * Register all of the hooks related to the common functionality
	 * which include admin section and public section of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function get_a_quote_common_hooks() {

		$gaq_plugin_common = new Get_A_Quote_Common( $this->gaq_get_plugin_name(), $this->gaq_get_version() );

		// Remove submenu form quotes post type.
		$this->loader->add_action( 'admin_menu', $gaq_plugin_common, 'disable_new_posts' );

		$mwb_gaq_enable_option = get_option( 'gaq_enable_quote_form_switch' );
		if ( 'on' === $mwb_gaq_enable_option ) {
			$this->loader->add_action( 'init', $gaq_plugin_common, 'register_post_type_quote' );
			$mwb_gaq_taxonomies_option = get_option( 'mwb_gaq_taxonomies_options' );
			if ( empty( $mwb_gaq_taxonomies_option ) ) {
				$mwb_gaq_taxonomies_option['select_for_services'] = 'Yes';
				$mwb_gaq_taxonomies_option['select_for_status'] = 'Yes';
			}
			if ( 'Yes' === $mwb_gaq_taxonomies_option['select_for_services'] ) {
				$this->loader->add_action( 'init', $gaq_plugin_common, 'register_default_taxonomy' );
			}
			if ( 'Yes' === $mwb_gaq_taxonomies_option['select_for_status'] ) {
				$this->loader->add_action( 'init', $gaq_plugin_common, 'register_default_taxonomy_quote_status' );
			}
		}
		// Ajax actions for triggering the form data.
		$this->loader->add_action( 'wp_ajax_trigger_edit_form_data', $gaq_plugin_common, 'trigger_edit_form_data' );
		$this->loader->add_action( 'wp_ajax_nopriv_trigger_edit_form_data', $gaq_plugin_common, 'trigger_edit_form_data' );
		$this->loader->add_action( 'wp_ajax_trigger_form_submission', $gaq_plugin_common, 'trigger_form_submission' );
		$this->loader->add_action( 'wp_ajax_nopriv_trigger_form_submission', $gaq_plugin_common, 'trigger_form_submission' );
		$this->loader->add_action( 'wp_ajax_trigger_country_list', $gaq_plugin_common, 'trigger_country_list' );
		$this->loader->add_action( 'wp_ajax_nopriv_trigger_country_list', $gaq_plugin_common, 'trigger_country_list' );
		$this->loader->add_action( 'wp_ajax_trigger_country_list_public', $gaq_plugin_common, 'trigger_country_list_public' );
		$this->loader->add_action( 'wp_ajax_nopriv_trigger_country_list_public', $gaq_plugin_common, 'trigger_country_list_public' );

	}
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function get_a_quote_public_hooks() {

		$gaq_plugin_public = new Get_A_Quote_Public( $this->gaq_get_plugin_name(), $this->gaq_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $gaq_plugin_public, 'gaq_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $gaq_plugin_public, 'gaq_public_enqueue_scripts' );

		/**MY CUSTOM WORK */
		$this->loader->add_action( 'init', $gaq_plugin_public, 'register_shortcodes' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function gaq_run() {
		$this->loader->gaq_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function gaq_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Get_A_Quote_Loader    Orchestrates the hooks of the plugin.
	 */
	public function gaq_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Get_a_quote_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function gaq_get_onboard() {
		return $this->gaq_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function gaq_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_gaq_plug tabs.
	 *
	 * @return  Array       An key=>value pair of get-a-quote tabs.
	 */
	public function mwb_gaq_plug_default_tabs() {

		$gaq_default_tabs = array();

		$gaq_default_tabs['get-a-quote-general']  = array(
			'title' => esc_html__( 'General Setting', 'get-a-quote' ),
			'name'  => 'get-a-quote-general',
		);
		$gaq_default_tabs                         = apply_filters( 'mwb_gaq_plugin_standard_admin_settings_tabs', $gaq_default_tabs );
		return $gaq_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_gaq_plug_load_template( $path, $params = array() ) {

		$gaq_file_path = GET_A_QUOTE_DIR_PATH . $path;

		if ( file_exists( $gaq_file_path ) ) {

			include $gaq_file_path;
		} else {

			/* translators: %s: file path */
			$gaq_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'get-a-quote' ), $gaq_file_path );
			$this->mwb_gaq_plug_admin_notice( $gaq_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $gaq_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_gaq_plug_admin_notice( $gaq_message, $type = 'error' ) {

		$gaq_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$gaq_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$gaq_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$gaq_classes .= 'notice-success is-dismissible';
				break;

			default:
				$gaq_classes .= 'notice-error is-dismissible';
		}

		$gaq_notice  = '<div class="' . esc_attr( $gaq_classes ) . ' mwb-errorr-8">';
		$gaq_notice .= '<p>' . esc_html( $gaq_message ) . '</p>';
		$gaq_notice .= '</div>';

		echo wp_kses_post( $gaq_notice );
	}


	/**
	 * Mwb_gaq_plug_system_status WordPress and server info.
	 *
	 * @return  Array $gaq_system_data returns array of all WordPress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_gaq_plug_system_status() {
		global $wpdb;
		$gaq_system_status    = array();
		$gaq_wordpress_status = array();
		$gaq_system_data      = array();

		// Get the web server.
		$gaq_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$gaq_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'get-a-quote' );

		// Get the server's IP address.
		$gaq_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$gaq_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$gaq_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'get-a-quote' );

		// Get the server path.
		$gaq_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'get-a-quote' );

		// Get the OS.
		$gaq_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'get-a-quote' );

		// Get WordPress version.
		$gaq_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'get-a-quote' );

		// Get and count active WordPress plugins.
		$gaq_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'get-a-quote' );

		// See if this site is multisite or not.
		$gaq_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'get-a-quote' ) : __( 'No', 'get-a-quote' );

		// See if WP Debug is enabled.
		$gaq_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'get-a-quote' ) : __( 'No', 'get-a-quote' );

		// See if WP Cache is enabled.
		$gaq_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'get-a-quote' ) : __( 'No', 'get-a-quote' );

		// Get the total number of WordPress users on the site.
		$gaq_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'get-a-quote' );

		// Get the number of published WordPress posts.
		$gaq_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'get-a-quote' );

		// Get PHP memory limit.
		$gaq_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'get-a-quote' );

		// Get the PHP error log path.
		$gaq_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'get-a-quote' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$gaq_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'get-a-quote' );

		// Get PHP max post size.
		$gaq_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'get-a-quote' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$gaq_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$gaq_system_status['php_architecture'] = '64-bit';
		} else {
			$gaq_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$gaq_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'get-a-quote' );

		// Show the number of processes currently running on the server.
		$gaq_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'get-a-quote' );

		// Get the memory usage.
		$gaq_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$gaq_system_status['is_windows'] = true;
			$gaq_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'get-a-quote' );
		}

		// Get the memory limit.
		$gaq_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'get-a-quote' );

		// Get the PHP maximum execution time.
		$gaq_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'get-a-quote' );

		// Get outgoing IP address.
		$gaq_system_status['outgoing_ip'] = function_exists( 'file_get_contents' ) ? file_get_contents( 'http://ipecho.net/plain' ) : __( 'N/A (file_get_contents function does not exist)', 'get-a-quote' );

		$gaq_system_data['php'] = $gaq_system_status;
		$gaq_system_data['wp'] = $gaq_wordpress_status;

		return $gaq_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $gaq_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_gaq_plug_generate_html( $gaq_components = array() ) {
		if ( is_array( $gaq_components ) && ! empty( $gaq_components ) ) {
			foreach ( $gaq_components as $gaq_component ) {
				switch ( $gaq_component['type'] ) {

					case 'hidden':
					case 'number':
					case 'email':
					case 'text':
						?>
					<div class="mwb-form-group mwb-gaq-<?php echo esc_attr( $gaq_component['type'] ); ?>">
						<div class="mwb-form-group__label">
							<label for="<?php echo esc_attr( $gaq_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $gaq_component['title'] ); // WPCS: XSS ok. ?></label>
						</div>
						<div class="mwb-form-group__control">
							<label class="mdc-text-field mdc-text-field--outlined">
								<span class="mdc-notched-outline">
									<span class="mdc-notched-outline__leading"></span>
									<span class="mdc-notched-outline__notch">
										<?php if ( 'number' != $gaq_component['type'] ) { ?>
											<span class="mdc-floating-label" id="my-label-id" style=""><?php echo esc_attr( $gaq_component['placeholder'] ); ?></span>
										<?php } ?>
									</span>
									<span class="mdc-notched-outline__trailing"></span>
								</span>
								<input 
								class="mdc-text-field__input <?php echo esc_attr( $gaq_component['class'] ); ?>" 
								name="<?php echo esc_attr( $gaq_component['id'] ); ?>"
								id="<?php echo esc_attr( $gaq_component['id'] ); ?>"
								type="<?php echo esc_attr( $gaq_component['type'] ); ?>"
								value="<?php echo esc_attr( $gaq_component['value'] ); ?>"
								placeholder="<?php echo esc_attr( $gaq_component['placeholder'] ); ?>"
								>
							</label>
							<div class="mdc-text-field-helper-line">
								<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo esc_attr( $gaq_component['description'] ); ?></div>
							</div>
						</div>
					</div>
						<?php
						break;

					case 'password':
						?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label for="<?php echo esc_attr( $gaq_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $gaq_component['title'] ); // WPCS: XSS ok. ?></label>
						</div>
						<div class="mwb-form-group__control">
							<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
								<span class="mdc-notched-outline">
									<span class="mdc-notched-outline__leading"></span>
									<span class="mdc-notched-outline__notch">
									</span>
									<span class="mdc-notched-outline__trailing"></span>
								</span>
								<input 
								class="mdc-text-field__input <?php echo esc_attr( $gaq_component['class'] ); ?> mwb-form__password" 
								name="<?php echo esc_attr( $gaq_component['id'] ); ?>"
								id="<?php echo esc_attr( $gaq_component['id'] ); ?>"
								type="<?php echo esc_attr( $gaq_component['type'] ); ?>"
								value="<?php echo esc_attr( $gaq_component['value'] ); ?>"
								placeholder="<?php echo esc_attr( $gaq_component['placeholder'] ); ?>"
								>
								<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
							</label>
							<div class="mdc-text-field-helper-line">
								<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo esc_attr( $gaq_component['description'] ); ?></div>
							</div>
						</div>
					</div>
						<?php
						break;

					case 'textarea':
						?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label class="mwb-form-label" for="<?php echo esc_attr( $gaq_component['id'] ); ?>"><?php echo esc_attr( $gaq_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control">
							<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea"  	for="text-field-hero-input">
								<span class="mdc-notched-outline">
									<span class="mdc-notched-outline__leading"></span>
									<span class="mdc-notched-outline__notch">
										<span class="mdc-floating-label"><?php echo esc_attr( $gaq_component['placeholder'] ); ?></span>
									</span>
									<span class="mdc-notched-outline__trailing"></span>
								</span>
								<span class="mdc-text-field__resizer">
									<textarea class="mdc-text-field__input <?php echo esc_attr( $gaq_component['class'] ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo esc_attr( $gaq_component['id'] ); ?>" id="<?php echo esc_attr( $gaq_component['id'] ); ?>" placeholder="<?php echo esc_attr( $gaq_component['placeholder'] ); ?>"><?php echo esc_textarea( $gaq_component['value'] ); // WPCS: XSS ok. ?></textarea>
								</span>
							</label>
						</div>
					</div>
						<?php
						break;

					case 'select':
					case 'multiselect':
						?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label class="mwb-form-label" for="<?php echo esc_attr( $gaq_component['id'] ); ?>"><?php echo esc_html( $gaq_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control">
							<div class="mwb-form-select">
								<select name="<?php echo esc_attr( $gaq_component['id'] ); ?><?php echo ( 'multiselect' === $gaq_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $gaq_component['id'] ); ?>" class="mdl-textfield__input <?php echo esc_attr( $gaq_component['class'] ); ?>" <?php echo 'multiselect' === $gaq_component['type'] ? 'multiple="multiple"' : ''; ?> >
									<?php
									foreach ( $gaq_component['options'] as $gaq_key => $gaq_val ) {
										?>
										<option value="<?php echo esc_attr( $gaq_key ); ?>"
											<?php
											if ( is_array( $gaq_component['value'] ) ) {
												selected( in_array( (string) $gaq_key, $gaq_component['value'], true ), true );
											} else {
												selected( $gaq_component['value'], (string) $gaq_key );
											}
											?>
											>
											<?php echo esc_html( $gaq_val ); ?>
										</option>
										<?php
									}
									?>
								</select>
								<label class="mdl-textfield__label" for="octane"><?php echo esc_html( $gaq_component['description'] ); ?></label>
							</div>
						</div>
					</div>
						<?php
						break;

					case 'checkbox':
						?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label for="<?php echo esc_attr( $gaq_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $gaq_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control mwb-pl-4">
							<div class="mdc-form-field">
								<div class="mdc-checkbox">
									<input 
									name="<?php echo esc_attr( $gaq_component['id'] ); ?>"
									id="<?php echo esc_attr( $gaq_component['id'] ); ?>"
									type="checkbox"
									class="mdc-checkbox__native-control <?php echo esc_attr( isset( $gaq_component['class'] ) ? $gaq_component['class'] : '' ); ?>"
									value="<?php echo esc_attr( $gaq_component['value'] ); ?>"
									<?php
									if ( 'on' === $gaq_component['checked'] ) {
										checked( $gaq_component['checked'], 'on' );}
									?>
									/>
									<div class="mdc-checkbox__background">
										<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
											<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
										</svg>
										<div class="mdc-checkbox__mixedmark"></div>
									</div>
									<div class="mdc-checkbox__ripple"></div>
								</div>
								<label for="checkbox-1"><?php echo esc_html( $gaq_component['description'] ); ?></label>
							</div>
						</div>
					</div>
						<?php
						break;

					case 'radio':
						?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label for="<?php echo esc_attr( $gaq_component['id'] ); ?>" class="mwb-form-label"><?php echo esc_html( $gaq_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control mwb-pl-4">
							<div class="mwb-flex-col">
								<?php
								foreach ( $gaq_component['options'] as $gaq_radio_key => $gaq_radio_val ) {
									?>
									<div class="mdc-form-field">
										<div class="mdc-radio">
											<input
											name="<?php echo esc_attr( $gaq_component['id'] ); ?>"
											value="<?php echo esc_attr( $gaq_radio_key ); ?>"
											type="radio"
											class="mdc-radio__native-control <?php echo esc_attr( $gaq_component['class'] ); ?>"
											<?php checked( $gaq_radio_key, $gaq_component['value'] ); ?>
											>
											<div class="mdc-radio__background">
												<div class="mdc-radio__outer-circle"></div>
												<div class="mdc-radio__inner-circle"></div>
											</div>
											<div class="mdc-radio__ripple"></div>
										</div>
										<label for="radio-1"><?php echo esc_html( $gaq_radio_val ); ?></label>
									</div>	
									<?php
								}
								?>
							</div>
						</div>
					</div>
						<?php
						break;
					case 'radio-switch':
						?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__label">
							<label for="" class="mwb-form-label"><?php echo esc_html( $gaq_component['title'] ); ?></label>
						</div>
						<div class="mwb-form-group__control">
							<div>
								<div class="mdc-switch">
									<div class="mdc-switch__track"></div>
									<div class="mdc-switch__thumb-underlay">
										<div class="mdc-switch__thumb"></div>
										<input name="<?php echo esc_html( $gaq_component['id'] ); ?>" type="checkbox" id="basic-switch" value="on" class="mdc-switch__native-control" role="switch" aria-checked="
																<?php
																if ( 'on' === $gaq_component['value'] ) {
																	echo 'true';
																} else {
																	echo 'false';
																}
																?>
										"
										<?php checked( $gaq_component['value'], 'on' ); ?>
										>
									</div>
								</div>
							</div>
						</div>
					</div>
						<?php
						break;
					case 'button':
						?>
					<div class="mwb-form-group">
						<div class="mwb-form-group__control">
							<button class="mdc-button mdc-button--raised" name="<?php echo esc_attr( $gaq_component['id'] ); ?>"
								id="<?php echo esc_attr( $gaq_component['id'] ); ?>"> <span class="mdc-button__ripple"></span>
								<span class="mdc-button__label"><?php echo esc_attr( $gaq_component['button_text'] ); ?></span>
							</button>
						</div>
					</div>

						<?php
						break;

					case 'submit':
						?>
					<tr valign="top">
						<td scope="row">
							<input type="submit" class="button button-primary mdc-button mdc-button--raised" 
							name="<?php echo esc_attr( $gaq_component['id'] ); ?>"
							id="<?php echo esc_attr( $gaq_component['id'] ); ?>"
							value="<?php echo esc_attr( $gaq_component['button_text'] ); ?>"
							/>
						</td>
					</tr>
						<?php
						break;

					default:
						break;
				}
			}
		}
	}
}
