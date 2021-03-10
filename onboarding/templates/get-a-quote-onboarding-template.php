<?php
/**mwb_gaq_plug_generate_html
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Makewebbetter_Onboarding
 * @subpackage Makewebbetter_Onboarding/admin/onboarding
 */
global $gaq_mwb_gaq_obj;
$gaq_onboarding_form_fields = apply_filters( 'mwb_gaq_on_boarding_form_fields', array() );
?>

<?php if ( ! empty( $gaq_onboarding_form_fields ) ) : ?>
	<div class="mdc-dialog mdc-dialog--scrollable">
		<div class="mwb-gaq-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-gaq-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-gaq-on-boarding-close-btn">
						<a href="#"><span class="gaq-close-form material-icons mwb-gaq-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span></a>
					</div>

					<h3 class="mwb-gaq-on-boarding-heading mdc-dialog__title"><?php esc_html_e( 'Welcome to MakeWebBetter', 'get-a-quote' ); ?> </h3>
					<p class="mwb-gaq-on-boarding-desc"><?php esc_html_e( 'We love making new friends! Subscribe below and we promise to keep you up-to-date with our latest new plugins, updates, awesome deals and a few special offers.', 'get-a-quote' ); ?></p>

					<form action="#" method="post" class="mwb-gaq-on-boarding-form">
						<?php
						$gaq_onboarding_html = $gaq_mwb_gaq_obj->mwb_gaq_plug_generate_html( $gaq_onboarding_form_fields );
						echo esc_html( $gaq_onboarding_html );
						?>
						<div class="mwb-gaq-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-gaq-on-boarding-form-submit mwb-gaq-on-boarding-form-verify ">
								<input type="submit" class="mwb-gaq-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-gaq-on-boarding-form-no_thanks">
								<a href="#" class="mwb-gaq-on-boarding-no_thanks mdc-button" data-mdc-dialog-action="discard"><?php esc_html_e( 'Skip For Now', 'get-a-quote' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>
