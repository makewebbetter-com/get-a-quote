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
<div class="mwb_gaq__modal-wrapper">
	<div class="mwb_gaq__header">
		<div class="mwb_gaq__logo">
			<img src="https://mwblive-0obrejwqde.netdna-ssl.com/wp-content/uploads/2018/12/mwb-logo.png" alt="mwb-logo">
		</div>
		<a href='admin.php?page=get_a_quote_menu&gaq_tab=get-a-quote-form-fields' class="mwb_gaq__cross"><i class="fa fa-times fa-3x " id='addclass'></i></a>
	</div>
	<nav class="navbar navbar-expand-sm navbar-light ">
		<div class="navbar-collapse-wrapper">
			<button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavId">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item">
						<b><?php esc_html_e( 'Preview Form', 'get-a-quote' ); ?></b>
					</li>
				</ul>
			</div>
		</div>
		<form class="form-inline">
			<a href="?page=get_a_quote_menu&gaq_tab=get-a-quote-form-fields-edit" class="btn btn-info" id="mwb_gaq__publishbutton"><?php esc_html_e( 'Back', 'get-a-quote' ); ?></a>
		</form>
	</nav>
	<div class="mwb_gaq__form">
		<div class='mwb_display_form'>
		</div>
	</div>
</div>
