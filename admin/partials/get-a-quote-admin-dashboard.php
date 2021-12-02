<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://makewebbetter.com/
 * @since 1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $gaq_mwb_gaq_obj, $error_notice;
$gaq_active_tab   = isset( $_GET['gaq_tab'] ) ? sanitize_key( $_GET['gaq_tab'] ) : 'get-a-quote-general';
if ( 'get-a-quote-form-fields-edit' === $gaq_active_tab || 'get-a-quote-form-fields-preview' === $gaq_active_tab ) {
	echo '<style>#wpadminbar{
		display:none;
	}
	body {
	overflow:hidden;
	}</style>';
}
?>
<header>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php echo esc_attr( strtoupper( str_replace( '-', ' ', $gaq_mwb_gaq_obj->gaq_get_plugin_name() ) ) ); ?></h1>
		<a href="<?php echo esc_url( 'https://docs.makewebbetter.com/get-a-quote-for-wordpress/?utm_source=MWB-getquote-backend&utm_medium=MWB-backend&utm_campaign=MWB-getquote-backend' ); ?>" class="mwb-link"><?php esc_html_e( 'Documentation', 'mwb-product-filter-for-woocommerce' ); ?></a>|
		<a href="<?php echo esc_url( 'https://makewebbetter.com/contact-us/?utm_source=MWB-getquote-backend&utm_medium=MWB-backend&utm_campaign=MWB-getquote-backend"' ); ?>" class="mwb-link"><?php esc_html_e( 'Support', 'get-a-quote' ); ?></a>
	</div>
</header>
<?php
$gaq_default_tabs = $gaq_mwb_gaq_obj->mwb_gaq_plug_default_tabs();
?>
<main class="mwb-main mwb-bg-white mwb-r-8">
	<nav class="mwb-navbar">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $gaq_default_tabs ) && ! empty( $gaq_default_tabs ) ) {

				foreach ( $gaq_default_tabs as $gaq_tab_key => $gaq_default_tabs ) {

					$gaq_tab_classes = 'mwb-link ';

					if ( ! empty( $gaq_active_tab ) && $gaq_active_tab === $gaq_tab_key ) {
						$gaq_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $gaq_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=get_a_quote_menu' ) . '&gaq_tab=' . esc_attr( $gaq_tab_key ) ); ?>" class="<?php echo esc_attr( $gaq_tab_classes ); ?>"><?php echo esc_html( $gaq_default_tabs['title'] ); ?></a>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</nav>
<?php
if ( ! $error_notice ) {
	$gaq_mwb_gaq_obj->mwb_gaq_plug_admin_notice( 'Settings saved !', 'success' );
}
?>
	<section class="mwb-section">
		<div>
			<?php
			do_action( 'mwb_gaq_before_general_settings_form' );

			if ( empty( $gaq_active_tab ) ) {

				$gaq_active_tab = 'mwb_gaq_plug_general';
			}
			// look for the path based on the tab id in the admin templates.
			$gaq_tab_content_path = 'admin/partials/' . $gaq_active_tab . '.php';

			$gaq_mwb_gaq_obj->mwb_gaq_plug_load_template( $gaq_tab_content_path );

			do_action( 'mwb_gaq_after_general_settings_form' );
			?>
		</div>
	</section>
