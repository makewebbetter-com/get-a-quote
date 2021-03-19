<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
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
global $gaq_mwb_gaq_obj;
$gaq_support_settings = apply_filters( 'gaq_support_tab_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="gaq-section-wrap">
	<?php if ( is_array( $gaq_support_settings ) && ! empty( $gaq_support_settings ) ) { ?>
		<?php foreach ( $gaq_support_settings as $gaq_support_setting ) { ?>
		<div class="mwb-col-wrap">
			<div class="mwb-shadow-panel">
				<div class="content-wrap">
					<div class="content">
						<h3><?php echo esc_html( $gaq_support_setting['title'] ); ?></h3>
						<p><?php echo esc_html( $gaq_support_setting['description'] ); ?></p>
					</div>
					<div class="mdc-button mwb-cta-btn"><span class="mdc-button__ripple"></span>
						<a href="#" class="mwb-btn mwb-btn-primary"><?php echo esc_html( $gaq_support_setting['link-text'] ); ?></a>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	<?php } ?>
</div>
