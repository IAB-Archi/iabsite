<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

# Register Portfolio Posts Type


function testimonial() {
	$labels = array(
		'name'                  => _x( 'News', 'Post Type General Name', THEME_TEXT_DOMAIN ),
		'singular_name'         => _x( 'News', 'Post Type Singular Name', THEME_TEXT_DOMAIN ),
		'menu_name'             => __( 'News', THEME_TEXT_DOMAIN ),
		'name_admin_bar'        => __( 'News', THEME_TEXT_DOMAIN),
		'archives'              => __( 'News Archives', THEME_TEXT_DOMAIN ),
		'parent_item_colon'     => __( 'Parent News:', THEME_TEXT_DOMAIN ),
		'all_items'             => __( 'All News', THEME_TEXT_DOMAIN ),
		'add_new_item'          => __( 'Add New News', THEME_TEXT_DOMAIN ),
		'add_new'               => __( 'Add New', THEME_TEXT_DOMAIN ),
		'new_item'              => __( 'New Item', THEME_TEXT_DOMAIN ),
		'edit_item'             => __( 'Edit News', THEME_TEXT_DOMAIN ),
		'update_item'           => __( 'Update News', THEME_TEXT_DOMAIN ),
		'view_item'             => __( 'View News', THEME_TEXT_DOMAIN ),
		'search_items'          => __( 'Search News', THEME_TEXT_DOMAIN ),
		'not_found'             => __( 'Not found', THEME_TEXT_DOMAIN ),
		'not_found_in_trash'    => __( 'Not found in Trash', THEME_TEXT_DOMAIN ),
		'insert_into_item'      => __( 'Insert into News', THEME_TEXT_DOMAIN ),
		'uploaded_to_this_item' => __( 'Uploaded to this News', THEME_TEXT_DOMAIN ),
		'items_list'            => __( 'Items News', THEME_TEXT_DOMAIN ),
		'items_list_navigation' => __( 'News list navigation', THEME_TEXT_DOMAIN ),
		'filter_items_list'     => __( 'Filter items News', THEME_TEXT_DOMAIN ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'news' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'supports'           => array( 'title' ,  'thumbnail' , 'editor',  'custom-fields',  'revisions' , 'author' ), //,  'editor'   
	);

	register_post_type( 'news', $args );

	$labels = array(
		'name'              => _x( 'Category for News', THEME_TEXT_DOMAIN ),
		'singular_name'     => _x( 'Category', THEME_TEXT_DOMAIN ),
		'search_items'      => __( 'Search Category', THEME_TEXT_DOMAIN),
		'all_items'         => __( 'Add Category', THEME_TEXT_DOMAIN  ),
		'parent_item'       => __( 'Parent Category', THEME_TEXT_DOMAIN ),
		'parent_item_colon' => __( 'Parent Category:', THEME_TEXT_DOMAIN ),
		'edit_item'         => __( 'Edit Category', THEME_TEXT_DOMAIN ),
		'update_item'       => __( 'Update Category', THEME_TEXT_DOMAIN ),
		'add_new_item'      => __( 'Add Category', THEME_TEXT_DOMAIN ),
		'new_item_name'     => __( 'Name Category New', THEME_TEXT_DOMAIN ),
		'menu_name'         => __( 'Categories for News', THEME_TEXT_DOMAIN ),
	);

	$args = array(
		'hierarchical'      => true,
		 'public' 			=> true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'has_archive' 		=> false,
		'rewrite'           => array( 'slug' => 'news-and-updates' ),
	);

	register_taxonomy( 'news-and-updates', array( 'news' ), $args ); 


	$labels = array(
		'name'                  => _x( 'Resource', 'Post Type General Name', THEME_TEXT_DOMAIN ),
		'singular_name'         => _x( 'Resource', 'Post Type Singular Name', THEME_TEXT_DOMAIN ),
		'menu_name'             => __( 'Resources', THEME_TEXT_DOMAIN ),
		'name_admin_bar'        => __( 'Resource', THEME_TEXT_DOMAIN),
		'archives'              => __( 'Resources Archives', THEME_TEXT_DOMAIN ),
		'parent_item_colon'     => __( 'Parent Resource:', THEME_TEXT_DOMAIN ),
		'all_items'             => __( 'All Resources', THEME_TEXT_DOMAIN ),
		'add_new_item'          => __( 'Add New Resource', THEME_TEXT_DOMAIN ),
		'add_new'               => __( 'Add New', THEME_TEXT_DOMAIN ),
		'new_item'              => __( 'New Item', THEME_TEXT_DOMAIN ),
		'edit_item'             => __( 'Edit Resource', THEME_TEXT_DOMAIN ),
		'update_item'           => __( 'Update Resource', THEME_TEXT_DOMAIN ),
		'view_item'             => __( 'View Resource', THEME_TEXT_DOMAIN ),
		'search_items'          => __( 'Search Resource', THEME_TEXT_DOMAIN ),
		'not_found'             => __( 'Not found', THEME_TEXT_DOMAIN ),
		'not_found_in_trash'    => __( 'Not found in Trash', THEME_TEXT_DOMAIN ),
		'insert_into_item'      => __( 'Insert into Resource', THEME_TEXT_DOMAIN ),
		'uploaded_to_this_item' => __( 'Uploaded to this Resource', THEME_TEXT_DOMAIN ),
		'items_list'            => __( 'Items Resource', THEME_TEXT_DOMAIN ),
		'items_list_navigation' => __( 'Resources list navigation', THEME_TEXT_DOMAIN ),
		'filter_items_list'     => __( 'Filter items Resource', THEME_TEXT_DOMAIN ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'resource' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'supports'           => array( 'title' ,  'thumbnail' , 'editor',  'custom-fields',  'revisions', 'author' ), //,  'editor'   
	);

	register_post_type( 'resource', $args );

	$labels = array(
		'name'              => _x( 'Category for Resource', THEME_TEXT_DOMAIN ),
		'singular_name'     => _x( 'Category', THEME_TEXT_DOMAIN ),
		'search_items'      => __( 'Search Category', THEME_TEXT_DOMAIN),
		'all_items'         => __( 'Add Category', THEME_TEXT_DOMAIN  ),
		'parent_item'       => __( 'Parent Category', THEME_TEXT_DOMAIN ),
		'parent_item_colon' => __( 'Parent Category:', THEME_TEXT_DOMAIN ),
		'edit_item'         => __( 'Edit Category', THEME_TEXT_DOMAIN ),
		'update_item'       => __( 'Update Category', THEME_TEXT_DOMAIN ),
		'add_new_item'      => __( 'Add Category', THEME_TEXT_DOMAIN ),
		'new_item_name'     => __( 'Name Category New', THEME_TEXT_DOMAIN ),
		'menu_name'         => __( 'Categories for Resources', THEME_TEXT_DOMAIN ),
	);

	$args = array(
		'hierarchical'      => true,
		 'public' 			=> true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'has_archive' 		=> false,
		'rewrite'           => array( 'slug' => 'research-and-resources' ),
	);

	register_taxonomy( 'research-and-resources', array( 'resource' ), $args ); 

	$labels = array(
		'name'                  => _x( 'Guideline', 'Post Type General Name', THEME_TEXT_DOMAIN ),
		'singular_name'         => _x( 'Guideline', 'Post Type Singular Name', THEME_TEXT_DOMAIN ),
		'menu_name'             => __( 'Guidelines', THEME_TEXT_DOMAIN ),
		'name_admin_bar'        => __( 'Guideline', THEME_TEXT_DOMAIN),
		'archives'              => __( 'Guidelines Archives', THEME_TEXT_DOMAIN ),
		'parent_item_colon'     => __( 'Parent Guideline:', THEME_TEXT_DOMAIN ),
		'all_items'             => __( 'All Guidelines', THEME_TEXT_DOMAIN ),
		'add_new_item'          => __( 'Add New Guideline', THEME_TEXT_DOMAIN ),
		'add_new'               => __( 'Add New', THEME_TEXT_DOMAIN ),
		'new_item'              => __( 'New Item', THEME_TEXT_DOMAIN ),
		'edit_item'             => __( 'Edit Guideline', THEME_TEXT_DOMAIN ),
		'update_item'           => __( 'Update Guideline', THEME_TEXT_DOMAIN ),
		'view_item'             => __( 'View Guideline', THEME_TEXT_DOMAIN ),
		'search_items'          => __( 'Search Guideline', THEME_TEXT_DOMAIN ),
		'not_found'             => __( 'Not found', THEME_TEXT_DOMAIN ),
		'not_found_in_trash'    => __( 'Not found in Trash', THEME_TEXT_DOMAIN ),
		'insert_into_item'      => __( 'Insert into Guideline', THEME_TEXT_DOMAIN ),
		'uploaded_to_this_item' => __( 'Uploaded to this Guideline', THEME_TEXT_DOMAIN ),
		'items_list'            => __( 'Items Guideline', THEME_TEXT_DOMAIN ),
		'items_list_navigation' => __( 'Guidelines list navigation', THEME_TEXT_DOMAIN ),
		'filter_items_list'     => __( 'Filter items Guideline', THEME_TEXT_DOMAIN ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'guideline' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'supports'           => array( 'title' ,  'thumbnail' , 'editor',  'custom-fields',  'revisions' , 'author'), //,  'editor'   
	);

	register_post_type( 'guideline', $args );

	$labels = array(
		'name'              => _x( 'Category for Guidelines', THEME_TEXT_DOMAIN ),
		'singular_name'     => _x( 'Category', THEME_TEXT_DOMAIN ),
		'search_items'      => __( 'Search Category', THEME_TEXT_DOMAIN),
		'all_items'         => __( 'Add Category', THEME_TEXT_DOMAIN  ),
		'parent_item'       => __( 'Parent Category', THEME_TEXT_DOMAIN ),
		'parent_item_colon' => __( 'Parent Category:', THEME_TEXT_DOMAIN ),
		'edit_item'         => __( 'Edit Category', THEME_TEXT_DOMAIN ),
		'update_item'       => __( 'Update Category', THEME_TEXT_DOMAIN ),
		'add_new_item'      => __( 'Add Category', THEME_TEXT_DOMAIN ),
		'new_item_name'     => __( 'Name Category New', THEME_TEXT_DOMAIN ),
		'menu_name'         => __( 'Categories for Guidelines', THEME_TEXT_DOMAIN ),
	);

	$args = array(
		'hierarchical'      => true,
		 'public' 			=> true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'has_archive' 		=> false,
		'rewrite'           => array( 'slug' => 'guidelines-and-best-practice' ),
	);

	register_taxonomy( 'guidelines-and-best-practice', array( 'guideline' ), $args ); 

	// services
	/*$labels = array(
		'name'                  => _x( 'Regulatory Affair', 'Post Type General Name', THEME_TEXT_DOMAIN ),
		'singular_name'         => _x( 'Regulatory Affair', 'Post Type Singular Name', THEME_TEXT_DOMAIN ),
		'menu_name'             => __( 'Regulatory Affairs', THEME_TEXT_DOMAIN ),
		'name_admin_bar'        => __( 'Regulatory Affair', THEME_TEXT_DOMAIN),
		'archives'              => __( 'Regulatory Affairs Archives', THEME_TEXT_DOMAIN ),
		'parent_item_colon'     => __( 'Parent Regulatory Affair:', THEME_TEXT_DOMAIN ),
		'all_items'             => __( 'All Regulatory Affairs', THEME_TEXT_DOMAIN ),
		'add_new_item'          => __( 'Add New Regulatory Affair', THEME_TEXT_DOMAIN ),
		'add_new'               => __( 'Add New', THEME_TEXT_DOMAIN ),
		'new_item'              => __( 'New Item', THEME_TEXT_DOMAIN ),
		'edit_item'             => __( 'Edit Regulatory Affair', THEME_TEXT_DOMAIN ),
		'update_item'           => __( 'Update Regulatory Affair', THEME_TEXT_DOMAIN ),
		'view_item'             => __( 'View Regulatory Affair', THEME_TEXT_DOMAIN ),
		'search_items'          => __( 'Search Regulatory Affair', THEME_TEXT_DOMAIN ),
		'not_found'             => __( 'Not found', THEME_TEXT_DOMAIN ),
		'not_found_in_trash'    => __( 'Not found in Trash', THEME_TEXT_DOMAIN ),
		'insert_into_item'      => __( 'Insert into Regulatory Affair', THEME_TEXT_DOMAIN ),
		'uploaded_to_this_item' => __( 'Uploaded to this Regulatorya Affair', THEME_TEXT_DOMAIN ),
		'items_list'            => __( 'Items Regulatory Affair', THEME_TEXT_DOMAIN ),
		'items_list_navigation' => __( 'RegulatoryaAffairs list navigation', THEME_TEXT_DOMAIN ),
		'filter_items_list'     => __( 'Filter items Regulatory Affair', THEME_TEXT_DOMAIN ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'regulatory-affair' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 22,
		'supports'           => array( 'title' ,  'thumbnail' , 'editor',  'custom-fields',  'revisions', 'author' ), //,  'editor'   
	);

	register_post_type( 'regulatory-affair', $args );


	$labels = array(
		'name'              => _x( 'Category for Affair', THEME_TEXT_DOMAIN ),
		'singular_name'     => _x( 'Category', THEME_TEXT_DOMAIN ),
		'search_items'      => __( 'Search Category', THEME_TEXT_DOMAIN),
		'all_items'         => __( 'Add Category', THEME_TEXT_DOMAIN  ),
		'parent_item'       => __( 'Parent Category', THEME_TEXT_DOMAIN ),
		'parent_item_colon' => __( 'Parent Category:', THEME_TEXT_DOMAIN ),
		'edit_item'         => __( 'Edit Category', THEME_TEXT_DOMAIN ),
		'update_item'       => __( 'Update Category', THEME_TEXT_DOMAIN ),
		'add_new_item'      => __( 'Add Category', THEME_TEXT_DOMAIN ),
		'new_item_name'     => __( 'Name Category New', THEME_TEXT_DOMAIN ),
		'menu_name'         => __( 'Categories for Affair', THEME_TEXT_DOMAIN ),
	);

	$args = array(
		'hierarchical'      => true,
		 'public' 			=> true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'has_archive' 		=> false,
		'rewrite'           => array( 'slug' => 'regulatory-affairs' ),
	);

	register_taxonomy( 'regulatory-affairs', array( 'regulatory-affair' ), $args ); */

	/*$labels = array(
		'name'                  => _x( 'Podcast', 'Post Type General Name', THEME_TEXT_DOMAIN ),
		'singular_name'         => _x( 'Podcast', 'Post Type Singular Name', THEME_TEXT_DOMAIN ),
		'menu_name'             => __( 'Podcasts ', THEME_TEXT_DOMAIN ),
		'name_admin_bar'        => __( 'Podcast', THEME_TEXT_DOMAIN),
		'archives'              => __( 'Podcasts  Archives', THEME_TEXT_DOMAIN ),
		'parent_item_colon'     => __( 'Parent Podcast:', THEME_TEXT_DOMAIN ),
		'all_items'             => __( 'All Podcasts ', THEME_TEXT_DOMAIN ),
		'add_new_item'          => __( 'Add New Podcast', THEME_TEXT_DOMAIN ),
		'add_new'               => __( 'Add New', THEME_TEXT_DOMAIN ),
		'new_item'              => __( 'New Item', THEME_TEXT_DOMAIN ),
		'edit_item'             => __( 'Edit Podcast', THEME_TEXT_DOMAIN ),
		'update_item'           => __( 'Update Podcast', THEME_TEXT_DOMAIN ),
		'view_item'             => __( 'View Podcast', THEME_TEXT_DOMAIN ),
		'search_items'          => __( 'Search Podcast', THEME_TEXT_DOMAIN ),
		'not_found'             => __( 'Not found', THEME_TEXT_DOMAIN ),
		'not_found_in_trash'    => __( 'Not found in Trash', THEME_TEXT_DOMAIN ),
		'insert_into_item'      => __( 'Insert into Podcast', THEME_TEXT_DOMAIN ),
		'uploaded_to_this_item' => __( 'Uploaded to this Podcast', THEME_TEXT_DOMAIN ),
		'items_list'            => __( 'Items Podcast', THEME_TEXT_DOMAIN ),
		'items_list_navigation' => __( 'Podcasts list navigation', THEME_TEXT_DOMAIN ),
		'filter_items_list'     => __( 'Filter items Podcast', THEME_TEXT_DOMAIN ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'podcast' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 23,
		'supports'           => array( 'title' ,  'thumbnail' , 'editor',  'custom-fields',  'revisions' ), //,  'editor'   
	);

	register_post_type( 'podcast', $args );*/


	$labels = array(
		'name'                  => _x( 'Event', 'Post Type General Name', THEME_TEXT_DOMAIN ),
		'singular_name'         => _x( 'Event', 'Post Type Singular Name', THEME_TEXT_DOMAIN ),
		'menu_name'             => __( 'Events ', THEME_TEXT_DOMAIN ),
		'name_admin_bar'        => __( 'Event', THEME_TEXT_DOMAIN),
		'archives'              => __( 'Events  Archives', THEME_TEXT_DOMAIN ),
		'parent_item_colon'     => __( 'Parent Event:', THEME_TEXT_DOMAIN ),
		'all_items'             => __( 'All Events ', THEME_TEXT_DOMAIN ),
		'add_new_item'          => __( 'Add New Event', THEME_TEXT_DOMAIN ),
		'add_new'               => __( 'Add New', THEME_TEXT_DOMAIN ),
		'new_item'              => __( 'New Item', THEME_TEXT_DOMAIN ),
		'edit_item'             => __( 'Edit Event', THEME_TEXT_DOMAIN ),
		'update_item'           => __( 'Update Event', THEME_TEXT_DOMAIN ),
		'view_item'             => __( 'View Event', THEME_TEXT_DOMAIN ),
		'search_items'          => __( 'Search Event', THEME_TEXT_DOMAIN ),
		'not_found'             => __( 'Not found', THEME_TEXT_DOMAIN ),
		'not_found_in_trash'    => __( 'Not found in Trash', THEME_TEXT_DOMAIN ),
		'insert_into_item'      => __( 'Insert into Event', THEME_TEXT_DOMAIN ),
		'uploaded_to_this_item' => __( 'Uploaded to this Event', THEME_TEXT_DOMAIN ),
		'items_list'            => __( 'Items Event', THEME_TEXT_DOMAIN ),
		'items_list_navigation' => __( 'Events list navigation', THEME_TEXT_DOMAIN ),
		'filter_items_list'     => __( 'Filter items Event', THEME_TEXT_DOMAIN ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'event' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 24,
		'supports'           => array( 'title' ,  'thumbnail' , 'editor',  'custom-fields',  'revisions', 'author' ), //,  'editor'   
	);

	register_post_type( 'event', $args );


	$labels = array(
		'name'              => _x( 'Category for Event', THEME_TEXT_DOMAIN ),
		'singular_name'     => _x( 'Category', THEME_TEXT_DOMAIN ),
		'search_items'      => __( 'Search Category', THEME_TEXT_DOMAIN),
		'all_items'         => __( 'Add Category', THEME_TEXT_DOMAIN  ),
		'parent_item'       => __( 'Parent Category', THEME_TEXT_DOMAIN ),
		'parent_item_colon' => __( 'Parent Category:', THEME_TEXT_DOMAIN ),
		'edit_item'         => __( 'Edit Category', THEME_TEXT_DOMAIN ),
		'update_item'       => __( 'Update Category', THEME_TEXT_DOMAIN ),
		'add_new_item'      => __( 'Add Category', THEME_TEXT_DOMAIN ),
		'new_item_name'     => __( 'Name Category New', THEME_TEXT_DOMAIN ),
		'menu_name'         => __( 'Categories for Events', THEME_TEXT_DOMAIN ),
	);

	$args = array(
		'hierarchical'      => true,
		 'public' 			=> true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'has_archive' 		=> false,
		'rewrite'           => array( 'slug' => 'events-and-training' ),
	);

	register_taxonomy( 'events-and-training', array( 'event' ), $args ); 

	$labels = array(
		'name'                  => _x( 'Members & Councils', 'Post Type General Name', THEME_TEXT_DOMAIN ),
		'singular_name'         => _x( 'Members & Councils', 'Post Type Singular Name', THEME_TEXT_DOMAIN ),
		'menu_name'             => __( 'Members & Councils', THEME_TEXT_DOMAIN ),
		'name_admin_bar'        => __( 'Members & Councils', THEME_TEXT_DOMAIN),
		'archives'              => __( 'Members & Councils Archives', THEME_TEXT_DOMAIN ),
		'parent_item_colon'     => __( 'Parent Members & Councils:', THEME_TEXT_DOMAIN ),
		'all_items'             => __( 'All Members & Councils', THEME_TEXT_DOMAIN ),
		'add_new_item'          => __( 'Add New Members & Councils', THEME_TEXT_DOMAIN ),
		'add_new'               => __( 'Add New', THEME_TEXT_DOMAIN ),
		'new_item'              => __( 'New Members & Councils', THEME_TEXT_DOMAIN ),
		'edit_item'             => __( 'Edit Members & Councils', THEME_TEXT_DOMAIN ),
		'update_item'           => __( 'Update Members & Councils', THEME_TEXT_DOMAIN ),
		'view_item'             => __( 'View Members & Councils', THEME_TEXT_DOMAIN ),
		'search_items'          => __( 'Search Members & Councils', THEME_TEXT_DOMAIN ),
		'not_found'             => __( 'Not found', THEME_TEXT_DOMAIN ),
		'not_found_in_trash'    => __( 'Not found in Trash', THEME_TEXT_DOMAIN ),
		'insert_into_item'      => __( 'Insert into Members & Councils', THEME_TEXT_DOMAIN ),
		'uploaded_to_this_item' => __( 'Uploaded to this Members & Councils', THEME_TEXT_DOMAIN ),
		'items_list'            => __( 'Members & Councils list', THEME_TEXT_DOMAIN ),
		'items_list_navigation' => __( 'Members & Councils list navigation', THEME_TEXT_DOMAIN ),
		'filter_items_list'     => __( 'Filter Members & Councils list', THEME_TEXT_DOMAIN ),
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'members-and-councils' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 25,
		'supports'           => array( 'title' ,  'thumbnail' , 'editor',  'custom-fields',  'revisions', 'author' ), //,  'editor'   
	);

	register_post_type( 'members-and-councils', $args );

	$labels = array(
		'name'              => _x( 'Category for Members & Councils', THEME_TEXT_DOMAIN ),
		'singular_name'     => _x( 'Category', THEME_TEXT_DOMAIN ),
		'search_items'      => __( 'Search Category', THEME_TEXT_DOMAIN),
		'all_items'         => __( 'Add Category', THEME_TEXT_DOMAIN  ),
		'parent_item'       => __( 'Parent Category', THEME_TEXT_DOMAIN ),
		'parent_item_colon' => __( 'Parent Category:', THEME_TEXT_DOMAIN ),
		'edit_item'         => __( 'Edit Category', THEME_TEXT_DOMAIN ),
		'update_item'       => __( 'Update Category', THEME_TEXT_DOMAIN ),
		'add_new_item'      => __( 'Add Category', THEME_TEXT_DOMAIN ),
		'new_item_name'     => __( 'Name Category New', THEME_TEXT_DOMAIN ),
		'menu_name'         => __( 'Categories for Members & Councils', THEME_TEXT_DOMAIN ),
	);

	$args = array(
		'hierarchical'      => true,
		 'public' 			=> true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'has_archive' 		=> false,
		'rewrite'           => array( 'slug' => 'members-and-councils-categories' ),
	);

	register_taxonomy( 'members-and-councils-categories', array( 'members-and-councils' ), $args );
	
} 
add_action( 'init', 'testimonial', 0 ); 


function reg_tag() {
    register_taxonomy_for_object_type('post_tag', 'resource');
    register_taxonomy_for_object_type('post_tag', 'guideline');
    register_taxonomy_for_object_type('post_tag', 'regulatory-affair');
    register_taxonomy_for_object_type('post_tag', 'event');
    register_taxonomy_for_object_type('post_tag', 'news');
}
add_action('init', 'reg_tag');
