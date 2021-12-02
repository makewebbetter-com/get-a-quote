<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/public/partials
 */

?>
<div class="mwb-gaq-dialog-wrapper">
	<div class="mwb-gaq-dialog">   
		<div class="mwb-gaq-item">
			<img src="<?php echo esc_html( GET_A_QUOTE_DIR_URL . 'public/src/loader.gif' ); ?>" class="mwb-gaq-item-img">
			<div class="mwb-gaq-item-details"></div>
			<div class="mwb-gaq-action-buttons"></div>
		</div>
	</div>
</div>
