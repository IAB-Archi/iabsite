<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );  ?>

<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title(); ?></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<?php wp_head(); ?>
    <?php   $favicon = get_field('favicon_desktop', 'options');
            if($favicon){ ?>
                <link rel="icon" href="<?php echo $favicon['url']; ?>" type="<?php echo $favicon['mime_type']; ?>"  sizes="50x50">
    <?php   } ?>
    <?php   $favicon_iphone = get_field('favicon_iphone', 'options');
            if($favicon_iphone){ ?>
                <link rel="apple-touch-icon" href="<?php echo $favicon_iphone['url']; ?>"  sizes="60x60">
    <?php   } ?>
    <?php   $favicon_ipad = get_field('favicon_ipad', 'options');
            if($favicon_ipad){ ?>
                <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $favicon_ipad['url']; ?>">
    <?php   } ?>
    <?php   $favicon_iphone_retina = get_field('favicon_iphone_retina', 'options');
            if($favicon_iphone_retina){ ?>
                <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $favicon_iphone_retina['url']; ?>">
    <?php   } ?>
    <?php   $favicon_ipad_retina = get_field('favicon_ipad_retina', 'options');
            if($favicon_ipad_retina){ ?>
                <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $favicon_ipad_retina['url']; ?>">
   <?php    } ?>
     <link rel="gettext" type="application/x-po" href="<?php echo get_template_directory_uri(); ?>/js/languages/en/LC_MESSAGES/en.po" />
