<?php 
/**
 * Template Name: Test Page Template
 */
 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 

//vc_get_mautic_companies(); 

//wpb_update_company_domains();


//wpb_udpate_mautic_refresh_token();

// $response_body['content']= '{"action":"custom_action","wpwhpro_zapier_arguments":{"email":"oanatest6@gmail.com"},"email":"oanatest6@gmail.com"}'; 
//  $bmess = json_decode($response_body['content'], true); 
//  var_dump($bmess);
//  var_dump($bmess['email']);

//vc_get_mautic_companies();

// /echo "111";

//vc_get_mautic_companies();

//export_members();

//vc_get_mautic_companies();

//cron_fix_fields(); 
//cron_fix_fields();

//cron_fix_fields(); 

// $json_encode = '{"content_type":"application\/json","content":{"action":"custom_action","wpwhpro_zapier_arguments":{"email":"oanatest6@gmail.com"},"email":"oanatest6@gmail.com"}}
// ';
// $json = json_decode($json_encode, true);

// echo '<pre>';
// var_dump($json['content']['email']);


//vc_get_mautic_companies();

//cron_user_update_json();
 //cron_run_resetpass();

//cron_3();
  // $create_mautic = vc_mautic_create_account_newsletter( 'oana.gagea@gmail.com', 'egnjkge', 'rsrsr', false, true );

  // var_dump(  $create_mautic);         

 //cron_run_resetpass(); 


 //maut();

//cron_3();

  //  cron_run2();

// Bootup the Composer autoloader
// include __DIR__ . '/vendor/autoload.php';  

// use Mautic\MauticApi;
// use Mautic\Auth\ApiAuth;



// echo '<pre>';

// $search_results = vc_mautic_search_contacts_by_email( 'oanatest09@gmail.com' ); 
// var_dump($search_results);

/*
$settings = array(
    'baseUrl'      => get_option('_mautic_api_url'), //'https://m.iabaustralia.com.au',
    'version'      => 'OAuth2',
    'clientKey'    => get_option('_mautic_client_key'), // '2_4n9yex0k04g0ok8kgc4g8woggkcow4g4ogww0kk84ss4kgs48k',
    'clientSecret' => get_option('_mautic_client_secret'), // '2r5kr81yc6gw400w04w4gkgkss80oo04wkg4848gw4ooc8skos', 
    'callback'     => urlencode(get_option('_mautic_callback')) //'https://verycreative.info/oana/iab/wp/wp-content/plugins/wp-mautic-api/includes/callback.php'
);

$settings['accessToken']        = get_option('_mautic_access_token'); //'ZGU0ZDJlNjM0ZWYyMDE2MDE5OGMwOWVkZDY4ZjJlM2E4OWRjM2FmZTEyZjBiZWRlMGE3ZTM2NTM1YWYwZDkxYg';
 
$settings['accessTokenExpires'] = get_option('_mautic_expires_in');  //360000; //UNIX timestamp
$settings['refreshToken']       = get_option('_mautic_refresh_token');  //'Nzg0N2M0ODc4NDZhNGFlMWVlMmFlZWFjMDc4YjM1OTJmOTdjY2ViOTdiZTAwNThmNzFjMTJlOTY0NGE2MmRkOQ';
// ...
$initAuth = new ApiAuth();
$auth     = $initAuth->newAuth($settings);
var_dump($settings);
var_dump($auth);
$apiUrl   =  get_option('_mautic_api_url'); //esc_url(home_url('/')); //"https://m.iabaustralia.com.au/";

$api      = new MauticApi();

var_dump($api);

$contactApi = $api->newApi("contacts", $auth, $apiUrl);
$contact = $contactApi->get(1);


var_dump($contact);


 die(); */ 

 /*
get_header();

//require TEMPLATEPATH . '/lib/MauticApi.php';


$main_id = get_the_ID(); ?>

<div class="page page-article">
    <div class="container">
        <?php 	echo vc_show_top_slider(); ?>
        <?php	echo vc_show_breadcrumb(); ?>
		
        <div class="container">
        	<article class="long">
        		<div class="general-content">

             <?php  





               


                 //cron_run();
                     // Read JSON file
                   /* $json = file_get_contents('http://173.212.217.92/oana/iab/wp/seo/seo.json');
                    $json_data = json_decode($json,true);

                    foreach ($json_data as $key1 => $value1) {
                        $main_title     = $json_data[$key1]["h1"] ;
                        $main_title_seo = $json_data[$key1]["title"] ;
                        $main_meta      = $json_data[$key1]['meta'];

                        $result_search = search_item($main_title);
                        if($result_search == false){
                            echo 'Not found for ' .  $main_title .'<br/>';
                        } else {
                            echo 'Found ' . $result_search.'<br/>';
                            // $seo_updated = add_to_yoast_seo(
                            //     $result_search ,
                            //     $main_title_seo,
                            //     $main_meta,
                            //     ''
                            // );

                           $o1 = update_post_meta( $result_search, '_yoast_wpseo_title', $main_title_seo );
                           $o2 = update_post_meta( $result_search, '_yoast_wpseo_metadesc', $main_meta );
            
                           var_dump($o1);
                            var_dump($o2);
                            echo '<br/>';

                        }
                       
                    }*/

                    /*$args =  array( 
                        'ignore_sticky_posts'   => true, 
                        'post_type'             => array('post', 'news', 'resource', 'guideline', 'regulatory-affair', 'event'),
                        'order'                 => 'DESC',
                        'posts_per_page'        => -1,
                    );   

                   $loop = new WP_Query( $args ); 
                        $count = 1 ;
                        if ($loop->have_posts()) {  ?>
                            <?php  while ($loop->have_posts())  {  $loop->the_post(); ?>


                            <?php } ?>
                    <?php } *//* ?>
           
				</div>
        	</article>
        </div>
       
    </div> 
</div>

<?php get_footer(); ?>