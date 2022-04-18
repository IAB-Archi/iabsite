<?php 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );
get_header(); 
$current_category = get_queried_object();
$term_link = get_term_link($current_category); ?>

<div class="page page-results">
    <div class="container">
        <?php 	echo vc_show_top_slider(); ?>
        <?php	echo vc_show_breadcrumb(); ?>

        <div class="title">
		    <h1><?php if ( is_404() || is_category() || is_tag() || is_day() || is_month() || is_year() || is_search() ) { ?>
				<?php /* If this is a category archive */ if (is_category()) { ?>
					<?php single_cat_title(); ?>
				<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
					<?php  _e('Tag: ', THEME_TEXT_DOMAIN); single_tag_title(); ?>
				<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
					<?php the_time('F jS, Y'); _e(' Archives ', THEME_TEXT_DOMAIN); ?> 
				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
					<?php the_time('F, Y'); _e(' Archives ', THEME_TEXT_DOMAIN); ?>  
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
					<?php the_time('Y'); _e(' Archives ', THEME_TEXT_DOMAIN); ?> 
				<?php /* If this is an author archive */ } elseif (is_author()) { 
					_e('Author Archive ', THEME_TEXT_DOMAIN);	?>
				<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { 
					_e('Blog Archives ', THEME_TEXT_DOMAIN);	?>
				<?php } elseif( is_search() )	{ ?>
					<?php _e('Results for: ', THEME_TEXT_DOMAIN); the_search_query() ?>
				<?php } ?>
			<?php } else { ?>
				 <?php _e('Blog ', THEME_TEXT_DOMAIN); if ( $paged ) {echo  _e(' - Page ', THEME_TEXT_DOMAIN). $paged; } ?>
			<?php } ?></h1>
		</div>

		<?php   $description = $current_category->description;
				if(!empty($description)) { ?>
					<div class="mb general-content">
						<?php echo $description; ?>
					</div>
		<?php	}	?>

        <?php 	global $wp_query;
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
				$active_filter 	= false;
				$args = array( 
							'ignore_sticky_posts' 	=> true, 
							'paged' 				=> $paged,
							'orderby' 				=> 'date',
            				'order'   				=> 'DESC',
						);

				// if(isset($_GET['tag']) && strlen($_GET['tag'])) {
				// 	$args[ 'tag'] = $_GET['tag']; 
				// }

				if(isset($_GET['tags']) && strlen($_GET['tags']) > 0) { // post_tag
					//$args[ 'tag'] = $_GET['tags'];
					$args['tax_query'] 	= array(
											array(
												'taxonomy' 	=> 'post_tag',
												'field'    	=> 'name', // slug
												'terms'   	=> $_GET['tags'],
											),
										) ;
					$active_filter 	= true;
				}

				if( isset($_GET['to']) && strlen($_GET['to']) > 0) {
					$active_filter 	= true;
					$args['date_query'] = array(
						'relation' => 'AND',
					    array(
					        'before' => $_GET['to'],
					        'inclusive' => true,
					    )
					);
				}

				if( isset($_GET['from']) && strlen($_GET['from']) > 0) {
					$active_filter 	= true;
					$args['date_query'][] = 
					    array(
					        'after' => $_GET['from'],
					        'inclusive' => true,
					);
				}


				query_posts( array_merge( $wp_query->query_vars,  $args ) );?>
				<?php if (have_posts())	: $x = 0; 
						while (have_posts())	: the_post(); 
							$pg_id = get_the_ID();
							$post_ids[] = $pg_id; 	
						endwhile; ?>
		<?php 	endif; ?>	

		<?php  	$type_of_page = get_field('type_of_page', $current_category);
				if($type_of_page == "masonry-index") { ?>

					<div class="mason grid">
			            <div class="grid-sizer"></div>

			            <?php 	foreach($post_ids as $key => $value) {
				            		if($key % 6 == 0) { ?>
				            			<div class="grid-item grid-item-big">
							                <?php echo vc_show_post_image($value); ?>
							            </div>
				            <?php	} else {  ?>
					            		<div class="grid-item">
						                    <?php echo vc_show_post_image($value); ?>
						                </div>
				            <?php 	} ?>
			            <?php 	} ?>
			        </div>

			        <div class="page-navigation"><?php
							global $wp_query;
							$big = 999999999; 
							echo paginate_links( array(
								'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' 		=> '?paged=%#%',
								'current' 		=> max( 1, get_query_var('paged') ),
								'total' 		=> $wp_query->max_num_pages,
								'type' 			=> 'plain',
								'prev_next'    	=> True,
								'prev_text'    	=> "«" ,
								'next_text'    	=> "»" 
									
							) );
						?>
					</div>	

 		<?php	} else { ?>

 				<div class="flex flex-aside">
		            <section>
		                <div class="filter_box">
		                	<?php  echo vc_show_filter_form($active_filter, '2'); ?>
		                </div>
		                <?php 	if(sizeof($post_ids) > 0) {  ?>
								 	<ul><?php 	
								 		foreach ($post_ids as $pg_id) { ?>
											<li>
												<?php echo show_post_small_col($pg_id);  ?>
											</li>
								<?php 	} ?>
									</ul>
									<div class="page-navigation"><?php
											global $wp_query;
											$big = 999999999; 
											echo paginate_links( array(
												'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
												'format' 		=> '?paged=%#%',
												'current' 		=> max( 1, get_query_var('paged') ),
												'total' 		=> $wp_query->max_num_pages,
												'type' 			=> 'plain',
												'prev_next'    	=> True,
												'prev_text'    	=> "«" ,
												'next_text'    	=> "»" 
													
											) );
										?>
									</div>	
						<?php  } else { ?>
									<?php // no posts ?>
						<?php  } ?>
		            </section>
		            <?php 	if ( is_active_sidebar( 'primary' ) ) : ?>
		            		<aside>
				        		<?php dynamic_sidebar( 'primary' ); ?>
				    		</aside>
				    <?php 	endif; ?>
		        </div>

 		<?php	}   ?>

        
    </div>
</div>
<?php echo vc_show_banner(); ?>

<?php get_footer(); ?>