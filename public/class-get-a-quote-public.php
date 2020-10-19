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
	public function Quote_form() {?>
		<form method="post">
		<p>
			<label>First Name</label><br />
			<input type="text" name="qfname" pattern="[a-zA-Z0-9 ]+" value="" size="40" placeholder="First Name" />
		</p>
		<p>
			<label>Last Name</label><br />
			<input type="text" name="qlname" pattern="[a-zA-Z0-9 ]+" value="" size="40" placeholder="Last Name" />
		</p>
		<p>
			<label>Address</label><br />
			<input type="text" name="qaddress" value="" size="40" placeholder="Address" />
		</p>
		<p>
			<label>City</label><br />
			<input type="text" name="qcity" value="" size="40" placeholder="City" />
		</p>
		<p>
			<label>Zipcode</label><br />
			<input type="text" name="qzipcode" value="" size="40" placeholder="Zipcode" />
		</p>
		<p>
			<label>Country</label><br />
			<input type="text" name="qcountry" value="" size="40" placeholder="Country" />
		</p>
		<p>
			<label>States</label><br />
			<input type="text" name="qstates" value="" size="40" placeholder="States" />
		</p>
		<p>
			<label>Email</label><br />
			<input type="text" name="qemail" value="" size="40" placeholder="Email" />
		</p>
		<p>
			<label>Phone</label><br />
			<input type="text" name="qphone" value="" size="40" placeholder="Phone" />
		</p>
		<p>
			<label>Budget</label><br />
			<input type="text" name="qbudget" value="" size="40" placeholder="Budget" />
		</p>
		<p>
			<label>Additional</label><br />
			<textarea name="qadd" rows="3" cols="50" ></textarea>
		</p>
		<p>
			<label> Max Size: 3MB</label><br />
			<input type="button" name="qfile" size="40" value="Upload File" />
		</p>
		<input type="submit" name="qsubmit" value="Submit"><?php
	}

}
