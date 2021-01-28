jQuery(document).ready(function($) {

    /**
     * Constants.
     */
    // const deleteButton = '<i id="icon_del" class="fas fa-trash-alt"></i>';
    const label = '<lable for="{{fields-id-here}}" class="mwb-gaq-fields-label"><b>{{fields-label-here}}</b><i id="icon_del" class="fas fa-trash-alt"></i></label>';
    const wrapper = '<div id="form-group-{{fields-scope-here}}" class="form-group"></div>';

    /**
     * Add Class to body when builder is initiated.
     */
    transformBodyOnBuilder();

    // Remove Class to body when builder is closed.
    jQuery('.mwb_gaq__cross').on('click', function() {
        jQuery('body').removeClass('mwb_gaq_transform_body');
        jQuery('.mwb_gaq__modal-wrapper').css('overflow', 'hidden');
    });


    // drawer query start
    jQuery('.mwb_gaq_open__drawer').on('click', function() {
        jQuery(this).parents('.mwb_gaq_container').addClass('active');
    });

    jQuery('#mqb_gaq_close__drawer').on('click', function() {
        jQuery(this).parents('.mwb_gaq_container').removeClass('active');
    });

    // Insertion of new fields in form.
    jQuery('.mwb_gaq_commonFields_group').on('click', function() {

        var attrs = jQuery( this ).data();
        appendNewlement( attrs );
    });

    /**
     * Library Functions here.
     */
    // Add new field to form.
    function appendNewlement( attrs=[] ) {
        var newElement = document.createElement( attrs.ftype.toUpperCase() );
        jQuery.each( attrs, function ( key, value ) {
            // console.log( key )
            switch ( key ) {
                case 'class':
                case 'id':
                case 'type':
                case 'inputmode':
                case 'pattern':
                case 'placeholder':
                case 'required':
                case 'size':
                case 'name':
                    newElement.setAttribute( key, value );
                    break;

                case 'label':
                    newLabel = label.replace( "{{fields-id-here}}", attrs.id );
                    newLabel = newLabel.replace( "{{fields-label-here}}", attrs.label );
                    break;

                default:
                    break;
            }    
        });

        newWrapper = wrapper.replace( "{{fields-scope-here}}", attrs.scope );        
        var labelHTML = $(newLabel);
        var divHTML = $( newWrapper );
        divHTML.append( labelHTML );
        divHTML.append( newElement );
        jQuery( ".form-group:last" ).append( divHTML );
    }

    // Add class to body on builder open.
    function transformBodyOnBuilder() {
        if ('edit' == getParameterByName('form_action')) {
            jQuery('body').addClass('mwb_gaq_transform_body');
        }
    }

    // Search query params.
    function getParameterByName(name, url = document.URL) {
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
    // $( '.mwb_form_first_name' ).on('click', function() {
    //     $(".form-group:last").append( '<div id="form-group-first-name" class="form-group"><label for="ffname"><b>First Name*</b><i id="icon_del" class="fas fa-trash-alt"></i></label><input type="text" required="required" class="form-control" id="ffname" pattern="[a-zA-Z0-9 ]+" required="required" value="" size="40" placeholder="First Name" /></div>' );
    // })

// End of scripts.	
});

