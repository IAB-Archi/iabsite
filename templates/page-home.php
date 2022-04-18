<?php
/**
 * Template Name: Home Page Template
 */
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

get_header(); ?>

<div class="page page-home">
    <?php // include 'php_parts/hero.php'; ?>

    <?php  	$slider = get_field('slider');
    		if(!empty($slider)) {  ?>
    <div class="hero swiper-container">
	    <div class="swiper-wrapper">
	        <?php 	foreach ($slider as $slide){
	        			$image 			= $slide['image'];
	        			$title 			= $slide['title'];
	        			$subtitle 		= $slide['subtitle'];
	        			$button_label 	= $slide['button_label'];
	        			$button_link 	= $slide['button_link'];  ?>
	            <div class="swiper-slide">
	                <div class="hero-wrap">
	                    <div class="hero-slide" style="background-image: url(<?php if(!empty($image)) { echo $image['sizes']['hero']; } ?>);"></div>
	                    <div class="container">
	                        <h2 class="h1"><a href="<?php echo $button_link; ?>"><?php echo $title; ?></a></h2>
	                        <p><?php echo $subtitle; ?></p>
	                        <a href="<?php echo $button_link; ?>" class="btn"><?php echo $button_label; ?></a>
	                    </div>
	                </div>
	            </div>
	        <?php } ?>
	    </div>
	    <div class="swiper-pagination"></div>
	    <div class="hero-button-prev"></div>
	    <div class="hero-button-next"></div>
	</div>
<?php  } ?>

  <?php if( have_rows('home_tile') ): ?>
    <section class="white latest-from-iab latest-post">
      <div class="container">
        <div class="title">
          <div class="flex">
            <div class="col">
              <h2>The latest from IAB</h2>
            </div>
            <div class="col">
            </div>
          </div>
        </div>

        <div class="flex flex-with-article-big">
        <?php while( have_rows('home_tile') ): the_row(); 
        $home_tile_image = get_sub_field( 'home_tile_image' );
        $home_tile_title = get_sub_field( 'home_tile_title' );
        $home_tile_link = get_sub_field( 'home_tile_link' );
        $home_tile_date = get_sub_field( 'home_tile_date' );
        ?>
          <div class="article-preview col-xl-3 col-lg-3 col-md-6 col-sm-12">
            <div class="article-top">
              <?php 
                if ( !empty( $home_tile_image ) ) {
                  if( $home_tile_link ) {
                    $link_url = $home_tile_link['url'];
                    $link_target = $home_tile_link['target'] ? $link['target'] : '_self';
                    echo '<a href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'"><img src="'.esc_url($home_tile_image['url']).'" alt="'.esc_attr($home_tile_image['alt']).'" /></a>';
                  }
                } else {
                  if( $home_tile_link ) {
                    $link_url = $home_tile_link['url'];
                    $link_target = $home_tile_link['target'] ? $home_tile_link['target'] : '_self';
                    echo '<a href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'"><img src="'.get_template_directory_uri().'/img/jpg/n-medium.jpg'.'" /></a>';
                  }
                }
              ?>
              <?php if( $home_tile_title ): ?>
                <h4 class="h4"><?php echo $home_tile_title; ?></h4>
              <?php endif; ?>
              <?php
                if ( $home_tile_date ) {
                  echo '<span class="date">'.$home_tile_date.'</span>';
                }
              ?>
            </div>
            <div class="article-bottom">
            
            <?php           
              if( $home_tile_link ) {
                $link_url = $home_tile_link['url'];
                $link_title = $home_tile_link['title'] ? $home_tile_link['title'] : 'Read More';
                $link_target = $home_tile_link['target'] ? $home_tile_link['target'] : '_self';
                echo '<a class="link" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.esc_html( $link_title ).'</a>';
              } 
            ?>
            
            </div>
          </div>
        <?php endwhile; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

