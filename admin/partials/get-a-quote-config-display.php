<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Get_A_Quote
 * @subpackage Get_A_Quote/admin/partials
 */

// <!-- This file should primarily consist of HTML with a little bit of PHP. -->
if ( ! defined('ABSPATH') ) {
	exit;
}
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'setting';
do_action('mwb_gaq_setting_tab_active');

?>
<div class="wrapper" id="mwb_gaq_setting_wrapper">
	<h1 class="mwb_gaq_setting_title"><?php esc_html_e('Get a Quote', 'get-a-quote'); ?>
		<span class="mwb_gaq_setting_title_version">
			<?php
			    sprintf( '%s V %s', esc_html__( 'Get A Quote', GAQ_TEXT_DOMAIN ), esc_html( GAQ_VERSION ) );
			?>
		</span>
	</h1>
	<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
		<a class="nav-tab <?php echo $active_tab == 'setting' ? 'nav-tab-active' : ''; ?>" href="?page=gaq-config&tab=setting"><?php _e('Settings', 'get-a-quote'); ?></a>
		<a class="nav-tab <?php echo $active_tab == 'form-fields' ? 'nav-tab-active' : ''; ?>" href="?page=gaq-config&tab=form-fields"><?php _e('Form Fields', 'get-a-quote'); ?></a>
		<a class="nav-tab <?php echo $active_tab == 'taxonomies' ? 'nav-tab-active' : ''; ?>" href="?page=gaq-config&tab=taxonomies"><?php _e('Taxonomies', 'get-a-quote'); ?></a>
		<a class="nav-tab <?php echo $active_tab == 'email-settings' ? 'nav-tab-active' : ''; ?>" href="?page=gaq-config&tab=email-settings"><?php _e('Email Settings', 'get-a-quote'); ?></a>

		<?php do_action('mwb_gaq_setting_tab'); ?>
	</nav>
	<?php

	if ($active_tab == 'setting') {

		include_once 'templates/mwb-gaq-setting.php';
	} elseif( $active_tab == 'form-fields' ) {
		include_once 'templates/mwb-gaq-form-fields.php';
	} elseif( $active_tab == 'taxonomies' ) {
		include_once 'templates/mwb-gaq-taxonomies.php';
	} elseif( $active_tab == 'email-settings' ) {
		include_once 'templates/mwb-gaq-email-setting.php';
	}

	do_action( 'mwb_gaq_setting_tab_html' );

?>
</div>