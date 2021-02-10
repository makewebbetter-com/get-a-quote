<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="mwb_gaq__modal-wrapper">
	<div class="mwb_gaq__header">
		<div class="mwb_gaq__logo">
			<img src="https://mwblive-0obrejwqde.netdna-ssl.com/wp-content/uploads/2018/12/mwb-logo.png" alt="mwb-logo">
		</div>
		<a href='?page=gaq-config&tab=form-fields' class="mwb_gaq__cross"><i class="fa fa-times fa-3x"></i></a>
	</div>
	<nav class="navbar navbar-expand-sm navbar-light ">
		<div class="navbar-collapse-wrapper">
			<button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="collapsibleNavId">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item active">
						<a class="nav-link" href="admin.php?page=gaq-config&tab=form-fields&form_action=edit">Form Fields <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link preview_form" href="?page=gaq-config&tab=form-fields&form_action=preview">Preview Form</a>
					</li>
				</ul>
			</div>
		</div>
		<form class="form-inline" >
			<a href="#" class="mwb_gaq__publishbutton btn btn-info">Publish</a>
		</form>
	</nav>
	<div class="mwb_gaq__form_title">
		<h2>Get A Quote</h2>
	</div>
	<div class="mwb_gaq_container">
		<div id="mwb_gaq__form" class="mwb_gaq__form">
			<form method="post" class="form-group-fields">
				<div id="append-form">
					<!-- <div id="form-group-sname" class="mwb_gaq__form--group">
						<label for="name" id="nlname">Name*</label>
						<a class="mwb_gaq__icon--del"><i id="sname" class="fas fa-trash-alt icon_del"></i></a>
						<a class="mwb_gaq__icon--edit"><i data-id="sname" class="far fa-edit icon_edit"></i></a>
						<input id="name" type="text" required="required" placeholder="Enter your name" class="form-control">
					</div> -->
				</div>
				<a href="#" class="mwb_gaq__form__submit btn btn-info">Save Form</a>
			</form>
		</div>
		<div id="mwb_gaq_commonFields" class="mwb_gaq__commonFields">
			<div class="mwb_gaq_close__drawer">
				<button id="mqb_gaq_close__drawer">Done</button>
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_first_name" data-ftype="input" data-type="text" data-name="ffname" data-id="fname" data-placeholder="First Name" data-class="form-control" data-required="required" data-scope="sfirstname" data-label="First Name" >
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-file-signature"></span></div>
				First name
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_city" data-ftype="input" data-type="text" data-name="fcityname" data-id="city" data-placeholder="City name here" data-class="form-control" data-scope="scityname" data-label="City">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-search-location"></span></div>
				City
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_email" data-ftype="input" data-type="email" data-name="email" data-required="required" data-id="email" data-placeholder="Email here" data-class="form-control" data-scope="ssemail" data-label="Email">
				<div class="mwb_gaq_commonFields_icon" ><span class="far fa-envelope-open"></span></div>
				Email			
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_file" data-ftype="input" data-type="file" data-name="ffiles" data-id="files" data-class="form-control" data-scope="sfile" data-label="File">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-file-alt"></span></div>
				File		
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_country" data-ftype="input" data-type="text" data-name="fcountry" data-placeholder="Enter Country Name" data-id="fcountry" data-class="form-control" data-scope="scountry" data-label="Country">
				<div class="mwb_gaq_commonFields_icon" ><span class="far fa-flag"></span></div>
				Country		
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_zipcode" data-pattern="^(?(^00000(|-0000))|(\d{5}(|-\d{4})))$" data-placeholder="Zipcode here" data-ftype="input" data-type="text" data-name="zipcode" data-id="zipcodes" data-class="form-control" data-scope="szipcode" data-label="Zipcode">
				<div class="mwb_gaq_commonFields_icon" ><span class="far fa-address-card"></span></div>
				Zipcode		
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_states" data-ftype="input" data-type="text" data-name="fstates" data-placeholder="Enter States Name" data-id="fstates" data-class="form-control" data-scope="sstates" data-label="States">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-flag-usa"></span></div>
				States		
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_budget" data-ftype="input" data-type="number" data-name="fbudget" data-placeholder="Budget" data-id="fbudget" data-class="form-control" data-scope="sbudget" data-label="Budget">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-dollar-sign"></span></div>
				Budget	
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_phone" data-ftype="input" data-type="tel" data-required="required" data-name="phone" data-placeholder="123-45-67-890" data-pattern="[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{3}" data-id="phone" data-class="form-control" data-scope="sphone" data-label="Phone Number">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-mobile-alt"></span></div>
				Phone	
			</div>
			<div class="mwb_gaq_commonFields_group mwb_form_addon" data-ftype="textarea" data-name="additional" data-id="addon" data-class="form-control" data-scope="sadd" data-label="Additional Info">
				<div class="mwb_gaq_commonFields_icon" ><span class="fas fa-question-circle"></span></div>
				Additional	
			</div>
		</div>
		<div class="mwb_gaq_open__drawerwrapper">
			<a href="#" class="mwb_gaq_open__drawer"><i class="fa fa-plus fa-3x"></i></a>
		</div>
		<div class="mwb_gaq_edit_container">
			<div class='mwb_gaq_edit_form_fields' id="mwb_gaq_edit_fields">			
				<label for="field_name" id="field-name">Name</label>
				<input type="text" data-key="" id="field_name" value="" class="field form-control" placeholder="name">
				<label for="field_place_name" id="field-place-name">Placeholder-Name</label>
				<input type="text" data-key="" id="field_place_name" value="" class="field  form-control" placeholder="place">		
				<button id="mwb_gaq_close_form_editer" data-id="mwb_gaq_edit_fields" class="btn btn-info">Done</button>
			</div>
		</div>
	</div>
</div>
