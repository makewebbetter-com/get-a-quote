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
		<table class="form-table mwb_gaq_setting">
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="mwb_gaq_enable_plugin"><?php esc_html_e('Enable Plugin', 'get-a-quote'); ?></label>
				</th>
				<td>
					<?php
					// $attribut_description = esc_html__('Enable plugin.', 'get-a-quote');
					// echo wc_help_tip($attribut_description);
					?>
					<label class="mwb_gaq_enable_plugin_label">
						<input class="mwb_wocuf_pro_enable_plugin_input" type="checkbox" <?php echo ($mwb_wocuf_pro_enable_plugin == 'on') ? "checked='checked'" : ''; ?> name="mwb_wocuf_pro_enable_plugin">
						<span class="mwb_wocuf_pro_enable_plugin_span"></span>
					</label>
				</td>
			</tr>
			<tbody>
</form>