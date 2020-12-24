jQuery(document).ready(function($) {
    $('.form_labels_state').hide();
    $('#state_list').hide();
    
    $("#country_list_select").on('change', function() {
        var conceptName = $('#country_list_select').find(":selected").val();
        $('.form_labels_state').show();
        $('#state_list').show();
        $.ajax({
            type : 'POST',
        	url : ajax_url_global.ajax_url,
        	data : {
        		ID : conceptName,
        		action : 'ajax_count_state',
        		_ajax_nonce : ajax_url_global.nonce,

        	},
        	success: function(response){
                    $("#state_list").html(response);
                
        	}
        });
    });
})