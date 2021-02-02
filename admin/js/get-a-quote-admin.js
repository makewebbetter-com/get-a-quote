jQuery(document).ready(function($) {

    /**
     * Constants.
     */
    const label = '<lable for="{{fields-id-here}}" id="{{field-lname}}">{{fields-label-here}}</label>';
    const icons = '<i id="{{fields-scope}}" class="fas fa-trash-alt icon_del"></i><i data-id="{{scope}}" class="far fa-edit icon_edit"></i>';
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
        removecls( jQuery(this), 'inactive');
        addcls( jQuery(this), 'active');
    });

    //For closing the adding field div.
    jQuery('#mqb_gaq_close__drawer').on('click', function() {
        removecls( jQuery(this), 'active');
    });
    
    //change the Label name on edit.
    jQuery(document).on("change paste keyup", "#field_name", function() {
        var attrt = jQuery( this ).data();
        var val = "#";
        attrt = val.concat( attrt.key );
        jQuery( attrt ).text( $(this).val() );
	}); 

    //change the Label name on edit.
    jQuery(document).on("change paste keyup", "#field_place_name", function() {
        var attrt = jQuery( this ).data();
        var val = "#";
        attrt = val.concat( attrt.key );
        jQuery(attrt).attr("placeholder", $(this).val());
        jQuery(attrt).setAttribute( "placeholder",$(this).val() );
	}); 

    //for deleting the div using Icon.
    jQuery(document).on("click", ".icon_del", function() {
        var attrs = jQuery( this );
        var classname = '#form-group-';
        var result = classname.concat( attrs[0].id );
        removecls( jQuery(this), 'inactive');
        result = jQuery( result ).remove();
        // alert( result );
    });

    //for editing the value using the edit logo.
    jQuery('#mwb_gaq_close_form_editer').on('click', function() {
        // var pnode = $(jQuery(this)[0].parentNode);
        // var pchild = jQuery( pnode ).children();
        // $( pchild ).each(function( index ) {
        //     if ( jQuery( this ).data().key !== undefined) {
        //         var dattr = jQuery( this ).data().key;
        //         console.log( dattr );
        //     }
        // });
        removecls( jQuery(this), 'inactive');
    });

    //Edit icon operation will open the side div and display the edit fields
    jQuery(document).on("click", ".icon_edit", function() {
        // if (jQuery(this).parents('.mwb_gaq_container')[0].className == 'mwb_gaq_container inactive' ) {
        //     // console.log( jQuery(this).parents('.mwb_gaq_container')[0].className );
        //     // console.log( $("#field_name").data('key') );
        //     // console.log( $("#field_name").attr('value') );
        //     // console.log( $("#field_place_name").data('key') );
        //     // console.log( $("#field_place_name").attr('value') );
        // }
        removecls( jQuery(this), 'active');
        addcls( jQuery(this), 'inactive' );
        var attrs = jQuery( this ).data();
        var classname = '#form-group-';
        var result = classname.concat( attrs.id );
        var child = jQuery( result ).children();
        edit_call( child);
    });

    function edit_call( child ) {
        $( child ).each(function( index ) {
            if( ( $( this ).text() ) != "" ) {
                console.log( $( this ).data("key") );
                $("#field_name").val( $( this ).text() );
                $("#field_name").attr("data-key", $( this )[0].id);
            }
            if ( ( $( this )[0].placeholder ) !== undefined ) {
                console.log( $( this ).data("key") );
                $("#field_place_name").attr("data-key", $( this )[0].id);
                $("#field_place_name").val( $( this )[0].placeholder);
            }
        });
    }

    //remove the class.
    function removecls( obj, cname ) {
        obj.parents('.mwb_gaq_container').removeClass( cname );
    }

    // add the class.
    function addcls( obj, cname ) {
        obj.parents('.mwb_gaq_container').addClass( cname );
    }

    // Insertion of new fields in form.
    jQuery('.mwb_gaq_commonFields_group').on('click', function() {

        var attrs = jQuery( this ).data();
        appendNewlement( attrs );
    });

    // Submit the form fields for front-end display
    // jQuery('.mwb_gaq__form__submit').on('click', function() {
    //     console.log( $('#append-form').children() );
    // });

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
                    newLabel = newLabel.replace( "{{field-lname}}", attrs.lname );
                    newLabel = newLabel.replace( "{{fields-label-here}}", attrs.label );
                    newIcon = icons.replace( "{{fields-scope}}", attrs.scope );
                    newIcon = newIcon.replace( "{{scope}}", attrs.scope );
                    break;
                default:
                    break;
            }    
        });
        newWrapper = wrapper.replace( "{{fields-scope-here}}", attrs.scope );  
        var iconHTML = $( newIcon );
        var labelHTML = $(newLabel);
        var divHTML = $(newWrapper);
        divHTML.append(labelHTML);
        divHTML.append(iconHTML);
        divHTML.append(newElement);
        jQuery("#append-form ").append(divHTML);
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
