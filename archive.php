<?php 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );
get_header(); 
$current_category = get_queried_object();
$term_link = get_term_link($current_category);   

//var_dump($current_category); ?>

<div class="page page-results">
    <div class="container">
        <?php 	echo vc_show_top_slider(); ?>
        <?php	echo vc_show_breadcrumb(); ?>

        <div class="title">
		    <h1><?php 

		    switch ($current_category->name) {
		    	case 'event':
		    		$title = 'Events & Training';
		    		break;
		    	case 'resource':
		    		$title = 'Research & Resources';
		    		break;
		    	case 'guideline':
		    		$title = 'Standards & Guidelines';
		    		break;
		    	case 'regulatory affair':
		    		$title = 'Regulatory Affairs';
		    		break;
		    	case 'news':
		    		$title = 'News & Opinion';
		    		break;
		    	default:
		    		$title = $current_category->label;
		    		break;
		    }

		    echo $title; //$current_category->name; ?></h1>
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

				query_posts( array_merge( $wp_query->query_vars,  $args ) ); ?>
				<?php if (have_posts())	: $x = 0; 
						while (have_posts())	: the_post(); 
							$pg_id = get_the_ID();
							$post_ids[] = $pg_id; 	
						endwhile; ?>
		<?php 	endif;  ?>	

		<?php  	$type_of_page = get_field('type_of_page', $current_category); // list-index masonry-index
				if($type_of_page == "masonry-index") { ?>

					<?php  echo vc_show_filter_form($active_filter, '2'); ?>

					<div class="mason grid results">
			            <div class="grid-sizer"></div>
			            <?php 	foreach($post_ids as $key => $value) {
				            		if($key % 6 == 0) { ?>
				            			<div class="grid-item grid-item-big single_article">
							                <?php echo vc_show_post_image($value); ?>
							            </div>
				            <?php	} else {  ?>
					            		<div class="grid-item single_article">
						                    <?php echo vc_show_post_image($value); ?>
						                </div>
				            <?php 	} ?>
			            <?php 	} ?>
			       </div>

			       <?php if( $wp_query->found_posts > 18) {  ?>
					       <div class="loading-info" data-total="<?php echo $wp_query->found_posts; ?>" data-page="2" >
								<a href="#" title="" class="btn hide_me_click">Load More</a> <i class="icon icon-loading"></i>
								<input type="hidden" id="template" name="template" value="full">
							</div>
					<?php  } ?>

 		<?php	} else { ?>
 				
 				<div class="flex flex-aside">
		            <section>
		                <div class="filter_box">
		                	<?php  echo vc_show_filter_form($active_filter, '2'); ?>
		                </div>
              	
			            <?php if(sizeof($post_ids) > 0 ) {  ?>
							 	<ul class="results"><?php 	
							 		foreach ($post_ids as $pg_id) { ?>
										<li class="single_article">
											<?php echo show_post_small_col($pg_id);  ?>
										</li>
							<?php 	} ?>
								</ul>
							<?php if( $wp_query->found_posts > 18) {  ?>
								<div class="loading-info" data-total="<?php echo $wp_query->found_posts; ?>" data-page="2" data-type="">
									<a href="#" title="" class="btn hide_me_click">Load More</a> <i class="icon icon-loading"></i>
									<input type="hidden" id="template" name="template" value="list">
								</div>
							<?php  } ?>


					<?php  } else { ?>

								<div class="not-found">
									<i class="fas fa-exclamation-triangle"></i>
									<p>No results found.</p>
								</div>

					<?php  } ?>
						
		            </section>
            		<aside>
        			<?php 	$type_of_sidebar = get_field('type_of_sidebar', $current_category); 
        					switch ($type_of_sidebar) {
        					 	case 'standard':
        					 		if ( is_active_sidebar( 'primary' ) ) {
        					 			 dynamic_sidebar( 'primary' ); 
        					 		} 
        					 		break;
        					 	case 'custom':
        					 		//$widgets_sidebar = get_field('widgets_sidebar',  $current_category); 
        					 		echo vc_get_custom_sidebar('widgets_sidebar', $current_category);
        					 		break;
        					 	default: 
        					 		dynamic_sidebar( 'primary' ); 
        					 		break;
        					 } ?>
		        		 
		    		</aside> 
		        </div>
		       

 		<?php	}   ?>

        
    </div>
</div>
<?php echo vc_show_banner(); ?>

<?php get_footer(); ?>