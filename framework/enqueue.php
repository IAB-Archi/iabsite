<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

/**
 * Enqueue scripts and styles for front-end.
 */
function theme_styles() {
	# jQuery
	wp_enqueue_script( 'jquery' );

	# Fonts
	wp_enqueue_style('fontawesome_style', get_template_directory_uri().'/css/fontawesome-all.min.css');
	wp_enqueue_style('font-google', '//fonts.googleapis.com/css2?family=Muli:wght@400;700;800;900&display=swap');
	wp_enqueue_style('iealert_style', get_template_directory_uri().'/css/iealert/style.css');
	wp_enqueue_style('swiper_style', get_template_directory_uri().'/css/swiper.min.css');
	wp_enqueue_style('classic_style', '//cdn.jsdelivr.net/npm/pickadate@3.6.2/lib/themes/classic.css');
	wp_enqueue_style('classicdate_style', '//cdn.jsdelivr.net/npm/pickadate@3.6.2/lib/themes/classic.date.css');
	wp_enqueue_style('fancybox_style', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css');

	if(is_page_template( 'templates/page-dashboard.php' )) {
		wp_enqueue_style('geodatasource_style', get_template_directory_uri().'/css/geodatasource-countryflag.css'); 
	}
	
 

	# Other(s)
	wp_register_script('modernizer_script', get_template_directory_uri().'/js/modernizr.js', '', '', false );
	wp_enqueue_script('modernizer_script', array('jquery'));

	wp_register_script('iealert_script', get_template_directory_uri().'/js/iealert.min.js', '', '', true );
	wp_enqueue_script('iealert_script', array('jquery')); 

	wp_register_script('swiper_script', get_template_directory_uri().'/js/swiper.min.js', '', '', true );
	wp_enqueue_script('swiper_script', array('jquery'));

	wp_register_script('masonry_script', get_template_directory_uri().'/js/masonry.min.js', '', '', true );
	wp_enqueue_script('masonry_script', array('jquery'));

	wp_register_script('fancybox_script', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', '', '', true );
	wp_enqueue_script('fancybox_script', array('jquery'));
	

	wp_register_script('jsdelivrpickadate_script', '//cdn.jsdelivr.net/npm/pickadate@3.6.2/lib/picker.js', '', '', true );
	wp_enqueue_script('jsdelivrpickadate_script', array('jquery')); 

	wp_register_script('pickadate_script', '//cdn.jsdelivr.net/npm/pickadate@3.6.2/lib/picker.date.js', '', '', true );
	wp_enqueue_script('pickadate_script', array('jquery')); 


	
	wp_register_script('validate_script', '//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', '', '', true );
	wp_enqueue_script('validate_script', array('jquery')); 

	if(is_page_template( 'templates/page-dashboard.php' )) {
		wp_register_script('geodatasourcecrc_script', get_template_directory_uri().'/js/geodatasource-cr.min.js', '', '', true );
		wp_enqueue_script('geodatasourcecrc_script', array('jquery'));	

		wp_register_script('geodatasource_script', get_template_directory_uri().'/js/geodatasource-cr.min.js', '', '', true );
		wp_enqueue_script('geodatasource_script', array('jquery'));	
	}

	wp_register_script('gettext_script', get_template_directory_uri().'/js/Gettext.js', '', '', true );
	wp_enqueue_script('gettext_script', array('jquery'));

 


	// wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
 //        'ajaxurl' => admin_url( 'admin-ajax.php' ),
 //        'redirecturl' => home_url(),
 //        'loadingmessage' => __('Sending user info, please wait...')
 //    ));
 //    wp_enqueue_script( 'ajax-login-script' );

	global $wp_query; 
	wp_register_script('my_loadmore', get_template_directory_uri().'/js/main.js', '', '', true );
	
	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages,

		'redirecturl' => get_field('dashboard_page', 'options'),
        'loadingmessage' => __('Sending user info, please wait...')
	) );

 	wp_enqueue_script( 'my_loadmore' );

 	wp_register_script('custom_script', get_template_directory_uri().'/js/custom.js', '', '', true );
	wp_enqueue_script('custom_script', array('jquery'));



	//wp_enqueue_script('main_script', array('jquery'));

	# Loads our main stylesheet.
	wp_enqueue_style('site-style', get_stylesheet_uri(), false, '');
	wp_enqueue_style('custom_style', get_template_directory_uri().'/css/custom.css', false, date('YmdHis'));

	

}
add_action( 'wp_enqueue_scripts', 'theme_styles' );





// add_filter('style_loader_tag', 'theme_styles_remove_type_attr', 10, 2);
// add_filter('script_loader_tag', 'theme_styles_remove_type_attr', 10, 2);
// function theme_styles_remove_type_attr($tag, $handle) {
//     return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
// }