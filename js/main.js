$ = jQuery;
var ajaxStart = false;

$(document).ready(function() {
    // HEADER
    // add or remove class after scroll
    var header = $('header');
    var headerHeight = header.innerHeight();
    var windowStaticScroll = $(window).scrollTop();
    if (windowStaticScroll > headerHeight) {
        $('.transparent').addClass('scrolled');
    } else {
        $('.transparent').removeClass('scrolled');
    }
    $(window).scroll(function() {
        var windowDynamicScroll = $(this).scrollTop();
        if (windowDynamicScroll > headerHeight) {
            $('.transparent').addClass('scrolled');
        } else {
            $('.transparent').removeClass('scrolled');
        }
    })
    var windowStaticScroll = $(window).scrollTop();
    // search dropdown list
    // $('.search input').focus(function(){
    //$('.search').addClass('active');
    //$('.icon-loading').addClass('active');
    //  });

    $('.gallery-item a').fancybox();

    // Show the login dialog box on click
    /* $('a#show_login').on('click', function(e) {
         $('body').prepend('<div class="login_overlay"></div>');
         $('form#login').fadeIn(500);
         $('div.login_overlay, form#login a.close').on('click', function() {
             $('div.login_overlay').remove();
             $('form#login').hide();
         });
         e.preventDefault();
     }); */

    // Perform AJAX login on form submit
    $('form.custom_login').on('submit', function(e) {
        e.preventDefault();

        //console.log('aaas');
        var current_item = jQuery(this);
        var logUser = jQuery('.username_custom').val();
        var logPass = jQuery('.password_custom').val();

        if (typeof logUser === 'undefined' && typeof logPass === 'undefined') { current_item.find('p.status').html('Your Username and Password is empty!').addClass('active'); return false; }
        if (typeof logUser === 'undefined' && logPass != '') { current_item.find('p.status').html('Your Username is empty!').addClass('active'); return false; }
        if (typeof logPass === 'undefined' && logUser != '') { current_item.find('p.status').html('Your Password is empty!').addClass('active'); return false; }

        // $('form.custom_login p.status').show().text(misha_loadmore_params.loadingmessage);

        var current_link = jQuery('#current_link').val();

        current_item.find('p.status').html('').removeClass('active');
        current_item.find('.submit-form').addClass('loading');
        if (false === ajaxStart) {
            ajaxStart = $.ajax({
                type: 'POST',
                dataType: 'json',
                url: misha_loadmore_params.ajaxurl,
                data: {
                    'action': 'ajaxlogincustom', //calls wp_ajax_nopriv_ajaxlogin
                    'username': current_item.find('.username_custom').val(),
                    'password': current_item.find('.password_custom').val(),
                    'security': current_item.find('#security').val()
                },
                success: function(data) {
                    current_item.find('p.status').html(data.message).addClass('active');
                    current_item.find('.submit-form').removeClass('loading');
                    ajaxStart = false;
                    if (data.loggedin == true) {
                        current_item.find('p.status').html(data.message).addClass('green');
                        // redirect to same page 
                        document.location.href = current_link; //misha_loadmore_params.redirecturl;
                    }
                }
            });
        }
        e.preventDefault();
    });



    // reset password page 
    $('form.reset_password_form').on('submit', function(e) {
        e.preventDefault();
        var current_item = jQuery(this);
        var password1 = jQuery('.password1').val();
        var password2 = jQuery('.password2').val();
        var key = jQuery('.hidden_key').val();

        //console.log('ssa');

        //current_item.find('p.status').removeClass('active');
        current_item.find('p.status').html('').removeClass('active');
        current_item.find('.submit-form').addClass('active');

        if (typeof password1 === 'undefined' && typeof password2 === 'undefined') {
            current_item.find('p.status').html('<span class="error">Please enter the new password!</span>').addClass('active');
            current_item.find('.submit-form').removeClass('active');
            return false;
        }

        if (password1 != password2) {
            current_item.find('p.status').html('<span class="error">Passwords do not match!</span>').addClass('active');
            current_item.find('.submit-form').removeClass('active');
            return false;
        }
        if (password1.length < 9) {
            current_item.find('p.status').html('<span class="error">Choose a strong password!</span>').addClass('active');
            current_item.find('.submit-form').removeClass('active');
        } else {
            if (false === ajaxStart) {

                ajaxStart = $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: misha_loadmore_params.ajaxurl,
                    data: {
                        'action': 'vc_reset_pass', //calls wp_ajax_nopriv_ajaxlogin
                        'password1': password1,
                        'password2': password2,
                        'key': key
                    },
                    success: function(data) {
                        //console.log(data);
                        current_item.find('p.status').html(data.message).addClass('active');
                        current_item.find('.submit-form').removeClass('loading');

                        if (data.loggedin == true) {
                            current_item.find('p.status').html(data.message).addClass('green');
                            setTimeout(function() {
                                document.location.href = misha_loadmore_params.redirecturl;
                            }, 3000);
                        }

                        ajaxStart = false;
                    }
                });
            }
        }

    });

    // newsletter
    $('form.subscribe_newsletter').on('submit', function(e) {
        e.preventDefault();
        var current_item = jQuery(this);
        var emailAddress = current_item.find('input[type="email"]').val();
        current_item.find('.newsletter-message').html('').removeClass('active');

        if (emailAddress.length > 0) {
            if (false === ajaxStart) {
                current_item.find('.submit-form').addClass('loading');
                ajaxStart = $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: misha_loadmore_params.ajaxurl,
                    data: {
                        'action': 'vc_subscribe_newsletter', //calls wp_ajax_nopriv_ajaxlogin
                        'email': emailAddress,
                    },
                    success: function(data) {
                        //console.log(data);
                        current_item.find('.newsletter-message').html(data.message).addClass('active');
                        current_item.find('.submit-form').removeClass('loading');
                        ajaxStart = false;
                    }
                });
            }
        } else {
            current_item.find('.newsletter-message').html('<span class="error">Please add a valid email address.</span>').addClass('active');
        }
    });

    $(".toggle-password").click(function(e) {
        e.preventDefault();

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    //register 
    $('form.register_header').on('submit', function(e) {
        e.preventDefault();
        var current_item = jQuery(this);
        var formData = new FormData(current_item[0]);

        current_item.find('p.status').html('').removeClass('active');
        current_item.find('.submit-form').addClass('loading');

        //console.log(formData);

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
                    if (data.loggedin == true) {
                        current_item.find('p.status').html(data.message).addClass('green');
                        setTimeout(function() {
                            document.location.href = misha_loadmore_params.redirecturl;
                        }, 3000);
                    }

                    ajaxStart = false;
                }
            });
        }
    });



    // forgot 
    $(document).on('click', '.lost-password', function(e) {
        e.preventDefault();
        var href = jQuery(this).attr('href');
        $.fancybox.close();
        if (href.length) {
            $(href).fancybox({ "touch": false }).trigger('click');
        }
    });


    // submit form forgot-password-form
    $(document).on('click', 'form.forgot-password-form input[type="submit"]', function(e) {
        e.preventDefault();

        var current_item = jQuery(this).parent().parent();
        current_item.find('p.status').html('').removeClass('active');
        current_item.find('.submit-form').addClass('loading');

        var email_val = current_item.find('input[type="email"]').val();

        var formData = new FormData();
        formData.append('action', "vc_forgot_password");
        formData.append('user_login', email_val);

        //console.log('aaa');

        if (email_val.length > 0) {
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
                    // if (data.loggedin == true) {
                    //     current_item.find('p.status').html(data.message).addClass('green');
                    //     document.location.href = misha_loadmore_params.redirecturl;
                    // }
                }
            });
        }

        e.preventDefault();

    });



    //$('.search input').on('keyup', '#aDropdownID', function(ev){ //.bind("keyup change", function(e) {
    $(document).on('keyup', '.search input', function() {
        var value = jQuery(this).val();
        $('.search-results').html('');
        $('.search').removeClass('active');

        if (value.length > 3) {

            if (false === ajaxStart) {
                // ajax to create sugestion list 
                var formData = new FormData();
                formData.append('action', "vc_search_action");
                formData.append('data_value', value);

                //$('.search').addClass('active');
                $('.icon-loading').addClass('active');

                ajaxStart = jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxUrl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (!jQuery.isEmptyObject(data.message)) {

                            $('.search').addClass('active');
                            $('.icon-loading').removeClass('active');
                            $('.search-results').html(data.message);
                        }

                        ajaxStart = false;

                    },
                    error: function(data) {
                        // nothing 
                        ajaxStart = false;
                    }
                });
            }
        }
    });



    /* var to_input = $('#to').pickadate({
         showMonthsShort: true,
         format: 'yyyy-mm-dd',
         //max: new Date(), //0,
         selectYears: 20,
         selectMonths: true,
         closeOnSelect: true,
         onSet: function(context) {
             from_input.set('min', to_input.get('select'));
             ///console.log('set new date')
         }
     });

     var from_input = $('#from').pickadate({
         showMonthsShort: true,
         format: 'yyyy-mm-dd',
         // max: new Date(), //0,
         selectYears: 20,
         selectMonths: true,
         closeOnSelect: true,
         onSet: function(context) {
             console.log(this.get('select', 'yyyy-mm-dd'));
             // console.log('set new date')
         }
     });*/

    var from_$input = $('#from').pickadate({
            showMonthsShort: true,
            format: 'yyyy-mm-dd',
            selectYears: 20,
            selectMonths: true,
            closeOnSelect: true,
        }),
        from_picker = from_$input.pickadate('picker');

    var to_$input = $('#to').pickadate({
            showMonthsShort: true,
            format: 'yyyy-mm-dd',
            selectYears: 20,
            selectMonths: true,
            closeOnSelect: true,
        }),
        to_picker = to_$input.pickadate('picker');

    if ($('#from').length && $('#to').length) {

        // Check if there’s a “from” or “to” date to start with.
        if (from_picker.get('value')) {
            to_picker.set('min', from_picker.get('select'))
        }
        if (to_picker.get('value')) {
            from_picker.set('max', to_picker.get('select'))
        }

        // When something is selected, update the “from” and “to” limits.
        from_picker.on('set', function(event) {
            if (event.select) {
                to_picker.set('min', from_picker.get('select'))
            } else if ('clear' in event) {
                to_picker.set('min', false)
            }
        });

        to_picker.on('set', function(event) {
            if (event.select) {
                from_picker.set('max', to_picker.get('select'))
            } else if ('clear' in event) {
                from_picker.set('max', false)
            }
        });
    }
    // to_input.set(function(e) {
    //     console.log('set new date');
    // });

    // from_input.set(function(e) {
    //     console.log('set new date');
    // });


    //picker.set('select', date);

    // $("#datetimepicker6").on("dp.change", function (e) {
    //            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    //        });
    //        $("#datetimepicker7").on("dp.change", function (e) {
    //            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    //        });

    // for events -> no max days
    var from_$input2 = $('#from2').pickadate({
            showMonthsShort: true,
            format: 'yyyy-mm-dd',
            selectYears: 20,
            selectMonths: true,
            closeOnSelect: true,
        }),
        from_picker2 = from_$input2.pickadate('picker');

    var to_$input2 = $('#to2').pickadate({
            showMonthsShort: true,
            format: 'yyyy-mm-dd',
            selectYears: 20,
            selectMonths: true,
            closeOnSelect: true,
        }),
        to_picker2 = to_$input2.pickadate('picker');


    if ($('#from2').length && $('#to2').length) {

        // Check if there’s a “from” or “to” date to start with.
        if (from_picker2.get('value')) {
            to_picker2.set('min', from_picker2.get('select'))
        }
        if (to_picker2.get('value')) {
            from_picker2.set('max', to_picker2.get('select'))
        }

        // When something is selected, update the “from” and “to” limits.
        from_picker2.on('set', function(event) {
            if (event.select) {
                to_picker2.set('min', from_picker2.get('select'))
            } else if ('clear' in event) {
                to_picker2.set('min', false)
            }
        });

        to_picker2.on('set', function(event) {
            if (event.select) {
                from_picker2.set('max', to_picker2.get('select'))
            } else if ('clear' in event) {
                from_picker2.set('max', false)
            }
        });
    }



    $(document).on('click', function(e) {
        if ($(e.target).closest('.search').length === 0) {
            $('.search').removeClass('active');
            $('.icon-loading').removeClass('active');
        }
    });

    // navigation main links icons
    var width = $(window).width();
    if (width < 1400) {
        $('.parent-li>a').click(function(e) {
            e.preventDefault();
            $('.parent-li>a').removeClass('active');
            $('header nav ul ul').removeClass('active');
            $(this).addClass('active');
            $(this).parent().find('ul').addClass('active');
        });

        $(document).on('click', function(e) {
            if ($(e.target).closest("header nav ul ul").length === 0 && $(e.target).closest(".parent-li>a").length === 0) {
                $('.parent-li>a').removeClass('active');
                $('header nav ul ul').removeClass('active');
            }
        });
    }

    // user dropdown
    $('.user-trigger').click(function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).parent().find('.user-dropdown').toggleClass('active');
    });
    $(document).on('click', function(e) {
        if ($(e.target).closest(".user-dropdown").length === 0 && $(e.target).closest(".user-trigger").length === 0) {
            $('.user-trigger').removeClass('active');
            $('.user-dropdown').removeClass('active');
        }
    });
    // menu bar
    $('.burger').click(function(e) {
        e.preventDefault();
        $('header nav').addClass('active');
    });
    $('.close').click(function(e) {
        e.preventDefault();
        $('header nav').removeClass('active');
    });
    // search functionality
    $('header .icon-search').click(function(e) {
        e.preventDefault();
        $('.search').toggle();
        $('.search-close').toggle();
    });
    $('.search-close a').click(function(e) {
        e.preventDefault();
        $(this).parent().hide();
        $('.search').hide();
    });
    // FOOTER




    // BANNERS
    var heroSwiper = new Swiper('.hero', {
        slidesPerView: 1,
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
        },
        navigation: {
            nextEl: '.hero-button-next',
            prevEl: '.hero-button-prev',
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true,
        },
        autoplay: {
            delay: 5000,
        },
    });
    var bannerSwiper = new Swiper('.banner', {
        slidesPerView: 1,
        navigation: {
            nextEl: '.banner-button-next',
            prevEl: '.banner-button-prev',
        },
    });
    // MASONRY
    $('.mason').masonry({
        // options
        columnWidth: '.grid-sizer',
        itemSelector: '.grid-item',
        percentPosition: true,
    });

    // load more projects 
    $('.hide_me_click').click(function(e) {
        e.preventDefault();

        // console.log('start');
        // console.log(ajaxStart);

        if (false == ajaxStart) {
            var data_type = jQuery(this).attr('data-type');
            var current = jQuery(this);
            var parrent = jQuery(this).parent();
            var data_total_show = jQuery('.results .single_article').size();
            var data_total_full = jQuery('.loading-info').attr('data-total');

            if (parseInt(data_total_show) < parseInt(data_total_full)) {
                jQuery('.loading-info').addClass('active');

                var type_event = '';
                if (jQuery('#type_event').length) {
                    type_event = jQuery('#type_event').val();
                }

                var button = $(this),
                    data = {
                        'action': 'loadmore',
                        'query': misha_loadmore_params.posts, // that's how we get params from wp_localize_script() function
                        'page': misha_loadmore_params.current_page,
                        'tags': jQuery('#tag').val(),
                        'a': jQuery('#author').val(),
                        'from': jQuery('.col-from input').val(),
                        'to': jQuery('.col-to input').val(),
                        'template': jQuery('#template').val(), // full or sidebar
                        'type_event': type_event
                    };


                ajaxStart = jQuery.ajax({
                    url: misha_loadmore_params.ajaxurl,
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        canBeLoaded = false;
                        ajaxStart = false;
                    },
                    success: function(data) {
                        if (!jQuery.isEmptyObject(data.message)) {
                            jQuery('.results').append(data.message);
                            canBeLoaded = true; // the ajax is completed, now we can run it again
                            ajaxStart = true;
                            misha_loadmore_params.current_page++;
                            jQuery('.loading-info').removeClass('active');
                            var $container = $('.mason');
                            $container.masonry({
                                columnWidth: '.grid-sizer',
                                itemSelector: '.grid-item',
                                percentPosition: true,
                            });
                            $container.masonry('reloadItems');
                            $container.masonry('layout');
                        }
                        ajaxStart = false;

                    },
                    error: function(data) {
                        jQuery('.loading-info').removeClass('active');
                    }
                });

            }
        }
        jQuery('.loading-info').removeClass('active');
    });

});


