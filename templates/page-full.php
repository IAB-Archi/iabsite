<?php 
/**
 * Template Name: Full Page Template
 */
 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 
get_header();

$main_id = get_the_ID(); ?>

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
                    <div class="featured_image_post_size_auto">
					<img src="<?php echo $img[0]; ?>" alt="" class="article-img">
                </div>
		<?php	} ?>
        
        <div class="container">
        	<article class="long">
        		<div class="general-content">
	        		<?php 	if (have_posts()) : while (have_posts()) : the_post();?>
								<?php the_content(); ?>
					<?php 	endwhile; endif; ?>
				</div>
        	</article>
        </div>
       
    </div> 
</div>

<?php get_footer(); ?>