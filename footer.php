<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); ?>

    <footer>
        <div class="container">
            <div class="newsletter">
                <div class="flex">
                    <?php   $title_newsletter = get_field('title_newsletter', 'options'); 
                            if(!empty($title_newsletter)) { ?>
                                <a  title="" class="btn red" data-fancybox data-src="#subscribe_newsletter" href="javascript:;"><?php echo $title_newsletter; ?></a>
                    <?php   }     ?>
                    <?php  // echo vc_show_newsletter(); ?>
                </div> 
            </div>
            <div class="navigation">
                <div class="flex flex-parent">
                    <?php   $logo_svg_white = get_field('logo_svg_white', 'options');
                            if(!empty($logo_svg_white)) { ?>
                            <a href="<?php echo site_url(); ?>" class="logo">
                                <img src="<?php echo $logo_svg_white['url'] ?>" alt="<?php echo  $logo_svg_white['alt']; ?>">
                            </a>
                    <?php  } ?>
                    <?php   $footer_text = get_field('footer_text', 'options');
                            if(!empty($footer_text)) {  ?>
                                <p><?php echo $footer_text; ?></p>
                    <?php   } ?>
                    <nav><?php
                                $menu = wp_nav_menu(array(
                                    'theme_location'  => 'footer_menu',
                                    'container'       => '',
                                    'menu_class'      => 'flex',
                                    'container_class' => '',
                                    'container_id'    => 'menu',
                                    'echo'            => true,
                                    'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                                    'depth'           => 1
                                )); ?>
                    </nav>
                </div>
            </div>
            <div class="ending">
                <div class="flex">
                    <?php echo vc_show_social(); ?>
                    <span>
                        <?php   $privacy_policy = get_field('privacy_policy', 'options');
                                if(!empty($privacy_policy)) {  ?>
                                    <a href="<?php echo get_permalink($privacy_policy); ?>"><?php echo get_the_title($privacy_policy); ?></a>
                        <?php   } ?>
                        &copy; <?php echo  auto_copyright(2020); ?> <?php  $copyright = get_field('copyright', 'options'); if(!empty($copyright)){ echo $copyright; } ?>
                    </span>
                </div>
            </div>
        </div>
    </footer>
 <?php  if(!is_user_logged_in()) {  ?>
        <div id="forgot-password" style="display: none;" class="login wrapp-login forgot-form">
            <?php echo vc_show_forgot_password(); ?>
        </div>
        <div id="register" style="display: none" class="login wrapp-login forgot-form">
            <?php  echo vc_register_mautic_user(); ?>
        </div>
<?php   } ?>
        <div id="subscribe_newsletter" style="display: none; width: 500px;" class="login wrapp-login forgot-form">
            <div class="wrapp-login login login-article">
                <div class="wrapp-login newsletter">
                    <?php   $title_newsletter = get_field('title_newsletter', 'options'); 
                            if(!empty($title_newsletter)) { ?>
                                <h3><?php echo $title_newsletter; ?></h3>
                    <?php   }  ?>
                 <?php echo vc_show_newsletter(); ?>
                </div>
            </div>
        </div>
     <input type="hidden" name="current_link" value="<?php 
        global $wp;
        $current_url = home_url(add_query_arg(array(),$wp->request));
        echo  $current_url;  ?>" id="current_link">   
    <?php wp_footer(); ?>
</body>
</html>