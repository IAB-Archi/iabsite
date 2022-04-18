<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

/**
 * This is required for $_SESSION variables to work.
 */
// session_start();

define('THEME_TEXT_DOMAIN', 'iab');

/**
 * FRAMEWORK
 */

# General theme setup,
require_once TEMPLATEPATH . '/framework/general.php';
require_once TEMPLATEPATH . '/framework/utilities.php';
# Register Enqueue
require_once TEMPLATEPATH . '/framework/enqueue.php';
# Register Post Type
require_once TEMPLATEPATH . '/framework/post-types.php';
# Register navigation menus
require_once TEMPLATEPATH . '/framework/navigation.php';
# Theme security
require_once TEMPLATEPATH . '/framework/security.php';
# Settings page
require_once TEMPLATEPATH . '/framework/processing.php';
# Settings page
require_once TEMPLATEPATH . '/framework/settings.php';
#widgets
require_once TEMPLATEPATH . '/framework/widgets.php';

require_once TEMPLATEPATH . '/framework/mautic.php';

require_once TEMPLATEPATH . '/framework/encrypts.php';

require_once TEMPLATEPATH . '/framework/dashboard.php';
require_once TEMPLATEPATH . '/framework/user_signup.php';

// Ajax
function add_localize_script()  {
?>
<script type="text/javascript">
		var jsHomeUrl = '<?php echo home_url(); ?>';
		var ajaxUrl = "<?php echo admin_url( 'admin-ajax.php' ) ?>";
</script>
<?php
}
add_action('wp_head', 'add_localize_script', 999);

// Other FUNCTIONS
function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function phonenr($args) {
	$str = $args;
	$str = preg_replace('/[^+0-9a-zA-Z]/', '', $str);
	return $str;
}

/* Search Filters */
// function searchfilter($query) {
// 	if ($query->is_search && !is_admin() ) {
// 		$query->set('post_type',array('post'));
// 	}
// 	return $query;
// }
// add_filter('pre_get_posts','searchfilter');

function slugify($text){
	// replace non letter or digits by -
	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
	// trim
	$text = trim($text, '-');
	// transliterate
	if (function_exists('iconv')){
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	}
	// lowercase
	$text = strtolower($text);
	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);
	if (empty($text)) {
			return 'n-a';
	}
	return $text;
}

/**
 * Auto Copyright
 */
function auto_copyright($year = 'auto'){
	if(intval($year) == 'auto'){ $year = date('Y'); }
	if(intval($year) == date('Y')){ return intval($year); }
	if(intval($year) < date('Y')){ return intval($year) . ' - ' . date('Y'); }
	if(intval($year) > date('Y')){ return date('Y'); }
}


function remove_http($url) {
	$disallowed = array('http://', 'https://');
	foreach($disallowed as $d) {
		if(strpos($url, $d) === 0) {
			 return str_replace($d, '', $url);
		}
	}
	return $url;
}


/**
 * Get Featured image of a page/post type
 *
 * @param id  		=> is the main ID
 * @param size 		=> the size of the image / default value = full
 * @param type 		=> img or bg
 * @param class 	=> extra classes added for img tag
 * @param $no_img 	=> default img

 * @return img tag or style background image
 */
function get_featured_img($id="", $size = "full", $type = "", $class="", $no_img) {
	if(!$id){
		$id = get_the_ID();
	}

	if(has_post_thumbnail($id)){
		$img = wp_get_attachment_image_src(get_post_thumbnail_id($id),  $size);

		switch ($type ) {
			case 'img':
				return '<img src="'. $img[0] .'" alt="'. esc_html ( get_the_post_thumbnail_caption($id) ).'"' . ($class ? ' class="'.$class.'"' : '') .'>';
				break;
			case 'bg':
				return 'style="background-image:url('. $img[0] .')"';
				break;
			default: break;
		}
	} else {
		if(!empty($no_img)) {
			switch ($type) {
				case 'img':
					return '<img src="'. $no_img .'" alt="">';
					break;
				case 'bg':
					return 'style="background-image:url('. $no_img .')"';
					break;
				default: break;
			}
		}
	}
}

// Function Share Buttons
// @param type of network and page id
// @return url for share_network
function share_network($network, $id) {
	switch ($network) {
		case 'facebook':
			echo "https://www.facebook.com/sharer/sharer.php?u=" . get_permalink($id);
		break;
		case 'twitter':
			echo "http://twitter.com/home?status=". get_the_title($id) ."+" . get_permalink($id) ;
			break;
		case 'linkedin':
			echo "http://www.linkedin.com/shareArticle?mini=true&url=".get_permalink($id)."&title=". get_the_title($id) ."&source=" . site_url();
			break;
		case 'pinterest':
			$img = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
			if($img[0]){
				echo "http://pinterest.com/pin/create/button/?url=".get_permalink($id)."&media={". $img[0] ."}&description=". get_the_title($id);
			}
			break;
		default: break;
	}
}


add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .user-facebook-wrap,
    .user-instagram-wrap,
    .user-linkedin-wrap,
    .user-myspace-wrap,
    .user-pinterest-wrap,
    .user-soundcloud-wrap,
    .user-tumblr-wrap,
    .user-twitter-wrap,
    .user-youtube-wrap,
    .user-wikipedia-wrap,
    .user-url-wrap {
      	display: none!important;
    }
  </style>';
}
