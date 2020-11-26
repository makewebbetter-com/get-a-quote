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
class Get_A_Quote_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_shortcode('fform', [$this, 'Quote_form']);

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/get-a-quote-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/get-a-quote-public.js', array('jquery'), $this->version, false);

    }

    /**
     * Quote_form
     * this function is used to print form and modify all its fields
     *
     * @return void
     */
    public function Quote_form()
    {
        $recent_post_id = 0;
        if (isset($_POST['qsubmit'])) {
            $mwb_gaq_form_data = array();

            $mwb_gaq_form_data['ffname'] = !empty($_POST['ffname']) ? sanitize_text_field(wp_unslash($_POST['ffname'])) : '';

            $mwb_gaq_form_data['fqlname'] = !empty($_POST['fqlname']) ? sanitize_text_field(wp_unslash($_POST['fqlname'])) : '';

            $mwb_gaq_form_data['fqaddress'] = !empty($_POST['fqaddress']) ? sanitize_text_field(wp_unslash($_POST['fqaddress'])) : '';

            $mwb_gaq_form_data['fqcity'] = !empty($_POST['fqcity']) ? sanitize_text_field(wp_unslash($_POST['fqcity'])) : '';

            $mwb_gaq_form_data['fqzipcode'] = !empty($_POST['fqzipcode']) ? sanitize_text_field(wp_unslash($_POST['fqzipcode'])) : '';

            $mwb_gaq_form_data['fqcountry'] = !empty($_POST['fqcountry']) ? sanitize_text_field(wp_unslash($_POST['fqcountry'])) : '';

            $mwb_gaq_form_data['fqstates'] = !empty($_POST['fqstates']) ? sanitize_text_field(wp_unslash($_POST['fqstates'])) : '';

            $mwb_gaq_form_data['fqemail'] = !empty($_POST['fqemail']) ? sanitize_text_field(wp_unslash($_POST['fqemail'])) : '';

            $mwb_gaq_form_data['fqphone'] = !empty($_POST['fqphone']) ? sanitize_text_field(wp_unslash($_POST['fqphone'])) : '';

            $mwb_gaq_form_data['fqbudget'] = !empty($_POST['fqbudget']) ? sanitize_text_field(wp_unslash($_POST['fqbudget'])) : '';

            $mwb_gaq_form_data['fqadd'] = !empty($_POST['fqadd']) ? sanitize_textarea_field(wp_unslash($_POST['fqadd'])) : '';

            if (!empty($mwb_gaq_form_data['ffname']) && !empty($mwb_gaq_form_data['fqlname']) && !empty($mwb_gaq_form_data['fqemail'])) {

                $my_post_details = array(
                    'post_author' => $mwb_gaq_form_data['ffname'],
                    'post_type' => 'quotes',
                    'post_status' => 'publish',
                );
                wp_insert_post($my_post_details);

                // $latest_books = wp_get_recent_post( $args );
                $recent_posts = get_posts(array(
                    'fields' => 'ids',
                    'post_type' => 'quotes')
				);
				
                // wp_get_recent_post()
				$recent_post_id = $recent_posts[0];
				// echo '<pre>'; print_r( $_POST ); echo '</pre>';
                if( !empty( $_FILES['fqfiles']['name'] ) ) {
					echo '<pre>'; print_r( $_FILES ); echo '</pre>';
					// echo '<pre>'; print_r( $_POST['fqfile'] ); echo '</pre>';
                    $errors = array();
					$file_name = $_FILES['fqfile']['name'];
                    // $file_size   = $_FILES['fqfile']['size'];
                    $file_tmp = $_FILES['fqfile']['tmp_name'];
                    $file_type = $_FILES['fqfile']['type'];
                    $file_ext = strtolower(end(explode('.', $_FILES['fqfile']['name'])));

                    $extensions = array("pdf", "docx", "txt", "png");
                    //echo '<pre>'; print_r( $FILE ); echo '</pre>';
					// die();
					if( ! empty ($file_ext)) {
						if (in_array($file_ext, $extensions) === false) {
							$errors[] = "extension not allowed, please choose a pdf or docx file.";
						}
					}
                    $log_dir = ABSPATH . "wp-content/uploads/quote-submission";
                    if (!is_dir($log_dir)) {

                        mkdir($log_dir, 0755, true);
					}

					$mwb_gaq_form_data['fqfilename'] = '';

                    if (empty($errors) == true) {
                        $mwb_gaq_form_data['fqfilename'] = "quote_" . $recent_post_id . "." . $file_ext;
                        move_uploaded_file($file_tmp, $log_dir . "/" . $mwb_gaq_form_data['fqfilename']);
                        echo "Success";

                    } else {
                        echo "\t";
                        print_r($errors);
                        echo "\t";
                    }
                }
                $data = array('quotes_meta' => $mwb_gaq_form_data);
				update_post_meta($recent_post_id, 'quotes_meta', $data);
				// $to = $mwb_gaq_form_data['fqemail'];
				// $subject = "Thank you we recieved your query.";
				// $headers = "Quotations";
				// $message = 'Thank you for choosing us';
				// $attachments = '';
				// $bool = WC_Emails::send( $to, $subject, $message, $headers, $attachments );
				// print_r( $bool );
				$header = array( 'Content-Type: text/html; charset=UTF-8' );
				wp_mail("shaileshkumardubey@makewebbetter.com", "Subject", "Message", $header);
                // print_r( $recent_post_id );
                ?>
				</ul>
					<div class="notice notice-success is-dismissible">
						<p><strong><?php esc_html_e('Thank you', 'get-a-quote');?></strong></p>
					</div>
				<?php
} else {
                ?>
					<div class="notice-success is-dismissible">
						<p><strong><?php esc_html_e('Issue in required Fields', 'get-a-quote');?></strong></p>
					</div>
				<?php
}
        }
        $mwb_gaq_form_fields_option = get_option('mwb_gaq_form_fields_options', array());
        $mwb_gaq_enable_form = get_option('mwb_gaq_form_enable');
        if ('on' === $mwb_gaq_enable_form) {
            // $last_post_id = get_post();
            // print_r( $last_post_id );
            // $mwb_gaq_form_values = get_option( 'mwb_gaq_form_option_value' );
            ?>
			<?php $fqfile = isset($mwb_gaq_form_values['fqfile']) ? $mwb_gaq_form_values['fqfile'] : '';?>

			<form action="" method="POST" enctype="multipart/form-data"  >

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_fname_field']) {?>

				<p>

					<label><?php esc_html_e('First Name', 'get-a-quote');?></label><span class="required">*</span><br />

					<?php $ffname = isset($mwb_gaq_form_values['ffname']) ? $mwb_gaq_form_values['ffname'] : '';?>

					<input type="text" name="ffname" pattern="[a-zA-Z0-9 ]+" required="required" value="<?php echo esc_html__(wp_unslash($ffname)); ?>" size="40" placeholder="First Name" />
				
				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_lname_field']) {?>

				<p>

					<label><?php esc_html_e('Last Name', 'get-a-quote');?></label><span class="required">*</span><br />

					<?php $fqlname = isset($mwb_gaq_form_values['fqlname']) ? $mwb_gaq_form_values['fqlname'] : '';?>

					<input type="text" name="fqlname" pattern="[a-zA-Z0-9 ]+" required="required" value="<?php echo esc_html__(wp_unslash($fqlname)); ?>" size="40" placeholder="Last Name" />
				
				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_address_field']) {?>

				<p>

					<label><?php esc_html_e('Address', 'get-a-quote');?></label><br />

					<?php $fqaddress = isset($mwb_gaq_form_values['fqaddress']) ? $mwb_gaq_form_values['fqaddress'] : '';?>

					<input type="text" name="fqaddress" value="<?php echo esc_html__(wp_unslash($fqaddress)); ?>" size="40" placeholder="Address" />

				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_city_field']) {?>

				<p>
					<label><?php esc_html_e('City', 'get-a-quote');?></label><br />

					<?php $fqcity = isset($mwb_gaq_form_values['fqcity']) ? $mwb_gaq_form_values['fqcity'] : '';?>

					<input type="text" name="fqcity" value="<?php echo esc_html__(wp_unslash($fqcity)); ?>" size="40" placeholder="City" />

				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_zipcode_field']) {?>

				<p>

					<label><?php esc_html_e('Zipcode', 'get-a-quote');?></label><br />

					<?php $fqzipcode = isset($mwb_gaq_form_values['fqzipcode']) ? $mwb_gaq_form_values['fqzipcode'] : '';?>

					<input type="text" name="fqzipcode" value="<?php echo esc_html__(wp_unslash($fqzipcode)); ?>" size="40" placeholder="Zipcode" />

				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_country_field']) {?>

				<p>

					<label><?php esc_html_e('Country', 'get-a-quote');?></label><br />

					<?php $fqcountry = isset($mwb_gaq_form_values['fqcountry']) ? $mwb_gaq_form_values['fqcountry'] : '';?>

					<input type="text" name="fqcountry" value="<?php echo esc_html__(wp_unslash($fqcountry)); ?>" size="40" placeholder="Country" />

				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_states_field']) {?>

				<p>

					<label><?php esc_html_e('States', 'get-a-quote');?></label><br />

					<?php $fqstates = isset($mwb_gaq_form_values['fqstates']) ? $mwb_gaq_form_values['fqstates'] : '';?>

					<input type="text" name="fqstates" value="<?php echo esc_html__(wp_unslash($fqstates)); ?>" size="40" placeholder="States" />

				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_email_field']) {?>

				<p>

					<label><?php esc_html_e('Email', 'get-a-quote');?></label><span class="required">*</span><br />

					<?php $fqemail = isset($mwb_gaq_form_values['fqemail']) ? $mwb_gaq_form_values['fqemail'] : '';?>

					<input type="email" name="fqemail" required="required" value="<?php echo esc_html__(wp_unslash($fqemail)); ?>" size="40" placeholder="Email" />
				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_phone_field']) {?>

				<p>

					<label><?php esc_html_e('Phone', 'get-a-quote');?></label><br />

					<?php $fqphone = isset($mwb_gaq_form_values['fqphone']) ? $mwb_gaq_form_values['fqphone'] : '';?>

					<input type="text" name="fqphone" value="<?php echo esc_html__(wp_unslash($fqphone)); ?>" size="40" placeholder="Phone" />

				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_budget_field']) {?>

				<p>
					<label><?php esc_html_e('Budget', 'get-a-quote');?></label><br />

					<?php $fqbudget = isset($mwb_gaq_form_values['fqbudget']) ? $mwb_gaq_form_values['fqbudget'] : '';?>

					<input type="text" name="fqbudget" value="<?php echo esc_html__(wp_unslash($fqbudget)); ?>" size="40" placeholder="Budget" />

				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_additional_field']) {?>

				<p>

					<label><?php esc_html_e('Additional', 'get-a-quote');?></label><br />

					<?php $fqadd = isset($mwb_gaq_form_values['fqadd']) ? $mwb_gaq_form_values['fqadd'] : '';?>

					<textarea name="fqadd" rows="3" cols="50" ><?php echo esc_html__(wp_unslash($fqadd)); ?></textarea>

				</p>

			<?php }?>

			<?php if ('yes' === $mwb_gaq_form_fields_option['select_for_fileup_field']) {?>

				<p>

					<label><?php esc_html_e(' Max Size: 3MB ', 'get-a-quote');?></label><br>

					<input type="file" name="fqfiles" id="fileToUpload">

				</p>

			<?php }?>

				<input type="submit" name="qsubmit" value="Submit">

			</form>

			<?php
}
    }
}
