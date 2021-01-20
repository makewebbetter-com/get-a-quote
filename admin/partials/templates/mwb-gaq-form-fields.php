<?php
?>
<div class="mwb_form_fields">
	<form class="active_fields">
		<table class="form-table mwb_gaq_form_setting">
			<tbody>
				<tr valign="top">
					<th scope="row" class="titledesc">
					<?php $mwb_gaq_enable_form = ''; ?>
						<label for="mwb_gaq_all_form_fields"><?php esc_html_e( 'Enable Form', 'get-a-quote' ); ?></label>
					</th>
					<td>
						<label class="mwb_gaq_enable_form_label">
							<input class="mwb_gaq_enable_form_input" type="checkbox" <?php echo ( $mwb_gaq_enable_form == 'on' ) ? "checked='checked'" : ''; ?> name="mwb_gaq_enable_form">
							<span class="mwb_gaq_enable_form_span"><?php esc_html_e( 'To allow Form', 'get-a-quote' ); ?></span>
						</label>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="active_form_fields">
			<b><label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e( 'First Name', 'get-a-quote' ); ?></label><br>
			<label class="wp-tooltip-label" for="mwb_gaq_lname_field"><?php esc_html_e( 'Last Name', 'get-a-quote' ); ?></label><br>
			<label class="wp-tooltip-label" for="mwb_gaq_fname_field"><?php esc_html_e( 'Email', 'get-a-quote' ); ?></label></b>
		</div>
	</form>
	<div class="inactive_form_fields">
		<div>
		</div>
	</div>
</div>
