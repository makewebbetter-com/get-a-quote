<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
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

if ( isset( $_POST['email_form_nonce'] ) ) {
	$email_form_nonce = sanitize_text_field( wp_unslash( $_POST['email_form_nonce'] ) );
	if ( wp_verify_nonce( $email_form_nonce, 'email-form-nonce' ) ) {
		unset( $_POST['mwb_gaq_email_fields_settings_save'] );

		$mwb_gaq_email_fields_settings = array();

		$mwb_gaq_email_fields_settings['mwb_gaq_enable_email_setting'] = isset( $_POST['mwb_gaq_enable_email_setting'] ) ? 'on' : 'off';

		$mwb_gaq_email_fields_settings['sender_email'] = ! empty( $_POST['sender_email'] ) ? sanitize_text_field( wp_unslash( $_POST['sender_email'] ) ) : '';

		$mwb_gaq_email_fields_settings['email_subject'] = ! empty( $_POST['email_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['email_subject'] ) ) : '';

		$mwb_gaq_email_fields_settings['emailmess'] = ! empty( $_POST['emailmess'] ) ? sanitize_textarea_field( wp_unslash( $_POST['emailmess'] ) ) : '';

		update_option( 'mwb_gaq_activate_email', $mwb_gaq_email_fields_settings['mwb_gaq_enable_email_setting'] );
		update_option( 'mwb_gaq_email_fields_data', $mwb_gaq_email_fields_settings );

		?>
		<div class="notice notice-success is-dismissible">
			<p><strong><?php esc_html_e( 'Settings saved', 'GAQ_TEXT_DOMAIN' ); ?></strong></p>
		</div>
		<?php
	}
}

$mwb_gaq_activate_email = get_option( 'mwb_gaq_email_fields_data' );
?>

<form class="mwb_email_setting_form" action="" method="POST">
	<input type="hidden" name="email_form_nonce" value="<?php echo esc_html( wp_create_nonce( 'email-form-nonce' ) ); ?>"/>
	<div class="wp-tooltip-label">
		<div class="mwb_gaq_email_sett_table">
			<table class="form-table mwb_gaq_email_setting">
				<tbody>
					<?php
					global $gaq_mwb_gaq_obj;
					$gaq_template_settings = apply_filters( 'gaq_email_settings_array', array() );
					?>
					<!--  template file for admin settings. -->
					<?php
						$gaq_template_html = $gaq_mwb_gaq_obj->mwb_gaq_plug_generate_html( $gaq_template_settings );
						echo esc_html( $gaq_template_html );
					?>
				</tbody>
			</table>
		</div>
	</div>
</form>

