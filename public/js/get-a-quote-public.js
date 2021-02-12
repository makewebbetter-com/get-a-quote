/**
 * All of the code for your public-facing JavaScript source
 * should reside in this file.
 */
jQuery(document).ready(function($) {
	/**
	 * Constants Of all the list
	 */
	const wrapp = '<div id="form-group-{{fields-scope-here}}" class="form-group"></div>';

	var iterval=[];
	iterval = (php_vars.converted);
	if ( iterval != null && iterval != '' ) {
		show_form_to_frontend( iterval );
	}
	/**
	 * Library Functions here.
	 */
	// Add new field to form.
	function show_form_to_frontend(iternal) {
		for(var i = 0; i < iternal.length; i++) {
			attrs= iternal[i];
			if ( attrs.ltype == 'label' ) {
				var newElelabel = document.createElement(attrs.ltype.toUpperCase());
				jQuery.each(attrs, function (key) {
					switch (key) {
						case 'lclass':
							newElelabel.setAttribute("class", attrs.lclass);
							newWrap = $(wrapp.replace("{{fields-scope-here}}", attrs.lclass));
							break;
						case 'ltext':
							$(newElelabel).text(attrs.ltext);
						default:
							break;
					}
				});
				var labelfield = $( newElelabel);
			}
			if ( attrs.ftype == 'input' || attrs.ftype == 'textarea'  ) {
				var newEleinput = document.createElement(attrs.ftype.toUpperCase());
				jQuery.each(attrs, function (key, value) {
					switch (key) {
						case 'required':
							if( value == 'true'){
								newEleinput.setAttribute(key , 'required');
								break;
							} else{
								break;
							}
						case 'name':
						case 'placeholder':
							newEleinput.setAttribute(key , value);
							break;
						case 'iid':
							newEleinput.setAttribute('id', attrs.iid);
							break;
						case 'iclass':
							newEleinput.setAttribute('class', attrs.iclass);
							break;
						case 'pattern':
							if( value != ''){
								newEleinput.setAttribute(key , value);
							} else{
								break;
							}
						case 'itype' :
							newEleinput.setAttribute('type' , value);
						default:
							break;
					}
				});
				var inputfield = $( newEleinput);
			}
			if ( labelfield != undefined && inputfield != undefined ) {
				$('.active-front-form').append( labelfield );
				$('.active-front-form').append( inputfield );
				$('.active-front-form').append( '<br>' );
				}
		}
	}

	/**
	 * Form Submission
	 */
	jQuery('#form_submit').on('click',function(){
		jQuery('.error_div')[0].innerHTML='';
		// //console.log(jQuery('.active-front-form')[0].children);
		var Form_data = [];
		jQuery(jQuery('.active-front-form')[0].children).each(function(index){
			if( jQuery(this)[0].localName == 'input' || jQuery(this)[0].localName == 'textarea' ){
				// //console.log(jQuery(this)[0].name);
				var req = jQuery(this)[0].required;
				var name = jQuery(this)[0].name;
				var value = jQuery(this)[0].value;
				if ( req == true && value != '' ) {
					Form_data.push({name, value});
				} else {
					jQuery('.error_div').append( name+ ' Is Required.');
					return false;
				}
			}
		});
		if( jQuery('.error_div')[0].innerHTML == ''){
			jQuery.ajax({
				type: 'POST',
				url: ajax_globals.ajax_url,
				data: {
					datalist: Form_data,
					action: 'trigger_form_submission',
					_ajax_nonce: ajax_globals.form_submission_nonce,
				},
				success: function(response) {
					alert(response);
				}
			});
		}
		return false;
	});
});

jQuery(document).ready(function($) {
	if( $('.active-front-form')[0].childElementCount > 2){
		$($('.active-front-form')[0].children).each(function(index){
			if( $(this)[0].localName == 'input' || $(this)[0].localName == 'textarea' ){
				// //console.log($(this));
			}
		})
	}
})
