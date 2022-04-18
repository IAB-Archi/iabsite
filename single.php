<?php 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 
get_header();

$main_id = get_the_ID();
$post_type_name = get_post_type($main_id);
$tax = get_object_taxonomies($post_type_name); 

if(!empty($tax[1])) { 
	$terms = get_the_terms( $main_id, $tax[1] );
	if ( $terms && ! is_wp_error( $terms ) ) { 
		$tax_ids = array(); $tax_links = '';
		$tax_l = array();
		foreach ( $terms as $term ) {
			$tax_ids[] = $term->term_id;
			$tax_l[] = '<a href="'. $term_link .'" class="tag">'. $term->name .'</a>';
		}

		$tax_links = join( ", ", $tax_l );
	}
}  ?>

<div class="page page-article">
    <div class="container">
        <?php 	echo vc_show_top_slider(); ?>
        <?php	echo vc_show_breadcrumb(); ?>

		<?php  	$type_of_template = get_field('type_of_template'); // full // with-sidebar  ?>

		<?php   switch ($type_of_template) {
					case 'full': ?>
						 <div class="container-small">
				            <?php echo vc_show_title_info($main_id, $tax_links); ?>

				            <?php   $event_date = get_field('event_date'); 
									if(!empty($event_date)) { 
										$date = DateTime::createFromFormat('Ymd', $event_date);  ?>
										<div class="dateev"><i class="far fa-calendar-alt"></i> <?php echo $date->format('l, j F Y'); ?></div>
							<?php  } ?>

							<?php 	$time = get_field('time'); 
									if(!empty($time)) { ?>
										<div class="dateev"><i class="far fa-clock"></i> <?php echo $time; ?></div>
							<?php 	} ?>

							<?php  	$location = get_field('location');
									if(!empty($location)) { ?>
										<div class="dateev"><i class="fas fa-map-marker-alt"></i> <?php echo $location; ?></div>
							<?php 	} ?>
				        </div>
				        <?php 	$featured_image = get_field('featured_image', $main_id);
				               	if($featured_image != 'no' || !isset($featured_image)) {  
				        			$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
									if($img[0]){ ?>
									<div class="featured_image_post">
										<img src="<?php echo $img[0]; ?>" alt="" class="article-img">
									</div>
							<?php	}
								} ?>
				        
				        <div class="container-small">
				        	<article class="long">
				        		<?php  echo vc_show_share($main_id); ?>
				        		<div class="general-content">
					        		<?php 	$content =	vc_show_post_content($main_id); 
					        			   	if(!empty($content)){
					        			   		echo $content;
					        			   	} else {
												if (have_posts()) : while (have_posts()) : the_post();
													the_content();
												endwhile; endif;
					        			   	}	?>
								</div>
				        	</article>
				        	<?php  echo vc_show_post_meta_documents($main_id); ?> 
				        </div><?php 
						break;
					case 'with-sidebar': ?>
						
						<?php echo vc_show_title_info($main_id, $tax_links); ?>
						<div class="flex flex-aside flex-content-mobile">
				            <section>
				            <?php   $event_date = get_field('event_date'); 
									if(!empty($event_date)) { 
										$date = DateTime::createFromFormat('Ymd', $event_date);  ?>
										<div class="dateev"><i class="far fa-calendar-alt"></i> <?php echo $date->format('l, j F Y'); ?></div>
							<?php  } ?>

							<?php 	$time = get_field('time'); 
									if(!empty($time)) { ?>
										<div class="dateev"><i class="far fa-clock"></i> <?php echo $time; ?></div>
							<?php 	} ?>
							
							<?php  	$location = get_field('location');
									if(!empty($location)) { ?>
										<div class="dateev"><i class="fas fa-map-marker-alt"></i> <?php echo $location; ?></div>
							<?php 	} ?>

				               	<article class="long">
				               		<?php  	echo vc_show_share($main_id); ?>
				               		<div class="general-content">
				               			 <?php 	// show featured image
				               			 		$featured_image = get_field('featured_image', $main_id);
				               			 		if($featured_image != 'no' || !isset($featured_image)) {  
					               			 		$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
													if($img[0]){ ?>
													<div class="featured_image_post">
														<img src="<?php echo $img[0]; ?>" alt="" class="article-img article_small">
													</div>
											<?php	} ?>
									<?php	} ?>
						        		<?php 	$content =	vc_show_post_content($main_id); 
						        			   	if(!empty($content) ){
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
				<?php 		
						break;
					default: break;
				}	?>
        <?php  echo vc_show_related_posts($main_id, $post_type_name, $tax[1], $tax_ids); ?>
    </div> 
</div>

<?php get_footer(); ?>