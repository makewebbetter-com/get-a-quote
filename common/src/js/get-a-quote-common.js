/**
 * Constants.
 */
const label = '<label for="{{fields-id-here}}" id="{{field-id-lname}}" data-id="{{field-lname}}" class="form-labels">{{fields-label-here}}</label>';
const icons = '<a class="mwb_gaq__icon--del"><i id="{{fields-scope}}" class="fas fa-trash-alt icon_del"></i></a><a class="mwb_gaq__icon--edit"><i data-id="{{scope}}" class="far fa-edit icon_edit"></i></a>';
const wrapper = '<div id="form-group-{{fields-scope-here}}" class="mwb_gaq__form--group"></div>';
const lab = '<label class="form-labels">{{fields-label-here}}</label>';
const wrap = '<div class="mwb_gaq__form--group"></div>';

/**
 * 
 * To show preview form
 */
function previewNewlement(attrs = []) {
    var newElement = document.createElement(attrs.ftype.toUpperCase());
    jQuery.each(attrs, function(key, value) {
        switch (key) {
            case 'cls':
                newElement.setAttribute('class', value);
                break;
            case 'class':
            case 'id':
            case 'type':
            case 'inputmode':
            case 'pattern':
            case 'placeholder':
            case 'required':
            case 'size':
            case 'name':
                newElement.setAttribute(key, value);
                break;
            case 'scope':
            case 'label':
                newLabel = lab.replace("{{fields-label-here}}", attrs.label);
                break;
            default:
                break;
        }
    });
    var labelHTML = jQuery(newLabel);
    labelHTML.css('font-weight', '600');
    var divHTML = jQuery(wrap);
    divHTML.append(labelHTML);
    divHTML.append(newElement);
    jQuery(".mwb_display_form ").append(divHTML);    
}
/**
 * Library Functions here.
 */
