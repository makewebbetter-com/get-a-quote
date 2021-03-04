<?php
/**
 * @package Get_A_Quote
 *
 * Exit if accessed directly
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $_POST['mwb_gaq_email_fields_settings_save'] ) ) {
	unset( $_POST['mwb_gaq_email_fields_settings_save'] );

	$mwb_gaq_email_fields_settings = array();

	$mwb_gaq_email_fields_settings['mwb_gaq_enable_email_setting'] = isset($_POST['mwb_gaq_enable_email_setting']) ? 'on' : 'off';

	$mwb_gaq_email_fields_settings['sender_email'] = ! empty( $_POST['sender_email'] ) ? sanitize_text_field( $_POST['sender_email'] ) : '';

	$mwb_gaq_email_fields_settings['email_subject'] = ! empty( $_POST['email_subject'] ) ? sanitize_text_field( $_POST['email_subject'] ) : '';

	$mwb_gaq_email_fields_settings['emailmess'] = ! empty( $_POST['emailmess'] ) ? sanitize_textarea_field( wp_unslash( $_POST['emailmess'] ) ) : '';

	update_option( 'mwb_gaq_activate_email', $mwb_gaq_email_fields_settings['mwb_gaq_enable_email_setting'] );
	update_option( 'mwb_gaq_email_fields_data', $mwb_gaq_email_fields_settings );

	?>
	<div class="notice notice-success is-dismissible">
		<p><strong><?php esc_html_e( 'Settings saved', 'GAQ_TEXT_DOMAIN' ); ?></strong></p>
	</div>
	<?php
}

$mwb_gaq_activate_email = get_option( 'mwb_gaq_email_fields_data' ); ?>

<form class="mwb_email_setting_form" action="" method="POST">
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

