jQuery(document).ready(function($) {

    /**
     * Constants.
     */
    const label = '<lable for="{{fields-id-here}}" class="mwb-gaq-fields-label">{{fields-label-here}}<i id="{{fields-scope}}" class="fas fa-trash-alt icon_del"></i></label>';
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

    // deletion of fields
    // jQuery(".icon_del").on('click', function() {
    //     var attrs = jQuery( this );
    //     alert(attrs[0].id);
    // });

      
    jQuery(document).on("click", ".icon_del", function() {
        var attrs = jQuery( this );
        var classname = '#form-group-';
        var result = classname.concat( attrs[0].id );
        result = jQuery( result ).hide();
        // console.log(result);
        // result.remove()
        //result = $( result );
        //jQuery()
        //alert( result );
        // alert(attrs[0].id);
        // var attrs = jQuery( this );
        // var id = $( attrs[0].id );
        // console.log( id );
        // jQuery( id ).remove();
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
                    newLabel = newLabel.replace( "{{fields-scope}}", attrs.scope );
                    break;
                default:
                    break;
            }    
        });

        newWrapper = wrapper.replace( "{{fields-scope-here}}", attrs.scope );        
        var labelHTML = $(newLabel);
        var divHTML = $(newWrapper);
        divHTML.append(labelHTML);
        divHTML.append(newElement);
        jQuery(".form-group:last ").append(divHTML);
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

// End of scripts.	
});