// Add new field to form.
function appendNewlement(attrs = []) {
    var newElement = document.createElement(attrs.ftype.toUpperCase());
    jQuery.each(attrs, function(key, value) {
        switch (key) {
            case 'cls':
                newElement.setAttribute('class', value);
                break;
            case 'class':
            case 'id':
            case 'type':
            case 'inputmode':
            case 'pattern':
            case 'placeholder':
            case 'required':
            case 'size':
            case 'name':
                newElement.setAttribute(key, value);
                break;
            case 'scope':
            case 'label':
                newLabel = label.replace("{{fields-id-here}}", attrs.id);
                newLabel = newLabel.replace("{{field-lname}}", attrs.scope);
                newLabel = newLabel.replace("{{field-id-lname}}", attrs.lname);
                newLabel = newLabel.replace("{{fields-label-here}}", attrs.label);
                newIcon = icons.replace("{{fields-scope}}", attrs.scope);
                newIcon = newIcon.replace("{{scope}}", attrs.scope);
                break;
            default:
                break;
        }
    });
    newWrapper = wrapper.replace("{{fields-scope-here}}", attrs.scope);
    var iconHTML = jQuery(newIcon);
    var labelHTML = jQuery(newLabel);
    labelHTML.css('font-weight', '600');
    var divHTML = jQuery(newWrapper);
    divHTML.append(labelHTML);
    divHTML.append(iconHTML);
    divHTML.append(newElement);
    jQuery("#append-form ").append(divHTML);
}
jQuery(document).ready(function($) {

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
        removecls(jQuery(this), 'inactive');
        addcls(jQuery(this), 'active');
    });

    //For closing the adding field div.
    jQuery('#mqb_gaq_close__drawer').on('click', function() {
        removecls(jQuery(this), 'active');
    });

    //for deleting the div using Icon.
    jQuery(document).on("click", ".icon_del", function() {
        var attrs = jQuery(this);
        var classname = '#form-group-';
        var result = classname.concat(attrs[0].id);
        removecls(jQuery(this), 'inactive');
        result = jQuery(result).remove();
        // alert( result );
    });

    //Edit icon operation will open the side div and display the edit fields
    jQuery(document).on("click", ".icon_edit", function() {
        removecls(jQuery(this), 'active');
        addcls(jQuery(this), 'inactive');
        var attrs = jQuery(this).data();
        var classname = '#form-group-';
        var result = classname.concat(attrs.id);
        var child = jQuery(result).children();
        edit_call(child);
    });

    //This function is for to edit setting for all the fields.
    function edit_call(child) {
        $(child).each(function(index) {
            if ($(this)[0].localName == 'label') {
                $("#field_name").val($(this).text());
                $("#field_name").attr("data-key", $(this)[0].id);
            }
            if ($(this)[0].localName == 'input') {
                if ($(this)[0].placeholder == '') {
                    $("#field_place_name").hide();
                    $("#field-place-name").hide();
                } else {
                    $("#field_place_name").show();
                    $("#field-place-name").show();
                    $("#field_place_name").attr("data-key", $(this)[0].id);
                    $("#field_place_name").val($(this)[0].placeholder);
                }
            } else if ($(this)[0].localName == 'textarea' || $(this)[0].localName == 'file' ){
                $("#field_place_name").hide();
                $("#field-place-name").hide();
            }
        });
    }

    //remove the class.
    function removecls(obj, cname) {
        obj.parents('.mwb_gaq_container').removeClass(cname);
    }

    // add the class.
    function addcls(obj, cname) {
        obj.parents('.mwb_gaq_container').addClass(cname);
    }

    // Insertion of new fields in form.
    jQuery('.mwb_gaq_commonFields_group').on('click', function() {
        var attrs = jQuery(this).data();
        var checker = '';
        $(jQuery('#append-form').children()).each(function(index) {
            $($(this).children()).each(function(inde) {
                if ($(this)[0].localName != 'svg') {
                    if ($(this)[0].localName != 'label') {
                        if( $(this)[0].id != '' ){
                            if( $(this)[0].id == attrs.id ){
                                checker = 'true';
                            }
                        }
                    }
                }
            })
        })
        if( checker != 'true' ) {
            appendNewlement(attrs)
        } else {
            swal("Already in the Form", "", "error");
        }
    });

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

    //for editing the value using the edit logo.
    jQuery('#mwb_gaq_close_form_editer').on('click', function() {
        removecls(jQuery(this), 'inactive');
        var pid = $(this).data('id');
        var temp = "#";
        pid = temp.concat(pid);
        edit_done($(pid).children())
    });

    //function to reflect edited value.
    function edit_done(child) {
        $(child).each(function(index) {
            if (child[index].localName == 'input') {
                var nid = $(this).attr("data-key");
                var temp = "#";
                nid = temp.concat(nid);
                if ($(this).attr('placeholder') == 'name') {

                    $(nid).text($(this).val());
                }
                if ($(this).attr('placeholder') == 'place') {

                    $(nid).attr('placeholder', $(this).val());
                }
            }
        });
    }
    //Data saving on the save form button.
    jQuery('.mwb_gaq__form__submit').on('click', function() {
        var IDs = [];
        $(jQuery('#append-form').children()).each(function(index) {
            var divlabel = $(this)[0].children[0];
            var divinput = $(this)[0].children[3];
            var cls = 'form-control';
            var ftype = $(divinput)[0].localName
            var id = $(divinput)[0].id;
            var lname = $(divlabel)[0].id;
            var label = $(divlabel).text();
            var name = $(divinput)[0].name;
            var pattern = '';
            if ( $(divinput)[0].pattern != '' && $(divinput)[0].pattern != undefined ){
                pattern = $(divinput)[0].pattern;
            }
            var placeholder ='';
            if ( $(divinput)[0].placeholder != '' ){
                placeholder = $(divinput)[0].placeholder;
            }
            var required = '';
            if ( $(divinput)[0].required == 'true' ){
                required = 'required';
            }
            var scope = $(divlabel).data('id');
            var type = $(divinput)[0].type;
            
            IDs.push({cls, ftype, lname, id, label, name, pattern, placeholder, required, scope, type});
        })
        if( IDs == [] ){
            IDs= 'No Values';
        }
        $.ajax({
            type: 'POST',
            url: ajax_form_edit.ajax_url,
            data: {
                savinglist : IDs,
                action: 'trigger_edit_form_data',
                _ajax_nonce: ajax_form_edit.nonce,
            },
            success: function( response ) {
                swal("Submitted", "Successfully Submitted","success");
            }
        });
    });

    //Data sending to the front-end form.
    jQuery('.mwb_gaq__publishbutton').on('click', function() {
        var IDs = [];
        var fdata= '';
        $(jQuery('#append-form').children()).each(function(index) {
                $($(this).children()).each(function(inde) {
                    if ($(this)[0].localName != 'svg') {
                        if (text = $(this).text() && $(this)[0].localName == 'label') {
                            var ltext = $(this).text();
                            var lclass = $(this)[0].className;
                            var ltype = $(this)[0].localName;
                            IDs.push({ lclass, ltext, ltype });
                        }
                        if ($(this)[0].placeholder != undefined && $(this)[0].id != '') {
                            var placeholder = $(this)[0].placeholder;
                            var name = $(this)[0].name;
                            if ( name == 'firstname'){
                                fdata = 'true';
                            }
                            var required = $(this)[0].required;
                            var iid = $(this)[0].id;
                            var ftype = $(this)[0].localName;
                            var itype = $(this)[0].type;
                            var iclass = $(this)[0].className;
                            var pattern = $(this)[0].pattern;
                            IDs.push({ iid, pattern, placeholder, ftype, itype, name, required, iclass });
                        }
                    }
                })
            })
            if ( fdata == 'true' ){
                $.ajax({
                    type: 'POST',
                    url: ajax_form_edit.ajax_url,
                    data: {
                        datalist: IDs,
                        action: 'trigger_edit_form_data',
                        _ajax_nonce: ajax_form_edit.nonce,
                    },
                    success: function(response) {
                        swal("Published!", "Also save the form", "success")
                    }
                });
            } else {
                swal("Oops...", "Please Select first name field!", "error");
            }
    });

    // End of scripts.	
});
jQuery(document).ready(function($) {
    var data = form_variables.converted;
    if ( data != null && data != '' ) {
        if( $( '#append-form').length > 0 ){
            if( $( '#append-form')[0].childElementCount == 0 ) {
                for (i = 0; i < data.length; i++) {
                    appendNewlement( data[i] );
                }
            }
        }
    }
    var dataforpreview = form_variables.converted;
    if ( dataforpreview != null && dataforpreview != '' ) {
        if( $('.mwb_display_form').length > 0 ){
            if( $('.mwb_display_form')[0].childElementCount == 0 ) {
                for (i = 0; i < dataforpreview.length; i++) {
                    previewNewlement( dataforpreview[i] );
                }
            }
            jQuery(".mwb_display_form ").append('<a href="#" class="btn btn-info">Submit</a>');
        }
    }
})

