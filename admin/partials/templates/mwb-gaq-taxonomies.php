<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( isset( $_POST['mwb_gaq_taxonomies_common_settings_save'] ) ) {

	check_admin_referer( 'gaq_admin_taxo', 'gaq_admin_taxo_nonce' );

	$mwb_gaq_taxonomies_setting = array();

	$mwb_gaq_taxonomies_setting['select_for_services'] = ! empty( $_POST['select_for_services'] ) ? sanitize_text_field( wp_unslash( $_POST['select_for_services'] ) ) : '';

	$mwb_gaq_taxonomies_setting['select_for_status'] = ! empty( $_POST['select_for_status'] ) ? sanitize_text_field( wp_unslash( $_POST['select_for_status'] ) ) : '';

	update_option( 'mwb_gaq_taxonomies_options', $mwb_gaq_taxonomies_setting ); ?>

	<div class="notice notice-success is-dismissible">
		<p><strong><?php esc_html_e( 'Settings saved', 'GAQ_TEXT_DOMAIN' ); ?></strong></p>
	</div>
	<?php
}

$mwb_gaq_taxonomies_option = get_option( 'mwb_gaq_taxonomies_options', array() );

?>
<form action="" method="POST">
<?php wp_nonce_field( 'gaq_admin_taxo', 'gaq_admin_taxo_nonce' ); ?>
	<div class="mwb_gaq_taxonomy_table">
		<h2> Taxonomy </h2>
		<table class="form-table mwb_gaq_taxonomy_setting">
			<tbody>
				<tr class="status_terms terms">
					<th class="status_terms_header header"><?php esc_html_e( 'Status', 'GAQ_TEXT_DOMAIN' ); ?></th>
					<th class="status_terms_sub-heading sub-heading"><?php esc_html_e( 'Active Terms', 'GAQ_TEXT_DOMAIN' ); ?></th>
					<th class="status_terms_btn btn"><a href="#">Add Status Terms</a></th>
					<div class="Status_taxo">
						<?php
						$terms = get_terms(
							array(
								'taxonomy'   => 'status',
								'hide_empty' => false,
							)
						);
						foreach ( $terms as $value => $key ) {
							$val = ! empty( $key->name ) ? $key->name : 'empty';
							echo sprintf( '<pre> %s </pre>', esc_html( $val ) );
						}
						?>
					</div>
					<hr>
				</tr>
				<tr class='service_terms terms'>
					<th class='service_terms_header header'><?php esc_html_e( 'Service', 'GAQ_TEXT_DOMAIN' ); ?></th>
					<th class="service_terms_sub-heading sub-heading"><?php esc_html_e( 'Active Terms', 'GAQ_TEXT_DOMAIN' ); ?></th>
					<th class="service_terms_btn btn"><a href="#">Add Service Terms</a></th>
					<div class="Service_taxo">
					<?php
						$terms = get_terms(
							array(
								'taxonomy'   => 'service',
								'hide_empty' => false,
							)
						);
						foreach ( $terms as $value => $key ) {
							$val = ! empty( $key->name ) ? $key->name : 'empty';
							echo sprintf( '<pre> %s </pre>', esc_html( $val ) );
						}
						?>
					</div>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label for="mwb_gaq_enable_taxonomy_plugin"><?php esc_html_e( 'Enable Service Taxonomy', 'GAQ_TEXT_DOMAIN' ); ?></label>
					</th>
					<td>
						<label class="mwb_gaq_enable_service_taxonomy_plugin_label">
							<?php
							$select_for_services = ! empty( $mwb_gaq_taxonomies_option['select_for_services'] ) ? $mwb_gaq_taxonomies_option['select_for_services'] : '';
							?>
							<select class="mwb_gaq_select" name="select_for_services">
								<option value="yes" <?php selected( $select_for_services, 'yes' ); ?>><?php esc_html_e( 'Yes', 'GAQ_TEXT_DOMAIN' ); ?></option>
								<option value="no" <?php selected( $select_for_services, 'no' ); ?>><?php esc_html_e( 'No', 'GAQ_TEXT_DOMAIN' ); ?></option>
							</select>
							<span class="mwb_upsell_global_description"><?php esc_html_e( 'To allow quote services taxonomy', 'GAQ_TEXT_DOMAIN' ); ?></span>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" class="titledesc">
						<label><?php esc_html_e( 'Enable Quote Status Taxonomy', 'GAQ_TEXT_DOMAIN' ); ?></label>
					</th>
					<td>
						<label class="mwb_gaq_enable_status_taxonomy_plugin_label">
							<?php
							$select_for_status = ! empty( $mwb_gaq_taxonomies_option['select_for_status'] ) ? $mwb_gaq_taxonomies_option['select_for_status'] : '';
							?>
							<select class="mwb_gaq_select" name="select_for_status">
								<option value="yes" <?php selected( $select_for_status, 'yes' ); ?>><?php esc_html_e( 'Yes', 'GAQ_TEXT_DOMAIN' ); ?></option>
								<option value="no" <?php selected( $select_for_status, 'no' ); ?>><?php esc_html_e( 'No', 'GAQ_TEXT_DOMAIN' ); ?></option>
							</select>
							<span class="mwb_upsell_global_description"><?php esc_html_e( 'To allow quote status taxonomy', 'GAQ_TEXT_DOMAIN' ); ?></span>
						</label>
					</td>
				</tr>
			<tbody>
		</table>
		<p class="submit">
			<input type="submit" value="<?php esc_html_e( 'Save Changes', 'GAQ_TEXT_DOMAIN' ); ?>" class="button-primary save-button" name="mwb_gaq_taxonomies_common_settings_save" id="mwb_gaq_taxonomies_setting_save">
		</p>
	</div>
</form>
<?php
