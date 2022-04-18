<?php 
/**
 * Template Name: Listing Page Template
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
					<img src="<?php echo $img[0]; ?>" alt="" class="article-img">
		<?php	} ?>
        
        <div class="container">
        	<article class="long">
        		<div class="general-content">
	        		<?php 	if (have_posts()) : while (have_posts()) : the_post();?>
								<?php the_content(); ?>
					<?php 	endwhile; endif; ?>
				</div>

                <?php   $pages_listing = get_field('pages_listing');
                        if(!empty($pages_listing)){ ?>
                            <ul class="results pages_listing">
                                <?php foreach( $pages_listing as $post): // variable must be called $post (IMPORTANT) ?>
                                    <?php setup_postdata($post); 
                                             $post_id = get_the_ID(); ?>
                                   <li class="single_article">
                                        <div data-id="<?php echo $post_id; ?>" class="article-preview article-preview-h article-preview-large">
                                            <div class="flex">
                                                <div class="col">
                                                    <a href="<?php echo get_permalink($post_id); ?>" class="article-preview-img">
                                                        <?php echo get_featured_img($post_id, "big-post", "img", "", get_bloginfo('template_directory').'/img/jpg/n-big.jpg'); ?>
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <h2 class="h3">
                                                        <a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a>
                                                    </h2>
                                                    <p><?php echo custom_excerpt($post_id);//get_the_excerpt($post_id); ?></p>
                                                    <a href="<?php echo get_permalink($post_id); ?>" class="link"><?php _e('Read more', THEME_TEXT_DOMAIN); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                <?php   } ?>
                 <?php wp_reset_postdata(); ?>
        	</article>
        </div>
       
    </div> 
</div>

<?php get_footer(); ?>