//copy to clipborad for shortcode.
jQuery(document).ready(function($) {
    
    $('#copytoclipTxt').on('click', function(){
        var cls = document.getElementById("copytoclipTxt");
        cls.select();
        cls.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Copied");
    })
});

jQuery(document).ready(function($) {

    var sat = document.getElementById("select_for_status");
    if( sat != null){
        var sat_val = sat.options[sat.selectedIndex].value;
        if (sat_val == 'No' ) {
            $('.mwb_gaq_status_terms').hide();
        } else if (sat_val == 'Yes' ) {
            $('.mwb_gaq_status_terms').show();
        }
    }
    var serv = document.getElementById("select_for_services");
    if( serv != null){
        var sev_val = serv.options[serv.selectedIndex].value;
        if (sev_val == 'No' ) {
            $('.service_terms').hide();
        } else if (sev_val == 'Yes' ) {
            $('.service_terms').show();
        }
    } 

    var status = taxonomy_values.status;
    var service = taxonomy_values.service;
    if( status != '' ) {
        for (i = 0; i < status.length; i++) {
            $('.mwb_gaq_status_terms ').append( "<td class='mwb_active_terms_status' id="+status[i].term_id+">"+status[i].name+"<i class='far fa-times-circle ' style='font-size:20px'></i></td>");
        }
    }
    if( service != '' ) {
        for (i = 0; i < service.length; i++) {
            $('.service_terms ').append( "<td class='mwb_active_terms_service' id="+service[i].term_id+">"+service[i].name+"<i class='far fa-times-circle' style='font-size:20px'></i></td>");
        }
    }

    $('#add_service_terms').on('click', function () {
        $('#mwb_service_add_div').show();
        $('#mwb_status_add_div').hide();
        $('#add_status_terms').show();
        $(this).hide();
    })
    $('#add_status_terms').on('click', function () {
        $('#mwb_status_add_div').show();
        $('#mwb_service_add_div').hide();
        $('#add_status_terms').show();
        $(this).hide();
    })
    
    $('.close').on('click', function () {
        $('.center').hide();
        $('#add_status_terms').show();
        $('#add_service_terms').show();
    })

    $('.mwb_active_terms_status').on('click', function(){
        var id = $(this)[0].id;
        if( id != '') {
            removeTaxo( id, 'status');
        }
    });
    $('.mwb_active_terms_service').on('click', function(){
        var id = $(this)[0].id;
        if( id != '') {
            removeTaxo( id, 'service');
        }
    });
});

//sending Ajax for taxonomy deletion
function removeTaxo( term_id, taxoname ) {

    jQuery.ajax({
        type: 'POST',
        url: ajax_form_edit.ajax_url,
        data: {
            term_name: term_id,
            taxonomy_name: taxoname,
            action: 'trigger_edit_form_data',
            _ajax_nonce: ajax_form_edit.nonce,
        },
        success: function(response) {
            window.location['reload']();
        }
    });
}

(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).ready(function() {

		const MDCText = mdc.textField.MDCTextField;
        const textField = [].map.call(document.querySelectorAll('.mdc-text-field'), function(el) {
            return new MDCText(el);
        });
        const MDCRipple = mdc.ripple.MDCRipple;
        const buttonRipple = [].map.call(document.querySelectorAll('.mdc-button'), function(el) {
            return new MDCRipple(el);
        });
        const MDCSwitch = mdc.switchControl.MDCSwitch;
        const switchControl = [].map.call(document.querySelectorAll('.mdc-switch'), function(el) {
            return new MDCSwitch(el);
        });

        $('.mwb-password-hidden').click(function() {
            if ($('.mwb-form__password').attr('type') == 'text') {
                $('.mwb-form__password').attr('type', 'password');
            } else {
                $('.mwb-form__password').attr('type', 'text');
            }
        });

	});

	$(window).load(function(){
		// add select2 for multiselect.
		if( $(document).find('.mwb-defaut-multiselect').length > 0 ) {
			$(document).find('.mwb-defaut-multiselect').select2();
		}
	});

	})( jQuery );
