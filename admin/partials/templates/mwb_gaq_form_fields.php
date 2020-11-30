<?php

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_POST['mwb_gaq_form_fields_settings_save'] ) ) {

	$mwb_gaq_form_fields_setting = array();

	$mwb_gaq_form_fields_setting['mwb_gaq_enable_form'] = ! empty( $_POST['mwb_gaq_enable_form'] ) ? 'on' : 'off';

	$mwb_gaq_form_fields_setting['select_for_fname_field'] = ! empty( $_POST['select_for_fname_field'] ) ? sanitize_text_field( $_POST['select_for_fname_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_lname_field'] = ! empty( $_POST['select_for_lname_field'] ) ? sanitize_text_field( $_POST['select_for_lname_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_address_field'] = ! empty( $_POST['select_for_address_field'] ) ? sanitize_text_field( $_POST['select_for_address_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_city_field'] = ! empty( $_POST['select_for_city_field'] ) ? sanitize_text_field( $_POST['select_for_city_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_zipcode_field'] = ! empty( $_POST['select_for_zipcode_field'] ) ? sanitize_text_field( $_POST['select_for_zipcode_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_country_field'] = ! empty( $_POST['select_for_country_field'] ) ? sanitize_text_field( $_POST['select_for_country_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_states_field'] = ! empty( $POST['select_for_states_field'] ) ? sanitize_text_field( $_POST['select_for_states_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_email_field'] = ! empty( $_POST['select_for_email_field'] ) ? sanitize_text_field( $_POST['select_for_email_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_phone_field'] = ! empty( $_POST['select_for_phone_field'] ) ? sanitize_text_field( $_POST['select_for_phone_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_budget_field'] = ! empty( $_POST['select_for_budget_field'] ) ? sanitize_text_field( $_POST['select_for_budget_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_additional_field'] = ! empty( $_POST['select_for_additional_field'] ) ? sanitize_text_field( $_POST['select_for_additional_field'] ) : 'yes';

	$mwb_gaq_form_fields_setting['select_for_fileup_field'] = ! empty( $_POST['select_for_fileup_field'] ) ? sanitize_text_field( $_POST['select_for_fileup_field'] ) : 'yes';

	update_option( 'mwb_gaq_form_enable', $mwb_gaq_form_fields_setting['mwb_gaq_enable_form'] );
	update_option( 'mwb_gaq_form_fields_options', $mwb_gaq_form_fields_setting );
?>
	<div class="notice notice-success is-dismissible">
		<p><strong><?php esc_html_e( 'Settings saved', 'get-a-quote' ); ?></strong></p>
	</div>
<?php
}

$mwb_gaq_form_fields_option = get_option( 'mwb_gaq_form_fields_options', Get_A_Quote_Helper::enabling_default_value( 'form_fields' ) );

$mwb_gaq_enable_form = get_option( 'mwb_gaq_form_enable', 'on' );
?>

<form action="" method="POST">
	<div class="mwb_gaq_form_fields_table">
		<h2> Form Fields </h2>
		<table class="form-table mwb_gaq_form_setting">
			<tbody>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_gaq_all_form_fields"><?php esc_html_e('Enable Form', 'get-a-quote'); ?></label>
					</th>
					<td>
						<label class="mwb_gaq_enable_form_label">
							<input class="mwb_gaq_enable_form_input" type="checkbox" <?php echo ($mwb_gaq_enable_form == 'on') ? "checked='checked'" : ''; ?> name="mwb_gaq_enable_form">
							<span class="mwb_gaq_enable_form_span"><?php esc_html_e('To allow Form', 'get-a-quote'); ?></span>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_gaq_attributes"><?php esc_html_e('Form Attributes', 'get-a-quote'); ?></label>
					<td>
						<table class="form-attributes" border="1px">
							<tbody>
								<tr>
									<th>
										<label for="mwb_gaq_attributes_fields"><?php esc_html_e('Fields', 'get-a-quote'); ?></label>
									</th>
									<th>
										<label for="mwb_gaq_attributes_visibility"><?php esc_html_e('Visibility', 'get-a-quote'); ?></label>
									</th>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('First Name', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show first name ' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_fname">

											<?php

											$select_for_fname_field = ! empty( $mwb_gaq_form_fields_option['select_for_fname_field'] ) ? $mwb_gaq_form_fields_option['select_for_fname_field'] : '';
											?>

											<select class="mwb_gaq_fname_select" name="select_for_fname_field">
												<option value="" <?php selected($select_for_fname_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_fname_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_fname_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_lname_field"><?php esc_html_e('Last Name', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show last name ' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_lname">

											<?php

											$select_for_lname_field = ! empty( $mwb_gaq_form_fields_option['select_for_lname_field'] ) ? $mwb_gaq_form_fields_option['select_for_lname_field'] : '';

											?>

											<select class="mwb_gaq_lname_select" name="select_for_lname_field">
												<option value="" <?php selected($select_for_lname_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_lname_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_lname_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('Address', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show Address fields ' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_address">

											<?php

											$select_for_address_field = ! empty( $mwb_gaq_form_fields_option['select_for_address_field'] ) ? $mwb_gaq_form_fields_option['select_for_address_field'] : '';

											?>

											<select class="mwb_gaq_address_select" name="select_for_address_field">
												<option value="" <?php selected($select_for_address_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_address_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_address_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('City', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show City field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_city">

											<?php

											$select_for_city_field = ! empty( $mwb_gaq_form_fields_option['select_for_city_field'] ) ? $mwb_gaq_form_fields_option['select_for_city_field'] : '';

											?>

											<select class="mwb_gaq_city_select" name="select_for_city_field">
												<option value="" <?php selected($select_for_city_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_city_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_city_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('Zipcode', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show zipcode field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_zipcode">

											<?php

											$select_for_zipcode_field = ! empty( $mwb_gaq_form_fields_option['select_for_zipcode_field'] ) ? $mwb_gaq_form_fields_option['select_for_zipcode_field'] : '';

											?>

											<select class="mwb_gaq_zipcode_select" name="select_for_zipcode_field">
												<option value="" <?php selected($select_for_zipcode_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_zipcode_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_zipcode_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('Country', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show Country field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_country">

											<?php

											$select_for_country_field = ! empty( $mwb_gaq_form_fields_option['select_for_country_field'] ) ? $mwb_gaq_form_fields_option['select_for_country_field'] : '';

											?>

											<select class="mwb_gaq_country_select" name="select_for_country_field">
												<option value="" <?php selected($select_for_country_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_country_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_country_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('States', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show State field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_states">

											<?php

											$select_for_states_field = ! empty( $mwb_gaq_form_fields_option['select_for_states_field'] ) ? $mwb_gaq_form_fields_option['select_for_states_field'] : '';

											?>

											<select class="mwb_gaq_states_select" name="select_for_states_field">
												<option value="" <?php selected($select_for_states_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_states_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_states_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('Email', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show Email field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_email">

											<?php

											$select_for_email_field = ! empty( $mwb_gaq_form_fields_option['select_for_email_field'] ) ? $mwb_gaq_form_fields_option['select_for_email_field'] : '';

											?>

											<select class="mwb_gaq_email_select" name="select_for_email_field">
												<option value="" <?php selected($select_for_email_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_email_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_email_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('Phone', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show Phone field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_phone">

											<?php

											$select_for_phone_field = ! empty( $mwb_gaq_form_fields_option['select_for_phone_field'] ) ? $mwb_gaq_form_fields_option['select_for_phone_field'] : '';

											?>

											<select class="mwb_gaq_phone_select" name="select_for_phone_field">
												<option value="" <?php selected($select_for_phone_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_phone_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_phone_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('Budget', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show Budget field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_budget">

											<?php

											$select_for_budget_field = ! empty( $mwb_gaq_form_fields_option['select_for_budget_field'] ) ? $mwb_gaq_form_fields_option['select_for_budget_field'] : '';

											?>

											<select class="mwb_gaq_budget_select" name="select_for_budget_field">
												<option value="" <?php selected($select_for_budget_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_budget_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_budget_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('Additional', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show Additional field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_additional">

											<?php

											$select_for_additional_field = ! empty( $mwb_gaq_form_fields_option['select_for_additional_field'] ) ? $mwb_gaq_form_fields_option['select_for_additional_field'] : '';

											?>

											<select class="mwb_gaq_additional_select" name="select_for_additional_field">
												<option value="" <?php selected($select_for_additional_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_additional_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_additional_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
								<tr>
									<th scope="row" class="titledesc">
										<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e('File Upload', 'get-a-quote'); ?><?php Get_A_Quote_Helper::helpertip( 'To show File field' ); ?></label>
									</th>
									<td>
										<label class="mwb_gaq_enable_fileup">

											<?php

											$select_for_fileup_field = ! empty( $mwb_gaq_form_fields_option['select_for_fileup_field'] ) ? $mwb_gaq_form_fields_option['select_for_fileup_field'] : '';

											?>

											<select class="mwb_gaq_fileup_select" name="select_for_fileup_field">
												<option value="" <?php selected($select_for_fileup_field, ''); ?>><?php esc_html_e('No Option Selected', 'get-a-quote'); ?></option>
												<option value="yes" <?php selected($select_for_fileup_field, 'yes'); ?>><?php esc_html_e('Yes', 'get-a-quote'); ?></option>
												<option value="no" <?php selected($select_for_fileup_field, 'no'); ?>><?php esc_html_e('No', 'get-a-quote'); ?></option>
											</select>
										</label>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<p class="submit">
		<input type="submit" value="<?php _e('Save Changes', 'get-a-quote'); ?>" class="button-primary save-button" name="mwb_gaq_form_fields_settings_save" id="mwb_gaq_form_fields_setting_save">
	</p>
</form>
