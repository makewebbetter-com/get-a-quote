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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode( 'fform', [ $this,  'Quote_form' ] );

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/get-a-quote-public.js', array( 'jquery' ), $this->version, false );

	}
	public function Quote_form() {
		$args = array(
			'name' => 'Services',
		);
		$taxo = get_taxonomies( $args );
		print_r( $taxo );

		if ( isset( $_POST['qsubmit'] ) ) {
			$mwb_gaq_form_fields_value = array();

		}
		$mwb_gaq_form_fields_option = get_option( 'mwb_gaq_form_fields_options', array() );
		$mwb_gaq_enable_form = get_option('mwb_gaq_form_enable');
		if ( 'on' === $mwb_gaq_enable_form ) {
			?>

			<form action="" method="post">

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_fname_field'] ) { ?>

				<p>

					<label>First Name</label><br />

					<?php $ffname = isset( $mwb_upsell_global_settings['ffname'] ) ? $mwb_upsell_global_settings['ffname'] : ''; ?>

					<input type="text" name="ffname" pattern="[a-zA-Z0-9 ]+" value="<?php echo esc_html__( wp_unslash( $ffname ) ); ?>" size="40" placeholder="First Name" />
				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_lname_field'] ) { ?>

				<p>

					<label>Last Name</label><br />

					<?php $fqlname = isset( $mwb_upsell_global_settings['fqlname'] ) ? $mwb_upsell_global_settings['fqlname'] : ''; ?>

					<input type="text" name="fqlname" pattern="[a-zA-Z0-9 ]+" value="<?php echo esc_html__( wp_unslash( $fqlname ) ); ?>" size="40" placeholder="Last Name" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_address_field'] ) { ?>

				<p>

					<label>Address</label><br />

					<?php $fqaddress = isset( $mwb_upsell_global_settings['fqaddress'] ) ? $mwb_upsell_global_settings['fqaddress'] : ''; ?>

					<input type="text" name="fqaddress" value="<?php echo esc_html__( wp_unslash( $fqaddress ) ); ?>" size="40" placeholder="Address" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_city_field'] ) { ?>

				<p>
					<label>City</label><br />

					<?php $fqcity = isset( $mwb_upsell_global_settings['fqcity'] ) ? $mwb_upsell_global_settings['fqcity'] : ''; ?>

					<input type="text" name="fqcity" value="<?php echo esc_html__( wp_unslash( $fqcity ) ); ?>" size="40" placeholder="City" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_zipcode_field'] ) { ?>

				<p>

					<label>Zipcode</label><br />

					<?php $fqzipcode = isset( $mwb_upsell_global_settings['fqzipcode'] ) ? $mwb_upsell_global_settings['fqzipcode'] : ''; ?>

					<input type="text" name="fqzipcode" value="<?php echo esc_html__( wp_unslash( $fqzipcode ) ); ?>" size="40" placeholder="Zipcode" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_country_field'] ) { ?>

				<p>

					<label>Country</label><br />

					<?php $fqcountry = isset( $mwb_upsell_global_settings['fqcountry'] ) ? $mwb_upsell_global_settings['fqcountry'] : ''; ?>

					<input type="text" name="fqcountry" value="<?php echo esc_html__( wp_unslash( $fqcountry ) ); ?>" size="40" placeholder="Country" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_states_field'] ) { ?>

				<p>

					<label>States</label><br />

					<?php $fqstates = isset( $mwb_upsell_global_settings['fqstates'] ) ? $mwb_upsell_global_settings['fqstates'] : ''; ?>

					<input type="text" name="fqstates" value="<?php echo esc_html__( wp_unslash( $fqstates ) ); ?>" size="40" placeholder="States" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_email_field'] ) { ?>

				<p>
					<label>Email</label><br />

					<?php $fqemail = isset( $mwb_upsell_global_settings['fqemail'] ) ? $mwb_upsell_global_settings['fqemail'] : ''; ?>

					<input type="text" name="fqemail" value="<?php echo esc_html__( wp_unslash( $fqemail ) ); ?>" size="40" placeholder="Email" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_phone_field'] ) { ?>

				<p>

					<label>Phone</label><br />

					<?php $fqphone = isset( $mwb_upsell_global_settings['fqphone'] ) ? $mwb_upsell_global_settings['fqphone'] : ''; ?>

					<input type="text" name="fqphone" value="<?php echo esc_html__( wp_unslash( $fqphone ) ); ?>" size="40" placeholder="Phone" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_budget_field'] ) { ?>

				<p>
					<label>Budget</label><br />

					<?php $fqbudget = isset( $mwb_upsell_global_settings['fqbudget'] ) ? $mwb_upsell_global_settings['fqbudget'] : ''; ?>

					<input type="text" name="fqbudget" value="<?php echo esc_html__( wp_unslash( $fqbudget ) ); ?>" size="40" placeholder="Budget" />

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_additional_field'] ) { ?>

				<p>

					<label>Additional</label><br />

					<?php $fqadd = isset( $mwb_upsell_global_settings['fqadd'] ) ? $mwb_upsell_global_settings['fqadd'] : ''; ?>

					<textarea name="fqadd" rows="3" cols="50" ><?php echo esc_html__( wp_unslash( $fqadd ) ); ?></textarea>

				</p>

			<?php } ?>

			<?php if ( 'yes' === $mwb_gaq_form_fields_option['select_for_fileup_field'] ) { ?>

				<p>

					<label> Max Size: 3MB</label><br />

					<?php $fqfile = isset( $mwb_upsell_global_settings['fqfile'] ) ? $mwb_upsell_global_settings['fqfile'] : ''; ?>

					<input type="button" name="fqfile" size="40" value="Upload File" />

				</p>

			<?php } ?>

				<input type="submit" name="qsubmit" value="Submit">

			</form>

			<?php
		}
	}

}
