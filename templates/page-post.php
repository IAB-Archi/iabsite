<?php 

/**
 * Template Name: Post Page Template
 */

defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 
get_header();

$main_id = get_the_ID(); ?>

<div class="page page-article">
    <div class="container">
        <?php 	echo vc_show_top_slider(); ?>
        <?php	echo vc_show_breadcrumb(); ?>
 
		<?php echo vc_show_title_info_page($main_id); ?>
		<div class="flex flex-aside">
            <section>
               	<article class="long">
               		<?php  	echo vc_show_share($main_id); ?>
               		<div class="general-content">
               			 <?php 	// show featured image
               			 		$featured_image = get_field('featured_image', $main_id);
               			 		if($featured_image != 'no' || !isset($featured_image)) {  
	               			 		$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
									if($img[0]){ ?>
										<img src="<?php echo $img[0]; ?>" alt="" class="article-img article_small">
							<?php	} ?>
					<?php	} ?>
		        		<?php 	$content =	vc_show_post_content($main_id); 
		        			   	if(!empty($content) && !is_user_logged_in()){
		        			   		echo $content;
		        			   	} else {
									if (have_posts()) : while (have_posts()) : the_post();
										the_content();
									endwhile; endif;
		        			   	}	?>
					</div>
	        	</article>
	        	<?php  echo vc_show_post_meta_documents($main_id); ?>
            </section>
            <?php 	if ( is_active_sidebar( 'primary' ) ) : ?>
            		<aside>
		        		<?php dynamic_sidebar( 'primary' ); ?>
		    		</aside>
		    <?php 	endif; ?>
        </div>
				
    </div> 
</div>

<?php get_footer(); ?>