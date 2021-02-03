jQuery(document).ready(function ($) {
	/**
	 * Constants.
	 */
	const label = '<label for="{{fields-id-here}}" id="{{field-lname}}">{{fields-label-here}}</label>';
	const icons = '<i id="{{fields-scope}}" class="fas fa-trash-alt icon_del"></i><i data-id="{{scope}}" class="far fa-edit icon_edit"></i>';
	const wrapper = '<div id="form-group-{{fields-scope-here}}" class="form-group"></div>';

	/**
	 * Add Class to body when builder is initiated.
	 */
	transformBodyOnBuilder();

	// Remove Class to body when builder is closed.
	jQuery('.mwb_gaq__cross').on('click', function () {
		jQuery('body').removeClass('mwb_gaq_transform_body');
		jQuery('.mwb_gaq__modal-wrapper').css('overflow', 'hidden');
	});

	// drawer query start
	jQuery('.mwb_gaq_open__drawer').on('click', function () {
		removecls(jQuery(this), 'inactive');
		addcls(jQuery(this), 'active');
	});

	//For closing the adding field div.
	jQuery('#mqb_gaq_close__drawer').on('click', function () {
		removecls(jQuery(this), 'active');
	});

	//for deleting the div using Icon.
	jQuery(document).on("click", ".icon_del", function () {
		var attrs = jQuery(this);
		var classname = '#form-group-';
		var result = classname.concat(attrs[0].id);
		removecls(jQuery(this), 'inactive');
		result = jQuery(result).remove();
		// alert( result );
	});

	//Edit icon operation will open the side div and display the edit fields
	jQuery(document).on("click", ".icon_edit", function () {
		$('.mwb_gaq_edit_container').load();
		removecls(jQuery(this), 'active');
		addcls(jQuery(this), 'inactive');
		var attrs = jQuery(this).data();
		var classname = '#form-group-';
		var result = classname.concat(attrs.id);
		var child = jQuery(result).children();
		// console.log( child );
		edit_call(child);
	});

	function edit_call(child) {

		$(child).each(function (index) {

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
				}
				$("#field_place_name").attr("data-key", $(this)[0].id);
				$("#field_place_name").val($(this)[0].placeholder);
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
	jQuery('.mwb_gaq_commonFields_group').on('click', function () {

		var attrs = jQuery(this).data();
		appendNewlement(attrs);
	});

	/**
	 * Library Functions here.
	 */
	// Add new field to form.
	function appendNewlement(attrs = []) {
		var newElement = document.createElement(attrs.ftype.toUpperCase());
		jQuery.each(attrs, function (key, value) {
			// console.log( key )
			switch (key) {
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
				case 'label':
					newLabel = label.replace("{{fields-id-here}}", attrs.id);
					newLabel = newLabel.replace("{{field-lname}}", attrs.lname);
					newLabel = newLabel.replace("{{fields-label-here}}", attrs.label);
					newIcon = icons.replace("{{fields-scope}}", attrs.scope);
					newIcon = newIcon.replace("{{scope}}", attrs.scope);
					break;
				default:
					break;
			}
		});
		newWrapper = wrapper.replace("{{fields-scope-here}}", attrs.scope);
		var iconHTML = $(newIcon);
		var labelHTML = $(newLabel);
		labelHTML.css('font-weight', '600');
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

	//for editing the value using the edit logo.
	jQuery('#mwb_gaq_close_form_editer').on('click', function () {
		removecls(jQuery(this), 'inactive');
		var pid = $(this).data('id');
		var temp = "#";
		pid = temp.concat(pid);
		edit_done($(pid).children())
	});

	//function to reflect edited value.
	function edit_done(child) {
		$(child).each(function (index) {
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

	//Data sending to the front-end form.
	jQuery('#mwb_gaq__publishbutton').on('click', function () {
		var IDs = [];
		$(jQuery('#append-form').children()).each(function (index) {
			// console.log( $( this ).children() );
			$($(this).children()).each(function (inde) {
				if ( $(this).text() != '' && $(this)[0].id != '' ) {
					var labelID = $(this)[0].id;
					var labelTEXT = $(this).text();
					IDs.push({labelID, labelTEXT});
					// console.log( lko );
					// console.log( 'hello' );
					// IDs[lko]['labeltext']= txt;
					// IDs.push({ name : txt });
					// console.log($(this).text());
				}
				if ( $(this)[0].placeholder != undefined && $(this)[0].placeholder != '' ) {
					var inputID = $(this)[0].id;
					var inputPHOLDER = $(this)[0].placeholder;
					IDs.push({inputID, inputPHOLDER});
					// var lko = $(this)[0].id;
					// var place = $(this)[0].placeholder;
					// IDs[lko]['placeholder']= place;
					// IDs[lko][].push({ placeholder : place });
					// console.log($(this)[0].placeholder);
				}
			})
		})
		console.log( IDs );
		// jQuery.ajax({
        //     type : 'POST',
		// 	url : ajax_globals.ajax_url,
		// 	action : 'trigger_states',
        // 	data : IDs,
		// 	},
		// 	success: function( response ) {}
		// });
	});

	// End of scripts.	
});
