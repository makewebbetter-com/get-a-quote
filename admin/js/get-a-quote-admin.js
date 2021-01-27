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

    /**
     * Helper Functions.
     */
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

    // drawer query start
    jQuery('.mwb_gaq_open__drawer').on('click', function() {
        jQuery(this).parents('.mwb_gaq_container').addClass('active');
    });

    jQuery('#mqb_gaq_close__drawer').on('click', function() {
        jQuery(this).parents('.mwb_gaq_container').removeClass('active');
    });

    //firstname click concept.
    $( '.mwb_form_first_name' ).on('click', function() {
       $(".form-group:last").append( '<br><div class="form-group"><label for="ffname"><b>First Name *</b></label><input type="text" required="required" class="form-control" name="ffname" pattern="[a-zA-Z0-9 ]+" required="required" value="" size="40" placeholder="First Name" /></div>' );
    })

    //lastname click concept.
    $( '.mwb_form_city' ).on('click', function() {
        $(".form-group:last").append( '<br><div class="form-group"><label for="city_name"><b>City</b></label><input type="text" class="form-control" name="fqcity" value="" size="40" placeholder="City" /></div>' );
    })

    //email click concept.
    $( '.mwb_form_email' ).on('click', function() {
        $(".form-group:last").append( '<br><div class="form-group"><label for="email"><b>Email*</b></label><input type="email" name="email" required="required" placeholder="Enter Your email" class="form-control"></div>' );
    })

    //file click concept.
    $( '.mwb_form_file' ).on('click', function() {
        $(".form-group:last").append( '<br><div class="form-group"><label for="fqfiles"><b>File</b></label><input type="file" name="fqfiles" id="fileToUpload" class="form-control"></div>' );
    })

    //country click concept.
    $( '.mwb_form_country' ).on('click', function() {
        $(".form-group:last").append( '<br><div class="form-group"><label for="country"><b>Country</b></label><input type="text" name="country" placeholder="Country Name" class="form-control"></div>' );
    })
/* */
    //lastname click concept.
    $( '.mwb_form_zipcode' ).on('click', function() {
        $(".form-group:last").append( '<br><div class="form-group"><label for="zipcode"><b>Zipcode</b></label><br><input name="zipcode" class="form-control" type="text" inputmode="numeric" size="40" pattern="^(?(^00000(|-0000))|(\d{5}(|-\d{4})))$" placeholder="Zipcode"></div>' );
    })

    //lastname click concept.
    $( '.mwb_form_states' ).on('click', function() {
        $(".form-group:last").append( '<br><div class="form-group"><label for="states"><b>States</b></label><input type="text" class="form-control" name="states" value="" size="40" placeholder="States" /></div>' );
    })

    //lastname click concept.
    $( '.mwb_form_budget' ).on('click', function() {
        $(".form-group:last").append( '<br><div class="form-group"><label for="budget"><b>Budget</b></label><input type="number" class="form-control" name="budget" value="" size="40" placeholder="Budget" /></div>' );
    })
    
    //lastname click concept.
    $( '.mwb_form_phone' ).on('click', function() {
        $(".form-group:last").append( '<br><div class="form-group"><label for="phone"><b>Phone Number</b></label><input type="tel" id="phone" name="phone" class="form-control" placeholder="123-45-67-890" pattern="[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{3}" required></div>' );
    })

    // drawer qurey end
    // End of scripts.	
});