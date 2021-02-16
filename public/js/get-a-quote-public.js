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
				$.each(attrs, function (key) {
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
				$.each(attrs, function (key, value) {
					switch (key) {
						case 'required':
							if( value == 'true'){
								newEleinput.setAttribute(key , 'required');
								break;
							} else{
								break;
							}
						case 'name':
							newEleinput.setAttribute('name', attrs.name);
							break;
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
	$(document).on('submit', 'form#formdata', function(e){
		e.preventDefault();
		var form_data = new FormData(this);
		form_data.append( "action", "trigger_form_submission" );
		console.log(form_data);
		$.ajax({
			url         : ajax_globals.ajax_url,
			type        : "POST",
			data        : form_data,
			dataType    : 'json',
			contentType : false,
			processData : false,
			success : function( response ) {
				// console.log(response);
				if( response == 'Success' || response == 'updated' ) {
					swal("Successfully Submitted!", "", "success");
				}
				if( response == 'Failed') {
					swal("Oops...", "Something went wrong!", "error");
				}
			}
		});
	});
});
