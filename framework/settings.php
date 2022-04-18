<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

add_image_size('homepage-slide', 1920, 780, true);
add_image_size('homepage-featured-post', 688, 414, true);
add_image_size('hero', 1920, 1080, true);
add_image_size('banner', 1200, 200, true);
add_image_size('big-post', 480, 282, true);
add_image_size('small-post', 150, 88, true);
add_image_size('medium', 360, 212, true);
add_image_size('team', 200, 200, true);

# Register option pages
if( function_exists('acf_add_options_sub_page') ){
	acf_add_options_page(array(
		'page_title' => 'Theme Options',
		'menu_title' => 'Theme Options',
		'menu_slug'  => 'theme-options',
		'capability' => 'manage_options',
		//'icon_url'   => get_template_directory_uri() . '/images/icons/favicon.png'
	));
	acf_add_options_sub_page(array(
		'parent'     => 'theme-options',
		'title'      => 'General',
		'slug'       => 'theme-general',
		'capability' => 'manage_options'
	));
	acf_add_options_sub_page(array(
		'parent'     => 'theme-options',
		'title'      => 'Mautic Data',
		'slug'       => 'theme-api',
		'capability' => 'manage_options'
	));
	acf_add_options_sub_page(array(
		'parent'     => 'theme-options',
		'title'      => 'Emails',
		'slug'       => 'theme-email',
		'capability' => 'manage_options'
	));
}

/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'disable_emojis' );

function vc_show_post_type($post_type, $no) {
   ob_start();
   $args =  array(
            'ignore_sticky_posts' 	=> true,
            'post_type'           	=> $post_type,
            'order'              	=> 'DESC',
             'posts_per_page'		=> $no,
            'posts_per_page' 		=> 5,

	);

   	if($post_type == "event") {
   		$args['meta_key'] = 'event_date';
    	$args['orderby']  = 'meta_value_num';
    	$args['order'] 	  = 'ASC';
    	// latest events
    	$args['tax_query'] 	= array(
									array(
										'taxonomy' 	=> 'events-and-training',
										'field'    	=> 'term_id', // slug
										'terms'   	=> 18,
									),
								) ;
   	}

   	//var_dump($args);

    $count = 0;
	$loop = new WP_Query( $args );
	if ($loop->have_posts()) {?>

     <?php
		//IF Event
		if($post_type == "event") {
	 ?>
		<div class="flex flex-with-article-big"><?php
    	    while ($loop->have_posts())	{  $loop->the_post();
    	        $count++;
    	        $post_id = get_the_ID();
    	        if($count == 1) {	
    	        		echo show_post_big_event($post_id);
    	        } else  {
    	            if($count == 2) { echo '<ul>'; }  ?>
    	            <li>
                        <?php echo show_post_small_col_event($post_id); ?>
                    </li>

    	 		<?php  } ?>
    		<?php  }  ?>
		
     <?php if($count > 1) { echo '</ul>'; } ?>
    </div>
	<?php  } else {  ?>
	<?php
		//IF Resources
     ?>
	<?php
    	    while ($loop->have_posts())	{  $loop->the_post();
    	        $count++;
    	        $post_id = get_the_ID();
    	        if($count == 1) {
    	        	echo show_post_big_xxl($post_id);
    	        } else  {
    	            if($count == 2) { echo '<ul class="flex flex-three">'; }  ?>
    	            <li>
                        <?php  echo show_post_small($post_id);  ?>	
                    </li>

    	 <?php  } ?>
    <?php  }  ?>
     <?php if($count > 1) { echo '</ul>'; } ?>
	<?php } ?>
<?php  	}
	wp_reset_query();
    $content = ob_get_clean();
	return $content;
}


function vc_show_post_type_black($post_type, $no) {
   ob_start();
   $args =  array(
            'ignore_sticky_posts' 	=> true,
            'post_type'           	=> $post_type,
            'order'              	=> 'DESC',
            'posts_per_page'		=> $no,
            'posts_per_page' 		=> 5,

	);
    $count = 0;
	$loop = new WP_Query( $args );
	if ($loop->have_posts()) {?>
	 <?php
    	    while ($loop->have_posts())	{  $loop->the_post();
    	        $count++;
    	        $post_id = get_the_ID();
    	        if($count == 1) {
    	            echo show_post_big_xxl($post_id);
    	        } else  {
    	            if($count == 2) { echo '<ul class="flex flex-three">'; }  ?>
    	            <li>
                        <?php  echo show_post_small($post_id);  ?>
                    </li>

    	 <?php  } ?>

    <?php  }  ?>
     <?php if($count > 1) { echo '</ul>'; } ?>

<?php  	}
	wp_reset_query();
    $content = ob_get_clean();
	return $content;
}

function vc_show_post_type_black_col($post_type, $no) {
   ob_start();
   $args =  array(
            'ignore_sticky_posts' 	=> true,
            'post_type'           	=> $post_type,
            'order'              	=> 'DESC',
            'posts_per_page'		=> 4,

	);
    $count = 0;
	$loop = new WP_Query( $args );
	if ($loop->have_posts()) {?>
	 <?php
		echo '<ul class="flex flex-three">';
    	    while ($loop->have_posts())	{  $loop->the_post();
    	        $count++;
    	        $post_id = get_the_ID();
				?>
    	            <li>
                        <?php  echo show_post_small($post_id);  ?>
                    </li>

    	

    		<?php  }  ?>
     <?php echo '</ul>';  ?>

<?php  	}
	wp_reset_query();
    $content = ob_get_clean();
	return $content;
}




function vc_show_videos($no) {
   ob_start();
   $args =  array(
            'ignore_sticky_posts' 	=> true,
            'post_type'           	=> 'post',
            'order'              	=> 'DESC',
            'posts_per_page'		=> $no,
            'tax_query'             => array(
                                            array(
                                                'taxonomy' => 'category',
                                                'field' => 'term_id',
                                                'terms' => 27
                                             )
              )
	);
    $count = 0;
	$loop = new WP_Query( $args );
	$total = $loop->found_posts;
	if ($loop->have_posts()) { ?>
	 <ul class="video_articles">
	 <?php
    	    while ($loop->have_posts())	{  $loop->the_post();
    	        $count++;
    	        $post_id = get_the_ID();
    	        if($count == 1) { ?>
    	            <li class="bigger">
                        <?php  echo show_post_big_video($post_id); ?>
                    </li><?php
    	        } else  {   ?>
    	            <li>
    	                <?php  if($count == 2) { echo '<ul>'; } ?>
                        <?php  echo show_post_big_video($post_id);  ?>
                        <?php  if($count == $total){ echo '</ul>'; } ?>
                    </li>

    	 <?php  } ?>

    <?php  }  ?>
      </ul>

<?php  	}
	wp_reset_query();
    $content = ob_get_clean();
	return $content;
}

