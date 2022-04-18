<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

/**
 * Register and load the widgets
 */
function load_widgets() {
	register_widget( 'Login' );
	register_widget( 'Quote' );
	register_widget( 'Newsletter' );
	register_widget( 'Recent_Posts' );
}
add_action( 'widgets_init', 'load_widgets' );



class Recent_Posts extends WP_Widget {

	public function __construct() {
		parent::__construct(
		'recentpost',
		'Recent_Posts',
		array( 'description' => 'Adds info quote', )
		);
	}

	public function widget( $args, $instance ) {

		$title_recent_posts = get_field('title_recent_posts', 'widget_' . $args['widget_id']);
		$post_type 			= get_field('post_type',  'widget_' . $args['widget_id']);
		$number 			= get_field('number',  'widget_' . $args['widget_id']); ?>

	    <div id="recent-posts-<?php echo $args['widget_id']; ?>" class="widget box box-gray widget_recent_entries">
	    <?php 	if(!empty($title_recent_posts)){ ?>		
	    			<h3 class="widget-title"><?php echo $title_recent_posts; ?></h3>
	    <?php  	} ?>
	    <?php  	$args =  array( 
		            'ignore_sticky_posts' 	=> true, 
		            'post_type'           	=> $post_type,
		            'order'              	=> 'DESC',
		            'post_status' 			=> 'publish',
		            'posts_per_page'		=> $number,
		            
				);   
	    	
	    		$loop = new WP_Query( $args ); 
				if ($loop->have_posts()) {  ?>
					<ul>
					<?php  
						while ($loop->have_posts())	{  
							$loop->the_post();
							$post_id = get_the_ID(); ?>
							<li>
								<a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
							</li>

					<?php }	?>
					</ul>
			<?php }	?>
			<?php wp_reset_query(); ?>			
		</div>
		<?php
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
		//$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}

class Newsletter extends WP_Widget {

	public function __construct() {
		parent::__construct(
		'newsletter',
		'Newsletter',
		array( 'description' => 'Adds info quote', )
		);
	}

	public function widget( $args, $instance ) {

		$title 		= get_field('title', 'widget_' . $args['widget_id']);
		$subtitle 	= get_field('subtitle',  'widget_' . $args['widget_id']);
		//$shortcode 	= get_field('shortcode',  'widget_' . $args['widget_id']); ?>

	    <div class="box box-gray box-gray-dark">
	    	<?php  	if(!empty($title)) {  ?>
	        			<h3><?php echo $title; ?></h3>
	    	<?php  	} ?>
	    	<?php 	if(!empty($subtitle)) {  ?>
	        		 	<p><?php echo $subtitle; ?></p>
	    	<?php  } ?>

		<?php   $mautic_code_newsletter = get_field('mautic_code_newsletter', 'options');
				if(!empty($mautic_code_newsletter)) { ?>
				<div class="subscribe_newsletter subscribe_newsletter_mautic">
					<?php echo $mautic_code_newsletter; ?>
				</div>
		<?php 	} ?>

	    	<?php /*
	    	<form method="POST" action="#" class="subscribe_newsletter">
		        <input type="email" name="newsletter" class="outline" placeholder="Email address">
		        <button type="submit" class="with-icon">
		            <i class="icon icon-check"></i>
		        </button>
		        <div class="submit-form">
		            <i class="icon icon-loading"></i>
		        </div>
		        <span class="newsletter-message"></span>
            </form>*/?>
	          
	        <?php  //echo do_shortcode($shortcode); ?>
	    </div>


		<?php
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
		//$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}

class Quote extends WP_Widget {

	public function __construct() {
		parent::__construct(
		'quote',
		'Quote',
		array( 'description' => 'Adds info quote', )
		);
	}

	public function widget( $args, $instance ) {

		$quote 	= get_field('quote', 'widget_' . $args['widget_id']);
		$name 	= get_field('name',  'widget_' . $args['widget_id']);
		$link 	= get_field('link',  'widget_' . $args['widget_id']); ?>

		<div class="box box-gray aside-blockquote">
	        <blockquote class="h3"><?php echo $quote; ?></blockquote>
	        <a href="<?php echo $link; ?>" title=""><small><?php echo $name; ?></small></a>
	    </div>

		<?php
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		/*?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: '); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<?php */
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
		//$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}

class Login extends WP_Widget {

	public function __construct() {
		parent::__construct(
		'login',
		'Login',
		array( 'description' => 'Adds info Login', )
		);
	}

	public function widget( $args, $instance ) { ?>

		<div class="login login-article">
		<?php 
				if(!is_user_logged_in()) { 
					echo vc_show_login_form(); 
				} else { ?>

			 <div class="wrapp-login">
        		<h3>Member login</h3>
				<div class="user-logged">
					<h6><i class="icon icon-user icon-user-black"></i>
                        Hi <?php $current_user = wp_get_current_user(); echo $current_user->user_firstname; ?>,</h6>
					<p>Welcome back to IAB. Click here to go to your <a href="<?php $dashboard = get_field('dashboard_page', 'options'); if(!empty($dashboard)) { echo $dashboard; } else { echo '#'; } ?>" class="link-item">IAB Dashboard</a>.</p>
					<a href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>" class="btn btn-outline">Log out</a>
				</div>
			</div>

		<?php 	} /*
			<h3>Member login</h3>
			<?php echo do_shortcode('[ajax-login]'); ?>
			<?php  if($_GET['action'] == "lostpassword") { ?>
						<div class="flex loginfp">
					        <a href="<?php echo get_permalink(); ?>#frm_user_signin">Existing Member?</a>
					    </div>
			<?php  } ?>

			 <?php  $register_page = get_field('register_page', 'options');
                    $register_label = get_field('register_label', 'options');
                    $join_us_label = get_field('join_us_label', 'options');
                    if(!empty($register_page) && !empty($register_label)) {  ?>
                    <div class="flex">
                        <span><?php echo $register_label; ?></span>
                        <a href="<?php echo $register_page; ?>" class="btn btn-outline change-tab"><?php echo $join_us_label; ?></a>
                    </div>
            <?php  } ?>*/?>
		</div>
		<?php /*
		<div class="login login-article register">
	    	<h3>Member Register</h3>
	    	<?php echo do_shortcode('[ajax-registration]'); ?>
	    	<div class="flex loginfp">
		        <a href="#login" class="change-tab">Existing Member?</a>
		    </div>
	    </div>*/ ?>
		<?php
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		/*?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: '); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<?php */
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
		//$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}


function vc_get_custom_sidebar($widgets_sidebar, $current_category) {
	ob_start();  
	if( have_rows($widgets_sidebar, $current_category) ):
	    while ( have_rows($widgets_sidebar, $current_category) ) : the_row();
	        if( get_row_layout() == 'login' ): ?>
	            <div class="login login-article"><?php 
						if(!is_user_logged_in()) { 
							echo vc_show_login_form(); 
						} else { ?>
							<div class="wrapp-login">
				        		<h3>Member login</h3>
								<div class="user-logged">
									<h6><i class="icon icon-user icon-user-black"></i>
				                        Hi <?php $current_user = wp_get_current_user(); echo $current_user->user_firstname; ?>,</h6>
									<p>Welcome back to IAB. Click here to go to your <a href="<?php $dashboard = get_field('dashboard_page', 'options'); if(!empty($dashboard)) { echo $dashboard; } else { echo '#'; } ?>" class="link-item">IAB Dashboard</a>.</p>
									<a href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>" class="btn btn-outline">Log out</a>
								</div>
							</div>
					<?php } ?>
				</div><?php 

	        elseif( get_row_layout() == 'newsletter' ):
	        	$title = get_sub_field('title_newsletter');
	        	$subtitle = get_sub_field('subtitle_newsletter'); ?>
			            
			    <div class="box box-gray box-gray-dark">
			    	<?php  	if(!empty($title)) {  ?>
			        			<h3><?php echo $title; ?></h3>
			    	<?php  	} ?>
			    	<?php 	if(!empty($subtitle)) {  ?>
			        		 	<p><?php echo $subtitle; ?></p>
			    	<?php  } ?>
			        <form method="POST" action="#" class="subscribe_newsletter">
				        <input type="email" name="newsletter" class="outline" placeholder="Email address">
				        <button type="submit" class="with-icon">
				            <i class="icon icon-check"></i>
				        </button>
				        <div class="submit-form">
				            <i class="icon icon-loading"></i>
				        </div>
				        <span class="newsletter-message"></span>
		            </form>
			    </div><?php 
	            
	        elseif( get_row_layout() == 'custom_content' ): 
	        	$content_widget = get_sub_field('content_widget');
	        	$author_widget = get_sub_field('author_widget');
	        	$page_link_widget = get_sub_field('page_link_widget'); ?>

				<div class="box box-gray aside-blockquote">
			        <blockquote class="h3"><?php echo $content_widget; ?></blockquote>
			        <a href="<?php echo $page_link_widget; ?>" title=""><small><?php echo $author_widget; ?></small></a>
			    </div>

	       
	<?php  elseif( get_row_layout() == 'last_posts' ): 
	        	$title_last_post 	= get_sub_field('title_last_post');
	        	$type_of_posts  	= get_sub_field('type_of_posts'); 
	        	$number 			= get_sub_field('number'); ?>

	        	<div class="widget box box-gray widget_recent_entries">
			    <?php 	if(!empty($title_last_post)){ ?>		
			    			<h3 class="widget-title"><?php echo $title_last_post; ?></h3>
			    <?php  	} ?>
			    <?php  	$args =  array( 
				            'ignore_sticky_posts' 	=> true, 
				            'post_type'           	=> $type_of_posts,
				            'order'              	=> 'DESC',
				            'post_status' 			=> 'publish',
				            'posts_per_page'		=> $number,
				            
						);   
			    	
			    		$loop = new WP_Query( $args ); 
						if ($loop->have_posts()) {  ?>
							<ul>
							<?php  
								while ($loop->have_posts())	{  
									$loop->the_post();
									$post_id = get_the_ID(); ?>
									<li>
										<a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
									</li>

							<?php }	?>
							</ul>
					<?php }	?>
					<?php wp_reset_query(); ?>			
				</div>
    <?php
	        endif;
	    endwhile;
	endif;

	$content = ob_get_clean();  
	return $content;
}