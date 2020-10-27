<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
	exit;
}

$mwb_gaq_taxonomies_option = get_option( 'mwb_gaq_taxonomies_options', array() );

?>
<form action="" method="POST">
	<div class="mwb_gaq_taxonomy_table">
	<h2> Taxonomy </h2>
	<table class="form-table mwb_gaq_taxonomy_setting">
		<tbody>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="mwb_gaq_enable_taxonomy_plugin"><?php esc_html_e('Enable Service Taxonomy', 'get-a-quote'); ?></label>
				</th>
				<td>
					<label class="mwb_gaq_enable_service_taxonomy_plugin_label">

					<?php

					$select_for_services = ! empty( $mwb_gaq_taxonomies_option['select_for_services'] ) ? $mwb_gaq_taxonomies_option['select_for_services'] : '';

					?>

					<select class="mwb_gaq_select" name="select_for_services">	
							<option value="yes" <?php selected( $select_for_services, 'yes' ); ?> ><?php esc_html_e( 'Yes', 'get-a-quote' ); ?></option>
							<option value="no" <?php selected( $select_for_services, 'no' ); ?> ><?php esc_html_e( 'No', 'get-a-quote' ); ?></option>
						</select>
						<span class="mwb_upsell_global_description"><?php esc_html_e( 'To allow quote services taxonomy', 'get-a-quote' ); ?></span>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label><?php esc_html_e( 'Enable Quote Status Taxonomy', 'get-a-quote' ); ?></label>
				</th>
				<td>
					<label class="mwb_gaq_enable_status_taxonomy_plugin_label">

					<?php

					$select_for_status = ! empty( $mwb_gaq_taxonomies_option['select_for_status'] ) ? $mwb_gaq_taxonomies_option['select_for_status'] : '';

					?>

					<select class="mwb_gaq_select" name="select_for_status">	
						<option value="yes" <?php selected( $select_for_status, 'yes' ); ?> ><?php esc_html_e( 'Yes', 'get-a-quote' ); ?></option>
						<option value="no" <?php selected( $select_for_status, 'no' ); ?> ><?php esc_html_e( 'No', 'get-a-quote' ); ?></option>
					</select>
					<span class="mwb_upsell_global_description"><?php esc_html_e( 'To allow quote status taxonomy', 'get-a-quote' ); ?></span>
					</label>
				</td>
			</tr>
		<tbody>
	</table>
	<p class="submit">
		<input type="submit" value="<?php _e( 'Save Changes', 'get-a-quote' ); ?>" class="button-primary save-button" name="mwb_gaq_taxonomies_common_settings_save" id="mwb_gaq_taxonomies_setting_save" >
	</p>
</form>
<?php 
if ( isset( $_POST['mwb_gaq_taxonomies_common_settings_save'] ) ) {

	$mwb_gaq_taxonomies_setting = array();

	$mwb_gaq_taxonomies_setting['select_for_services'] = ! empty( $_POST['select_for_services'] ) ? sanitize_text_field( $_POST['select_for_services'] ) : '';

	$mwb_gaq_taxonomies_setting['select_for_status'] = ! empty( $_POST['select_for_status'] ) ? sanitize_text_field( $_POST['select_for_status'] ) : '';

	update_option( 'mwb_gaq_taxonomies_options', $mwb_gaq_taxonomies_setting ); ?>

	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php _e( 'Settings saved', 'get-a-quote' ); ?></strong></p>
	</div>
	<?php
}
