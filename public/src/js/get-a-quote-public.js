/**
 * All of the code for your public-facing JavaScript source
 * should reside in this file.
 */
jQuery(document).ready(function($) {
  // JS for preloader
  $("#form_submit").on("click", function() {
    var show_img = setTimeout(function pre() {
      $("#primary").css("display", "none");
      $(".mwb-gaq-dialog-wrapper").css("display", "block");
    }, 300);
    setTimeout(function preloaded() {
      clearTimeout(show_img);
      $("#primary").css("display", "block");
      $(".mwb-gaq-dialog-wrapper").css("display", "none");
    }, 3000);
  });

  $(".success-div").hide();

  $(".error-div").hide();

  /**
   * Constants Of all the list
   */
  const wrapp =
    '<div id="form-group-{{fields-scope-here}}" class="form-group"></div>';

  var iterval = [];

  iterval = php_vars.converted;

  if (iterval != null && iterval != "") {
    $(".active-from").show();

    show_form_to_frontend(iterval);
  } else {
    $(".active-from").hide();
    $(".error-div").show();
    $(".error-div").html(
      "Please make a form from admin section to get displayed here"
    );
  }

  /**
   * Library Functions here.
   */
  // Add new field to form.
  function show_form_to_frontend(iternal) {
    for (var i = 0; i < iternal.length; i++) {
      attrs = iternal[i];

      if (attrs.ltype == "label") {
        var newElelabel = document.createElement(attrs.ltype.toUpperCase());

        $.each(attrs, function(key) {
          switch (key) {
            case "lclass":
              newElelabel.setAttribute("class", attrs.lclass);

              newWrap = $(wrapp.replace("{{fields-scope-here}}", attrs.lclass));

              break;

            case "ltext":
              $(newElelabel).text(attrs.ltext);

            default:
              break;
          }
        });

        var labelfield = $(newElelabel);
      }

      if (
        attrs.ftype == "input" ||
        attrs.ftype == "textarea" ||
        attrs.ftype == "select"
      ) {
        var newEleinput = document.createElement(attrs.ftype.toUpperCase());

        $.each(attrs, function(key, value) {
          switch (key) {
            case "required":
              if (value == "true") {
                newEleinput.setAttribute(key, "required");

                break;
              } else {
                break;
              }

            case "name":
              newEleinput.setAttribute("name", attrs.name);

              break;

            case "placeholder":
              newEleinput.setAttribute(key, value);

              break;

            case "iid":
              newEleinput.setAttribute("id", attrs.iid);

              break;

            case "iclass":
              newEleinput.setAttribute("class", attrs.iclass);

              break;

            case "pattern":
              if (value != "") {
                newEleinput.setAttribute(key, value);
              } else {
                break;
              }

            case "itype":
              newEleinput.setAttribute("type", value);

            default:
              break;
          }
        });

        var inputfield = $(newEleinput);
      }

      if (labelfield != undefined && inputfield != undefined) {
        $(".active-front-form").append(labelfield);

        $(".active-front-form").append(inputfield);
      }

      if (inputfield != undefined) {
        if (inputfield[0].localName == "select") {
          jQuery.ajax({
            type: "POST",

            url: gaq_public_param.ajaxurl,

            data: {
              message: "get_country_list",

              action: "trigger_country_list_public",

              _ajax_nonce: gaq_public_param.nonce,
            },

            success: function(response) {
              response = JSON.parse(response);

              jQuery.each(response, function(key, value) {
                jQuery("#fcountry").append(
                  "<option value=" + key + ">" + value + "</option>"
                );
              });
            },
          });
        }
      }
    }
  }

  /**
   * if country fiels is displaying
   */
  if ($("#fcountry").length > 0) {
    $("#fcountry").on("change", function() {
      $("#fstate").hide();

      var con = $("#fcountry")
        .find(":selected")
        .val();

      if (con != "") {
        jQuery.ajax({
          type: "POST",

          url: gaq_public_param.ajaxurl,

          data: {
            country: con,

            message: "get_state_list",

            action: "trigger_country_list_public",

            _ajax_nonce: gaq_public_param.nonce,
          },

          success: function(response) {
            if (response != "false") {
              $(
                '<select id="fstate" class="form-select mwb-form-control" name="State">'
              ).insertAfter("#fcountry");

              response = JSON.parse(response);

              jQuery.each(response, function(key, value) {
                jQuery("#fstate").append(
                  "<option value=" + key + ">" + value + "</option>"
                );
              });
            }
          },
        });
      }
    });
  }

  /**
   * Form Submission
   */
  $(document).on("submit", "form#formdata", function(e) {
    e.preventDefault();
    var redirect_value = php_vars.redirect;
    var form_data = new FormData(this);
    form_data.append("action", "trigger_form_submission");
    form_data.append("nonce", gaq_public_param.form_nonce);
    jQuery(".mwb-gaq-dialog-wrapper").show();
    $.ajax({
      url: gaq_public_param.ajaxurl,

      type: "POST",

      dataType: "json",

      data: form_data,

      contentType: false,

      processData: false,

      success: function(response) {
        jQuery(".mwb-gaq-dialog-wrapper").hide();
        if (response == "Success" || response == "updated") {
          $(".error-div").hide();

          $(".success-div").show();

          $(".success-div").html("<b>Successfully Submitted!</b>");

          $("html, body").animate({ scrollTop: 70 }, "slow");

          if (redirect_value == "Yes") {
            var red_page = php_vars.red_page;
            setTimeout(function() {
              window.location.pathname = "/" + red_page + "/";
            }, 2000);
          }
        } else if (response == "Deactivated") {
          window.location["reload"]();
        } else {
          $(".success-div").hide();

          $(".error-div").show();

          $("html, body").animate({ scrollTop: 100 }, "slow");

          $(".error-div").html("<b>*" + response + "</b>");
        }
      },
    });
  });
});
(function($) {
  "use strict";
})(jQuery);
