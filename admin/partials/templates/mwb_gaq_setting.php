<?php

/**
 * Exit if accessed directly
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
if ( isset( $_POST['mwb_gaq_common_settings_save'] ) ) {

	$mwb_gaq_setting = array();

	$mwb_gaq_setting['mwb_gaq_enable_plugin'] = !empty($_POST['mwb_gaq_enable_plugin']) ? 'on' : 'off';

	update_option( 'mwb_gaq_setting_visibility', $mwb_gaq_setting );
	update_option( 'mwb_gaq_enable_plugin', $mwb_gaq_setting['mwb_gaq_enable_plugin'] ); ?>

	<div class="notice notice-success is-dismissible">
		<p><strong><?php _e('Settings saved', 'get-a-quote'); ?></strong></p>
	</div>
	<?php
}
$mwb_gaq_enable_plugin = get_option( 'mwb_gaq_enable_plugin', 'on' );
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
							<input class="mwb_gaq_enable_plugin_input" type="checkbox" <?php echo ($mwb_gaq_enable_plugin == 'on') ? "checked='checked'" : ''; ?> name="mwb_gaq_enable_plugin">
							<span class="mwb_gaq_enable_plugin_span"></span>
						</label>
					</td>
				</tr>
				<?php do_action('mwb_gaq_create_more_settings'); ?>
			<tbody>
		</table>
		<p class="submit">
			<input type="submit" value="<?php esc_html_e('Save Changes', 'get-a-quote'); ?>" class="button-primary save-button" name="mwb_gaq_common_settings_save" id="mwb_gaq_setting_save">
		</p>
	</div>
</form>
