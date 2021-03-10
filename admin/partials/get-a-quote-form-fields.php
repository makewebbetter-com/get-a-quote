<?php
/**
 * Provide a admin-facing view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/admin/partials
 */

?>
<div class="mwb_form_fields">
	<table>
		<tr>
			<th><?php esc_html_e( 'Form Name', 'get-a-quote' ); ?></th>
			<th><?php esc_html_e( 'Shortcode', 'get-a-quote' ); ?></th>
			<th><?php esc_html_e( 'Operation', 'get-a-quote' ); ?></th>
		</tr>
		<tr>
			<td><?php esc_html_e( 'Contact Form', 'get-a-quote' ); ?></td>
			<td><input type="" id="copytoclipTxt" value="[gaq_form_fields]" readonly/></td>
			<td><a href="?page=get_a_quote_menu&gaq_tab=get-a-quote-form-fields-edit" class="edit-form"><?php esc_html_e( 'Edit', 'get-a-quote' ); ?></a></td>
		</tr>
	</table>
</div>
