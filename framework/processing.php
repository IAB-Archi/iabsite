<?php 

function search_item($title_doc) {
	$args =  array( 
            'ignore_sticky_posts'   => true, 
            'post_type'             => array('post', 'news', 'resource', 'guideline', 'regulatory-affair'), // , 'page' // , 'event'
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
            'search_prod_title'    => $title_doc,
        );   
add_filter( 'posts_where', 'title_filter', 10, 2 );
    $loop = new WP_Query( $args ); 
   remove_filter( 'posts_where', 'title_filter', 10, 2 );
	if ($loop->have_posts()) { 
	   	while ($loop->have_posts())  {  
	   		$loop->the_post(); 
	   		$pg_id = get_the_ID();
	   		$title = get_the_title($pg_id);
	   		//if(strcmp($title_doc, $title) == 0) {
	   		//if( $title_doc == $title ) {
	   			// update meta
	   			return $pg_id;
	   		//}

	    } 
    } 

    return false;
}


function search_item_id($old_id) {
    $args =  array( 
            'ignore_sticky_posts'   => true, 
            'post_type'             => array('post', 'news', 'resource', 'guideline', 'regulatory-affair'), // , 'page' // , 'event'
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
            'meta_query' => array(
                array(
                    'key'     => 'old_id',
                    'value'   => $old_id,
                    'compare' => '=',
                ),
            ),
           
        );   

    $loop = new WP_Query( $args ); 
    if ($loop->have_posts()) { 
        while ($loop->have_posts())  {  
            $loop->the_post(); 
            $pg_id = get_the_ID();
            $title = get_the_title($pg_id);
                return $pg_id;
            

        } 
    } 

    return false;
}


function title_filter( $where, &$wp_query )
{
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
    }
    return $where;
}


add_action( 'wpb_send_notifications_kr', 'wpb_send_notifications_kr' );
function wpb_send_notifications_kr() {
	//update_memberships_to_standard();
	//cron_run2();
    //cron_3();
  //  cron_run_seo();
}


function get_user_by_display_name($display_name) {
    $users = get_users( array(
        'meta_key'      => 'display_name',
        'meta_value'    => $display_name
    ) );

    $user =  ( isset( $users[0] ) ? $users[0] : false );

    $user_id = ( $user ? $user->ID : false );

    return $user_id;
}





// 
add_action( 'wpb_send_notifications_kr3', 'wpb_send_notifications_kr3' );
function wpb_send_notifications_kr3() {
    cron_run_resetpass();
}


function cron_run_resetpass() {
   // $user_query = new WP_User_Query( array( 'role' => 'Subscriber', 'include' => array( 12, 14, 16, 3 )  ) );
    $user_query = new WP_User_Query( array( 'role' => 'Subscriber' ) );
 
    // Get the results
    $authors = $user_query->get_results();
    $subject = get_field('subject_reset', 'options');
    $sender = 'IAB Australia';
    $from = get_field('from', 'options');
    $forgot_password = get_field('forgot_password', 'options');
    $message = get_field('content_email_reset', 'options'); 
    
    $headers[] = 'MIME-Version: 1.0' . "\r\n";
    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers[] = "X-Mailer: PHP \r\n";
    $headers[] = 'From: ' . $sender .' < ' . $from . '>' . "\r\n";

    $fp         = fopen('/home/stagingialia/public_html/users/info-emails.txt', 'w');

   // var_dump( $authors);

    if ( ! empty( $authors ) ) {
        foreach ( $authors as $key => $author ) {
            $author_info = get_userdata( $author->ID );
            $mail = wp_mail( $author_info->user_email, $subject, $message, $headers );
            fwrite($fp, $key . ' - ' .  $author_info->user_email  . ' Status:' . $mail . PHP_EOL);
            sleep(1);
        }
    } 

    fclose($fp);
}


add_action( 'wpb_send_notifications_kr1102', 'wpb_send_notifications_kr1102' );
function wpb_send_notifications_kr1102() {
    cron_fix_fields();
}

