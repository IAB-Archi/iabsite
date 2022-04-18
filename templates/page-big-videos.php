<?php 
/**
 * Template Name: Big Videos Page Template
 */
 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 
get_header('empty');

$main_id = get_the_ID(); ?>

<?php  $image = get_field('image');
        if(!empty($image)) {  ?>
            <div  class="banner_top" style="background-image: url(<?php echo $image['url']; ?>);"></div>
<?php  } ?>

<div class="page page-article page-small">
    <div class="container-large">
        <article class="long">
            <div class="general-content">
                <?php
                    if( have_rows('content') ):
                        while ( have_rows('content') ) : the_row();
                            if( get_row_layout() == 'videos' ):
                                $title = get_sub_field('title');
                                $videos = get_sub_field('videos'); ?>

                            <div class="section_inner">
                                <h2><?php echo $title; ?></h2>

                                <div class="row box_videos">
                                    <?php foreach($videos as $vid) {
                                            $name = $vid['name']; 
                                            $iframe = $vid['iframe']; ?>

                                            <div class="col_33 box_video">
                                                <h4><?php echo $name; ?></h4>

                                                <div class="box_iframe">
                                                    <?php echo $iframe; ?>
                                                </div>
                                            </div>  

                                    <?php } ?>
                                </div> 
                            </div>

                   <?php    elseif( get_row_layout() == 'mixed' ): 
                                $title_mixed = get_sub_field('title_mixed');
                                $boxes = get_sub_field('boxes'); ?>

                                <div class="section_inner">
                                    <h2><?php echo $title_mixed; ?></h2>

                                    <div class="row box_video">
                                        <?php foreach($boxes as $box) {
                                                 $title = $box['title'];
                                                 $image = $box['image'];
                                                 $button_label = $box['button_label'];
                                                 $button_link = $box['button_link'];
                                                 $video = $box['video'];
                                                 $description = $box['description']; ?>

                                                <div class="col_33 box_video">
                                                    <div class="gray">
                                                        <h4><?php echo $title; ?></h4>
                                                        <?php  if(!empty($image)){ ?>
                                                                    <img src="<?php echo $image['url']; ?>" alt="">
                                                        <?php   } ?>
                                                        <?php  if(!empty($button_link) && !empty($button_label)) { ?>
                                                                    <a href="<?php echo $button_link; ?>" title="" target="_blank" class="btn red"><?php echo $button_label; ?></a>
                                                        <?php   } ?>

                                                        <?php  if(!empty($video)) { ?>
                                                        <div class="box_iframe">
                                                            <p>Video</p>
                                                            <?php echo $video; ?>
                                                            <?php if(!empty($description)) { ?>
                                                                  <div class="desc"><?php echo $description; ?></div>
                                                            <?php  } ?>
                                                        </div>
                                                    <?php  } ?>
                                                    </div>
                                                </div>

                                        <?php  } ?>
                                    </div>
                                </div>  
                               
                     <?php 
                            endif;
                        endwhile;
                    endif; ?>


                      <?php   $sponsored_logos = get_field('sponsored_logos');
                            if(!empty($sponsored_logos)) { ?>
             <div class="section_inner sponsored_logos">
                   
                            <div class="group_sponsors">
                                <?php $sponsored_title_1 = get_field('sponsored_title_1');
                                        if(!empty($sponsored_title_1)){ ?>
                                            <h2><?php echo $sponsored_title_1; ?></h2>
                                <?php  } ?>
                                <div class="icons">
                                    <?php foreach($sponsored_logos as $logo) { ?>
                                                <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>">
                                    <?php  } ?>
                                </div>
                            </div>
                  
                      <?php   $supporting_partners = get_field('sponsored_logos_2');
                            if(!empty($supporting_partners)) { ?>
                            <div class="group_sponsors">
                                <?php $sponsored_title_2 = get_field('sponsored_title_2');
                                        if(!empty($sponsored_title_2)){ ?>
                                            <h2><?php echo $sponsored_title_2; ?></h2>
                                <?php  } ?>
                                <div class="icons">
                                    <?php foreach($supporting_partners as $logo) { ?>
                                                <img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['alt']; ?>">
                                    <?php  } ?>
                                </div>
                            </div>
                    <?php  } ?>

                </div>
              <?php  } ?>
                
            </div>  

          
          
        </article>
    </div>
</div>

<?php get_footer('empty'); ?>