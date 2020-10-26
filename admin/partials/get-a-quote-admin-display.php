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
if ( ! defined( 'ABSPATH' ) ) {

exit;
}
$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'Welcome';
do_action( 'mwb_gaq_setting_tab_active' );
if ( 'overview' == get_transient( 'mwb_gaq_default_settings_tab' ) ) {

$mwb_membership_active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'overview';
}
?>
<div class="wrapper" id="mwb_gaq_setting_wrapper">
<h1 class="mwb_gaq_setting_title"><?php esc_html_e( 'Get a Quote', 'get-a-quote' ); ?>
<span class="mwb_gaq_setting_title_version">
<?php
esc_html_e( 'v', 'get-a-quote' );
echo "GET_A_QUOTE_VERSION";
?>
</span>
</h1>
<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
    <a class="nav-tab <?php echo $active_tab == 'setting' ? 'nav-tab-active' : ''; ?>" href="?page=quote-options&tab=setting"><?php _e( 'Settings', 'get-a-quote' ); ?></a>
    <a class="nav-tab <?php echo $active_tab == 'form-fields' ? 'nav-tab-active' : ''; ?>" href="?page=quote-options&tab=form-fields"><?php _e( 'Form Fields', 'get-a-quote' ); ?></a>
    <a class="nav-tab <?php echo $active_tab == 'taxonomies' ? 'nav-tab-active' : ''; ?>" href="?page=quote-options&tab=taxonomies"><?php _e( 'Taxonomies', 'get-a-quote' ); ?></a>

    <?php do_action( 'mwb_gaq_setting_tab' ); ?>	
</nav>
<?php

if ( $active_tab == 'setting' ) {
    //echo "Setting";
    include_once 'templates/mwb_gaq_setting.php';
} elseif ( $active_tab == 'form-fields' ) {
    echo "From Fields";
    include_once 'templates/mwb_gaq_form_fields.php';
} elseif ( $active_tab == 'taxonomies' ) {
    include_once 'templates/mwb_gaq_taxonomies.php';
}

    do_action( 'mwb_gaq_setting_tab_html' );
?>
</div>