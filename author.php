<?php 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );
get_header(); ?>

<div class="page page-results">
    <div class="container">
        <?php 	echo vc_show_top_slider(); ?>
        <?php	echo vc_show_breadcrumb(); ?>

        <div class="title">
		    <h1><?php echo get_the_author(); _e(' Author Archive', THEME_TEXT_DOMAIN);  ?></h1>
		</div>
		<div class="flex flex-aside">
            <section>
             	<?php 	global $wp_query;
						$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
						query_posts( array_merge( $wp_query->query_vars, array( 'ignore_sticky_posts' => true, 'paged' => $paged) ) );?>
						<?php if (have_posts())	: $x = 0; 
								while (have_posts())	: the_post(); 
									$pg_id = get_the_ID();
									$post_ids[] = $pg_id; 	
								endwhile; ?>
				<?php 	endif; ?>
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
    </div>
</div>
<?php echo vc_show_banner(); ?>

<?php get_footer(); ?>