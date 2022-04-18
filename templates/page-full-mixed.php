<?php 
/**
 * Template Name: Full Mixed Page Template
 */
 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 
get_header('empty');

$main_id = get_the_ID(); ?>

<div class="page page-article page-small">
    <div class="container">
    	<article class="long">
    		<div class="general-content">
        		<?php 	if (have_posts()) : while (have_posts()) : the_post();?>
							<?php the_content(); ?>
				<?php 	endwhile; endif; ?>

                <div class="mixed_content">

                    <?php  if( have_rows('mixed_content') ):
                            while ( have_rows('mixed_content') ) : the_row();
                                if( get_row_layout() == 'listing_manual_posts' ):
                                    $content_1 = get_sub_field('content_1');
                                    $list_of_posts_1 = get_sub_field('list_of_posts_1'); ?>

                                    <div class="section_listing listing">
                                        <?php  if(!empty($content_1)) { ?>
                                                    <div class="full-text">
                                                        <?php echo $content_1; ?>
                                                    </div>
                                        <?php  } ?>
                                        <div class="listing-items">
                                        <?php  foreach( $list_of_posts_1 as $post_item) {
                                                    $title      = $post_item['title'];
                                                    $subtitle   = $post_item['subtitle'];
                                                    $link       = $post_item['link']; ?>

                                                    <div class="single_item">
                                                        <a href="<?php echo $link; ?>" title="" target="_blank"><?php echo $title; ?></a>
                                                        <p><?php echo $title; ?></p>
                                                    </div>

                                        <?php  } ?>
                                        </div>
                                    </div>
                                  
                    <?php        elseif( get_row_layout() == 'list_articles' ): 
                                    $content_2 = get_sub_field('content_2');
                                    $boxes_2  =  get_sub_field('boxes_2'); ?>

                                    <div class="section_listing listing_box">
                                        <?php  if(!empty($content_2)) { ?>
                                                    <div class="full-text">
                                                        <?php echo $content_2; ?>
                                                    </div>
                                        <?php  } ?>
                                        <div class="row listing-items">
                                            <?php  foreach( $boxes_2 as $post_item) {
                                                        $image          = $post_item['image'];
                                                        $content        = $post_item['content'];
                                                        $button_label   = $post_item['button_label'];
                                                        $button_link    = $post_item['button_link']; ?>

                                                    <div class="col_33 post_item">
                                                        <?php if(!empty($image)) { ?>
                                                            <a href="<?php echo $button_link; ?>" title="">
                                                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                                                            </a>
                                                        <?php } ?>
                                                        <?php   if(!empty($content)) { ?>
                                                                    <p><?php echo $content; ?></p>
                                                        <?php   } ?>
                                                        <a href="<?php echo  $button_link; ?>" target="_blank" title="" class="btn red"><?php echo $button_label; ?></a>
                                                    </div>

                                            <?php  } ?>
                                        </div>
                                    </div>
                    <?php        elseif( get_row_layout() == 'listing_2_columns' ): 
                                    $content_3 = get_sub_field('content_3');
                                    $columns_3 = get_sub_field('columns_3'); ?>

                                    <div class="section_listing listing_box">
                                        <?php  if(!empty($content_3)) { ?>
                                                    <div class="full-text">
                                                        <?php echo $content_3; ?>
                                                    </div>
                                        <?php  } ?>
                                         <div class="row listing-items">
                                            <?php  foreach( $columns_3 as $post_item) {
                                                        $content          = $post_item['content'];  ?>

                                                        <div class="col_50 content_box">
                                                            <?php  echo $content; ?>
                                                        </div>

                                             <?php  } ?>
                                        </div>
                                    </div>
                     <?php      endif;
                            endwhile;

                       
                        endif; ?>
                </div>
			</div>  
    	</article>
    </div>
</div>

<?php get_footer('empty'); ?>