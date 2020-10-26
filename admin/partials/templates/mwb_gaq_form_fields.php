<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}
?>

<form action="" method="POST">
    <div class="mwb_gaq_form_fields_table">
        <h2> Form Fields </h2>
        <table class="form-table mwb_gaq_form_setting">
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
            </tbody>
        </table>
    </div>
</form>