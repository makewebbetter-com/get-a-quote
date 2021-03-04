<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $gaq_mwb_gaq_obj;
$gaq_genaral_settings = apply_filters( 'gaq_general_settings_array', array() );
if ( isset( $_POST['mwb_gaq_setting_save'] ) ) {
	if ( ! isset( $_POST['gaq_enable_quote_form'] ) ) {
		$_POST['gaq_enable_quote_form'] = 'off';
	}
	update_option( 'gaq_enable_quote_form_switch', $_POST['gaq_enable_quote_form'] );
}
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-gaq-gen-section-form">
	<div class="gaq-secion-wrap">
		<?php
		$gaq_general_html = $gaq_mwb_gaq_obj->mwb_gaq_plug_generate_html( $gaq_genaral_settings );
		echo esc_html( $gaq_general_html );
		?>
	</div>
</form>