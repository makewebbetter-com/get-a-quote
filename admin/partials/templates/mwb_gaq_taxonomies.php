<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
	exit;
}


?>
<form action="" method="POST">
	<div class="mwb_gaq_taxonomy_table">
	<h2> Settings </h2>
		<table class="form-table mwb_gaq_setting">
			<tbody>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_gaq_enable_taxonomy_plugin"><?php esc_html_e('Enable Service Taxonomy', 'get-a-quote'); ?></label>
					</th>
					<td>
						<label class="mwb_gaq_enable_taxonomy_plugin_label">
                        <select class="mwb_gaq_select" name="select_from_visibility">	
                            <option value="yes" <?php selected( $enable_services_taxonomy, 'yes' ); ?> ><?php esc_html_e( 'Yes', 'get-a-quote' ); ?></option>
                            <option value="no" <?php selected( $enable_services_taxonomy, 'no' ); ?> ><?php esc_html_e( 'No', 'get-a-quote' ); ?></option>
                        </select>
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
							// $global_product_discount = isset( $mwb_upsell_global_settings['vsiblity_gaq_setting'] ) ? $mwb_upsell_global_settings['vsiblity_gaq_setting'] : 'admin';
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