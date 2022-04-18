<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

# register navigation menus
function register_navigation_menus() {
	register_nav_menu( 'header_menu', 'Header menu' );
	register_nav_menu( 'footer_menu', 'Footer menu' );
}
add_action( 'after_setup_theme', 'register_navigation_menus' );