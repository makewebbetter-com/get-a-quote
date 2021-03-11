<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Get_a_quote
 * @subpackage Get_a_quote/admin/partials
 */

// Overview Content Here.
?>
<div class="gaq-overview__wrapper">
	<div class="gaq-overview__banner">
		<img src="<?php echo esc_html( GET_A_QUOTE_DIR_URL . 'admin/src/images/overview-banner.png' ); ?>" alt="Overview banner image">
	</div>
	<div class="gaq-overview__content">
		<div class="gaq-overview__content-description">
			<h2><?php echo esc_html_e( 'What is Get A Quote for WordPress?', 'get-a-quote' ); ?></h2>
			<p>
			<?php
			echo esc_html_e(
				'Get A Quote for WordPress plugin helps you create & add a quotation form on your WordPress website. Users can fill this form to submit a request for a quotation of the required services. With this plugin, you can add multiple statuses for
				your quotations, multiple services in the form, & acknowledge users through an email for the successful submission of their quote request.',
				'get-a-quote'
			);
			?>
			</p>
			<h3><?php echo esc_html_e( 'With our Get A Quote for WordPress plugin you can:', 'get-a-quote' ); ?></h3>
			<ul class="gaq-overview__features">
				<li><?php echo esc_html_e( 'Add a quote form on your website', 'get-a-quote' ); ?></li>
				<li><?php echo esc_html_e( 'Notify customers for their quote submission through emails', 'get-a-quote' ); ?></li>
				<li><?php echo esc_html_e( 'Enable/Disable your quotation form fields', 'get-a-quote' ); ?></li>
				<li><?php echo esc_html_e( 'Enable/Disable service and quote status taxonomy', 'get-a-quote' ); ?></li>
				<li><?php echo esc_html_e( 'Add different statuses for your quotation', 'get-a-quote' ); ?></li>
			</ul>
		</div>
		<div class="gaq-overview__keywords">
			<div class="gaq-overview__keywords-item">
				<div class="gaq-overview__keywords-card">
					<div class="gaq-overview__keywords-image">
						<img src="<?php echo esc_html( GET_A_QUOTE_DIR_URL . 'admin/src/images/Quotation-Form.png' ); ?>" alt="Quotation image">
					</div>
					<div class="gaq-overview__keywords-text">
						<h3 class="gaq-overview__keywords-heading"><?php echo esc_html_e( 'Quotation Form', 'get-a-quote' ); ?></h3>
						<p class="gaq-overview__keywords-description">
						<?php
						echo esc_html_e(
							'The plugin provides a quotation form you can add on your website. Customers will fill this form to submit a quotation request on your website. As soon as you install and activate our Get A Quote plugin, this form will automatically
							be created.',
							'get-a-quote'
						);
						?>
						</p>
					</div>
				</div>
			</div>
			<div class="gaq-overview__keywords-item">
				<div class="gaq-overview__keywords-card">
					<div class="gaq-overview__keywords-image">
						<img src="<?php echo esc_html( GET_A_QUOTE_DIR_URL . 'admin/src/images/taxonomy.png' ); ?>" alt="Services image">
					</div>
					<div class="gaq-overview__keywords-text">
						<h3 class="gaq-overview__keywords-heading"><?php echo esc_html_e( 'Service and quote status taxonomies', 'get-a-quote' ); ?></h3>
						<p class="gaq-overview__keywords-description"><?php echo esc_html_e( 'The plugin provides you two different types of taxonomies. <b>1) Quote Service Taxonomy</b>, <b>2) Quote Status Taxonomy</b>. Merchants can enable/disable these taxonomies as per their requirements.', 'get-a-quote' ); ?></p>
					</div>
				</div>
			</div>
			<div class="gaq-overview__keywords-item">
				<div class="gaq-overview__keywords-card">
					<div class="gaq-overview__keywords-image">
						<img src="<?php echo esc_html( GET_A_QUOTE_DIR_URL . 'admin/src/images/Multiple-Quotation-Status.png' ); ?>" alt="Multiple quotations image">
					</div>
					<div class="gaq-overview__keywords-text">
						<h3 class="gaq-overview__keywords-heading"><?php echo esc_html_e( 'Multiple quotation statuses', 'get-a-quote' ); ?></h3>
						<p class="gaq-overview__keywords-description"><?php echo esc_html_e( 'Our Get A Quote plugin helps merchants to create multiple statuses for quotations. Admin can check and change the status for a particular quote.', 'get-a-quote' ); ?></p>
					</div>
				</div>
			</div>
			<div class="gaq-overview__keywords-item">
				<div class="gaq-overview__keywords-card">
					<div class="gaq-overview__keywords-image">
						<img src="<?php echo esc_html( GET_A_QUOTE_DIR_URL . 'admin/src/images/services.png' ); ?>" alt="Multiple services image">
					</div>
					<div class="gaq-overview__keywords-text">
						<h3 class="gaq-overview__keywords-heading"><?php echo esc_html_e( 'Multiple services', 'get-a-quote' ); ?></h3>
						<p class="gaq-overview__keywords-description">
						<?php
						echo esc_html_e(
							'With this plugin, merchants can create multiple services to offer. Customers will be able to select these services through the quotation form you added to your website. These services will be displayed in the Services field of
							your quotation form.',
							'get-a-quote'
						);
						?>
						</p>
					</div>
				</div>
			</div>
			<div class="gaq-overview__keywords-item">
				<div class="gaq-overview__keywords-card">
					<div class="gaq-overview__keywords-image">
						<img src="<?php echo esc_html( GET_A_QUOTE_DIR_URL . 'admin/src/images/acknowledgement.png' ); ?>" alt="Acknowledgement image">
					</div>
					<div class="gaq-overview__keywords-text">
						<h3 class="gaq-overview__keywords-heading"><?php echo esc_html_e( 'Submission Acknowledgement through email', 'get-a-quote' ); ?></h3>
						<p class="gaq-overview__keywords-description">
						<?php
						echo esc_html_e(
							'Our Get A Quote plugin also lets you send an acknowledgment email to the user whenever s/he submits the quote requests. You can create and save your email subject and message which will be sent to the user to notify them about
							their successful submission of their quote request.',
							'get-a-quote'
						);
						?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="gaq-overview__support">
			<div class="gaq-support__content">
				<h2 class="gaq-support__heading"><?php echo esc_html_e( 'Exclusive Support', 'get-a-quote' ); ?></h2>
				<p class="gaq-support__description"><?php echo esc_html_e( 'Receive dedicated ', 'get-a-quote' ); ?><b><?php echo esc_html_e( '24x7 ', 'get-a-quote' ); ?></b>
															   <?php
																echo esc_html_e(
																	'Phone, Email & Skype support. Our Support is ready to assist you regarding any query, issue, or feature request and if that doesn`t help our Technical team will connect with you personally and have your query
					resolved.',
																	'get-a-quote'
																);
																?>
				</p>
			</div>
			<div class="gaq-support__icons">
				<ul class="gaq-support__list">
					<li class="gaq-support__list-item"><a href="tel:+91 8765287591"><img src="<?php echo ( sprintf( '%sadmin/src/images/phone-call.png', esc_html( GET_A_QUOTE_DIR_URL ) ) ); ?>" alt="Icon"></a></li>
					<li class="gaq-support__list-item"><a href="mailto:ticket@makewebbetter.com"><img src="<?php echo ( sprintf( '%sadmin/src/images/mail.png', esc_html( GET_A_QUOTE_DIR_URL ) ) ); ?>" alt="Icon"></a></li>
					<li class="gaq-support__list-item"><a href="https://join.skype.com/invite/IKVeNkLHebpC"><img src="<?php echo ( sprintf( '%sadmin/src/images/skype_logo.png', esc_html( GET_A_QUOTE_DIR_URL ) ) ); ?>" alt="Icon"></a></li>
				</ul>
			</div>
		</div>
		<div class="gaq-overview__help">
			<div class="gaq-overview__help-icon"><span></span></div>
			<h4><?php echo esc_html_e( 'Connect with us in one click', 'get-a-quote' ); ?></h4>
			<a href="https://join.skype.com/invite/IKVeNkLHebpC"> <img src="<?php echo ( sprintf( '%sadmin/src/images/skype_logo.png', esc_html( GET_A_QUOTE_DIR_URL ) ) ); ?>" alt="Icon"><span><?php echo esc_html_e( 'Connect', 'get-a-quote' ); ?></span></a>
		</div>
	</div>
</div>
