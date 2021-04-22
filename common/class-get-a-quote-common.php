<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
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
class Get_A_Quote_Common
{

	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Base url of hubspot api for get-a-quote.
	 *
	 * @since 1.0.0
	 * @var   string base url of API.
	 */
	private $mwb_gaq_base_url = 'https://api.hsforms.com/';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version )
	{
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->gaq_helper  = Get_A_Quote_Helper::get_instance();
		$this->gaq_country = GAQ_Country_Manager::get_instance();
	}

	/**
	 * Register Quote Post Type.
	 *
	 * @return void
	 */
	public function register_post_type_quote()
	{

		$labels = array(
		'name'               => esc_html__('Quotes', 'get-a-quote'),
		'singular_name'      => esc_html__('Quote', 'get-a-quote'),
		'add_new'            => esc_html__('Add New', 'get-a-quote'),
		'add_new_item'       => esc_html__('Add New Quote', 'get-a-quote'),
		'edit_item'          => esc_html__('Edit Quote', 'get-a-quote'),
		'new_item'           => esc_html__('New Quote', 'get-a-quote'),
		'all_items'          => esc_html__('All Quotes', 'get-a-quote'),
		'view_item'          => esc_html__('View Quote', 'get-a-quote'),
		'search_items'       => esc_html__('Search Quotes', 'get-a-quote'),
		'not_found'          => esc_html__('No Quotes Found', 'get-a-quote'),
		'not_found_in_trash' => esc_html__('No Quotes Found In Trash', 'get-a-quote'),
		'menu_name'          => esc_html__('Quotes', 'get-a-quote'),
		);

		register_post_type(
			'quotes',
			array(
			'supports'            => array( '' ),
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 10,
			'menu_icon'           => 'dashicons-twitch',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => array( 'slug' => 'quotes-submission' ), // my custom slug.
			'capability_type'     => 'post',
			)
		);
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
		'show_admin_column' => false,
		'show_tagcloud'     => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'service' ),
		);

		register_taxonomy('service', 'quotes', $args);
		$register = array(
		array(
		'label'       => esc_html__('Quotation', 'get-a-quote'),
		'description' => esc_html__('Quote', 'get-a-quote'),
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
		'name'              => esc_html__('Quote Status', 'get-a-quote'),
		'singular_name'     => esc_html__('Status', 'get-a-quote'),
		'search_items'      => esc_html__('Search Status', 'get-a-quote'),
		'all_items'         => esc_html__('All Status', 'get-a-quote'),
		'parent_item'       => esc_html__('Parent Status', 'get-a-quote'),
		'parent_item_colon' => esc_html__('Parent Status:', 'get-a-quote'),
		'edit_item'         => esc_html('Edit Status'),
		'update_item'       => esc_html__('Update Status', 'get-a-quote'),
		'add_new_item'      => esc_html__('Add New Status', 'get-a-quote'),
		'new_item_name'     => esc_html__('New Status Name', 'get-a-quote'),
		'menu_name'         => esc_html__('Quote Statuses', 'get-a-quote'),
		);
		$args   =
		array(
		'hierarchical' => true,
		'labels'       => $labels,
		'show_ui'      => true,
		'query_var'    => true,
		'show_in_rest' => true,
		'rewrite'      => array( 'slug' => 'status' ),
		);

		register_taxonomy('status', 'quotes', $args);

		$register = array(
		array(
		'label'       => esc_html__('Pending', 'get-a-quote'),
		'description' => esc_html__('Pending For Review', 'get-a-quote'),
		),
		);
		$this->gaq_helper->insert_default_quote_taxonomies($register, 'status');
	}

	/**
	 * Trigger_edit_form_data
	 * It is for  the edit form setting.
	 */
	public function trigger_country_list()
	{

		// Nonce verification.
		check_ajax_referer('mwb_gaq_edit_form_nonce', '_ajax_nonce');

		if (isset($_POST['action']) ) {

			if (isset($_POST['message']) ) {

				$list = $this->gaq_helper->mwb_gaq_get_country_list();

				echo wp_json_encode($list);

				wp_die();
			}
		}
	}

	/**
	 * Trigger_edit_form_data
	 * It is for  the edit form setting.
	 */
	public function trigger_country_list_public()
	{

		// Nonce verification.
		check_ajax_referer('country_ajax', '_ajax_nonce');

		if (isset($_POST['action']) ) {

			if (isset($_POST['message']) && 'get_country_list' === $_POST['message'] ) {

				$list = $this->gaq_helper->mwb_gaq_get_country_list();

				echo wp_json_encode($list);

				wp_die();
			}

			if (isset($_POST['message']) && isset($_POST['country']) ) {

				$country = sanitize_text_field(wp_unslash($_POST['country']));
				$list    = $this->gaq_country->country_states($country);

				echo wp_json_encode($list);

				wp_die();
			}
		}
	}

	/**
	 * Trigger_edit_form_data
	 * It is for  the edit form setting.
	 */
	public function trigger_edit_form_data()
	{

		// Nonce verification.
		check_ajax_referer('mwb_gaq_edit_form_nonce', '_ajax_nonce');

		if (isset($_POST['action']) ) {

			if (isset($_POST['datalist']) ) {

				$resultf = map_deep(wp_unslash($_POST['datalist']), 'sanitize_text_field');

				update_option('mwb_gaq_edit_form_data', $resultf);

				$resultf = 'success';

				echo wp_json_encode($resultf);

			}

			if (isset($_POST['savinglist']) ) {

				$data = map_deep(wp_unslash($_POST['savinglist']), 'sanitize_text_field');

				update_option('mwb_gaq_save_form_data', $data);

				$results = 'form saved';

				echo wp_json_encode($results);

			}

			if (isset($_POST['term_name']) && isset($_POST['taxonomy_name']) ) {

				$resultt = wp_delete_term(sanitize_text_field(wp_unslash($_POST['term_name'])), sanitize_text_field(wp_unslash($_POST['taxonomy_name'])));

				echo wp_json_encode($resultt);

			}

			wp_die();

		}

	}

	/**
	 * Trigger_form_submission for form submission.
	 *
	 * @return void
	 */
	public function trigger_form_submission()
	{
		session_start();
		if ( 'on' === get_option( 'gaq_enable_quote_form' ) ) {

			check_ajax_referer( 'form_data_nonce', 'nonce' );

			if ( isset( $_POST['action'] ) && isset( $_POST['vercode'] ) ) {

				$result = map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );
				if ( $result['vercode'] != $_SESSION['vercode'] ) {
					$response = 'Captcha Not Verified';

				} else {

					foreach ( $result as $key => $value ) {
						if ( 'action' !== $key && 'vercode' !== $key ) {
							$data[ $key ] = $value;
						}
					}
					$service              = $data['taxo_service'];

					$data                 = $this->gaq_helper->vali_dation( $data );

					$data['taxo_service'] = $service;

					$data['status_taxo']  = 'Pending';

					if ( ! isset( $data['action'] ) ) {

						if ( isset( $data['firstname'] ) ) {

							$my_post_details = array(

								'post_title'  => $data['firstname'],

								'post_type'   => 'quotes',

								'post_status' => 'publish',

							);

						}

						$post_id = wp_insert_post( $my_post_details );
						// file upload procedure begin.
						if ( ! empty( $_FILES['Files']['name'] ) ) {

							$data['status'] = 'true';

							$file_name  = isset( $_FILES['Files']['name'] ) ?

							sanitize_textarea_field( wp_unslash( $_FILES['Files']['name'] ) ) : '';

							$file_tmp   = isset( $_FILES['Files']['tmp_name'] ) ?

							sanitize_textarea_field( wp_unslash( $_FILES['Files']['tmp_name'] ) ) : '';

							$file_type = isset( $_FILES['Files']['type'] ) ?

							sanitize_textarea_field( wp_unslash( $_FILES['Files']['type'] ) ) : '';

							$file_ext   = wp_check_filetype( basename( $file_name ), null );

							$extensions = array( 'png', 'jpeg', 'jpg' );

							if ( ! empty( $file_ext['ext'] ) ) {

								if ( ! in_array( $file_ext['ext'], $extensions, true ) ) {

									echo json_encode( 'This extension is not allowed, please choose a "png", "jpeg", "jpg" extension file.' );

									wp_delete_post( $post_id );

									wp_die();

								}
							}

							$data_dir = wp_upload_dir();

							$loc     = $data_dir['baseurl'] . '/quote-submission';

							$log_dir = WP_CONTENT_DIR . '/uploads/quote-submission';

							if ( ! is_dir( $log_dir ) ) {

								mkdir( $log_dir, 0755, true );

							}

							if ( empty( $err ) ) {

								$new_file_name = 'quote_' . $post_id . '.' . $file_ext['ext'];

								$loc           = $loc . '/' . $new_file_name;

								$file_add      = $log_dir . '/' . $new_file_name;

								move_uploaded_file( $file_tmp, $file_add );

								if ( ! empty( $file_add ) ) {

									$this->gaq_helper->create_attachment( $post_id, $file_add );

									$data['filename'] = $new_file_name;

									$data['filelink'] = $loc;

									$response         = 'Success';

									$email_activator  = get_option( 'mwb_gaq_activate_email' );

									if ( 'on' === $email_activator ) {

										$mail = $this->gaq_helper->email_sending( $post_id );

									}
								}
							} else {

								$response = 'Failed';

							}
						} else {

							$data['status'] = 'false';

						}//file upload procedure end.

						// formdata pushing to DB.
						if ( ! empty( $data ) ) {

							update_post_meta( $post_id, 'quotes_meta', $data );

							// Mail sending.

							if ( ! empty( $data['Email'] && isset( $data['Email'] ) ) ) {

								$email_activator = get_option( 'mwb_gaq_activate_email' );

								if ( 'on' === $email_activator ) {

									$mail = $this->gaq_helper->email_sending( $post_id );

									$respo = 'mail sent';

								}
							} //mail sending end here

							$response = 'updated';

							$this->gaq_helper->set_taxonomy( $post_id );

						}
					} else {

						foreach ( $data as $key => $value ) {

							$response = $data[ $key ];

							break;

						}
					}
				}
				// ajax response here.
				echo json_encode( $response );
				wp_die();
			}
		} else {
			$response = 'Deactivated';
			echo json_encode( $response );
			wp_die();
		}

	}

	/**
	 * Disable_new_posts for form submission.
	 *
	 * @return void
	 */
	public function disable_new_posts()
	{

		// Hide sidebar link.

		global $submenu;

		unset($submenu['edit.php?post_type=quotes'][10]);

		unset($submenu['edit.php?post_type=quotes'][15]);

		unset($submenu['edit.php?post_type=quotes'][16]);

	}


}
