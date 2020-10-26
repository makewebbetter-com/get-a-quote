<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
	exit;
}


?>
<form action="" method="POST">
	<div class="mwb_gaq_table">
	<h2> Settings </h2>
		<table class="form-table mwb_gaq_setting">
			<tbody>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_gaq_enable_plugin"><?php esc_html_e('Enable Plugin', 'get-a-quote'); ?></label>
					</th>
					<td>
						<label class="mwb_gaq_enable_plugin_label">
							<input class="mwb_gaq_enable_plugin_input" type="checkbox" <?php echo ($mwb_gaq_enable_plugin == 'on') ? "checked='checked'" : ''; ?> name="mwb_wocuf_pro_enable_plugin">
							<span class="mwb_gaq_enable_plugin_span"></span>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Visibility', 'get-a-quote' ); ?></label>
					</th>
					<td>
						<div class="mwb_gaq_visibility">
							<?php
							$global_product_discount = isset( $mwb_upsell_global_settings['vsiblity_gaq_setting'] ) ? $mwb_upsell_global_settings['vsiblity_gaq_setting'] : 'admin';
							?>

					<select class="mwb_gaq_select" name="select_from_visibility">	
						<option value="yes" <?php selected( $remove_all_styles, 'yes' ); ?> ><?php esc_html_e( 'Yes', 'get-a-quote' ); ?></option>
						<option value="no" <?php selected( $remove_all_styles, 'no' ); ?> ><?php esc_html_e( 'No', 'get-a-quote' ); ?></option>
					</select></div>
						<span class="mwb_upsell_global_description"><?php esc_html_e( 'To allow the visibility of form', 'get-a-quote' ); ?></span>
					</td>
				</tr>
			<tbody>
		</table>
</form>