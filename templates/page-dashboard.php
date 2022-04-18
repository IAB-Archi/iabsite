<?php 
/**
 * Template Name: Dashboard Template
 */

defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 

if(!is_user_logged_in()) { 

	header("Location: " . site_url("/") . "error-page/");
	exit();

} else { 
	get_header(); 

	$main_id = get_the_ID();  ?>

	<div class="page page-article">
	    <div class="container">
	        <?php 	echo vc_show_top_slider(); ?>
	        <?php	echo vc_show_breadcrumb(); ?>
			
			<div class="container">
	           	<div class="title">
				    <h1><?php echo get_the_title(); ?></h1>
				</div>
	        </div>
	        <?php 	$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					if($img[0]){ ?>
						<img src="<?php echo $img[0]; ?>" alt="" class="article-img">
			<?php	} ?>
	        
	        <div class="container">
	        	<article class="long">
	        		<div class="general-content">
		        		<?php 	if (have_posts()) : while (have_posts()) : the_post();?>
									<?php the_content(); ?>
						<?php 	endwhile; endif; ?>

						<div class="row group_tabs">
							<div class="col_25 group_tabs_left">
								<div class="my-account-article">
									<div class="user-account">
										<a href="#" title="" data-type="edit" class="active"><i class="fas fa-user-circle"></i> Edit Account</a>
										<a href="#" title="" data-type="password"><i class="fas fa-unlock-alt"></i> Password</a>
										<a href="#" title="" data-type="social"><i class="fas fa-heart"></i> Social</a>
									</div>
								</div>
							</div>
							<div class="col_75 group_tabs_right">
								<div class="tab-edit wrapp_edit_profile active">
									<?php  echo vc_show_edit_profile(); ?>
								</div>
								<div class="tab-password wrapp_edit_profile"> 
									<?php  echo vc_show_password_change(); ?>
								</div>
								<div class="tab-social wrapp_edit_profile">
									<?php  echo vc_edit_social(); ?>
								</div>
							</div>
						</div>
					</div>
	        	</article>
	        </div>
	       
	    </div> 
	</div>

	<?php get_footer();

} ?>