add_action( 'widgets_init', 'my_register_sidebars' );
function my_register_sidebars() {
    /* Register the 'primary' sidebar. */
    register_sidebar(
        array(
            'id'            => 'primary',
            'name'          => __( 'Primary Sidebar' ),
            'description'   => __( 'A short description of the sidebar.' ),
            'before_widget' => '<div id="%1$s" class="widget box box-gray  %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */
}

function get_excerpt_trim($num_words='20', $more='...'){
    $excerpt = get_the_content();
    $excerpt = wp_trim_words( $excerpt, $num_words , $more );
    return $excerpt;
}

function vc_show_social() {
	ob_start();
	$social_list = get_field('social_list', 'options');

	if(!empty($social_list)) { ?>
		<ul class="social-icons"><?php
		foreach ($social_list as $social) {
			$icon = $social['icon'];
			$link = $social['link']; ?>

			<li><a href="<?php echo $link; ?>" title="" target="_blank" rel="nofollow"><?php echo $icon; ?></a></li>
			<?php
		} ?>
		</ul><?php
	}

	$content = ob_get_clean();
	return $content;
}

function vc_show_banner() {
	ob_start();

	$banner_image 	= get_field('banner_image', 'options');
	$text_banner 	= get_field('text_banner', 'options');
	$button_label_banner = get_field('button_label_banner', 'options');
	$button_link_banner = get_field('button_link_banner', 'options'); ?>

	<div class="promotion" style="background-image: url('<?php if(!empty($banner_image)) { echo $banner_image['url']; } ?>');">
	    <div class="container">
	        <h2 class="h1"><?php echo $text_banner; ?></h2>
	        <?php  	if(!empty($button_label_banner) && !empty($button_link_banner)) {	?>
	        			<a href="<?php echo $button_link_banner; ?>" class="btn btn-white"><?php echo $button_label_banner; ?></a>
	    	<?php 	} ?>
	    </div>
	</div><?php

	$content = ob_get_clean();
	return $content;
}

function vc_show_small_compact($id) {
	ob_start();

	$terms = get_the_terms( $id, 'category' );
	if ( $terms && ! is_wp_error( $terms ) ) :
		$draught_links = array();
		foreach ( $terms as $term ) {
			$draught_links[] = '<a href="'. get_term_link($term) .'" class="tag">'.$term->name.'</a>';
		}
		$on_draught = join( ", ", $draught_links );
	endif;  ?>

	<div class="article-preview article-preview-small">
	    <a href="<?php echo get_permalink($id); ?>" class="article-preview-img"><img src="img/jpg/article.jpg" alt="img"></a>
	    <?php  echo $on_draught; ?>
	    <h3>
	        <a href="<?php echo get_permalink($id); ?>"><?php echo get_the_title($id); ?></a>
	    </h3>
	</div><?php

	$content = ob_get_clean();
	return $content;
}


function vc_show_top_slider() {
	ob_start();

	$slider_top = get_field('slider_top', 'options');
	if(!empty($slider_top)) { ?>
		<div class="banner swiper-container">
		    <div class="swiper-wrapper">
		        <?php 	foreach ($slider_top as $slide):
		        			$image 	= $slide['image'];
		        			$link 	= $slide['link']; ?>
		            <div class="swiper-slide">
		                <a href="<?php echo $link; ?>">
		                    <img src="<?php echo $image['sizes']['banner']; ?>" alt="<?php echo $image['alt']; ?>">
		                </a>
		            </div>
		        <?php 	endforeach; ?>
		    </div>
		    <div class="banner-button-prev"></div>
		    <div class="banner-button-next"></div>
		</div><?php
	}

	$content = ob_get_clean();
	return $content;
}

function vc_show_post_content($post_id){
	ob_start();

	$access_level = get_field('access_level', $post_id);
	if($access_level  != 'casual' && !empty($access_level)) {
		$restrictive_content = get_field('content_preview', $post_id);

		if(!is_user_logged_in()) {
			echo '<div class="short">';
				echo $restrictive_content;
			echo '</div>';

			if($access_level  == 'registered') {
				echo '<div class="note-info-content">This article is only accessible to registered users. Please <a data-fancybox="" data-src="#login" data-options=\'{"touch" : false}\' href="javascript:;" >log in</a> or <a data-fancybox="" data-src="#register" href="javascript:;" data-options=\'{"touch" : false}\'>click here to register for free</a>.</div>';
			} else if($access_level == 'member') {

				$member_form = get_field('member_form', 'options');
				echo '<div class="note-info-content">This article is only accessible to members. Please <a data-fancybox="" data-src="#login" data-options=\'{"touch" : false}\' href="javascript:;">log in</a> if you belong to a member organisation, if you do not have a member login it can be <a href="' . $member_form . '">set up here</a>.</div>';
			}

		} else {
			$current_user 		= wp_get_current_user();
			$user_id 			= $current_user->ID;
			$member_account 	= get_field('member_account', 'user_' . $user_id);

			if($member_account == false && $access_level  == 'member') {

				echo '<div class="short">';
					echo $restrictive_content;
				echo '</div>';

				$member_form = get_field('member_form', 'options');

				// "Please log in <current lightbox link> if you belong to a member organisation, if you do not have a member login it can be set up here <link to page to be created under item 32>

				echo '<div class="note-info-content">This article is only accessible to members. Please log in if you belong to a member organisation, if you do not have a member login it can be <a href="' . $member_form . '">set up  here</a>.</div>';
			}
		}
	}

	/*$restrictive_content = get_field('restrictive_content', $post_id);
	$membership_restriction = get_field('membership_restriction', $post_id);

	if( !empty($restrictive_content) && !is_user_logged_in() ) {  // user not-logged with membership restriction

		echo '<div class="short">';
			echo $restrictive_content;
		echo '</div>';

		echo '<div class="login login-post">';
			echo vc_show_login_form();
		echo '</div>';

	} else if(is_user_logged_in() && !empty($membership_restriction)) { // user logged with membership restriction
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		if(!empty($membership_restriction) && ( !current_user_can('administrator') && !current_user_can('editor')) ) {
			$member_account = get_field('member_account', 'user_' . $user_id);

			if(empty($member_account)) {
				echo '<div class="short">';
					echo $restrictive_content;
				echo '</div>';

				$join_us  = get_field('join_us', 'options');
				echo '<div class="yellow-note">Please <a data-fancybox="" data-src="#login" href="javascript:;">login</a> if you belong to a member organisation, if you do not have a login it can be <a data-fancybox="" data-src="#register" href="javascript:;">set up here</a>.</div>';
			}
		}
	}*/

	$content = ob_get_clean();
	return $content;
}

add_filter('acf/validate_value/name=content_preview', 'my_acf_validate_value', 10, 4);
function my_acf_validate_value( $valid, $value, $field, $input ){
    // bail early if value is already invalid
    if( !$valid ) {
        return $valid;
    }
    if( strlen($value) < 400 ) {
        $valid = 'You can\'t enter less that 400 characters';
    }
    // return
    return $valid;


}

function vc_show_post_meta_documents($post_id){
	ob_start();

	//$old_fields    = get_field('old_fields');
	// $documents 	   					= get_field('documents');
	// $documents_restrictive 			= get_field('documents_restrictive');
	// $documents_mautic  				= get_field('documents_mautic');
	// $documents_restrictice_mautic 	= get_field('documents_restrictice_mautic');
	//echo vc_show_documents( $documents, $documents_restrictive, $documents_mautic, $documents_restrictice_mautic );

	echo vc_show_documents($post_id);

	//echo vc_show_documents_restrictive($documents_restrictive);

	//$externals_links = get_field('externals_links');
	$externals_links = get_field('links_new_structure', $post_id);
	echo vc_show_links($externals_links);

	if ( !is_singular( 'event' ) ) {
		echo vc_show_author_box($main_id);
	}

	$content = ob_get_clean();
	return $content;
}


function vc_show_title_info($id,  $tax_links) {
	ob_start();
	$author_id = get_post_field ('post_author', $id); ?>

	<div class="title">
	    <h1><?php echo get_the_title(); ?></h1>

	    <?php if ( !is_singular( 'event' ) ) { ?>
			    <span class="title-details"><?php  echo vc_show_fake_author($id); /*?>Posted by <a href="<?php echo get_author_posts_url($author_id); ?>"><?php

				$display_name = get_the_author_meta( 'display_name' , $author_id );
				echo $display_name;

			    ?></a>*/?> On <span><?php echo get_the_date( 'F d, Y', $id ); ?></span>
		<?php  } ?>
	    <?php echo $tax_links; ?>
		</span>
	</div>

	<?php
	$content = ob_get_clean();
	return $content;
}

function vc_show_title_info_page($id) {
	ob_start();
	$author_id = get_post_field ('post_author', $id); ?>

	<div class="title">
	    <h1><?php echo get_the_title(); ?></h1>
	</div>

	<?php
	$content = ob_get_clean();
	return $content;
}


function vc_show_breadcrumb() {
	ob_start();

	if (  function_exists('yoast_breadcrumb') ) { ?>
    	<div class="breadcrumbs">
	        <?php yoast_breadcrumb('<p id="breadcrumbs">','</p>'); ?>
	    </div>
 <?php	}

	$content = ob_get_clean();
	return $content;
}

//
function vc_show_related_posts($post_id, $post_type, $tax_name, $tax_ids) {
	ob_start();

	$args =  array(
		'ignore_sticky_posts'   => true,
		'post_type'             => $post_type,
		'order'                 => 'DESC',
		//'orderby'				=> 'rand',
		//'category__in' 			=> wp_get_post_categories($post_id),
		'posts_per_page' 		=> 4,
		'post__not_in' 			=> array($post_id),
	);

	if(!empty($tax_name) && !empty($tax_ids)) {
		$args['tax_query'] =  array(
								array(
									'taxonomy' 	=> $tax_name,
									'field'    	=> 'term_id',
									'terms'   	=> $tax_ids,
								)
							);
	}

	$related = new WP_Query( $args );
	if( $related->have_posts() ) { ?>
		<h2><?php _e('Recommended', THEME_TEXT_DOMAIN); ?></h2>
		<div class="flex flex-four flex-content-mobile">
		<?php  	while( $related->have_posts() ) { $related->the_post();
					$post_id_inner = get_the_ID(); ?>

					<div class="article-preview article-preview-small">
					    <a href="<?php echo get_permalink($post_id_inner); ?>" class="article-preview-img recomanded_img" style="background-image: url(<?php
							$img = wp_get_attachment_image_src(get_post_thumbnail_id($post_id_inner), 'full');
							 if($img[0]){
							 	echo $img[0];
							 } else {
							 	echo get_template_directory_uri().'/img/jpg/n-medium.jpg';
							 } ?>);"></a>

						<?php 	$terms = get_the_terms( $post_id_inner, $tax_name );
								if ( $terms && ! is_wp_error( $terms ) ) : ?>
									<div class="tax-list"><?php
										$draught_links = array();
										foreach ( $terms as $term ) {
											$term_link = get_term_link($term);
											$draught_links[] = '<a href="'. $term_link .'" class="tag">'. $term->name .'</a>';
										}
										$on_draught = join( ", ", $draught_links );
									 	echo $on_draught; ?>
								 	</div><?php
								endif; ?>
					    <h3>
					        <a href="<?php echo get_permalink($post_id_inner); ?>"><?php echo get_the_title($post_id_inner); ?></a>
					    </h3>

					    <?php /*
					    <p><?php echo get_the_excerpt($post_id_inner); ?></p>

					    <a href="<?php echo get_permalink($post_id_inner); ?>" class="link"><?php _e('Read more', THEME_TEXT_DOMAIN); ?></a> */?>
					</div>

			  <?php   	} ?>
			</div>
	  </div><?php
	}
	wp_reset_postdata();

	$content = ob_get_clean();
	return $content;
}


function show_post_big($post_id) {
	ob_start();  ?>
	<div class="article-preview">
	    <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-img">
	    	<?php echo get_featured_img($post_id, "full", "img", "", get_template_directory_uri().'/img/jpg/n-big.jpg'); ?>
	    </a>
	    <?php
		$terms = get_the_terms( $post_id, 'category' );
		if ( $terms && ! is_wp_error( $terms ) ) :
			$draught_links = array();
			foreach ( $terms as $term ) {
				$term_link = get_term_link($term);
				$draught_links[] = '<a href="' . $term_link . '" class="tag">' . $term->name . '</a>';
			}
			$on_draught = join( ", ", $draught_links );
		 	echo $on_draught;
		endif; ?>

	    <h2 class="h3">
	        <a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
	    </h2>
	    <?php

	     $author_id = get_post_field ('post_author', $post_id); ?>
	    <span class="title-details"><?php vc_show_fake_author($post_id); /*_e('By', THEME_TEXT_DOMAIN); ?> <a href="<?php echo  get_author_posts_url( $author_id ); ?>"><?php
				$display_name = get_the_author_meta( 'display_name' , $author_id );
				echo $display_name;*/
			?></span> <?php _e('On', THEME_TEXT_DOMAIN); ?> <span><?php echo get_the_date('F d, Y'); ?></span>

			<?php
				$terms = get_the_terms( $post_id, 'category' );
				if ( $terms && ! is_wp_error( $terms ) ) :
					$draught_links = array();
					foreach ( $terms as $term ) {
						$term_link = get_term_link($term);
						$draught_links[] = '<a href="' . $term_link . '" title="">' . $term->name . '</a>';
					}
					$on_draught = join( ", ", $draught_links );
				 	echo $on_draught;
				endif; ?>
		</span>
	    <p><?php echo custom_excerpt($post_id); //get_the_excerpt($post_id); // get_excerpt($post_id); //get_the_excerpt($post_id); ?></p>
	    <a href="<?php echo get_permalink($post_id); ?>" class="link"><?php _e('Read more', THEME_TEXT_DOMAIN); ?></a>
	</div>
	<?php
	$content = ob_get_clean();
	return $content;
}

function show_post_big_event($post_id) {
	ob_start();  ?>
	<div class="article-preview">
	    <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-img">
	    	<?php echo get_featured_img($post_id, "full", "img", "", get_template_directory_uri().'/img/jpg/n-big.jpg'); ?>
	    </a>
	    <?php
		$terms = get_the_terms( $post_id, 'category' );
		if ( $terms && ! is_wp_error( $terms ) ) :
			$draught_links = array();
			foreach ( $terms as $term ) {
				$term_link = get_term_link($term);
				$draught_links[] = '<a href="' . $term_link . '" class="tag">' . $term->name . '</a>';
			}
			$on_draught = join( ", ", $draught_links );
		 	echo $on_draught;
		endif; ?>

	    <h2 class="h3">
	        <a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
	    </h2>
	    <?php
	    /*
	     $author_id = get_post_field ('post_author', $post_id); ?>
	    <span class="title-details"><?php //vc_show_fake_author($post_id); ?></span> <?php *///_e('On', THEME_TEXT_DOMAIN); ?>
	    <span><?php //echo get_the_date('F d, Y');

	        	$event_date = get_field('event_date', $post_id);
            		if(!empty($event_date)) { ?>
            			<span class="title-details">
            				<span class="info">
	            				<i class="far fa-calendar-alt"></i> <?php
	            				$date = DateTime::createFromFormat('Ymd', $event_date);
	            				echo $date->format('l, j M Y'); ?>
	            			</span><?php
            				$time = get_field('time', $post_id);
							if(!empty($time)) { ?>
								<span class="info info-time"><i class="far fa-clock"></i> <?php echo $time; ?></span>
					<?php 	} ?>
            			</span>
            <?php 	}
	    ?></span>

			<?php
				$terms = get_the_terms( $post_id, 'category' );
				if ( $terms && ! is_wp_error( $terms ) ) :
					$draught_links = array();
					foreach ( $terms as $term ) {
						$term_link = get_term_link($term);
						$draught_links[] = '<a href="' . $term_link . '" title="">' . $term->name . '</a>';
					}
					$on_draught = join( ", ", $draught_links );
				 	echo $on_draught;
				endif; ?>
		</span>
	    <p><?php echo custom_excerpt($post_id); //get_the_excerpt($post_id); // get_excerpt($post_id); //get_the_excerpt($post_id); ?></p>
	    <a href="<?php echo get_permalink($post_id); ?>" class="link"><?php _e('Read more', THEME_TEXT_DOMAIN); ?></a>
	</div>
	<?php
	$content = ob_get_clean();
	return $content;
}

function custom_excerpt($post_id) {
	$post = get_page($post_id);
	$content = $post->post_content;
	$excerpt = $post->post_excerpt;
	if (!$excerpt)	{
		return wp_trim_words($content, 19, '...');
	} else {
		return wp_trim_words($excerpt, 19, '...');
	}
}

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// function get_excerpt($post_id){
// 	$excerpt = get_the_content($post_id);
// 	$excerpt = preg_replace(" ([.*?])",'',$excerpt);
// 	$excerpt = strip_shortcodes($excerpt);
// 	$excerpt = strip_tags($excerpt);
// 	$excerpt = substr($excerpt, 0, 50);
// 	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
// 	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
// 	return $excerpt;
// }

function show_post_big_video($post_id) {
	ob_start();  ?>

	<a href="<?php echo get_permalink($post_id); ?>" class="article-preview article-preview-video"
			<?php echo get_featured_img($post_id, "full", "bg", "", get_template_directory_uri().'/img/jpg/n-big.jpg'); ?>>
	    <span class="link"><?php echo get_the_title($post_id); ?></span>
	    <i></i>
	</a>

	<?php
	$content = ob_get_clean();
	return $content;
}

function show_post_big_xxl($post_id) {
	ob_start();  ?>

	<div class="article-preview article-preview-h big">
	    <div class="flex">
	        <div class="col">
	            <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-img">
	            	<?php echo get_featured_img($post_id, "full", "img", "", get_template_directory_uri().'/img/jpg/n-big.jpg'); ?>
	            </a>
	        </div>
	        <div class="col">
	        	<?php
					//$terms = get_the_terms( $post_id, 'category' );
					//$terms = get_the_terms( $post_id, 'research-and-resources' );
					

						
					if ( get_post_type( $post_id ) == 'post' ) {
						$terms = get_the_terms( $post_id, 'category' );
					} else {
						$terms = get_the_terms( $post_id, 'research-and-resources' );
					}
	
					if ( $terms && ! is_wp_error( $terms ) ) :
						$draught_links = array();
						foreach ( $terms as $term ) {
							$term_link = get_term_link($term);
							$draught_links[] = '<a href="' . $term_link . '" class="tag tag-white">' . $term->name . '</a>';
						}
						$on_draught = join( ", ", $draught_links );
					 	echo $on_draught;
					endif; ?>
	            <h2 class="big">
	                <a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
	            </h2>
	            <?php $author_id = get_post_field ('post_author', $post_id); ?>
		        <span class="title-details"><?php echo vc_show_fake_author($post_id); /*_e('By', THEME_TEXT_DOMAIN); ?> <a href="<?php echo  get_author_posts_url( $author_id ); ?>"><?php
					$display_name = get_the_author_meta( 'display_name' , $author_id );
					echo $display_name;*/
				?></span> <?php _e('On', THEME_TEXT_DOMAIN); ?> <span><?php echo get_the_date('F d, Y'); ?></span>

	            <p><?php echo custom_excerpt($post_id); //get_the_excerpt($post_id); ?></p>
	            <a href="<?php echo get_permalink($post_id); ?>" class="link"><?php _e('Read more', THEME_TEXT_DOMAIN); ?></a>
	        </div>
	    </div>
	</div>

	<?php
	$content = ob_get_clean();
	return $content;
}

function show_post_small_col($post_id){
	ob_start();  ?>

	<div data-id="<?php echo $post_id; ?>" class="article-preview article-preview-h">
	    <div class="flex">
	        <div class="col">
	            <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-img">
	            	<?php echo get_featured_img($post_id, "full", "img", "", get_template_directory_uri().'/img/jpg/n-big.jpg'); ?>
	            </a>
	        </div>
	        <div class="col"><?php
				$terms = get_the_terms( $post_id, 'category' );
				if ( $terms && ! is_wp_error( $terms ) ) :
					$draught_links = array();
					foreach ( $terms as $term ) {
						$term_link = get_term_link($term);
						$draught_links[] = '<a href="' . $term_link . '" class="tag">' . $term->name . '</a>';
					}
					$on_draught = join( ", ", $draught_links );
				 	echo $on_draught;
				endif; ?>
	            <h2 class="h3">
	                <a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
	            </h2>
	             <?php $author_id = get_post_field ('post_author', $post_id); ?>
	            <span class="title-details"><?php echo vc_show_fake_author($post_id); /*_e('By', THEME_TEXT_DOMAIN); ?> <a href="<?php echo  get_author_posts_url( $author_id ); ?>"><?php
					$display_name = get_the_author_meta( 'display_name' , $author_id );
					echo $display_name;
				?></a> <?php */ _e('On', THEME_TEXT_DOMAIN); ?> <span><?php echo get_the_date('F d, Y', $post_id); ?></span></span>
	            <a href="<?php echo get_permalink($post_id); ?>" class="link"><?php _e('Read more', THEME_TEXT_DOMAIN); ?></a>
	        </div>
	    </div>
	</div>

	<?php
	$content = ob_get_clean();
	return $content;
}


function show_post_small_col_event($post_id){
	ob_start();  ?>

	<div class="article-preview article-preview-h">
	    <div class="flex">
	        <div class="col">
	            <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-img">
	            	<?php echo get_featured_img($post_id, "full", "img", "", get_template_directory_uri().'/img/jpg/n-big.jpg'); ?>
	            </a>
	        </div>
	        <div class="col"><?php
				$terms = get_the_terms( $post_id, 'category' );
				if ( $terms && ! is_wp_error( $terms ) ) :
					$draught_links = array();
					foreach ( $terms as $term ) {
						$term_link = get_term_link($term);
						$draught_links[] = '<a href="' . $term_link . '" class="tag">' . $term->name . '</a>';
					}
					$on_draught = join( ", ", $draught_links );
				 	echo $on_draught;
				endif; ?>
	            <h2 class="h3">
	                <a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
	            </h2>

	            <?php  	$event_date = get_field('event_date', $post_id);
	            		if(!empty($event_date)) { ?>
	            			<span class="title-details">
	            				<span class="info">
		            				<i class="far fa-calendar-alt"></i> <?php
		            				$date = DateTime::createFromFormat('Ymd', $event_date);
		            				echo $date->format('l, j M Y'); ?>
		            			</span><?php
	            				$time = get_field('time', $post_id);
								if(!empty($time)) { ?>
									<span class="info info-time"><i class="far fa-clock"></i> <?php echo $time; ?></span>
						<?php 	} ?>
	            			</span>
	            <?php 	} ?>

				<?php  	$location = get_field('location', $post_id);
						if(!empty($location)) { ?>
							<span class="title-details"><i class="fas fa-map-marker-alt"></i> <?php echo $location; ?></span>
				<?php 	} ?>
	            <a href="<?php echo get_permalink($post_id); ?>" class="link"><?php _e('Read more', THEME_TEXT_DOMAIN); ?></a>
	        </div>
	    </div>
	</div>

	<?php
	$content = ob_get_clean();
	return $content;
}

function show_post_small_col_event_image($post_id) {
	ob_start();  ?>
	<div class="article-preview article-preview-image">
	            <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-img">
	            	<?php echo get_featured_img($post_id, "full", "img", "", get_template_directory_uri().'/img/jpg/n-big.jpg'); ?>
	            </a>
	    <span class="article-preview-image-title">
	        <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-image-title-link">
	            <span><?php echo get_the_title($post_id); ?></span>
	        </a>
	        <?php  	$event_date = get_field('event_date', $post_id);
            		if(!empty($event_date)) { ?>
            			<span class="title-details">
            				<span class="info">
	            				<i class="far fa-calendar-alt"></i> <?php
	            				$date = DateTime::createFromFormat('Ymd', $event_date);
	            				echo $date->format('l, j M Y'); ?>
	            			</span><?php
            				$time = get_field('time', $post_id);
							if(!empty($time)) { ?>
								<span class="info info-time"><i class="far fa-clock"></i> <?php echo $time; ?></span>
					<?php 	} ?>
            			</span>
            <?php 	} ?>

			<?php  	$location = get_field('location', $post_id);
					if(!empty($location)) { ?>
						<span class="title-details"><i class="fas fa-map-marker-alt"></i> <?php echo $location; ?></span>
			<?php 	} ?>

	    	</span>
	    </span><?php
		$terms = get_the_terms( $post_id, 'category' );
		if ( $terms && ! is_wp_error( $terms ) ) :
			$draught_links = array();
			foreach ( $terms as $term ) {
				$term_link = get_term_link($term);
				$draught_links[] = '<a href="' . $term_link . '" class="tag tag-filled">' . $term->name . '</a>';
			}
			$on_draught = join( ", ", $draught_links );
		 	echo $on_draught;
		endif; ?>
	</div>
	<?php
	$content = ob_get_clean();
	return $content;
}


function show_post_small($post_id){
	ob_start();  ?>

	<div class="article-preview">
	    <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-img">
	    	<?php echo get_featured_img($post_id, "full", "img", "", get_template_directory_uri().'/img/jpg/n-medium.jpg'); ?>
	    </a>
	    <p class="tag"><?php
				$terms = get_the_terms( $post_id, 'category' );
				if ( $terms && ! is_wp_error( $terms ) ) :
					$draught_links = array();
					foreach ( $terms as $term ) {
						$term_link = get_term_link($term);
						$draught_links[] = '<a href="' . $term_link . '" class="tag">' . $term->name . '</a>';
					}
					$on_draught = join( ", ", $draught_links );
				 	echo $on_draught;
				endif; ?></p>
	    <h2 class="h3">
	        <a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
	    </h2>
		<span class="date-post"><?php _e('On', THEME_TEXT_DOMAIN); ?> <span><?php echo get_the_date('F d, Y'); ?></span></span>
	    <p><?php echo custom_excerpt($post_id); //get_the_excerpt($post_id); ?></p>
	    <a href="<?php echo get_permalink($post_id); ?>" class="link"><?php _e('Read more', THEME_TEXT_DOMAIN); ?></a>
	</div>

	<?php
	$content = ob_get_clean();
	return $content;
}

function vc_show_post_image($post_id) {
	ob_start();  ?>
	<div class="article-preview article-preview-image">
	    <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-background" <?php echo get_featured_img($post_id, "full", "bg", "", get_template_directory_uri().'/img/jpg/n-big.jpg'); ?>
	           ></a>
	    <span class="article-preview-image-title">
	        <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-image-title-link">
	            <span><?php echo get_the_title($post_id); ?></span>
	        </a>
	         <?php $author_id = get_post_field ('post_author', $post_id); ?>
	        <span class="title-details"><?php echo vc_show_fake_author($post_id); /*_e('By', THEME_TEXT_DOMAIN); ?> <a href="<?php echo  get_author_posts_url( $author_id ); ?>" title=""><?php

	        	$display_name = get_the_author_meta( 'display_name' , $author_id );
				echo $display_name;

	        ?></a> <?php*/ _e('On', THEME_TEXT_DOMAIN); ?> <span><?php echo get_the_date('F d, Y'); ?></span>
	    	</span>
	    </span><?php
		$terms = get_the_terms( $post_id, 'category' );
		if ( $terms && ! is_wp_error( $terms ) ) :
			$draught_links = array();
			foreach ( $terms as $term ) {
				$term_link = get_term_link($term);
				$draught_links[] = '<a href="' . $term_link . '" class="tag tag-filled">' . $term->name . '</a>';
			}
			$on_draught = join( ", ", $draught_links );
		 	echo $on_draught;
		endif; ?>
	</div>
	<?php
	$content = ob_get_clean();
	return $content;
}

function show_title_button($title, $button_label, $button_link, $type) {
	ob_start();  ?>

	<div class="title">
	    <div class="flex">
	        <div class="col">
	        	<?php 	if(!empty($title)) { ?>
	            			<h2><?php echo $title; ?></h2>
	        	<?php  	} ?>
	        </div>
	        <div class="col">
	        	<?php  	if(!empty($button_label) && !empty($button_link)) { ?>
	            			<a href="<?php echo $button_link; ?>" class="btn btn-outline <?php if($type == "black"){ echo 'btn-outline-light'; } ?>"><?php echo $button_label; ?></a>
	        	<?php  	} ?>
	        </div>
	    </div>
	</div>

	<?php
	$content = ob_get_clean();
	return $content;
}

function vc_show_author_box($post_id) {
	ob_start();

	$author_id = get_post_field ('post_author', $post_id);
	$display_name = get_the_author_meta( 'display_name' , $author_id );

	$author_name = get_field('author_name', $post_id);
	$hide_author = get_field('hide_author', $post_id);

	if($hide_author != 'yes') { ?>
		<div class="author">
		    <div class="flex">
		        <div class="author-img">
		        	<?php   if(!empty($author_name) && !is_numeric($author_name)) { ?>
		        				<img src="<?php echo get_template_directory_uri(); ?>/img/jpg/user-avatar.jpg" height="96" class="no-user">
					<?php	}  else { ?>
					        	<?php  $my_custom_avatar = get_avatar(get_the_author_meta( 'ID' ), 96 );  ?>
					            <a href="<?php echo  get_author_posts_url( $author_id ); ?>" title="">
					            	<?php  echo $my_custom_avatar; ?>
					            </a>
					            <?php  $linkedin = get_the_author_meta('linkedin', $author_id);
					            		if(!empty($linkedin)) { ?>
					            			<a href="<?php echo $linkedin; ?>" target="_blank" class="linkedin" rel="nofollow"></a>
					        	<?php   } ?>
						<?php  } ?>
		        </div>
		        <div class="author-name">
		        	<?php   if(!empty($author_name) && !is_numeric($author_name)) { ?>
		        				 <h3><?php echo $author_name; ?></h3>
		        	<?php   } else { ?>
					            <h3><a href="<?php echo  get_author_posts_url( $author_id ); ?>"><?php echo $display_name; ?></a></h3>
					            <?php 	$description = get_the_author_meta('description', $author_id);
					            		if(!empty($description)) { ?>
					            			<small><?php echo $description; ?></small>
					        	<?php  } ?>
		        	<?php  } ?>
		        </div>
		    </div>
		</div>

		<?php
	}
	$content = ob_get_clean();
	return $content;
}

function vc_show_fake_author($post_id) {
	$author_name = get_field('author_name', $post_id); //var_dump($author_name);
	$hide_author = get_field('hide_author', $post_id);

	if($hide_author != 'yes') {
		if(!is_numeric($author_name) && !empty($author_name) && strlen($author_name) > 2) {
		    $search_author = get_user_by_display_name_custom($author_name) ;

		    //if(!empty($search_author)) {
		       // $display_name 	= get_the_author_meta( 'display_name' , $search_author );
		      //  return 'Posted by <a href="' . get_author_posts_url($search_author) . '">' . $display_name . '</a> ' ;
		    //} else {
		        return 'Posted by ' . $author_name . ' ' ;
		    //}

		} else {
			$post_author_id = get_post_field( 'post_author', $post_id );
			$display_name 	= get_the_author_meta( 'display_name' , $post_author_id );
			if(!empty($post_author_id)) {
				return 'Posted by <a href="' . get_author_posts_url($post_author_id) . '">' . $display_name . '</a> ' ;
			}
		}
	}

	return '';

	/* Posted by <a href="<?php echo get_author_posts_url($author_id); ?>"><?php

				$display_name = get_the_author_meta( 'display_name' , $author_id );
				echo $display_name;

			    ?></a> */
}

/*
function vc_show_login_form() {
	ob_start(); ?>

	<form action="#" class="login login-article">
	    <h3>Login to [insert keyword]</h3>
	    <div class="flex">
	        <input type="email" placeholder="Email address">
	        <input type="password" placeholder="Password">
	    </div>
	    <input type="submit" value="login">
	    <div class="flex">
	        <a href="#">Forgot password</a>
	        <span>Become a member today <a href="#" class="btn btn-outline">Join us</a></span>
	    </div>
	</form>

	<?php
	$content = ob_get_clean();
	return $content;

} */


function vc_show_share($main_id) {
	ob_start(); ?>

	<div class="share">
        <h6><?php _e('Share', THEME_TEXT_DOMAIN); ?></h6>
        <ul>
            <li><a href="http://www.facebook.com/share.php?u=<?php echo get_permalink($main_id); ?>&title=<?php echo get_the_title($main_id); ?>"><i class="icon icon-facebook-circle"></i></a></li>
            <li><a href="http://twitter.com/home?status=<?php echo get_the_title($main_id); ?>+<?php echo get_permalink($main_id); ?>"><i class="icon icon-twitter-circle"></i></a></li>
            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink($main_id); ?>&title=<?php echo get_the_title($main_id); ?>&source=<?php echo site_url(); ?>"><i class="icon icon-linkedin-circle"></i></a></li>
            <li><a href="mailto:%20?body=<?php echo get_the_title($main_id) . ' - ' . get_permalink($main_id); ?>"><i class="icon icon-email-circle"></i></a></li>
        </ul>
    </div>

	<?php
	$content = ob_get_clean();
	return $content;
}


// search ajax

function vc_search_action(){
	ob_start();

	if(isset($_POST['action']) && strcmp($_POST['action'], "vc_search_action") == 0 &&
		isset($_POST['data_value']) && strlen($_POST['data_value'] ) > 3 ) {

		$args =  array(
            'ignore_sticky_posts' 	=> true,
            'post_type'           	=> array( 'post', 'page', 'resource', 'guideline', 'regulatory-affair', 'event', 'news' ), //'post',
            'order'              	=> 'DESC',
            'posts_per_page'		=> 10,
            's'						=> $_POST['data_value']
		);

		$args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	 	$loop = new WP_Query( $args );
		if ($loop->have_posts()) {  ?>

			<?php  	while ($loop->have_posts())	{
						$loop->the_post();
						$post_id = get_the_ID(); ?>

				<li>
                    <a href="<?php echo get_permalink($post_id); ?>" title="">
                        <strong><?php echo get_the_title($post_id); ?></strong>
                    </a>
                    <br>
                    <?php
						$terms = get_the_terms( $post_id, 'category' );
						if ( $terms && ! is_wp_error( $terms ) ) :
							$draught_links = array();
							foreach ( $terms as $term ) {
								$term_link = get_term_link($term);
								$draught_links[] = '<a href="'. $term_link .'">'. $term->name . '</a>';
							}
							$on_draught = join( ", ", $draught_links );
						?>
						<span>Posted in: <?php echo $on_draught; ?></span>
						<?php endif; ?>
                </li>

		<?php }	?>

<?php 	} else {	?>

				<li>No results found.</li>
	 	<?php
	 	}

	}

	$content = ob_get_clean();

	echo json_encode(array('message' => $content ));
    die();
}

add_action( 'wp_ajax_vc_search_action', 'vc_search_action' );
add_action( 'wp_ajax_nopriv_vc_search_action', 'vc_search_action' );


function loadmore(){
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	if(isset($_POST['tags']) && strlen($_POST['tags']) > 0) { // post_tag
		$args['tax_query'] 	= array(
								array(
									'taxonomy' 	=> 'post_tag',
									'field'    	=> 'name', // slug
									'terms'   	=> $_POST['tags'],
								),
							) ;
	}

	if(isset($_POST['a']) && strlen($_POST['a']) > 0 && $_POST['a'] != 'null') {
		$args['author'] =  $_POST['a'];
	}

	if($_POST['type_event'] == 'events') {
		//event_date
		if( isset($_POST['from']) && strlen($_POST['from']) > 0) {
			$active_filter 	= true;
			$new_to = str_replace("-", "", $_POST['from']);
			$args['meta_query'] = array(
				'relation' => 'AND',
				array(
		            'key'     => 'event_date',
		            'compare' => '>=',
		            'value'   => $new_to,
		        ),
			);

		}

		if( isset($_POST['to']) && strlen($_POST['to']) > 0) {
			$active_filter 	= true;
			$new_from = str_replace("-", "", $_POST['to']);
			$args['meta_query'][] =
				array(
		            'key'     => 'event_date',
		            'compare' =>  '<=',
		            'value'   => $new_from,
				);
		}

		$args['meta_key'] = 'event_date';
    	$args['orderby']  = 'meta_value_num';

	} else {
		if( isset($_POST['to']) && strlen($_POST['to']) > 0) {
			$args['date_query'] = array(
				'relation' => 'AND',
			    array(
			        'before' => $_POST['to'],
			        'inclusive' => true,
			    )
			);
		}

		if( isset($_POST['from']) && strlen($_POST['from']) > 0) {
			$args['date_query'][] =
			    array(
			        'after' => $_POST['from'],
			        'inclusive' => true,
			);
		}
	}

	// it is always better to use WP_Query but not here
	query_posts( $args );
 	$count_each = -1;
	if( have_posts() ) :
		while( have_posts() ): the_post();
			$pg_id = get_the_ID();
			$count_each++;

			if($_POST['template'] == 'list') {
				if($_POST['type_event'] == 'events') { // events column
					$content .= '<li>'. show_post_small_col_event($pg_id) .'</li>';
				} else {
					$content .= '<li>'. show_post_small_col($pg_id) .'</li>';
				}

			} else if($_POST['template'] == 'full') {
				if($count_each % 6 == 0) {
					if($_POST['type_event'] == 'events') { // events large
						$content .=  '<div class="grid-item grid-item-big single_article">'.show_post_small_col_event_image($pg_id).'</div>';
					} else {
						$content .=  '<div class="grid-item grid-item-big single_article">'.vc_show_post_image($pg_id).'</div>';
					}
				} else {
					if($_POST['type_event'] == 'events') { // events small
						$content .=  '<div class="grid-item single_article">'.show_post_small_col_event_image($pg_id).'</div>';
					} else {
						$content .=  '<div class="grid-item single_article">'.vc_show_post_image($pg_id).'</div>';
					}
				}
			}

		endwhile;
	endif;

	echo json_encode(array('message' => $content ));
    die();
}
add_action('wp_ajax_loadmore', 'loadmore'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'loadmore'); // wp_ajax_nopriv_{action}




function size_as_kb($yoursize) {
	if($yoursize < 1024) {
		return "{$yoursize} bytes";
	} elseif($yoursize < 1048576) {
		$size_kb = round($yoursize/1024);
		return "{$size_kb} KB";
	} else {
		$size_mb = round($yoursize/1048576, 1);
		return "{$size_mb} MB";
	}
}


function vc_show_documents($post_id) {
	ob_start();

	$intro = 0;
	$registred = false;
	$member = false;

	$documents_new_structure = get_field('documents_new_structure', $post_id);
	if(!empty($documents_new_structure)) {
		$count_casual = 0;
		$count_registred = 0;
		$count_member = 0;

		foreach ($documents_new_structure as $key => $value) {
		 	$access_required = $value['access_required'];
		 	if($access_required == "casual") {
		 		$count_casual++;
		 	} else if($access_required == "registered")  {
		 		$count_registred++;
		 	} else if($access_required == "member")  {
		 		$count_member++;
		 	}
		}

		if(is_user_logged_in() && !current_user_can('administrator') ) { // not admin
			$registred = true;
			$current_user 	= wp_get_current_user();
			$user_id 		= $current_user->ID;
			$member_account = get_field('member_account', 'user_' . $user_id);

			if( $member_account == true ) {
				$member = true;
				$registred = true;
			}

		} else if(current_user_can('administrator')) {
				$member = true;
				$registred = true;
		} ?>

		<div class="downloads">
			<?php 	//if( $count_casual > 0 || ($registred == true && $count_registred > 0) || ($member == true && $count_member > 0)){
					if( $count_casual > 0 || $count_registred > 0 || $count_member > 0 ){
						$intro = 1;  ?>
			   	 		<h3><?php _e('Downloads:', THEME_TEXT_DOMAIN); ?></h3>
					   	<ul>
			<?php  	} ?>

	    	<?php 	// casual
	    			echo vc_show_doc_by_access($documents_new_structure, "casual");

	    			// registred
	    			if($count_registred > 0 && $registred == true ) {
	    				echo vc_show_doc_by_access($documents_new_structure, "registered");
					} else if($count_registred > 0 && $registred != true) {
						// show message restricitve doc
						echo '<p class="info-note"><b>This page contains downloads that are only available to registered users. </b><br/>Please <a data-fancybox="" data-src="#login" href="javascript:;" data-options=\'{"touch" : false}\'>log in</a> or <a data-fancybox="" data-src="#register" href="javascript:;" data-options=\'{"touch" : false}\'>click here to register for free</a>.</p>';
					}

					// members
					if($count_member > 0 && $member == true ) {
	    				echo vc_show_doc_by_access($documents_new_structure, "member");
					} else if($count_member > 0  && $member != true ) {

						// show message member doc
						$member_form = get_field('member_form', 'options');

						//"Please log in <current lightbox link> if you belong to a member organisation, if you do not have a member login it can be set up here <link to page to be created under item 32>
						if(is_user_logged_in()) {
							echo '<p class="info-note"><b>This page contains downloads that are only available to members. </b><br/>Please log in as a member if you belong to a member organisation, if you do not have a member login it can be <a href="' . $member_form . '">set up here</a>.</p>';
						} else {
							echo '<p class="info-note"><b>This page contains downloads that are only available to members. </b><br/>Please <a data-fancybox="" data-src="#login" href="javascript:;" data-options=\'{"touch" : false}\' >log in</a> if you belong to a member organisation, if you do not have a member login it can be <a href="' . $member_form . '">set up here</a>.</p>';
						}


					} ?>

			<?php 	//if( $count_casual > 0 || ($registred == true && $count_registred > 0) || ($member == true && $count_member > 0)){
					if( $count_casual > 0 || $count_registred > 0 || $count_member > 0 ){   ?>
					    </ul>
			<?php  	} ?>

		 </div>
		<?php

	}


	/*if(!empty($documents)  || !empty($restrictive_documents) || !empty($documents_mautic) || !empty($documents_restrictice_mautic)) { ?>
		<div class="downloads">
		    <h3><?php _e('Downloads:', THEME_TEXT_DOMAIN); ?></h3>
		    <ul>
		        <?php foreach ($documents as $doc):
		        		if(!empty($doc['file'])) {  ?>
					        <li>
					            <a href="<?php echo $doc['file']['url']; ?>" title=""  download><?php echo $doc['file']['filename']; ?></a>
					            <?php  $size_b = $doc['file']['filesize']; ?>
					            <small>(size: <?php echo size_as_kb($size_b); ?>)</small>
					        </li>
		        	<?php  } ?>
		        <?php endforeach; ?>

		        <?php  foreach ($documents_mautic as $doc_mautic) {
		        			$file_name = $doc_mautic['file_name'];
		        			$file_url  = $doc_mautic['file_url'];

		        			if(!empty($file_name) && !empty($file_url)){ ?>
		        				<li>
						            <a href="<?php echo $file_url; ?>" title=""  ><?php echo $file_name; ?></a>
						        </li>
		        	<?php  	} ?>
		        <?php  } ?>

		        <?php  if(is_user_logged_in()) { ?>
		 				<?php foreach ($restrictive_documents as $doc): ?>
				        <li>
				            <a href="<?php echo $doc['file']['url']; ?>" title="" download><?php echo $doc['file']['filename']; ?></a>
				            <?php  $size_b = $doc['file']['filesize']; ?>
				            <small>(size: <?php echo size_as_kb($size_b); ?>)</small>
				        </li>
				        <?php endforeach; ?>

				        <?php  foreach($documents_restrictice_mautic as $doc) {
				        			$file_name = $doc['file_name'];
				        			$file_url  = $doc['file_url'];

				        			if(!empty($file_name) && !empty($file_url)) { ?>
				        				<li>
								            <a href="<?php echo $file_url; ?>" title=""><?php echo $file_name; ?></a>
								        </li>
				        	<?php  } ?>
				        <?php  } ?>
		        <?php  } ?>
		    </ul>

		    <?php  if(!is_user_logged_in()) {
		    			$join_us = get_field('join_us', 'options'); ?>
		    			<p class="info-note">Please <a data-fancybox="" data-src="#login" href="javascript:;">login</a> if you belong to a member organisation, if you do not have a login it can be <a data-fancybox="" data-src="#register" href="javascript:;">set up here</a>.</p>
		    <?php  } ?>
		</div>
	<?php 	} */
	$content = ob_get_clean();
	return $content;
}


function vc_show_doc_by_access($documents_new_structure, $access) {
	ob_start();

	foreach ($documents_new_structure as $key => $value) {
		$type_of_document 		= $value['type_of_document'];
		$file 					= $value['file'];
		$mautic_document_link 	= $value['mautic_document_link'];
		$mautic_document_name 	= $value['mautic_document_name'];
		$access_required 		= $value['access_required'];

		if($access_required == $access) {
			switch ($type_of_document) {
				case 'file':
					if(!empty($file)) {  //var_dump($file); ?>
						<li>
				            <a href="<?php echo $file['url']; ?>" title=""  download target="_blank"><?php echo $file['filename']; ?></a>
				            <?php  $size_b = $file['filesize']; ?>
				            <small>(size: <?php echo size_as_kb($size_b); ?>)</small>
				        </li><?php
				    }
					break;
				case 'mautic-link':
					if(!empty($mautic_document_link) && !empty($mautic_document_name)) { ?>
						<li>
				            <a href="<?php echo $mautic_document_link; ?>" title=""  ><?php echo $mautic_document_name; ?></a>
				        </li><?php
					}
					break;
				default: break;
			}
		} ?>
<?php 	}
	$content = ob_get_clean();
	return $content;
}

/*
function vc_show_documents_restrictive($documents) {
	ob_start();

	if(!empty($documents)) {  ?>
		<div class="downloads second">
		    <h3><?php _e('Downloads Members:', THEME_TEXT_DOMAIN); ?></h3>
	<?php if(is_user_logged_in()) {  ?>
		    <ul>
		        <?php foreach ($documents as $doc): ?>
		        <li>
		            <a href="<?php echo $doc['file']['url']; ?>"><?php echo $doc['file']['filename']; ?></a>
		            <?php  $size_b = $doc['file']['filesize']; ?>
		            <small>(size: <?php echo size_as_kb($size_b); ?>)</small>
		        </li>
		        <?php endforeach; ?>
		    </ul>
	<?php } else {
				echo "<p>This article has restricted downloads for report only members. Login to view further information, or become a member.</p>"; ?>

		<?php  } ?>
		</div>
	<?php
	}
	$content = ob_get_clean();
	return $content;
}*/



function vc_show_links($links) {
	ob_start();


	$intro = 0;
	$registred = false;
	$member = false;


	if(!empty($links)) {
		$count_casual = 0;
		$count_registred = 0;
		$count_member = 0;

		foreach ($links as $key => $value) {
		 	$access_required = $value['access_required'];
		 	if($access_required == "casual") {
		 		$count_casual++;
		 	} else if($access_required == "registered")  {
		 		$count_registred++;
		 	} else if($access_required == "member")  {
		 		$count_member++;
		 	}
		}

		if(is_user_logged_in() && !current_user_can('administrator') ) { // not admin
			$registred = true;
			$current_user 	= wp_get_current_user();
			$user_id 		= $current_user->ID;
			$member_account = get_field('member_account', 'user_' . $user_id);

			if( $member_account == true ) {
				$member = true;
				$registred = true;
			}

		} else if(current_user_can('administrator')) {
				$member = true;
				$registred = true;
		} else {
			$member = false;
			$registred = false;
		} ?>

		<div class="links_box second">
			<?php 	//var_dump($count_member );
					//if( $count_casual > 0 || ($registred == true && $count_registred > 0) || ($member == true && $count_member > 0)){
					if( $count_casual > 0 || $count_registred > 0 || $count_member > 0 ){
						$intro = 1;  ?>
			   	 		<h3><?php _e('External URLs:', THEME_TEXT_DOMAIN); ?></h3>
					   	<ul>
			<?php  	} ?>

	    	<?php 	// casual
	    			echo vc_show_link_by_access($links, "casual");

	    			// registred
	    			if($count_registred > 0 && $registred == true ) {
	    				echo vc_show_link_by_access($links, "registered");
					} else if($count_registred > 0 && $registred != true) {
						// show message restricitve doc

						echo '<p class="info-note"><b>This page contains links that are only available to registered users. </b><br/>Please <a data-fancybox="" data-src="#login" href="javascript:;" data-options=\'{"touch" : false}\'>log in</a> or <a data-fancybox="" data-src="#register" href="javascript:;" data-options=\'{"touch" : false}\'>click here to register for free</a>.</p>';
					}

					// members
					//var_dump($count_member);
					if($count_member > 0 && $member == true ) {
	    				echo vc_show_link_by_access($links, "member");
					} else if($count_member > 0  && $member != true ) {

						// show message member doc
						// "Please log in <current lightbox link> if you belong to a member organisation, if you do not have a member login it can be set up here <link to page to be created under item 32>
						$member_form = get_field('member_form', 'options');
						if(is_user_logged_in()) {
							echo '<p class="info-note"><b>This page contains links that are only available to members. </b><br/>Please log in as a member if you belong to a member organisation, if you do not have a member login it can be <a href="' . $member_form . '">set up here</a>.</p>';
						} else {
							echo '<p class="info-note"><b>This page contains links that are only available to members. </b><br/>Please <a data-fancybox="" data-src="#login" href="javascript:;" data-options=\'{"touch" : false}\'>log in</a> if you belong to a member organisation, if you do not have a member login it can be <a href="' . $member_form . '">set up here</a>.</p>';
						}


					} ?>

			<?php 	if( $count_casual > 0 || $count_registred > 0 || $count_member > 0 ){   ?>
					    </ul>
			<?php  	} ?>

		 </div>
		<?php
	}

	$content = ob_get_clean();
	return $content;
}

function vc_show_link_by_access($links_new_structure, $access) {
	ob_start();

	foreach ($links_new_structure as $key => $value) {
		$link_name 				= $value['link_name'];
		$link 					= $value['link'];
		$access_required 		= $value['access_required'];
		if($access_required == $access && !empty($link_name) && !empty($link)) { ?>
			<li>
	            <a href="<?php echo $link; ?>" title="" target="_blank"><i class="fas fa-chevron-right"></i><?php echo $link_name; ?></a>
	        </li>
<?php  	}
	}
	$content = ob_get_clean();
	return $content;
}

// filters for events
function vc_show_filter_form_events($active_filter, $current_category ) {
	ob_start();
	//$current_category = get_queried_object();
	$term_link = get_term_link($current_category); //var_dump($term_link); ?>

	<form action="" method="GET" class="filter" id="filter_info">
	    <h6>Filter</h6>
	    <div class="flex">
	        <div class="col full">
	            <label for="tag">By Tag</label>
	            <input type="text" list="options" id="tag" name="tags" value="<?php if(isset($_GET['tags']) && strlen($_GET['tags']) > 0) { echo $_GET['tags']; } ?>">
	            <?php
					$terms = get_terms( 'post_tag' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
					  	<datalist id="options"><?php
						    foreach ( $terms as $term ) {
						        echo '<option value="'. ucfirst($term->name)  .'">';
						    } ?>
					    </datalist>
				<?php	} ?>
	        </div>
	        <div class="col col-from">
	            <label for="from">Start Date</label>
	            <input type="text" id="from" name="from" value="<?php if(isset($_GET['from']) && strlen($_GET['from']) > 0) { echo $_GET['from']; }  ?>">
	        </div>
	        <div class="col col-to">
	            <label for="to">End Date</label>
	            <input type="text" id="to" name="to" value="<?php if(isset($_GET['to']) && strlen($_GET['to']) > 0) { echo $_GET['to']; } ?>">
	        </div>
	    </div>
	    <div class="flex">
	    	<?php  if($active_filter == true) { ?>
	        			<a href="<?php echo $term_link; ?>" class="reset">Reset filters</a>
	    	<?php  } ?>
	        <input type="submit" value="Apply">
	    </div>
	</form>

	<?php
	$content = ob_get_clean();
	return $content;
}

// filters for form normal
function vc_show_filter_form($active_filter, $no) {
	ob_start();
	$current_category = get_queried_object();
	$term_link = get_term_link($current_category); ?>

	<form action="" method="GET" class="filter" id="filter_info">
	    <h6>Filter</h6>
	    <div class="flex">
	        <div class="col full">
	            <label for="tag">By Tag</label>
	            <input type="text" list="options" id="tag" name="tags" value="<?php if(isset($_GET['tags']) && strlen($_GET['tags']) > 0) { echo $_GET['tags']; } ?>">
	            <?php
					$terms = get_terms( 'post_tag' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
					  	<datalist id="options"><?php
						    foreach ( $terms as $term ) {
						        echo '<option value="'. $term->name  .'">';
						    } ?>
					    </datalist>
				<?php	} ?>
	        </div>
	        <div class="col col-from">
	            <label for="from">From</label>
	            <input type="text" id="from<?php echo $no; ?>" name="from" value="<?php if(isset($_GET['from']) && strlen($_GET['from']) > 0) { echo $_GET['from']; }  ?>">
	        </div>
	        <div class="col col-to">
	            <label for="to">To</label>
	            <input type="text" id="to<?php echo $no; ?>" name="to" value="<?php if(isset($_GET['to']) && strlen($_GET['to']) > 0) { echo $_GET['to']; } ?>">
	        </div>
	    </div>
	    <div class="flex">
	    	<?php  if($active_filter == true) { ?>
	        			<a href="<?php echo $term_link; ?>" class="reset">Reset filters</a>
	    	<?php  } ?>
	        <input type="submit" value="Apply">
	    </div>
	</form>

	<?php
	$content = ob_get_clean();
	return $content;
}

function vc_show_forgot_password() {
	ob_start(); ?>

	<form method="post" action="" class="forgot-password-form">
        <div class="wrapp-login forgot-wrapp">
            <p class="status"></p>
            <h3>Password Reset</h3>
            <p class="white-text">Please enter your email address. You will receive a link to create a new password via email.</p>
            <div class="form-group">
                <input type="email" name="user_login" value="" placeholder="E-mail Address"/> <?php //  id="user_login" ?>
            </div>
            <div class="submit-form">
                <i class="icon icon-loading"></i>
                <input type="hidden" name="action" value="reset" />
                <input type="submit" value="Reset Password" class="button" id="submit" />
            </div>

        </div>
    </form>

<?php
	$content = ob_get_clean();
	return $content;
}


// ajax login
function ajax_login(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );


    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );


	//var_dump($info); var_dump($user_signon);
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('<span class="error">Wrong username or password.</span>')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('<span class="succes">Login successful. Please wait...</span>')));
    }

    die();

}
add_action('wp_ajax_ajaxlogincustom', 'ajax_login'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_ajaxlogincustom', 'ajax_login'); // wp_ajax_nopriv_{action}

// ajax reset password
// disable change password
add_filter( 'send_password_change_email', '__return_false' );

function vc_forgot_password() {

	//var_dump(($_POST));

	$email = trim($_POST['user_login']);

    if( empty( $email ) ) {
        $error = 'Enter a username or e-mail address..';
    } else if( ! is_email( $email )) {
        $error = 'Invalid username or e-mail address.';
    } else if( ! email_exists( $email ) ) {
        $error = 'There is no user registered with that email address.';
    } else {

        $random_password = wp_generate_password( 12, false );
        $user = get_user_by( 'email', $email );

        $update_user = wp_update_user( array (
                'ID' => $user->ID,
                'user_pass' => $random_password
            )
        );

        $validate_mautic = vc_mautic_search_contacts_by_email( $user );  //var_dump($validate_mautic);

        // if  update user return true then lets send user an email containing the new password
        if( $update_user && $validate_mautic == 1 ) {
            $to = $email;
            $subject = 'Reset your password';
            $sender = 'IAB Australia';
            $from = get_field('from', 'options');
            $forgot_password = get_field('forgot_password', 'options');

            $message = '<p>Hi there, <br/><br/>Someone requested that the password be reset for the following account: <br/><br/>Username: ' . $email . '<br/><br/>If this was a mistake, just ignore this email and nothing will happen.<br/>To reset your password, visit the following address: '. $forgot_password . '?key=' . encrypt( $email )  . '<br/><br/>Thank you</p>';

            $headers[] = 'MIME-Version: 1.0' . "\r\n";
            $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers[] = "X-Mailer: PHP \r\n";
            $headers[] = 'From: '.$sender.' <' .  $from  . '>' . "\r\n";

            $mail = wp_mail( $to, $subject, $message, $headers );

            //if( $mail != false ) {
                $success = 'Please check your inbox for our email to create a new password.';
           // } //else {
            	//var_dump($headers);
            	// $error = 'There are some problems so the emails wasn\'t sent. Please contact us.';
            //}


        } else {
            $error = 'Oops something that failed to find your account.';
        }

    }

    if( ! empty( $error ) )
        $content  =  '<span class="error"><strong>ERROR:</strong> '. $error .'</span>';

    if( ! empty( $success ) )
        $content  =  '<span class="success">'. $success .'</span>';

    echo json_encode(array('message' => $content ));
    die();

}
add_action('wp_ajax_vc_forgot_password', 'vc_forgot_password'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_vc_forgot_password', 'vc_forgot_password'); // wp_ajax_nopriv_{action}


// reset password
function vc_reset_pass() {
	$loggedin = false;
	$dashboard_page = get_field('dashboard_page', 'options');

	if(isset($_POST['action']) && strlen($_POST['action']) > 0) {
		if (isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['key']) ) {
			if(strcmp($_POST['password1'], $_POST['password2']) == 0) {
				if(strlen($_POST['password1']) >= 9 ) {
					// update use password
					$user_email = decrypt($_POST['key']);
					$user = get_user_by( 'email', $user_email );
					$user_id = $user->ID;

					wp_set_password( $_POST['password1'], $user_id );

					$userdata['ID'] = $user_id; //admin user ID
					$userdata['user_pass'] = $_POST['password1'];
					wp_update_user( $userdata );

					$creds = array(
				        'user_login'    => $user_email ,
				        'user_password' => $_POST['password1'],
				        'remember'      => true
				    );

				  	//var_dump($out);

				 	$user_login = wp_signon( $creds,  is_ssl() );
				 	wp_set_current_user( $user_id , $user_login );
					wp_set_auth_cookie( $user_id , true, false );
					//do_action( 'wp_login', $user_login );

					//do_action('wp_login', $user->user_login, $user);
					//wp_set_current_user( $user->ID );
					//wp_set_auth_cookie( $user->ID );

					//wp_safe_redirect($dashboard_page);
					//. die();
					//header('Location: ' . $account['location']);


				   // if ( is_wp_error( $user_login ) ) {
				   //    	$content = '<span class="error">' . $user_login->get_error_message() . '</span>';
				   // } else {
				    	$content = '<span class="success">Password changed successfully. You will be redirected in 3 seconds... </span>';
				    	$loggedin = true;

				   // }

				} else {
					$content = '<span class="error">Please choose a strong password!</span>';
				}

			} else {
				$content = '<span class="error">Passwords do not match!</span>';
			}
		} else {
			$content = '<span class="error">Please enter the new password!</span>';
		}
	}

    echo json_encode(array('message' => $content , 'loggedin' =>  $loggedin, 'redirecturl' => $dashboard_page ));
    die();

}
add_action('wp_ajax_vc_reset_pass', 'vc_reset_pass'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_vc_reset_pass', 'vc_reset_pass'); // wp_ajax_nopriv_{action}



function vc_subscribe_newsletter() {

	if(isset($_POST['action']) && strlen($_POST['action']) > 0) {
		if( isset($_POST['email'])  ) { //  && isEmail( $_POST['email'] ) == true
			$create_mautic =  vc_mautic_create_account_newsletter('', '',  $_POST['email'], true, false);

			if( !empty($create_mautic['contact'])) {
				//var_dump($create_mautic['contact']);
				if( !empty( $create_mautic['contact']['dateModified'] ) ) { /// 2020-06-11T14:33:49+00:00
					$content = '<span class="error">You are already registered for the newsletter.</span>';
				} else {
					$content = '<span class="success">Please check for an email from us in your inbox to validate your subscription. </span>';

					// send thankyou email
					//vc_send_email_newsletter($_POST['email']);
				}

			} else {
				$content = '<span class="error">Sorry, but we encountered technical issues. Please try again later. </span>';
			}
		}
	}

    echo json_encode(array('message' => $content ));
    die();

}
add_action('wp_ajax_vc_subscribe_newsletter', 'vc_subscribe_newsletter');
add_action('wp_ajax_nopriv_vc_subscribe_newsletter', 'vc_subscribe_newsletter');


function vc_show_newsletter() {
	ob_start();

	$mautic_code_newsletter = get_field('mautic_code_newsletter', 'options');
	if(!empty($mautic_code_newsletter)) { ?>
		<div class="subscribe_newsletter subscribe_newsletter_mautic">
			<?php echo $mautic_code_newsletter; ?>
		</div>
<?php }  /*?>

	<form method="POST" action="#" class="subscribe_newsletter">
		<div class="relative">
	        <input type="email" name="newsletter" class="outline" placeholder="Email address">
	        <button type="submit" class="with-icon">
	            <i class="icon icon-check"></i>
	        </button>
	        <div class="submit-form">
	            <i class="icon icon-loading"></i>
	        </div>
	    </div>
        <span class="newsletter-message"></span>
        <?php /*<span class="newsletter-message error">Please enter a valid email address</span>
        <span class="newsletter-message success">You have successfully subscribed!</span>?>
    </form>
    <?php */
	$content = ob_get_clean();
	return $content;
}

function vc_register_mautic_user() {
	ob_start(); ?>

	<div class="wrapp-login register">
        <h3>Register</h3>
        <form class="register_header" action=""  method="post">
        	<div class="input_block">
        		<input type="text" name="user_fname"  placeholder="First Name" required="">
        	</div>
        	<div class="input_block">
        		<input type="text" name="user_lname"  placeholder="Last Name" required="">
        	</div>
        	<div class="input_block">
        		<input type="text" name="user_email"  placeholder="Email Address" required="">
        	</div>
        	<div class="input_block">
        		<input type="password" name="user_password"  id="password-field" placeholder="Password" required="">
        		<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
        	</div>
        	<div class="input_block submit-form">
        		<input type="hidden" name="action" value="vc_register_user">
        		<input type="submit" name="Register" class="btn button">
        		 <i class="icon icon-loading"></i>
        	</div>
        	<p class="status"></p>
        </form>
    </div>

	 <?php
	$content = ob_get_clean();
	return $content;
}

function vc_send_email_register($to) {
	$from  		  = get_field('from', 'options');
	$subject      = get_field('subject', 'options');
	$headers[]    = 'From: IAB Australia<'. $from .'>';
    $headers[] 	  = 'Content-Type: text/html; charset=UTF-8';
    $message 	  = get_field('content_email_register', 'options');
 	$mail 		  = wp_mail($to, $subject, $message, $headers);
}

/*
function vc_send_email_newsletter($to) {
	$from  		  = get_field('from', 'options');
	$subject      = get_field('subject_newsletter', 'options');
	$headers[]    = 'From: '.get_bloginfo('name').' <'. $from .'>';
    $headers[] 	  = 'Content-Type: text/html; charset=UTF-8';
    $message 	  = get_field('content_email_newsletter', 'options');
 	$mail 		  = wp_mail($to, $subject, $message, $headers);
} */



function get_user_by_display_name_custom($search_string) {

    $users = new WP_User_Query( array(
        'search'         => "*{$search_string}*",
) );
$users_found = $users->get_results();


$user =  ( isset( $users_found[0] ) ? $users_found[0] : false );
$user_id = ( $user ? $user->ID : false );
return $user_id;
    /*$users = get_users( array(
        'meta_key'      => 'display_name',
        'meta_value'    => $display_name
    ) );



    $user =  ( isset( $users[0] ) ? $users[0] : false );

    $user_id = ( $user ? $user->ID : false );

    return $user_id; */
}


// create new member from anyone
function vc_create_member() {
	$message = '';
	$contact_page  = get_field('contact_page', 'options');
	//var_dump($_POST);

    if(wp_verify_nonce($_POST['submit_form_members'], 'submit_form_members') == 1) {

	    $email_account = $_POST['emailaddress'];
	    if(!empty($email_account)) {

			$email_domain 		= explode('@', $email_account);
            $companies_array    = json_decode( get_field('mautic_domain_names_full_copy', 'options'), true );

	    	if(in_array($email_domain[1], $companies_array )){

	    		// create account on mautic
	    		if(sizeof($mautic_account['errors']) != 0 ) {
	    			$message = "<span class='error'>Error: We have problems on adding this account. Please <a href='".$contact_page."'>contact us.</a></span>";
	    		} else {
	    			// create account to wp
	    			$user_info = array(
						"user_pass"     => wp_generate_password(12),//$_POST['password'],
						"user_login"    => $_POST['emailaddress'],
						"user_nicename" => $_POST['emailaddress'],
						"user_email"    => $_POST['emailaddress'] ,
						"display_name"  => $_POST['firstname'] . ' ' . $_POST['surname'] ,
						"first_name"    => $_POST['firstname'],
						"last_name"     => $_POST['surname'],
					);

					$insert_user_result = wp_insert_user( $user_info );

					if ( is_wp_error($insert_user_result) ) {
						if(username_exists( $_POST['emailaddress'] )) {
							$message = "<span class='error'>The person you have added is already a part of our team.</span>";
						} else {
							$message = '<span class="error">'. $insert_user_result->get_error_message() .'  Please <a href="'.$contact_page.'">contact us.</a></span>';
						}
					} else {
						$company_name  = lc_search_company_by_domain($email_domain[1]);
	    				$mautic_account = vc_mautic_create_account_general_register( $_POST, $company_name );

						// update acf fields
						update_field('field_5ed41bd3f98a9', $mautic_account['contact']['dateAdded'], 'user_' . $insert_user_result ); // date
						update_field('field_5ed42271bab73', $mautic_account['contact']['id'], 'user_' . $insert_user_result ); // id
						update_field('field_5ee86fdc8dde3', 'yes', 'user_'. $insert_user_result );  // member
						update_field('field_5ed7912f53507', $company_name, 'user_'. $insert_user_result ); //company
						update_field('field_5ed7915953508', $_POST['userprofileposition'], 'user_'. $insert_user_result ); // position
						//update_field('field_5ed7917bfd2dc', $_POST['userprofilephone'], 'user_'. $insert_user_result); // phone
						update_field('field_5ed79186fd2dd', $_POST['userprofilemobile'], 'user_'. $insert_user_result); // mobile

						if($_POST['newsletters'] == 'on') {
							update_field('field_5ed791d4fd2e4', 'yes', 'user_'. $insert_user_result); // newletter
						} else {
							update_field('field_5ed791d4fd2e4', 'no', 'user_'. $insert_user_result);
						}

						vc_send_email_register_members( $email_account );

						$message = "<span class='success'>The person you have added is now part of the specified member organisation. Please check the inbox of the email specified to validate the account.</span>";

						// send email new account and reset password
						//vc_send_email_register($_POST['user_email']);
					}
	    		}

	    	} else {
	    		$message = "<span class='error'>The details you have submitted don't seem to match the member organisation details in our database. Please <a href='".$contact_page."'>contact us.</a> or update the form details.</span>";
	    	}

	    } else {
	    	$message = "<span class='error'>Error: Invaild email address.</span>";
	    }


	} else {
        $message = "<span class='error'>Error: Please try again later.</span>";
    }

   echo json_encode(array('message' => $message ));
   die();

}
add_action( 'wp_ajax_vc_create_member', 'vc_create_member' );
add_action( 'wp_ajax_nopriv_vc_create_member', 'vc_create_member' );

function vc_search_company_by_domain($list, $value) {

    foreach($list as $key => $company){
    	foreach($company as $key2 => $domain) {
    		if($domain == $value) {
    			return $key;
    		}
    	}
    }
    return false;
}

function lc_search_company_by_domain($user_domain) {
	$list = json_decode( get_field('mautic_domain_names_copy', 'options'), true);

	foreach($list as $key => $company){
		foreach($company as $key2 => $domain) {
			if($domain == $user_domain) {
				return $key;
			}
		}
	}

	return false;
}


function vc_send_email_register_members($to) {
	$from  		  = get_field('from', 'options');
	$subject      = get_field('subject_member', 'options');
	$headers[]    = 'From: IAB Australia<'. $from .'>';
    $headers[] 	  = 'Content-Type: text/html; charset=UTF-8';
    $message 	  = get_field('content_email_register_member', 'options');
 	$mail 		  = wp_mail($to, $subject, $message, $headers);
}


/*
function vc_load_more_items() {
	$content = '';

	if(isset($_POST['action']) && strcmp($_POST['action'], "vc_load_more_items") == 0 &&
		isset($_POST['pg']) && strlen($_POST['pg'] ) > 0 ) {

		global $wp_query;
	var_dump($wp_query);
		$args = array(
					'ignore_sticky_posts' 	=> true,
					'paged' 				=> $_POST['pg'],
					'orderby' 				=> 'date',
    				'order'   				=> 'DESC',
    				'paged'					=> 	$_POST['pg']
				);

		if(isset($_POST['tags']) && strlen($_POST['tags']) > 0) { // post_tag
			$args['tax_query'] 	= array(
									array(
										'taxonomy' 	=> 'post_tag',
										'field'    	=> 'name', // slug
										'terms'   	=> $_POST['tags'],
									),
								) ;
		}

		if(isset($_POST['a']) && strlen($_POST['a']) > 0 && $_POST['a'] != 'null') {
			$args['author'] =  $_POST['a'];
		}


		if( isset($_POST['to']) && strlen($_POST['to']) > 0) {
			$args['date_query'] = array(
				'relation' => 'AND',
			    array(
			        'before' => $_POST['to'],
			        'inclusive' => true,
			    )
			);
		}

		if( isset($_POST['from']) && strlen($_POST['from']) > 0) {
			$args['date_query'][] =
			    array(
			        'after' => $_POST['from'],
			        'inclusive' => true,
			);
		}

		query_posts( array_merge( $wp_query->query_vars,  $args ) );

		$res = query_posts( array_merge( $wp_query->query_vars,  $args ) );
		if (have_posts())	: $x = 0;
			while (have_posts())	: the_post();
				$pg_id = get_the_ID();
				$post_ids[] = $pg_id;
				$content .= show_post_small_col($pg_id);
			endwhile;
		endif;

		//var_dump($res);

	}

	$content = ob_get_clean();
	echo json_encode(array('message' => $content ));
    die();
}

add_action( 'wp_ajax_vc_load_more_items', 'vc_load_more_items' );
add_action( 'wp_ajax_nopriv_vc_load_more_items', 'vc_load_more_items' ); */