<?php 
    if( have_rows('content') ):
        while ( have_rows('content') ) : the_row();
            if( get_row_layout() == 'posts_in_white_section' ):
                $title_fx1 = get_sub_field('title_fx1');
                $posts_fx1 = get_sub_field('posts_fx1');
                $button_label_fx1 = get_sub_field('button_label_fx1');
                $button_link_fx1  = get_sub_field('button_link_fx1');
                $type_of_post_fx1 = get_sub_field('type_of_post_fx1');
                $post_no_fx1  = get_sub_field('post_no_fx1'); 


                if ( $title_fx1 === 'The latest from IAB' ) {
                  $title_class = 'latest-post';
                } elseif ( $title_fx1 === 'News' ) {
                  $title_class = 'news';
                } elseif ( $title_fx1 === 'IAB Resources' ) {
                  $title_class = 'resources-sec';
                } else {
                  $title_class = 'post-sec';
                }
          
          
                ?>



                <section class="white iab-resource">
                    <div class="container">
                        <?php   echo show_title_button($title_fx1, $button_label_fx1, $button_link_fx1, 'black');  ?>
                        <?php   echo vc_show_post_type( $type_of_post_fx1, $artpost_no_fx1) ; ?>
                    </div>
                </section><?php 

          
            elseif( get_row_layout() == 'posts_in_black_section' ): 
                $title_fx2 = get_sub_field('title_fx2');
                $posts_fx2 = get_sub_field('posts_fx2');
                $button_label_fx2 = get_sub_field('button_label_fx2');
                $button_link_fx2  = get_sub_field('button_link_fx2');
                $type_of_post_fx2 = get_sub_field('type_of_post_fx2');
                $post_no_fx2 = get_sub_field('post_no_fx2'); 
	
				$title_class = $title_fx2 ? 'Recent Articles' : 'News';
				if ( $title_fx2 === 'Recent Articles' ) {
					$title_class = 'recent-articles';
				} elseif ( $title_fx2 === 'News' ) {
					$title_class = 'news';
				} else {
					$title_class = 'post-sec';
				}
			?>
               
	
	
                <section class="dark post-sec <?php echo $title_class; ?>">
                    <div class="container">
                        <?php   echo show_title_button($title_fx2, $button_label_fx2, $button_link_fx2, 'white');  ?>
						<?php 
							if($title_fx2 === 'Recent Articles') {
								echo vc_show_post_type_black($type_of_post_fx2, $post_no_fx2);
							} else {
								echo vc_show_post_type_black_col($type_of_post_fx2, $post_no_fx2);
							} 
						?>
                        <?php   //echo vc_show_post_type_black_col($type_of_post_fx2, $post_no_fx2) ; ?>
                        <?php  /* $first_post = $posts_fx2[0];
                                if(!empty($first_post)) {
                                    echo show_post_big_xxl($first_post->ID);
                                } ?>
                        <?php   if(sizeof($posts_fx2) > 1) { ?>
                                <ul class="flex flex-three">
                                    <?php   for ($i=1; $i < sizeof($posts_fx2); $i++): ?>
                                            <li>
                                                <?php echo show_post_small($posts_fx2[$i]->ID); ?>
                                            </li>
                                    <?php endfor; ?>
                                </ul>
                        <?php  } */ ?>
                    </div>
                </section><?php  


            elseif( get_row_layout() == 'video_posts_in_white_section' ): 
                $title_fx3 = get_sub_field('title_fx3');
               // $posts_fx3 = get_sub_field('posts_fx3');
                $button_label_fx3 = get_sub_field('button_label_fx3');
                $button_link_fx3  = get_sub_field('button_link_fx3');
                $no         = get_sub_field('number_fx3');?>

                <section class="white">
                    <div class="container">
                       <?php   echo show_title_button($title_fx3, $button_label_fx3, $button_link_fx3, 'black');  ?>
                       <?php   echo vc_show_videos($no); ?>
                       <?php /* <ul class="video_articles">
                            <?php   $first_post = $posts_fx3[0];
                                    if(!empty($first_post)) { ?>
                                        <li class="bigger">
                                            <?php  echo show_post_big_video($first_post->ID); ?>
                                        </li>
                            <?php } ?>
                            
                            <li>
                                <ul>
                                    <?php for ($i=1; $i < sizeof($posts_fx3); $i++): ?>
                                        <li>
                                             <?php  echo show_post_big_video($posts_fx3[$i]->ID); ?>
                                            <?php //include 'php_parts/article/article_preview_video.php'; ?>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </li>
                        </ul> */ ?>
                    </div>
                </section>
<?php 
            endif;
        endwhile;
    endif; ?> 
    <?php echo vc_show_banner(); ?>
</div>

<?php get_footer(); ?>