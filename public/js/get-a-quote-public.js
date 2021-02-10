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
	} else {
		var p = '<p> No Field Selected </p>';
		$('.active-front-form').append( $(p) );
	}
	/**
	 * Library Functions here.
	 */
	// Add new field to form.
	function show_form_to_frontend(iternal) {
		console.log(iternal);
		for(var i = 0; i < iternal.length; i++) {
			attrs= iternal[i];
			if ( attrs.ltype == 'label' ) {
				var newElelabel = document.createElement(attrs.ltype.toUpperCase());
				jQuery.each(attrs, function (key) {
					switch (key) {
						case 'lid':
							newElelabel.setAttribute('id', attrs.lid);
							newWrap = $(wrapp.replace("{{fields-scope-here}}", attrs.lid));
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
						case 'placeholder':
							newEleinput.setAttribute(key , value);
							break;
						case 'iid':
							newEleinput.setAttribute('id', attrs.iid);
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
				$('.active-front-form').append( '<br>' );}
		}
	}
});

//form Submission Process.
jQuery('#form_submit').on('click',function($){
	alert( $('#form_submit').length );
})

//Ajax For States
// jQuery(document).ready(function($) {
// 	const stateFieldLabel = $( '.form_labels_state' );
// 	const stateField = $( '#state_list' );
// 	stateFieldLabel.hide();
// 	stateField.hide();

//     $( '#country_list_select' ).on( 'change', function() {
// 		const selected_country = $( '#country_list_select' ).find( ":selected" ).val();
//         jQuery.ajax({
//             type : 'POST',
//         	url : ajax_globals.ajax_url,
//         	data : {
//         		selected_country : selected_country,
//         		action : 'trigger_states',
//         		_ajax_nonce : ajax_globals.nonce,
//         	},
//         	success: function( response ) {
// 				response = JSON.parse( response );
// 				console.log( 'true' == response.result );
// 				if( 'true' == response.result ) {
// 					stateField.html( response.html );
// 					stateFieldLabel.show();
// 					stateField.show();
// 				}
//                 else {
// 					stateFieldLabel.hide();
// 					stateField.hide();
// 				}
//         	}
//         });
//     });
// })