 <?php 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );
get_header(); 
$current_category = get_queried_object();
$term_link = get_term_link($current_category);
$post_ids = array();   ?>

<div class="page page-results">
    <div class="container">
        <?php 	echo vc_show_top_slider(); ?>
        <?php	echo vc_show_breadcrumb(); ?>

        <div class="title">
		    <h1><?php  echo $current_category->name; ?></h1>
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
            				//'order'   				=> 'ASC',
            				'meta_key'  			=> 'event_date',
    						'orderby'   			=> 'meta_value_num',
						);

				if($current_category->term_id == 18) { // latest post
					$args['order'] = 'ASC';
				} else {
					$args['order'] = 'DESC';
				}	

				if(isset($_GET['tags']) && strlen($_GET['tags']) > 0) { // post_tag
					$args['tax_query'] 	= array(
											array(
												'taxonomy' 	=> 'post_tag',
												'field'    	=> 'name', // slug
												'terms'   	=> $_GET['tags'],
											),
										) ;
					$active_filter 	= true;
				}

				//event_date
				if( isset($_GET['from']) && strlen($_GET['from']) > 0) {
					$active_filter 	= true;
					$new_to = str_replace("-", "", $_GET['from']);
					$args['meta_query'] = array(
						'relation' => 'AND',
						array(
				            'key'     => 'event_date',
				            'compare' => '>=',
				            'value'   => $new_to,
				        ),
					);
					
				}

				if( isset($_GET['to']) && strlen($_GET['to']) > 0) {
					$active_filter 	= true;
					$new_from = str_replace("-", "", $_GET['to']);
					$args['meta_query'][] = 
						array(
				            'key'     => 'event_date',
				            'compare' =>  '<=',
				            'value'   => $new_from,
						);
				}

				$res = query_posts( array_merge( $wp_query->query_vars,  $args ) );  ?>
				<?php if (have_posts())	: $x = 0; 
						while (have_posts())	: the_post(); 
							$pg_id = get_the_ID();
							$post_ids[] = $pg_id; 	
						endwhile; ?>
		<?php 	endif; ?>	

		<?php  if( $current_category->count >= 1) { 
					$type_of_page = get_field('type_of_page', $current_category); //list-index masonry-index
					if($type_of_page == "masonry-index") { ?>

						<?php  echo  vc_show_filter_form_events($active_filter, $current_category); ?>

						<div class="mason grid results">
				            <div class="grid-sizer"></div>
				            <?php 	foreach($post_ids as $key => $value) {
					            		if($key % 6 == 0) { ?>
					            			<div class="grid-item grid-item-big single_article">
								                <?php echo show_post_small_col_event_image($value); ?>
								            </div>
					            <?php	} else {  ?>
						            		<div class="grid-item single_article">
							                    <?php echo show_post_small_col_event_image($value); ?>
							                </div>
					            <?php 	} ?>
				            <?php 	} ?>
				        </div>
				        <?php 	if($current_category->count >= 18) { ?> 
						        <div class="loading-info" data-total="<?php echo $wp_query->found_posts; ?>" data-page="2" >
									<a href="#" title="" class="btn hide_me_click">Load More</a> <i class="icon icon-loading"></i>
									<input type="hidden" id="template" name="template" value="full">
									<input type="hidden" id="type_event" name="type_event" value="events">
								</div>
						<?php  	} ?>
					

	 		<?php	} else { ?>

	 				<div class="flex flex-aside">
			            <section>
			                <div class="filter_box">
			                	<?php  echo  vc_show_filter_form_events($active_filter, $current_category); ?>
			                </div>

	              	<?php 	if(sizeof($post_ids) > 0) {  ?>
							 	<ul class="results"><?php 	
							 		foreach ($post_ids as $pg_id) { ?>
										<li class="single_article">
											<?php 	echo show_post_small_col_event($pg_id);  ?>
										</li>
							<?php 	} ?>
								</ul>

							<?php 	if($current_category->count >= 18) { ?>
									<div class="loading-info" data-total="<?php echo $wp_query->found_posts; ?>" data-page="2" data-type="">
										<a href="#" title="" class="btn hide_me_click">Load More</a> <i class="icon icon-loading"></i>
										<input type="hidden" id="template" name="template" value="list">
										<input type="hidden" id="type_event" name="type_event" value="events">
									</div>
							<?php  } ?>

					 <?php  } else { ?>
								
								<div class="not-found">
									<i class="fas fa-exclamation-triangle"></i>
									<p>No results found.</p>
								</div>

					<?php  	} ?>
			            </section>
			            <?php 	if ( is_active_sidebar( 'primary' ) ) : ?>
			            		<aside>
					        		<?php dynamic_sidebar( 'primary' ); ?>
					    		</aside>
					    <?php 	endif; ?>
			        </div>
			       
			    <?php	}   ?>    
 		<?php	}   ?>

        
    </div>
</div>
<?php echo vc_show_banner(); ?>

<?php get_footer(); ?>