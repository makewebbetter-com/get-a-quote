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
if ( isset( $_POST['mwb_gaq_add_status'] ) ) {
	$t_status = isset( $_POST['new_status'] ) ? sanitize_text_field( wp_unslash( $_POST['new_status'] ) ) : '';
	if ( ! empty( $t_status ) ) {
		wp_insert_term( $t_status, 'status', array( 'slug' => $t_status ) );
		echo ( "<meta http-equiv='refresh' content='1'>" );
	}
}
if ( isset( $_POST['mwb_gaq_add_service'] ) ) {
	$t_service = isset( $_POST['new_service'] ) ? sanitize_text_field( wp_unslash( $_POST['new_service'] ) ) : '';
	if ( ! empty( $t_service ) ) {
		wp_insert_term( $t_service, 'service', array( 'slug' => $t_service ) );
		echo ( "<meta http-equiv='refresh' content='1'>" );
	}
}
if ( isset( $_POST['mwb_gaq_taxonomies_common_settings_save'] ) ) {

	check_admin_referer( 'gaq_admin_taxo', 'gaq_admin_taxo_nonce' );

	$mwb_gaq_taxonomies_setting = array();

	$mwb_gaq_taxonomies_setting['select_for_services'] = ! empty( $_POST['select_for_services'] ) ? sanitize_text_field( wp_unslash( $_POST['select_for_services'] ) ) : '';

	$mwb_gaq_taxonomies_setting['select_for_status'] = ! empty( $_POST['select_for_status'] ) ? sanitize_text_field( wp_unslash( $_POST['select_for_status'] ) ) : '';

	update_option( 'mwb_gaq_taxonomies_options', $mwb_gaq_taxonomies_setting ); ?>

	<div class="notice notice-success is-dismissible">
		<p><strong><?php esc_html_e( 'Settings saved', 'get-a-quote' ); ?></strong></p>
	</div>

	<?php
}
$mwb_gaq_taxonomies_option = get_option( 'mwb_gaq_taxonomies_options', array() );

?>

<form action="" method="POST">
	<div class="gaq-section-wrap">
		<?php
		wp_nonce_field( 'gaq_admin_taxo', 'gaq_admin_taxo_nonce' );
		global $gaq_mwb_gaq_obj;
		$gaq_template_settings = apply_filters( 'gaq_taxonomies_settings_array', array() );
		$gaq_template_html     = $gaq_mwb_gaq_obj->mwb_gaq_plug_generate_html( $gaq_template_settings );
		?>
		<table class='form-table mwb_gaq_taxonomy_setting'>
			<tbody>
				<tr class='mwb_gaq_status_terms terms'>
					<th class='status_terms_header sub-heading'><?php esc_html_e( 'Status', 'get-a-quote' ); ?></th>
					<th class='status_terms_btn btn'><a href='#' id='add_status_terms'><?php esc_html_e( 'Add Status Terms', 'get-a-quote' ); ?></a></th>
					<th class='status_terms_sub-heading header'><?php esc_html_e( 'Active Terms', 'get-a-quote' ); ?></th>
					<div class='center hideform' id='mwb_status_add_div'>
						<i style='float: right;' class='fa fa-times close' aria-hidden='true'></i>
						<form action='' method='POST'>
							<?php esc_html_e( 'Term Name', 'get-a-quote' ); ?>
							<br>
							<br>
							<input type='text' name='new_status'>
							<br><br>
							<input type='submit' name='mwb_gaq_add_status' value='Add Status Term'>
						</form>
					</div>
				</tr>
				<tr class='service_terms terms'>
					<th class='service_terms_header sub-heading'><?php esc_html_e( 'Service', 'get-a-quote' ); ?></th>
					<th class='service_terms_btn btn'><a href='#' id='add_service_terms'><?php esc_html_e( 'Add Service Terms', 'get-a-quote' ); ?></a></th>
					<th class='service_terms_sub-heading header'><?php esc_html_e( 'Active Terms', 'get-a-quote' ); ?></th>
					<div class='center hideform' id='mwb_service_add_div'>
						<i style='float: right;' class='fa fa-times close' aria-hidden='true'></i>
						<form action='' method='POST'>
							<?php esc_html_e( 'Term Name', 'get-a-quote' ); ?>
							<br>
							<br>
							<input type='text' name='new_service'>
							<br><br>
							<input type='submit' name='mwb_gaq_add_service' value='Add Service Term'>
						</form>
					</div>
				</tr>
			</tbody>
		</table>
		<?php
		$gaq_template_settings = apply_filters( 'gaq_taxonomies_button_array', array() );
		$gaq_template_html     = $gaq_mwb_gaq_obj->mwb_gaq_plug_generate_html( $gaq_template_settings );
		?>
	</div>
</form>
<?php
