/**
 * All of the code for your public-facing JavaScript source
 * should reside in this file.
 */
jQuery(document).ready(function($) {

	const stateFieldLabel = $( '.form_labels_state' );
	const stateField = $( '#state_list' );
	stateFieldLabel.hide();
	stateField.hide();
    $( '#country_list_select' ).on( 'change', function() {
	
		const selected_country = $( '#country_list_select' ).find( ":selected" ).val();
		// console.log( selected_country );
        jQuery.ajax({
            type : 'POST',
        	url : ajax_globals.ajax_url,
        	data : {
        		selected_country : selected_country,
        		action : 'trigger_states',
        		_ajax_nonce : ajax_globals.nonce,
        	},
        	success: function( response ) {
				
				response = JSON.parse( response );
				console.log( 'true' == response.result );
				if( 'true' == response.result ) {
					stateField.html( response.html );
					stateFieldLabel.show();
					stateField.show();
				}
                else {
					stateFieldLabel.hide();
					stateField.hide();
				}
        	}
        });
    });
})