// fake infinite loop .. hide_me_click
jQuery(window).scroll(function() {
    var windowWidth = $(window).width();

    // if (windowWidth > 768) {
    if (jQuery('.hide_me_click').length) {
        var total = jQuery('.hide_me_click').parent().attr('data-total');
        var total_visible = jQuery('.results .single_article').size();

        if (total > total_visible) {
            jQuery('.hide_me_click').parent().find('i').addClass('active');
        }
    }


    clearTimeout(jQuery.data(this, 'scrollTimer'));
    jQuery.data(this, 'scrollTimer', setTimeout(function() {
        // do something
        var height_max = 0;
        height_max = 700;
        if (windowWidth > 768) {
            bottomOffset = 2000; //2000;
        } else {
            bottomOffset = 5000;
        }

        jQuery('.loading-info').addClass('active');
        // console.log("bbb");
        // console.log($(document).scrollTop());
        // console.log($(document).height());

        if ($(document).scrollTop() > ($(document).height() - bottomOffset)) {
            //console.log("aaa");

            if (jQuery('.hide_me_click').length) {
                var total = jQuery('.loading-info').attr('data-total');
                var total_visible = jQuery('.results .single_article').size();

                // console.log(total);
                // console.log(total_visible);


                if (total > total_visible) {
                    jQuery('.hide_me_click').trigger('click');

                } else {
                    jQuery('.loading-info').removeClass('active');

                }
            } else {
                jQuery('.loading-info').removeClass('active');
            }
        }
    }, 200));
    //}

});

/*
jQuery(function($){
    var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
        bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts
 
    $(window).scroll(function(){
        var data = {
            'action': 'loadmore',
            'query': misha_loadmore_params.posts,
            'page' : misha_loadmore_params.current_page
        };
        if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) &amp;&amp; canBeLoaded == true ){
            $.ajax({
                url : misha_loadmore_params.ajaxurl,
                data:data,
                type:'POST',
                beforeSend: function( xhr ){
                    // you can also add your own preloader here
                    // you see, the AJAX call is in process, we shouldn't run it again until complete
                    canBeLoaded = false; 
                },
                success:function(data){
                    if( data ) {
                        $('#main').find('article:last-of-type').after( data ); // where to insert posts
                        canBeLoaded = true; // the ajax is completed, now we can run it again
                        misha_loadmore_params.current_page++;
                    }
                }
            });
        }
    });
});*/


function getDocHeight() {
    var D = document;
    return Math.max(
        D.body.scrollHeight, D.documentElement.scrollHeight,
        D.body.offsetHeight, D.documentElement.offsetHeight,
        D.body.clientHeight, D.documentElement.clientHeight
    );

}