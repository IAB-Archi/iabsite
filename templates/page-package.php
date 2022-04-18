<?php 
/**
 * Template Name: Package Page Template
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
                <?php   $packages = get_field('packages');
                        if(!empty($packages)){  ?>
                        <div class="flex-only flex-row flex-packages">
                            <?php  foreach($packages as $package) { 
                                        $name           = $package['name'];
                                        $price          = $package['price'];
                                        $content        = $package['content'];
                                        $button_label   = $package['button_label'];
                                        $button_link    = $package['button_link']; ?>
                                    <div class="col col-package">
                                        <div class="wrapp-package">
                                            <div class="package-title"><?php echo $name; ?></div>
                                            <?php   if(!empty( $price )){  ?>
                                                        <div class="package-price"><?php  echo $price; ?></div>
                                           <?php    } ?>
                                            <div class="package-button"><?php 
                                                if(!empty($button_label) && !empty( $button_link )) { ?>
                                                    <a href="<?php echo $button_link; ?>" class="btn"><?php echo $button_label; ?></a>
                                     <?php  } ?></div>
                                            <div class="package-content general-content">
                                                <?php  echo $content; ?>
                                            </div>
                                        </div>  
                                    </div>
                            <?php  } ?>
                        </div>
                <?php  } ?>
        	</article>
        </div> 
       
    </div> 
</div>

<?php get_footer(); ?>