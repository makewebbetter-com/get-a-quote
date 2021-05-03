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
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="mwb_gaq__modal-wrapper">
	<div class="mwb_gaq__header">
		<div class="mwb_gaq__logo">
			<img src="<?php echo esc_html( GET_A_QUOTE_DIR_URL . 'admin/src/images/mwb-logo1.png' ); ?>" alt="mwb-logo">
		</div>
		<a href='admin.php?page=get_a_quote_menu&gaq_tab=get-a-quote-form-fields' class="mwb_gaq__cross"><i class="fa fa-times fa-3x " id='addclass'></i></a>
	</div>
	<nav class="navbar navbar-expand-sm-mwb navbar-light ">
		<div class="navbar-collapse-wrapper-mwb">
			<button class="navbar-toggler-mwb d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon-mwb"></span>
			</button>
			<div class="collapse navbar-collapse-mwb" id="collapsibleNavId">
				<ul class="navbar-nav mwb-nav-desgin mr-auto mt-2 mt-lg-0">
					<li class="nav-item active">
						<a class="nav-link-mwb" href="admin.php?page=get_a_quote_menu&gaq_tab=get-a-quote-form-fields-edit"><?php esc_html_e( 'Form Fields', 'get-a-quote' ); ?><span class="sr-only"><?php esc_html_e( '(current)', 'get-a-quote' ); ?></span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link-mwb preview_form" href="?page=get_a_quote_menu&gaq_tab=get-a-quote-form-fields-preview"><?php esc_html_e( 'Preview Form', 'get-a-quote' ); ?></a>
					</li>
				</ul>
			</div>
		</div>
		<form class="form-inline" >
			<a href="#" class="mwb_gaq__publishbutton mwb-btn btn-info-mwb"><?php esc_html_e( 'Publish', 'get-a-quote' ); ?></a>
		</form>
	</nav>
	<div class="mwb_gaq__form_title">
		<h2><?php esc_html_e( 'Get A Quote', 'get-a-quote' ); ?></h2>
	</div>
	<div class="mwb_gaq_container">
		<div id="mwb_gaq__form" class="mwb_gaq__form">
			<form method="post" class="form-group-fields">
				<div id="append-form">
				</div>
				<a href="#" class="mwb_gaq__form__submit mwb-btn btn-info-mwb"><?php esc_html_e( 'Save Form', 'get-a-quote' ); ?></a>
			</form>
		</div>
		<div id="mwb_gaq_commonFields" class="mwb_gaq__commonFields">
			<div class="mwb_gaq_close__drawer">
				<button id="mqb_gaq_close__drawer"><?php esc_html_e( 'Done', 'get-a-quote' ); ?></button>
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_first_name" data-ftype="input" data-type="text" data-lname="firstnamelabel" data-name="firstname" data-id="fname" data-placeholder="First Name" data-class="mwb-form-control" data-required="required" data-scope="sfirstname" data-label="First Name" >
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-file-signature"></span></div>
				<?php esc_html_e( 'First name', 'get-a-quote' ); ?>
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_city" data-ftype="input" data-type="text" data-lname="citylabel" data-name="Cityname" data-id="city" data-placeholder="City name here" data-class="mwb-form-control" data-scope="scityname" data-label="City">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-search-location"></span></div>
				<?php esc_html_e( 'City', 'get-a-quote' ); ?>
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_email" data-ftype="input" data-type="email" data-lname="emaillabel" data-name="Email" data-required="required" data-id="email" data-placeholder="Email here" data-class="mwb-form-control" data-scope="ssemail" data-label="Email">
				<div class="mwb_gaq_commonFields_icon" ><span class="far fa-envelope-open"></span></div>
				<?php esc_html_e( 'Email', 'get-a-quote' ); ?>			
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_file" data-ftype="input" data-type="file" data-lname="fileslabel" data-name="Files" data-id="files" data-class="mwb-form-control" data-scope="sfile" data-label="File">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-file-alt"></span></div>
				<?php esc_html_e( 'File', 'get-a-quote' ); ?>			
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_country" data-ftype="Select" data-lname="countrylabel" data-name="Country" data-id="fcountry" data-class="mwb-form-control" data-scope="scountry" data-label="Country">
				<div class="mwb_gaq_commonFields_icon" ><span class="far fa-flag"></span></div>
				<?php esc_html_e( 'Country', 'get-a-quote' ); ?>			
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_zipcode" data-pattern="[0-9]{6}" data-placeholder="123456" data-ftype="input" data-type="text" data-lname="zipcodelabel" data-name="Zipcode" data-id="zipcodes" data-class="mwb-form-control" data-scope="szipcode" data-label="Zipcode">
				<div class="mwb_gaq_commonFields_icon" ><span class="far fa-address-card"></span></div>
				<?php esc_html_e( 'Zipcode', 'get-a-quote' ); ?>			
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_budget" data-ftype="input" data-type="number" data-lname="budgetlabel" data-name="Budget" data-placeholder="Budget" data-id="fbudget" data-class="mwb-form-control" data-scope="sbudget" data-label="Budget">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-dollar-sign"></span></div>
				<?php esc_html_e( 'Budget', 'get-a-quote' ); ?>			
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_phone" data-ftype="input" data-type="tel" data-required="required" data-lname="phonelabel" data-name="Phone" data-placeholder="86 8005551234" data-pattern="[0-9]{2} [0-9]{10}" data-id="phone" data-class="mwb-form-control" data-scope="sphone" data-label="Phone Number">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-mobile-alt"></span></div>
				<?php esc_html_e( 'Phone', 'get-a-quote' ); ?>			
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_addon" data-ftype="textarea" data-lname="addlabel" data-name="Additional" data-id="addon" data-class="mwb-form-control" data-scope="sadd" data-label="Additional Info">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-question-circle"></span></div>
				<?php esc_html_e( 'Additional', 'get-a-quote' ); ?>	
			</div>
		</div>
		<div class="mwb_gaq_open__drawerwrapper">
			<a href="#" class="mwb_gaq_open__drawer"><i class="fa fa-plus fa-3x "></i></a>
		</div>
		<div class="mwb_gaq_edit_container">
			<div class='mwb_gaq_edit_form_fields' id="mwb_gaq_edit_fields">			
				<label for="field_name" id="field-name"><?php esc_html_e( 'Name', 'get-a-quote' ); ?></label>
				<input type="text" data-key="" id="field_name" value="" class="field mwb-form-control" placeholder="name">
				<label for="field_place_name" id="field-place-name"><?php esc_html_e( 'Placeholder-Name', 'get-a-quote' ); ?></label>
				<input type="text" data-key="" id="field_place_name" value="" class="field  mwb-form-control" placeholder="place">		
				<button id="mwb_gaq_close_form_editer" data-id="mwb_gaq_edit_fields" class="mwb-btn btn-info-mwb"><?php esc_html_e( 'Done', 'get-a-quote' ); ?></button>
			</div>
		</div>
	</div>
</div>
