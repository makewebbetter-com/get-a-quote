<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->gaq_helper  = Get_A_Quote_Helper::get_instance();
		$this->gaq_country = GAQ_Country_Manager::get_instance();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function gaq_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();

		if ( isset( $screen->id ) && 'edit-quotes' === $screen->id ) {
			wp_enqueue_style( $this->plugin_name, GET_A_QUOTE_DIR_URL . 'admin/src/scss/get-a-quote-admin-section.css', array(), $this->version, 'all' );
		}
		if ( isset( $screen->id ) && 'makewebbetter_page_get_a_quote_menu' === $screen->id || 'quotes' === $screen->id || 'makewebbetter_page_get_a_quote_overview_menu' === $screen->id ) {
			wp_enqueue_style( 'mwb-gaq-select2-css', GET_A_QUOTE_DIR_URL . 'package/lib/select-2/get-a-quote-select2.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-gaq-meterial-css', GET_A_QUOTE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-gaq-meterial-css2', GET_A_QUOTE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-gaq-meterial-lite', GET_A_QUOTE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-gaq-meterial-icons-css', GET_A_QUOTE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );
			wp_enqueue_style( $this->plugin_name . '-admin-global', GET_A_QUOTE_DIR_URL . 'admin/src/scss/get-a-quote-admin-global.css', array( 'mwb-gaq-meterial-icons-css' ), time(), 'all' );
			wp_enqueue_style( $this->plugin_name, GET_A_QUOTE_DIR_URL . 'admin/src/scss/get-a-quote-admin.css', array(), $this->version, 'all' );
		}
		wp_enqueue_style( $this->plugin_name . 'custom', GET_A_QUOTE_DIR_URL . 'admin/src/scss/get-a-quote-admin-custom.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function gaq_admin_enqueue_scripts( $hook ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_get_a_quote_menu' === $screen->id || 'quotes' === $screen->id || 'makewebbetter_page_get_a_quote_overview_menu' === $screen->id ) {
			wp_enqueue_script( 'mwb-gaq-select2', GET_A_QUOTE_DIR_URL . 'package/lib/select-2/get-a-quote-select2.js', array( 'jquery' ), time(), false );
			wp_enqueue_script( 'mwb-gaq-metarial-js', GET_A_QUOTE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-gaq-metarial-js2', GET_A_QUOTE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-gaq-metarial-lite', GET_A_QUOTE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );
			wp_enqueue_script( 'sweetalert', GET_A_QUOTE_DIR_URL . 'admin/src/js/sweet-alert.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'all-js', GET_A_QUOTE_DIR_URL . 'admin/src/js/all.js', array( 'jquery' ), $this->version, false );
			wp_register_script( $this->plugin_name . 'admin-js', GET_A_QUOTE_DIR_URL . 'admin/src/js/get-a-quote-admin.js', array( 'jquery', 'mwb-gaq-select2', 'mwb-gaq-metarial-js', 'mwb-gaq-metarial-js2', 'mwb-gaq-metarial-lite' ), $this->version, false );

			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'gaq_admin_param',
				array(
					'ajaxurl'            => admin_url( 'admin-ajax.php' ),
					'reloadurl'          => admin_url( 'admin.php?page=get_a_quote_menu' ),
					'gaq_gen_tab_enable' => get_option( 'gaq_radio_switch_demo' ),
				)
			);
			$terms_service = get_terms(
				array(
					'taxonomy'   => 'service',
					'hide_empty' => false,
				)
			);
			$terms_status  = get_terms(
				array(
					'taxonomy'   => 'status',
					'hide_empty' => false,
				)
			);
			$form_value = empty( get_option( 'mwb_gaq_save_form_data' ) ) ? '' : get_option( 'mwb_gaq_save_form_data' );
			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'taxonomy_values',
				array(
					'service'   => $terms_service,
					'status'    => $terms_status,
					'converted' => $form_value,
					'redirect'  => get_option( 'select_for_redirection' ),
				)
			);
			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'ajax_form_edit',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'mwb_gaq_edit_form_nonce' ),
				)
			);
			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
	}

	/**
	 * Adding settings menu for get-a-quote.
	 *
	 * @since    1.0.0
	 */
	public function gaq_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( 'MakeWebBetter', 'MakeWebBetter', 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), GET_A_QUOTE_DIR_URL . 'admin/src/images/MWB_White-01-01-01.svg', 15 );
			$gaq_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $gaq_menus ) && ! empty( $gaq_menus ) ) {
				foreach ( $gaq_menus as $gaq_key => $gaq_value ) {
					add_submenu_page( 'mwb-plugins', $gaq_value['name'], $gaq_value['name'], 'manage_options', $gaq_value['menu_link'], array( $gaq_value['instance'], $gaq_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since   1.0.0
	 */
	public function mwb_gaq_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}

	/**
	 * Gaq_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function gaq_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'      => __( 'Get A Quote', 'get-a-quote' ),
			'slug'      => 'get_a_quote_menu',
			'menu_link' => 'get_a_quote_menu',
			'instance'  => $this,
			'function'  => 'gaq_options_menu_html',
		);
		return $menus;
	}

	/**
	 * Mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require GET_A_QUOTE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * Gaq_options_menu_html
	 * Admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function gaq_options_menu_html() {
		include_once GET_A_QUOTE_DIR_PATH . 'admin/partials/get-a-quote-admin-dashboard.php';
	}

	/**
	 * Admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $gaq_settings_general Settings fields.
	 */
	public function gaq_admin_general_settings_page( $gaq_settings_general ) {
		$val = get_pages();
		$pages = array();
		foreach ( $val as $page ) {
			$pages[ $page->post_name ] = $page->post_name;
		}
		$gaq_settings_general = array(
			array(
				'title'       => __( 'Enable Quote Form', 'get-a-quote' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable plugin to start the functionality.', 'get-a-quote' ),
				'id'          => 'gaq_enable_quote_form',
				'value'       => get_option( 'gaq_enable_quote_form' ),
				'class'       => 'gaq-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'get-a-quote' ),
					'no' => __( 'NO', 'get-a-quote' ),
				),
			),
			// Feature Update in the version v1.0.1 Redirection After Submission.
			array(
				'title'       => __( 'Enable Redirection after Submission', 'get-a-quote' ),
				'type'        => 'select',
				'id'          => 'select_for_redirection',
				'value'       => get_option( 'select_for_redirection' ),
				'description' => 'Redirect to page after successful submission',
				'name'        => 'select_for_redirection',
				'class'       => 'gaq-select-class mwb_gaq_select',
				'options'     => array(
					'Yes' => __( 'Yes', 'get-a-quote' ),
					'No'  => __( 'No', 'get-a-quote' ),
				),
			),
			// Feature Update in the version v1.0.1 Redirection After Submission.
			array(
				'title'       => __( 'Redirection page', 'get-a-quote' ),
				'type'        => 'select',
				'wrap-class'     => 'redirection',
				'id'          => 'select_page_for_redirection',
				'value'       => get_option( 'select_page_for_redirection' ),
				'description' => 'Select the page you want user to get redirected',
				'name'        => 'select_page_for_redirection',
				'class'       => 'gaq-select-class mwb_gaq_select',
				'options'     => $pages,
			),
			array(
				'type'        => 'button',
				'id'          => 'mwb_gaq_setting_save',
				'button_text' => __( 'Save Changes', 'get-a-quote' ),
				'class'       => 'gaq-button-class',
			),
		);
		return $gaq_settings_general;
	}

	/**
	 * Save tab settings.
	 *
	 * @since 1.0.0
	 */
	public function gaq_admin_save_tab_settings() {

		global $gaq_mwb_gaq_obj, $error_notice;
		if ( isset( $_POST['general_nonce'] ) ) {
			$general_form_nonce = sanitize_text_field( wp_unslash( $_POST['general_nonce'] ) );
			if ( wp_verify_nonce( $general_form_nonce, 'general-form-nonce' ) ) {
				if ( isset( $_POST['mwb_gaq_setting_save'] ) ) {
					$mwb_gaq_gen_flag = false;
					$gaq_genaral_settings = apply_filters( 'gaq_general_settings_array', array() );
					$gaq_button_index = array_search( 'submit', array_column( $gaq_genaral_settings, 'type' ) );
					if ( isset( $gaq_button_index ) && ( null == $gaq_button_index || '' == $gaq_button_index ) ) {
						$gaq_button_index = array_search( 'button', array_column( $gaq_genaral_settings, 'type' ) );
					}
					if ( isset( $gaq_button_index ) && '' !== $gaq_button_index ) {
						unset( $gaq_genaral_settings[ $gaq_button_index ] );
						if ( is_array( $gaq_genaral_settings ) && ! empty( $gaq_genaral_settings ) ) {
							foreach ( $gaq_genaral_settings as $gaq_genaral_setting ) {
								if ( isset( $gaq_genaral_setting['id'] ) && '' !== $gaq_genaral_setting['id'] ) {
									if ( isset( $_POST[ $gaq_genaral_setting['id'] ] ) ) {
										update_option( $gaq_genaral_setting['id'], sanitize_text_field( wp_unslash( $_POST[ $gaq_genaral_setting['id'] ] ) ) );
									} else {
										update_option( $gaq_genaral_setting['id'], '' );
									}
								} else {
									$mwb_gaq_gen_flag = true;
								}
							}
						}
						if ( $mwb_gaq_gen_flag ) {
							$mwb_gaq_error_text = esc_html__( 'Id of some field is missing', 'get-a-quote' );
						} else {
							$error_notice = false;
						}
					}
				}
			}
		}
	}

	/**
	 * Gaq_adding_tabs
	 *
	 * @param array $tabs are used for the list of all tabs.
	 * @return $tabs updated list of tabs.
	 */
	public function gaq_adding_tabs( $tabs = array() ) {
		$tabs['get-a-quote-form-fields']   =
			array(
				'title' => esc_html__( 'Form Settings', 'get-a-quote' ),
				'name'  => 'get-a-quote-form-fields',
			);
		$tabs['get-a-quote-taxonomies']    =
			array(
				'title' => esc_html__( 'Taxonomies', 'get-a-quote' ),
				'name'  => 'get-a-quote-taxonomies',
			);
		$tabs['get-a-quote-email-setting'] = array(
			'title' => esc_html__( 'Email Setting', 'get-a-quote' ),
			'name'  => 'get-a-quote-email-setting',
		);
		$tabs['get-a-quote-admin-overview'] = array(
			'title' => esc_html__( 'Overview', 'get-a-quote' ),
			'name'  => 'get-a-quote-admin-overview',
		);

		return $tabs;
	}

	/**
	 * Get-a-quote admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $gaq_settings_template Settings fields.
	 */
	public function gaq_admin_email_settings_page( $gaq_settings_template ) {
		$values = get_option( 'mwb_gaq_email_fields_data' );
		$val    = '';
		if ( isset( $values ) ) {
			if ( isset( $values['mwb_gaq_enable_email_setting'] ) ) {
				( 'on' === $values['mwb_gaq_enable_email_setting'] ) ? $val = 'on' : $val = '';
			}
			isset( $values['sender_email'] ) ? esc_html( $values['sender_email'] ) : '';
			isset( $values['email_subject'] ) ? esc_html( $values['email_subject'] ) : '';
			isset( $values['emailmess'] ) ? esc_html( $values['emailmess'] ) : '';
		}
		$gaq_settings_template = array(
			array(
				'title'       => __( 'Activate Email', 'get-a-quote' ),
				'type'        => 'checkbox',
				'id'          => 'mwb_gaq_enable_email_setting',
				'name'        => 'mwb_gaq_enable_email_setting',
				'value'       => 'on',
				'description' => 'Activate this to send the mail on every successful submission of Quote.',
				'checked'     => $val,
				'class'       => 'gaq-checkbox-class mwb_gaq_enable_form_input',
			),
			array(
				'title'       => __( 'Get reply on email', 'get-a-quote' ),
				'type'        => 'email',
				'name'        => 'sender_email',
				'id'          => 'sender_email',
				'value'       => $values['sender_email'],
				'class'       => 'gaq-text-class',
				'description' => 'Mention the Email-ID here on which you want to answer query.',
				'placeholder' => __( 'Enter reply back email', 'get-a-quote' ),
			),
			array(
				'title'       => __( 'Email Subject', 'get-a-quote' ),
				'type'        => 'text',
				'id'          => 'email_subject',
				'name'        => 'email_subject',
				'value'       => $values['email_subject'],
				'class'       => 'gaq-text-class',
				'description' => 'Mention the subject you want to make in the mail on successful submission',
				'placeholder' => __( 'Subject Here', 'get-a-quote' ),
			),
			array(
				'title'       => __( 'Email Message', 'get-a-quote' ),
				'type'        => 'textarea',
				'id'          => 'emailmess',
				'name'        => 'emailmess',
				'value'       => $values['emailmess'],
				'class'       => 'gaq-textarea-class',
				'rows'        => '5',
				'cols'        => '10',
				'description' => 'Mention the message you to send on the successful submission',
				'placeholder' => __( 'Message Here', 'get-a-quote' ),
			),
			array(
				'type'        => 'submit',
				'id'          => 'mwb_gaq_email_fields_settings_save',
				'name'        => 'mwb_gaq_email_fields_settings_save',
				'button_text' => __( 'Save Changes', 'get-a-quote' ),
				'description' => 'Activate this to send the mail on every successful submission of Quote.',
				'class'       => 'gaq-button-class button-primary save-button',
			),
		);
		return $gaq_settings_template;
	}

	/**
	 * Get-a-quote admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $gaq_settings_template Settings fields.
	 */
	public function gaq_admin_taxonomies_button( $gaq_settings_template ) {
		$gaq_settings_template = array(
			array(
				'type'        => 'button',
				'id'          => 'mwb_gaq_taxonomies_common_settings_save',
				'name'        => 'mwb_gaq_taxonomies_common_settings_save',
				'button_text' => __( 'Save Changes', 'get-a-quote' ),
				'class'       => 'gaq-button-class button-primary save-button taxonomy-save',
			),
		);
		return $gaq_settings_template;
	}

	/**
	 * Get-a-quote admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $gaq_settings_template Settings fields.
	 */
	public function gaq_admin_taxonomies_settings_page( $gaq_settings_template ) {
		$values = get_option( 'mwb_gaq_taxonomies_options' );
		if ( isset( $values ) ) {
			if ( isset( $values['select_for_services'] ) ) {
				( 'No' === $values['select_for_services'] ) ? $valser = 'No' : $valser = 'Yes';
			} else {
				$valser = 'Yes';
			}
			if ( isset( $values['select_for_status'] ) ) {
				( 'No' === $values['select_for_status'] ) ? $valsat = 'No' : $valsat = 'Yes';
			} else {
				$valsat = 'Yes';
			}
		}
		$gaq_settings_template = array(
			array(
				'title'       => __( 'Enable Quote Status', 'get-a-quote' ),
				'type'        => 'select',
				'wrap-class'  => 'mwb_quote_status_gaq',
				'id'          => 'select_for_status',
				'value'       => $valsat,
				'description' => 'Enables the status of the quote submitted by the user.',
				'name'        => 'select_for_status',
				'class'       => 'gaq-select-class mwb_gaq_select',
				'options'     => array(
					'Yes' => __( 'Yes', 'get-a-quote' ),
					'No'  => __( 'No', 'get-a-quote' ),
				),
			),
			array(
				'title'       => __( 'Enable Service Type', 'get-a-quote' ),
				'type'        => 'select',
				'wrap-class'  => 'mwb_quote_service_gaq',
				'id'          => 'select_for_services',
				'value'       => $valser,
				'description' => 'Enables the service to the customer to query for.',
				'name'        => 'select_for_services',
				'class'       => 'gaq-select-class mwb_gaq_select',
				'options'     => array(
					'Yes' => __( 'Yes', 'get-a-quote' ),
					'No'  => __( 'No', 'get-a-quote' ),
				),
			),
		);
		return $gaq_settings_template;
	}

	/**
	 * Register the meta box for Quote submissions.
	 *
	 * @since    1.0.0
	 */
	public function insert_gaq_metabox() {
		add_meta_box( 'mwb_gaq_meta_box', esc_html__( 'Quote Details', 'get-a-quote' ), array( $this, 'gaq_metabox_callback' ), 'quotes' );
	}

	/**
	 * Render Content for the meta box.
	 *
	 * @since    1.0.0
	 */
	public function gaq_metabox_callback() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/meta-box/get-a-quote-custom-meta-box.php';
	}

	/**
	 * Add_gaq_columns.
	 * Register custom Columns for the post details.
	 *
	 * @param array $columns list of columns.
	 * @since    1.0.0
	 */
	public function add_gaq_columns( $columns ) {
		unset( $columns['title'] );
		unset( $columns['taxonomy-service'] );
		unset( $columns['taxonomy-status'] );
		unset( $columns['date'] );
		$columns['post_type_name'] = esc_html__( 'First Name', 'get-a-quote' );
		$value                     = get_option( 'mwb_gaq_taxonomies_options' );
		if ( ! isset( $value['select_for_services'] ) ) {
			$value['select_for_services'] = 'Yes';
		}
		if ( ! isset( $value['select_for_status'] ) ) {
			$value['select_for_status'] = 'Yes';
		}
		if ( 'Yes' === $value['select_for_services'] ) {
			$columns['taxonomy-service'] = esc_html__( 'Quote Service', 'get-a-quote' );
		}
		if ( 'Yes' === $value['select_for_status'] || '' === $value['select_for_status'] ) {
			$columns['taxonomy-status'] = esc_html__( 'Quote Status', 'get-a-quote' );
		}
		$columns['post_type_email'] = esc_html__( 'Email', 'get-a-quote' );
		$columns['post_type_phone'] = esc_html__( 'Phone', 'get-a-quote' );
		$columns['date']            = esc_html__( 'Date', 'get-a-quote' );
		return $columns;
	}

	/**
	 * Fill_gaq_columns.
	 * Register custom Columns for the post details.
	 *
	 * @param array  $column list of columns.
	 * @param  string $post_id list of id.
	 * @since    1.0.0
	 */
	public function fill_gaq_columns( $column, $post_id ) {
		$details = get_post_meta( $post_id, 'quotes_meta', true );
		$details = json_decode( wp_json_encode( $details ), true );

		switch ( $column ) {

			case 'post_type_email':
				$email = ! empty( $details['Email'] ) ? $details['Email'] : '';
				echo esc_html( $email );
				break;
			case 'post_type_name':
				$fname = ! empty( $details['firstname'] ) ? $details['firstname'] : '';
				$add   = admin_url( 'post.php?post=' . $post_id . '&amp;action=edit' );
				echo sprintf( '<a href="%s"><strong>%s</strong></a>', esc_html( $add ), esc_html( $fname ) );
				break;
			case 'post_type_phone':
				$phone = ! empty( $details['Phone'] ) ? $details['Phone'] : '';
				echo esc_html( $phone );
				break;
		}
	}

	/**
	 * Fill_cols.
	 * Unset columns of the actions shown in the edit row.
	 *
	 * @param array  $actions array of the list.
	 * @param object $post of the post.
	 */
	public function fill_cols( $actions, $post ) {
		if ( 'quotes' === $post->post_type ) {
			unset( $actions['inline hide-if-no-js'] );
			unset( $actions['view'] );
		}
		return $actions;
	}

	/**
	 * Add/Update submission at admin panel.cedcoss
	 *
	 * @since    1.0.0
	 */
	public function update_quote_callback() {

		// Return if doing autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Return if doing ajax :: Quick edits.
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		// Return on post trash, quick-edit, new post.
		if ( empty( $_POST['action'] ) || 'editpost' !== $_POST['action'] ) {
			return;
		}

		// Nonce verification.
		check_admin_referer( 'mwb_gaq_meta_box_nonce', 'mwb_gaq_meta_form' );

		// quotes post is updated here.
		$details = $this->gaq_helper->detailed_post_array( get_the_ID() );
		if ( isset( $_POST['firstname'] ) ) {
			$post_update_meta = array();
			$post_id          = get_the_ID();
			if ( isset( $_POST['tax_input'] ) ) {
				$post_update_meta['taxo_service'] = $this->gaq_helper->get_taxonomy( 'service', map_deep( wp_unslash( $_POST['tax_input'] ), 'sanitize_text_field' ) );
				$post_update_meta['status_taxo']  = $this->gaq_helper->get_taxonomy( 'status', map_deep( wp_unslash( $_POST['tax_input'] ), 'sanitize_text_field' ) );
			}
			$post_update_meta['firstname']  = ! empty( $_POST['firstname'] ) ? sanitize_text_field( wp_unslash( $_POST['firstname'] ) ) : '';
			$post_update_meta['Cityname']   = ! empty( $_POST['Cityname'] ) ? sanitize_text_field( wp_unslash( $_POST['Cityname'] ) ) : '';
			$post_update_meta['Zipcode']    = ! empty( $_POST['Zipcode'] ) ? sanitize_text_field( wp_unslash( $_POST['Zipcode'] ) ) : '';
			$post_update_meta['State']      = ! empty( $_POST['State'] ) ? sanitize_text_field( wp_unslash( $_POST['State'] ) ) : '';
			$post_update_meta['Country']    = ! empty( $_POST['Country'] ) ? sanitize_text_field( wp_unslash( $_POST['Country'] ) ) : '';
			$post_update_meta['Email']      = ! empty( $_POST['Email'] ) ? sanitize_text_field( wp_unslash( $_POST['Email'] ) ) : '';
			$post_update_meta['Phone']      = ! empty( $_POST['Phone'] ) ? sanitize_text_field( wp_unslash( $_POST['Phone'] ) ) : '';
			$post_update_meta['Budget']     = ! empty( $_POST['Budget'] ) ? sanitize_text_field( wp_unslash( $_POST['Budget'] ) ) : '';
			$post_update_meta['Additional'] = ! empty( $_POST['Additional'] ) ? sanitize_text_field( wp_unslash( $_POST['Additional'] ) ) : '';
			$post_update_meta['filename']   = ! empty( $details['filename'] ) ? sanitize_text_field( wp_unslash( $details['filename'] ) ) : '';
			$post_update_meta['status']     = ! empty( $details['status'] ) ? sanitize_text_field( wp_unslash( $details['status'] ) ) : '';
			$post_update_meta['filelink']   = ! empty( $details['filelink'] ) ? sanitize_text_field( wp_unslash( $details['filelink'] ) ) : '';

			if ( ! empty( $post_update_meta ) ) {

				update_post_meta( $post_id, 'quotes_meta', $post_update_meta );

			}
		}
	}

	/**
	 * Get all valid screens to add scripts and templates.
	 *
	 * @param array $valid_screens validated screen.
	 * @since    1.0.0
	 */
	public function add_mwb_frontend_screens( $valid_screens = array() ) {

		if ( is_array( $valid_screens ) ) {

			// Push your screen here.
			array_push( $valid_screens, 'makewebbetter_page_get_a_quote_menu' );
		}
		return $valid_screens;
	}

	/**
	 * Get all valid slugs to add deactivate popup.
	 *
	 * @param array $valid_screens validated screen.
	 * @since    1.0.0
	 */
	public function add_mwb_deactivation_screens( $valid_screens = array() ) {

		if ( is_array( $valid_screens ) ) {

			// Push your screen here.
			array_push( $valid_screens, 'get-a-quote' );
		}

		return $valid_screens;
	}

}
