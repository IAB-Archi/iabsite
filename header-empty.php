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
	