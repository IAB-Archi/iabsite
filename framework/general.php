<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

/**
 * Theme Setup
 */
function theme_setup() {
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support('post-thumbnails'); // size name: post-thumbnail
	set_post_thumbnail_size(1400, 475, true);
}
add_action( 'after_setup_theme', 'theme_setup' );