function cron_fix_fields() {
    //$post_id = 5332;

    $fp         = fopen('/home/stagingialia/public_html/users/info-posts3.txt', 'w');
    $args2 =  array( 
            'ignore_sticky_posts'   => true, 
            'post_type'             => 'event', //'resource', // array('post', 'news', 'resource', 'guideline', 'regulatory-affair'), // , 'page' // , 'event'
            'order'                 => 'DESC',
            'posts_per_page'        => -1,
        //     'tax_query' => array(
        //         array(
        //             'taxonomy' => 'research-and-resources',
        //             'field'    => 'term_id',
        //             'terms'    => '8',
        //         ),
        //     ),
       );   

    //echo '<pre>';

    $loop2 = new WP_Query( $args2 ); 
   // var_dump($loop2);
 
    $loop2 = new WP_Query( $args2 ); 
    if ($loop2->have_posts()) { 
        while ($loop2->have_posts())  { 
            $loop2->the_post();
            $post_id = get_the_ID();
            $my_post = array(
              'ID'           =>  $post_id,
            );
            wp_update_post( $my_post );

            //fwrite($fp,  'Done for ' . $post_id . PHP_EOL);

           // var_dump($post_id);
            // documents 
            $new_documents = array();
            $documents = get_field('documents', $post_id);
            if(!empty($documents)) {
                foreach ($documents as $key => $value) {
                    $file = $value['file'];
                    $file_id = $file['id'];

                    $new_documents[] = array(
                        'type_of_document' => 'file',
                        'file'  => $file_id,
                        'access_required' => 'casual'
                    );
                }
            }
           
            $documents_restrictive = get_field('documents_restrictive', $post_id);
            if(!empty($documents_restrictive)) {
                foreach ($documents_restrictive as $key => $value) {
                    $file = $value['file'];
                    $file_id = $file['id'];

                    $new_documents[] = array(
                        'type_of_document' => 'file',
                        'file'  => $file_id,
                        'access_required' => 'casual'
                    );
                }
            } 
            update_field('field_5efee0a957a3a', $new_documents, $post_id ); 

            // echo '<pre>';
            // var_dump($new_documents);

            // links
            $new_links = array();
            $externals_links = get_field('externals_links', $post_id);
            if(!empty($externals_links )) {
                foreach ($externals_links as $key => $value) {
                    $name = $value['name'];
                    $link = $value['link'];

                    $new_links[] = array(
                        'link_name'         => $name,
                        'link'              => $link,
                        'access_required'   => 'casual'
                    );
                }
            }
          
            $externals_links_registered = get_field('externals_links_registered', $post_id);
            if(!empty($externals_links_registered )) {
                foreach ($externals_links_registered as $key => $value) {
                    $name = $value['name'];
                    $link = $value['link'];

                    $new_links[] = array(
                        'link_name'         => $name,
                        'link'              => $link,
                        'access_required'   => 'casual'
                    );
                }
            }

            update_field('field_5efee18d57a40', $new_links, $post_id ); 

            fwrite($fp,  'Done for ' . $post_id . PHP_EOL);

        }
    }
    fwrite($fp,  'All done'. PHP_EOL);
    fclose($fp);

    wp_reset_query(); 

//    var_dump($new_links);

}


function present($val) {
    return !empty($val);
}

 // these crons remain active
add_action( 'wpb_update_company_domains', 'wpb_update_company_domains' );
function wpb_update_company_domains() {
    $companies_map = array();
    $companies_array = array();
   
    for ($starting = 0; $starting < 300; $starting++) {
        $out = vc_get_mautic_companies_cron($starting);
        if (present( $out['map'] ) ) {
            $companies_map   = array_merge( $companies_map,   $out['map']   );
            $companies_array = array_merge( $companies_array, $out['array'] );
        }
    }
      
    if(empty($companies_map) || empty($companies_array)) {
        $headers[]      = 'From: '.get_bloginfo('name').' <'. get_bloginfo('admin_email') .'>';
        $headers[]      = 'Content-Type: text/html; charset=UTF-8';
        $mail           = wp_mail('felix@kruegermarketing.com', 'Error IAB Company List', 'Please manual run the cron - wpb_update_company_domains.' , $headers);
        $mail           = wp_mail('dev@kruegermarketing.com', 'Error IAB Company List', 'Please manual run the cron - wpb_update_company_domains.' , $headers);
        $mail           = wp_mail('oana@verycreative.info', 'Error IAB Company List', 'Please manual run the cron - wpb_update_company_domains.' , $headers);
    } else {
        $headers[]      = 'From: '.get_bloginfo('name').' <'. get_bloginfo('admin_email') .'>';
        $headers[]      = 'Content-Type: text/html; charset=UTF-8';
        $mail           = wp_mail('felix@kruegermarketing.com', 'Daily Update of IAB Company List ran Successfully', json_encode($companies_array, JSON_UNESCAPED_SLASHES), $headers);
        $mail           = wp_mail('dev@kruegermarketing.com', 'Daily Update of IAB Company List ran Successfully', json_encode($companies_array, JSON_UNESCAPED_SLASHES), $headers);
    }

    update_field('mautic_domain_names_copy', json_encode($companies_map, JSON_UNESCAPED_SLASHES), 'options');
    update_field('mautic_domain_names_full_copy', json_encode($companies_array, JSON_UNESCAPED_SLASHES), 'options' );
    update_field('last_update_copy', date('Y-m-d H:i:s'), 'options');

    update_field('mautic_companies_map', json_encode($companies_map, JSON_UNESCAPED_SLASHES), 'options');
    update_field('mautic_companies_array', json_encode($companies_array, JSON_UNESCAPED_SLASHES), 'options' );
    update_field('mautic_companies_last_updated_at', date('Y-m-d H:i:s'), 'options' );
}


