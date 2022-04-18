<?php 
/**
 * Template Name: Event Page Template
 */
 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 
get_header('empty');

$main_id = get_the_ID(); ?>

<?php  $image = get_field('image');
        if(!empty($image)) {  ?>
            <div  class="banner_top" style="background-image: url(<?php echo $image['url']; ?>);"></div>
<?php  } ?>

<div class="page page-article page-small">
    <div class="container">
        <article class="long">
            <div class="general-content">

                <div class="box_tabs">
                        <a href="#overview" class="item_tab active">Overview</a>
                        <a href="#agenda" class="item_tab">Agenda</a>
                        <a href="#team" class="item_tab">Speakers</a>
                        <a href="<?php $tickets_link = get_field('tickets_link'); if(!empty($tickets_link)){ echo $tickets_link; } else { echo '#'; }?>" class="" rel="noopener noreferrer" target="_blank">Tickets </a>
                </div>

                <div class="section-tab active" id="overview">
                    <?php 
                    if( have_rows('overview') ):
                        while ( have_rows('overview') ) : the_row();
                            if( get_row_layout() == 'content' ):
                                $content = get_sub_field('content'); ?>
                             
                           <div class="section_inner general_content">
                                <?php echo $content; ?>
                            </div>

                    <?php    elseif( get_row_layout() == 'videos' ): 
                                $content_videos = get_sub_field('content_videos');
                                $videos = get_sub_field('videos'); ?>

                                <div class="section_inner general_content">
                                    <?php echo $content_videos; ?>

                                    <?php if(!empty( $videos )) { ?>
                                    <div class="row">
                                        <?php foreach( $videos as $vid )  {  ?>
                                                <div class="col_33 box_vid">
                                                    <p><?php echo $vid['title']; ?></p>
                                                    <div class="iframe_video">
                                                        <?php echo $vid['video']; ?>
                                                    </div>
                                                </div>
                                        <?php  } ?>
                                    </div>
                                <?php  } ?>
                                </div>
                                
                    <?php     endif;
                        endwhile;
                    endif; 
                    ?>
                </div> 

                <div class="section-tab" id="agenda">
                    <?php   $agenda = get_field('agenda'); 
                            if(!empty($agenda)) { ?>
                                <div class="times">
                                    <?php foreach($agenda as $agd) {
                                            $hour = $agd['hour'];
                                            $events = $agd['events']; ?>
                                                <div class="group-time">
                                                    <div class="group-time-title"><?php echo $hour; ?></div>
                                                    <div class="group-time-items">
                                                    <?php foreach ($events as $ev_box) {
                                                                $hour = $ev_box['hour']; 
                                                                $content = $ev_box['content']; ?>

                                                            <div class="flex-only flex-row flex-wrap">
                                                                <div class="col_20 time"><span><?php echo $hour; ?></span></div>
                                                                <div class="col_80 text">
                                                                    <?php echo $content; ?>
                                                                </div>
                                                            </div>
                                                        
                                                   <?php } ?>
                                                    </div>
                                                </div>
                                    <?php  } ?>
                                </div>
                    <?php   } ?>
                </div>

                <div class="section-tab" id="team">
                    <?php   $title_speakers = get_field('title_speakers');
                            if(!empty($title_speakers)) { ?>
                                <div class="colored_box"><h2 class="centred"><?php echo $title_speakers; ?></h2></div>
                    <?php   } ?>
                    <?php   $members =  get_field('members');
                            if(!empty($members)) { ?>
                            <div class="row">
                                <?php foreach($members as $mb) { 
                                        $image      = $mb['image'];
                                        $name       = $mb['name'];
                                        $occupation = $mb['occupation']; ?>
                                        <div class="col_25 box_mb">
                                            <div class="bg_img" style="background-image: url(<?php echo $image['url']; ?>);"></div>
                                            <p class="name"><?php echo $name; ?></p>
                                            <p class="occupation"><?php echo $occupation; ?></p>
                                        </div>
                                <?php  } ?>
                            </div>
                    <?php   } ?>
                </div>

                <div class="sponsored_logos">
                    <?php   $sponsored_logos = get_field('sponsored_logos');
                            if(!empty($sponsored_logos)) { ?>
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
                    <?php  } ?>
                      <?php   $supporting_partners = get_field('supporting_partners');
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
          
                
            </div>  
        </article>
    </div>
</div>

<?php get_footer('empty'); ?>