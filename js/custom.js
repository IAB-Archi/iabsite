jQuery(document).ready(function($) {

    // tabs
    $(document).on('click', '.user-account a', function(e) {
        e.preventDefault();
        var type = jQuery(this).attr('data-type');
        var current = jQuery(this);

        jQuery('.user-account a').removeClass('active');
        current.addClass('active');

        jQuery('.group_tabs_right .wrapp_edit_profile').removeClass('active');
        jQuery('.group_tabs_right .tab-' + type).addClass('active');

        jQuery('p.status').html('');
    });

    $(document).on('click', '.box_tabs .item_tab', function(e) {
        e.preventDefault();
        jQuery('.item_tab').removeClass('active');
        jQuery('.section-tab').removeClass('active');

        var href = jQuery(this).attr('href');
        jQuery(this).addClass('active');
        jQuery(href).addClass('active');
    });

    //dashboard edit account -> social
    $('form.social_profile').on('submit', function(e) {
        e.preventDefault();
        var current_item = jQuery(this);
        var formData = new FormData(current_item[0]);

        current_item.find('p.status').html('').removeClass('active');
        current_item.find('.submit-form').addClass('loading');

        if (false === ajaxStart) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: misha_loadmore_params.ajaxurl,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    //console.log(data);
                    current_item.find('p.status').html(data.message).addClass('active');
                    current_item.find('.submit-form').removeClass('loading');
                    ajaxStart = false;
                },
                error: function() {
                    ajaxStart = false;
                }
            });
        }
    });

    // dashboard edit account -> general
    $('form.edit_profile').on('submit', function(e) {
        e.preventDefault();
        var current_item = jQuery(this);
        var formData = new FormData(current_item[0]);

        current_item.find('p.status').html('').removeClass('active');
        current_item.find('.submit-form').addClass('loading');

        if (false === ajaxStart) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: misha_loadmore_params.ajaxurl,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    //console.log(data);
                    current_item.find('p.status').html(data.message).addClass('active');
                    current_item.find('.submit-form').removeClass('loading');
                    ajaxStart = false;
                },
                error: function() {
                    ajaxStart = false;
                }
            });
        }

    });

    // dashboard edit account -> password 
    $('form.change_password').on('submit', function(e) {
        e.preventDefault();
        var current_item = jQuery(this);
        var formData = new FormData(current_item[0]);

        current_item.find('p.status').html('').removeClass('active');
        current_item.find('.submit-form').addClass('loading');

        if (false === ajaxStart) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: misha_loadmore_params.ajaxurl,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    //console.log(data);
                    current_item.find('p.status').html(data.message).addClass('active');
                    current_item.find('.submit-form').removeClass('loading');
                    ajaxStart = false;
                },
                error: function() {
                    ajaxStart = false;
                }
            });
        }
    });

    // register member to mautic
    $('#reg_members').validate({
        rules: {
            firstname: {
                required: true,
                // minlength: 4
            },
            surname: {
                required: true,
                //  minlength: 4
            },
            emailaddress: {
                required: true,
                email: true
            },
            // userprofilemobile: {
            //     phoneUS: true
            // },
            // userprofilephone: {
            //     phoneUS: true
            // },
            userprofileposition: {
                required: true
            }
        },
        showErrors: function(errorMap, errorList) {

            if (errorList.length > 0) {
                output = "<span class='error'>One or more fields have errors. Please check and try again.</span>";
                this.defaultShowErrors();
                jQuery('.output').html(output);
            }
        },
        invalidHandler: function(form, validator) {
            submitted = true;
        }

    });

    $('form#reg_members').on('submit', function(e) {
        e.preventDefault();
        var current_item = jQuery(this);
        var formData = new FormData(current_item[0]);

        current_item.find('p.status').html('').removeClass('active');
        current_item.find('.submit-form').addClass('loading');

        if (false === ajaxStart) {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: misha_loadmore_params.ajaxurl,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    //console.log(data);
                    current_item.find('p.status').html(data.message).addClass('active');
                    current_item.find('.submit-form').removeClass('loading');
                    // current_item[0].reset();
                    //current_item.trigger("reset");
                    current_item.find('input[type="text"]').val('');
                    current_item.find('input[type="email"]').val('');
                    current_item.find('input[type="tel"]').val('');
                    current_item.find('input[type="checkbox"]').removeAttr('checked');

                    ajaxStart = false;
                },
                error: function() {
                    ajaxStart = false;
                }
            });
        }

    });

});