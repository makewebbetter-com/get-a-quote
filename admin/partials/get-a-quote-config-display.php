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
$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'setting';
do_action( 'mwb_gaq_setting_tab_active' );

?>
<div class="wrapper" id="mwb_gaq_setting_wrapper">
    <h1 class="mwb_gaq_setting_title"><?php esc_html_e( 'Get a Quote', 'GAQ_TEXT_DOMAIN' ); ?>
        <span class="mwb_gaq_setting_title_version">
            <?php
            sprintf('%s V %s', 'Get A Quote', 'GAQ_VERSION');
            ?>
        </span>
    </h1>
    <nav class="nav-tab-wrapper woo-nav-tab-wrapper">
        <a class="nav-tab <?php echo 'setting' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=gaq-config&tab=setting"><?php esc_html_e( 'Settings', 'GAQ_TEXT_DOMAIN' ); ?></a>
        <a class="nav-tab <?php echo 'form-fields' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=gaq-config&tab=form-fields"><?php esc_html_e( 'Form Fields', 'GAQ_TEXT_DOMAIN' ); ?></a>
        <a class="nav-tab <?php echo 'taxonomies' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=gaq-config&tab=taxonomies"><?php esc_html_e( 'Taxonomies', 'GAQ_TEXT_DOMAIN' ); ?></a>
        <a class="nav-tab <?php echo 'email-settings' === $active_tab ? 'nav-tab-active' : ''; ?>" href="?page=gaq-config&tab=email-settings"><?php esc_html_e( 'Email Settings', 'GAQ_TEXT_DOMAIN' ); ?></a>

        <?php do_action( 'mwb_gaq_setting_tab' ); ?>
    </nav>
    <?php

    if ( 'setting' === $active_tab ) {

        include_once 'templates/mwb-gaq-setting.php';
    } elseif ( 'form-fields' === $active_tab ) {
        include_once 'templates/mwb-gaq-form-fields.php';
    } elseif ( 'taxonomies' === $active_tab ) {
        include_once 'templates/mwb-gaq-taxonomies.php';
    } elseif ( 'email-settings' === $active_tab ) {
        include_once 'templates/mwb-gaq-email-setting.php';
    }
    $form = isset( $_GET['form_action'] ) ? $_GET['form_action'] : '';
    
    if ( 'edit' === $form ) {
        echo '<style>#wpadminbar{
            display:none;
        }</style>';
        include_once 'templates/mwb-gaq-edit-form-fields.php';
        echo "<script type='text/javascript' > document.body.className+=' folded'; </script>";
    }
    if ( 'preview' === $form ) {
        echo '<style>#wpadminbar{
            display:none;
        }</style>';
        include_once 'templates/mwb-gaq-preview-form-fields.php';
    }
    do_action('mwb_gaq_setting_tab_html');

    ?>
</div>
