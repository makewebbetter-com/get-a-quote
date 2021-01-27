<?php
/**
 * @package Get_A_Quote
 *
 * Exit if accessed directly
 */

if ( !defined('ABSPATH') ) {
	exit;
}

if ( ! empty( $_POST['mwb_gaq_email_fields_settings_save'] ) ) {

	unset( $_POST['mwb_gaq_email_fields_settings_save'] );

	$mwb_gaq_email_fields_settings = array();

	$mwb_gaq_email_fields_settings['mwb_gaq_enable_email_setting'] = ! empty( $_POST['mwb_gaq_enable_email_setting'] ) ? 'on' : 'off';

	$mwb_gaq_email_fields_settings['sender_email'] = ! empty( $_POST['sender_email'] ) ? sanitize_text_field( $_POST['sender_email'] ) : '';

	$mwb_gaq_email_fields_settings['email_reply'] = ! empty( $_POST['email_reply'] ) ? sanitize_text_field( $_POST['email_reply'] ) : '';

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

$mwb_gaq_activate_email = get_option( 'mwb_gaq_email_fields_data' );

?>

<form class="mwb_email_setting_form" action="" method="POST">
	<div class="wp-tooltip-label">
		<div class="mwb_gaq_email_sett_table">
			<h2> Email Fields </h2>
			<table class="form-table mwb_gaq_email_setting">
				<tbody>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<label><?php esc_html_e( 'Activate Email', 'GAQ_TEXT_DOMAIN' ); ?></label>
						</th>
						<td>
							<label class="mwb_gaq_enable_email">
								<input class="mwb_gaq_enable_form_input" type="checkbox"
									<?php echo ( 'on' === $mwb_gaq_activate_email['mwb_gaq_enable_email_setting'] ) ? "checked='checked'" : ''; ?>
									name="mwb_gaq_enable_email_setting">
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<label><?php esc_html_e( 'Sender email', 'GAQ_TEXT_DOMAIN' ); ?>
						</th>
						<td>
							<label class="mwb_gaq_sender_email">
								<input id="semail" type="email" name="sender_email" value="<?php echo esc_html( $mwb_gaq_activate_email['sender_email'] ); ?>">
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<label class="mwb_gaq_reply_to"><?php esc_html_e( 'Reply to', 'GAQ_TEXT_DOMAIN' ); ?></label>
						</th>
						<td>
							<label class="mwb_gaq_email_reply_to">
								<input id="emailrt" type="email" name="email_reply" value="<?php echo esc_html( $mwb_gaq_activate_email['email_reply'] ); ?>">
							</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<label ><?php esc_html_e( 'Email Subject', 'GAQ_TEXT_DOMAIN' ); ?></label>
						</th>
						<td>
							<label class="mwb_gaq_email_subject">
								<input id="emailsub" type="text" name="email_subject" value="<?php echo esc_html( $mwb_gaq_activate_email['email_subject'] ); ?>">
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row" class="titledesc">
							<label ><?php esc_html_e( 'Message', 'GAQ_TEXT_DOMAIN' ); ?></label>
						</th>
						<td>
							<label class="mwb_gaq_email_message">
								<textarea name="emailmess" rows="3" cols="30" ><?php echo esc_html( $mwb_gaq_activate_email['emailmess'] ); ?></textarea>
							</label>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<p class="submit">
		<input type="submit" value="<?php esc_html_e( 'Save Changes', 'GAQ_TEXT_DOMAIN' ); ?>" class="button-primary save-button" name="mwb_gaq_email_fields_settings_save" id="mwb_gaq_email_fields_setting_save">
	</p>
</form>

