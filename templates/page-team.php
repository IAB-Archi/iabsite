<?php 
/**
 * Template Name: Team Page Template
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

                <?php   $team = get_field('team');
                        if(!empty($team)) { ?>
                            <div class="team">
                                <?php  foreach($team as $mb) {
                                            $name = $mb['name'];
                                            $occupation = $mb['occupation'];
                                            $image = $mb['image'];
                                            $content = $mb['content'];  ?>

                                            <div class="flex">
                                                <div class="col col-img">
                                                    <img src="<?php if(!empty($image)) { echo $image['sizes']['team']; } ?>" alt="<?php echo $image['alt']; ?>">
                                                </div>
                                                <div class="col col-text">
                                                    <?php   if(!empty($name)) {  ?>
                                                                <p class="name"><?php echo $name; ?></p>
                                                    <?php   } ?>
                                                    <?php   if(!empty($occupation)) {  ?>
                                                                <p class="occ"><?php echo $occupation; ?></p>
                                                    <?php   }  ?>

                                                    <div class="general-content">
                                                        <?php  echo  $content; ?>
                                                    </div>
                                                </div>
                                            </div>

                                <?php  } ?>
                            </div>
                <?php   } ?>
        	</article>
        </div>
       
    </div> 
</div>

<?php get_footer(); ?>