// add_action( 'wpb_update_export_members', 'wpb_update_export_members' );
// function wpb_update_export_members() {
//     export_members();
// }

function export_members() {
       // $user_query = new WP_User_Query( array( 'role' => 'Subscriber', 'include' => array( 12, 14, 16, 3 )  ) );
    $user_query = new WP_User_Query(array('number' => -1 )); // ( array( 'role' => 'Subscriber' ) );
 
    // Get the results
    $authors = $user_query->get_results();
    $fp         = fopen('/home/stagingialia/public_html/users/output_users.csv', 'w');

   // var_dump( $authors);

    $user_data = array();
    $user_data_head = array(
        'NO',
        'ID', 
        'First Name',
        'Last Name',
        'Email',
        'Member Account',
        'Mautic ID',
        'Company',
        'Position', 
        'Phone',
        'Mobile',
        'Country',
        'State',
        'City',
        'Zipcode',
        'Address',
        'Newsletter',
        'Facebook',
        'Foursquare',
        'Instagram',
        'Linkedin',
        'Skype',
        'Twitter'
    );

    fputcsv($fp, $user_data_head);

    if ( ! empty( $authors ) ) {
        foreach ( $authors as $key => $author ) {
            $author_info = get_userdata( $author->ID );


            $fname = $author_info->first_name;
            $lname = $author_info->last_name;
            $mail = $author_info->user_email;
            $member_account = get_field('member_account', 'user_' . $author->ID  ); 
            $mautic_user_id = get_field('mautic_user_id', 'user_' . $author->ID ); 
            $company = get_field('company', 'user_' . $author->ID); 
            $position = get_field('position', 'user_' . $author->ID); 
            $phone = get_field('phone', 'user_' . $author->ID); 
            $mobile = get_field('mobile', 'user_' . $author->ID); 
            $fax = get_field('fax', 'user_' . $author->ID); 
            $country = get_field('country', 'user_' . $author->ID); 
            $state = get_field('state', 'user_' . $author->ID); 
            $city = get_field('city', 'user_' . $author->ID); 
            $zipcode = get_field('zipcode', 'user_' . $author->ID); 
            $address1 = get_field('address1', 'user_' . $author->ID); 
            $newsletter_subscriber = get_field('newsletter_subscriber', 'user_' . $author->ID); 
            $facebook = get_field('facebook', 'user_' . $author->ID); 
            $foursquare = get_field('foursquare', 'user_' . $author->ID); 
            $instagram = get_field('instagram', 'user_' . $author->ID); 
            $linkedin = get_field('linkedin', 'user_' . $author->ID); 
            $skype = get_field('skype', 'user_' . $author->ID); 
            $twitter = get_field('twitter', 'user_' . $author->ID); 

            if(empty($newsletter_subscriber)) {
                $newsletter_subscriber = "no";
            }

            if(!empty($member_account)) {
                $member_account = "yes";
            } 

           // $user_data[] = array( $author->ID,  $fname,   $lname, $mail,  $member_account, $mautic_user_id, $company,  $position,  $phone,  $mobile, $fax, $country, $state, $city, $zipcode,  $address1, $newsletter_subscriber ,   $facebook , $foursquare , $instagram,  $linkedin, $skype ,  $twitter );

            $fields = array( ($key+1), $author->ID,  $fname,   $lname, $mail,  $member_account, $mautic_user_id, $company,  $position,  $phone,  $mobile,  $country, $state, $city, $zipcode,  $address1, $newsletter_subscriber ,   $facebook , $foursquare , $instagram,  $linkedin, $skype ,  $twitter );


            fputcsv($fp, $fields);
           
        }

    } 

     fclose($fp);
}