</head>
<body <?php if(is_user_logged_in() && current_user_can( 'administrator' )){ echo 'class="user_admin"'; }//body_class(); ?>>
	<header class="<?php  if(is_front_page()){ echo 'transparent'; } ?>">
        <div class="dark">
            <div class="flex">
                <?php   $title_newsletter = get_field('title_newsletter', 'options'); 
                        if(!empty($title_newsletter)) { ?>
                            <a  data-fancybox data-src="#subscribe_newsletter" href="javascript:;" class="link link-white"><?php echo  $title_newsletter; ?></a>
                <?php   } ?>
                <?php echo vc_show_social(); ?>
            </div>
        </div>
        <div class="navigation">
            <div class="flex flex-parent">
                <div class="col">
                    <div class="flex flex-search">
                        <?php   $logo_svg = get_field('logo_svg', 'options');
                                $logo_svg_white = get_field('logo_svg_white', 'options');
                                //if(!empty($logo_svg)) { ?>
                        <a href="<?php echo site_url(); ?>" class="logo">
                            <?php   if(is_front_page()){ ?>
                                        <img src="<?php echo $logo_svg_white['url']; ?>" alt="<?php echo $logo_svg_white['alt']; ?>">
                            <?php   } else { ?>
                                        <img src="<?php echo $logo_svg['url']; ?>" alt="<?php echo $logo_svg['alt']; ?>">
                            <?php   } ?>
                        </a>
                    
                        <div class="search">
                            <form action="<?php echo site_url(); ?>" method="get" autocomplete="off">
                                <input type="text" value="<?php echo  $_GET['s']; ?>" name="s" placeholder="Search">
                                <i class="icon icon-loading"></i>
                                <button type="submit" class="with-icon"></button>
                            </form>
                            <!-- results -->
                            <ul class="search-results"></ul>
                        </div>
                    </div>
                    <div class="search-close"><a href="#" class="icon icon-close"></a></div>
                </div>
                <div class="col">
                    <div class="flex flex-center">
                        <nav>
                            <?php
                                $menu = wp_nav_menu(array(
                                    'theme_location'  => 'header_menu',
                                    'container'       => '',
                                    'menu_class'      => 'parent-ul',
                                    'container_class' => '',
                                    'container_id'    => 'menu',
                                    'echo'            => true,
                                    'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                                    'depth'           => 2
                                )); ?>
                            <a href="#" class="close"></a>
                        </nav>
                        <div class="user">
                            <a href="#" class="user-trigger"><i class="icon icon-user <?php if(!is_front_page()){ echo 'icon-user-red'; } ?>"></i></a>
                        <?php   if(is_user_logged_in()) {  ?>
                                    <div class="user-dropdown authenticated">
                                        <strong>
                                            <i class="icon icon-user icon-user-black"></i>
                                            Hello <span><?php $current_user = wp_get_current_user(); echo $current_user->user_firstname; ?></span>
                                        </strong>
                                        <ul>
                                            <?php   $dashboard_page = get_field('dashboard_page', 'options');
                                                    if(!empty($dashboard_page)) {  ?>
                                                        <li><a href="<?php echo $dashboard_page; ?>" class="btn btn-red">Dashboard</a></li>
                                            <?php   } ?>
                                            <li><a href="<?php echo esc_url( wp_logout_url(home_url('/')) );//echo wp_logout_url( home_url() ); ?>" class="btn btn-outline"><?php _e('Logout', THEME_TEXT_DOMAIN); ?></a></li>
                                        </ul>
                                    </div>
                        <?php  } else { ?>
                                <div class="user-dropdown new">
                                    <strong>
                                        <i class="icon icon-user icon-user-black"></i>
                                        Hello stranger
                                    </strong>
                                    <ul>
                                        <li><a data-fancybox data-src="#login" href="javascript:;" data-options='{"touch" : false}' class="btn btn-red">Login</a></li>
                                        <?php   $register_page = get_field('register_page', 'options');
                                                if(!empty($register_page)){  ?>
                                                    <li><a  data-fancybox data-src="#register" href="javascript:;" data-options='{"touch" : false}' class="btn btn-outline">Register</a></li>
                                                   <?php /* <li><a href="<?php echo $register_page; ?>" class="btn btn-outline">Register</a></li>*/?>
                                        <?php   } ?>
                                    </ul>
                                    <div id="login" style="display: none;" >
                                        <div class="wrapp-login login login-article">
                                            <?php  echo vc_show_login_form(); ?>
                                        </div>
                                        <?php /*
                                        <div class="wrapp-login login login-article">
                                            <h3>Member login</h3>
                                            <form class="custom_login" action="login" id="login_header" method="post">
                                                <p class="status"></p> 
                                                <div class="form-group">
                                                    <input class="username_custom" type="text" name="username" placeholder="Username or Email Address">
                                                </div>
                                                <div class="form-group">
                                                    <input class="password_custom" type="password" name="password" placeholder="Password">
                                                </div>
                                                <div class="form-group forgotten-pass">
                                                    <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a>
                                                </div>
                                                <input class="submit_button" type="submit" value="Login" name="submit">
                                                <?php   wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                                                <?php   $register_page = get_field('register_page', 'options');
                                                        $register_label = get_field('register_label', 'options');
                                                        $join_us_label = get_field('join_us_label', 'options');
                                                        if(!empty($register_page) && !empty($register_label)) {  ?>
                                                        <div class="flex">
                                                            <span><?php echo $register_label; ?></span>
                                                            <a href="<?php echo $register_page; ?>" class="btn btn-outline change-tab"><?php echo $join_us_label; ?></a>
                                                        </div>
                                                <?php  } ?>
                                            </form>
                                        </div>*/?>
                                    </div>
                                </div>
                        <?php  } ?>
                        </div>
                        <?php   if(!is_user_logged_in()) { 
                                    $join_us = get_field('join_us', 'options');
                                    $join_us_label = get_field('join_us_label', 'options');

                                   if(!empty($join_us) && !empty($join_us_label)){  ?>
                                        <a href="<?php echo $join_us; ?>" class="btn btn-red"><?php echo $join_us_label; ?></a>
                            <?php   }  ?>

                                   
                        <?php   } ?>
                        <a href="#" class="icon icon-search"></a>
                        <a href="#" class="burger burger-<?php if(is_front_page()){ echo 'white'; } else { echo 'black'; } ?>">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
	</header>