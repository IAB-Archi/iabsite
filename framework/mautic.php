<?php

use Mautic\MauticApi;
use Mautic\Auth\ApiAuth;

function check_checkbox($user, $password){
    if ( ! isset ( $_POST['username']) ){
       $user = new WP_Error( 'denied', __("Error: Account is not created.") );
    }

    if ( ! is_numeric( $_POST['username'] ) && !empty($_POST['username']) ) {
        // make api call to see if the email address is in mautic account

        $user = get_user_by( 'email', $_POST['username'] );
        if ( !in_array( 'administrator', (array) $user->roles ) && !in_array( 'editor', (array) $user->roles )) {

            $search_results = vc_mautic_search_contacts_by_email( $_POST['username'] );

            if($search_results != 1) {

                $user = new WP_Error( 'denied', __("ERROR: Account is not created.") );
            }
        }
    } else if(!empty($_POST['log'])) {
        $user = get_user_by( 'email', $_POST['log'] );
        if (  !in_array( 'administrator', (array) $user->roles ) && !in_array( 'editor', (array) $user->roles )) {
            $user = new WP_Error( 'denied', __("Error: You are not able to access this page.") );
        }
    }
    return $user;
}
add_filter( 'wp_authenticate_user', 'check_checkbox', 10, 3 );


function vc_show_login_form(){
    ob_start();

    $rand = rand(50, 15000); ?>

    <div class="wrapp-login">
        <h3>Login</h3>
        <form class="custom_login" action="login" id="login_header" method="post">
            <p class="status"></p>
            <div class="form-group form-group-user">
                <input class="username_custom" type="text" name="username" placeholder="Username or Email Address" autocomplete="username">
            </div>
            <div class="form-group form-group-password">
                <input class="password_custom" id="password-login-<?php echo  $rand; ?>" type="password" name="password" placeholder="Password" autocomplete="current-password" >
                <span toggle="#password-login-<?php echo  $rand; ?>" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
            <div class="form-group forgotten-pass">
                <a class="lost lost-password" href="#forgot-password" >Lost your password?</a>
            </div>
            <div class="submit-form">
                <i class="icon icon-loading"></i>
                <input class="submit_button" type="submit" value="Login" name="submit">
            </div>
            <?php   wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
            <?php   $register_page = get_field('register_page', 'options');
                    $register_label = get_field('register_label', 'options');
                    $join_us_label = get_field('join_us_label', 'options');
                    if(!empty($register_page) && !empty($register_label)) {  ?>
                    <div class="flex form-register">
                        <span><?php echo $register_label; ?></span>
                        <a href="<?php echo $register_page; ?>" class="btn btn-outline change-tab"><?php echo $join_us_label; ?></a>
                    </div>
            <?php  } ?>
        </form>
    </div>

<?php
    $content = ob_get_clean();
    return $content;

}


function vc_mautic_search_contacts_by_email($email_address, $return = false) {
    $settings = array(
        'baseUrl'      => get_option('_mautic_api_url'),
        'version'      => 'OAuth2',
        'clientKey'    => get_option('_mautic_client_key'),
        'clientSecret' => get_option('_mautic_client_secret'),
        'callback'     => urlencode(get_option('_mautic_callback'))
    );

    $settings['accessToken']        = get_option('_mautic_access_token');
    $settings['accessTokenExpires'] = get_option('_mautic_expires_in');  //360000; //UNIX timestamp
    $settings['refreshToken']       = get_option('_mautic_refresh_token');
    $initAuth = new ApiAuth();
    $auth     = $initAuth->newAuth($settings);
    $apiUrl   = get_option('_mautic_api_url'); //esc_url(home_url('/')); //"https://m.iabaustralia.com.au/";
    $api      = new MauticApi();

    $contactApi = $api->newApi("contacts", $auth, $apiUrl);
    $contact = $contactApi->getList($email_address, 0, 1, 'date_identified', 'asc', '', '');

    json_logger([
      'method' => 'vc_mautic_search_contacts_by_email',
      'email' => $email_address,
      'return' => $contact['contacts']
    ]);

   // var_dump($contact);
    if($return) {
      return $contact['contacts'];
    } else {
      return intval(sizeof($contact['contacts']));
    }
}

$users_cache = array();

function lc_get_field_value($api, $email, $key) {
  if(! empty($users_cache[$email])) {
    $user = $users_cache[$email];

    if(!array_key_exists($key, $user['fields']['core'])) {
        return NULL;
    }

    return $user['fields']['core'][$key]['value'];
  } else {
    $find_user  = $api->getList($email, 0, 1, 'date_identified', 'asc', '', '');
    $user_found = intval(sizeof($find_user['contacts'])) > 0;

    if($user_found) {
      $user = get_first_from_array($find_user['contacts']);
      $users_cache[$email] = $user;

      if(!array_key_exists($key, $user['fields']['core'])) {
          return NULL;
      }

      return $user['fields']['core'][$key]['value'];
    } else {
      return NULL;
    }
  }
}

// mautic create new account
function vc_mautic_create_account_newsletter( $first_name, $last_name, $email, $newsletter, $registered, $force_newsletter = false ) {
    $settings = array(
        'baseUrl'      => get_option('_mautic_api_url'),
        'version'      => 'OAuth2',
        'clientKey'    => get_option('_mautic_client_key'),
        'clientSecret' => get_option('_mautic_client_secret'),
        'callback'     => urlencode(get_option('_mautic_callback'))
    );

    $settings['accessToken']        = get_option('_mautic_access_token');
    $settings['accessTokenExpires'] = get_option('_mautic_expires_in');
    $settings['refreshToken']       = get_option('_mautic_refresh_token');

    $initAuth = new ApiAuth();
    $auth     = $initAuth->newAuth($settings);
    $apiUrl   = get_option('_mautic_api_url');
    $api      = new MauticApi();

    $data = array(
        'firstname' => $first_name,
        'lastname'  => $last_name,
        'email'     => $email,
        'ipAddress' => $_SERVER['REMOTE_ADDR'],
        'overwriteWithBlank' => false,
    );

    if(true == $newsletter) {
        $data['newsletter_subscriber'] = "yes";
        $data['notes'] = 'Created on ' . date('Y/m/d H:i:s') . ' from newsletter website' ;
    }

    if(true == $registered) {
        $data['registered_user'] = "yes";
        $data['notes'] = 'Created on ' . date('Y/m/d H:i:s') . ' from registration form website' ;
    }

    // for debugging purposes, mostly
    if(true == $force_newsletter) {
      $data['newsletter_subscriber'] = $newsletter ? 'yes' : 'no';
    }

    $contactApi = $api->newApi("contacts", $auth, $apiUrl);
    $data['member'] = lc_get_field_value($contactApi, $email, 'member') == "1";

    $contact = $contactApi->create($data);

    json_logger([
      'method' => 'vc_mautic_create_account_newsletter',
      'data' => $data
    ]);

    return $contact;
}

function vc_mautic_create_account_member($first_name, $last_name, $email, $company_name) {
    $settings = array(
        'baseUrl'      => get_option('_mautic_api_url'),
        'version'      => 'OAuth2',
        'clientKey'    => get_option('_mautic_client_key'),
        'clientSecret' => get_option('_mautic_client_secret'),
        'callback'     => urlencode(get_option('_mautic_callback'))
    );

    $settings['accessToken']        = get_option('_mautic_access_token');
    $settings['accessTokenExpires'] = get_option('_mautic_expires_in');
    $settings['refreshToken']       = get_option('_mautic_refresh_token');

    $initAuth = new ApiAuth();
    $auth     = $initAuth->newAuth($settings);
    $apiUrl   = get_option('_mautic_api_url');
    $api      = new MauticApi();

    $data = array(
        'firstname' => $first_name,
        'lastname'  => $last_name,
        'email'     => $email,
        'ipAddress' => $_SERVER['REMOTE_ADDR'],
        'company'   => $company_name,
        'overwriteWithBlank' => false,
        'registered_user' => 'yes',
        'member' => 'yes'
    );

    $contactApi = $api->newApi("contacts", $auth, $apiUrl);

    $data['newsletter_subscriber'] = lc_get_field_value($contactApi, $email, 'newsletter_subscriber') == "1";
    $data['notes'] = lc_get_field_value($contactApi, $email, 'notes');

    $contact = $contactApi->create($data);

    json_logger([
      'method' => 'vc_mautic_create_account_member',
      'contact' => $contact,
      'data' => $data
    ]);

    return $contact;
}

// Dashboard My account
function vc_mautic_connection_contacts() {
    $settings = array(
        'baseUrl'      => get_option('_mautic_api_url'),
        'version'      => 'OAuth2',
        'clientKey'    => get_option('_mautic_client_key'),
        'clientSecret' => get_option('_mautic_client_secret'),
        'callback'     => urlencode(get_option('_mautic_callback'))
    );

    $settings['accessToken']        = get_option('_mautic_access_token');
    $settings['accessTokenExpires'] = get_option('_mautic_expires_in');
    $settings['refreshToken']       = get_option('_mautic_refresh_token');

    $initAuth = new ApiAuth();
    $auth     = $initAuth->newAuth($settings);
    $apiUrl   = get_option('_mautic_api_url');
    $api      = new MauticApi();

    $contactApi = $api->newApi("contacts", $auth, $apiUrl);

    return $contactApi;
}

function vc_mautic_create_account_general_register( $data_user, $company_name ) {
    $settings = array(
        'baseUrl'      => get_option('_mautic_api_url'),
        'version'      => 'OAuth2',
        'clientKey'    => get_option('_mautic_client_key'),
        'clientSecret' => get_option('_mautic_client_secret'),
        'callback'     => urlencode(get_option('_mautic_callback'))
    );

    $settings['accessToken']        = get_option('_mautic_access_token');
    $settings['accessTokenExpires'] = get_option('_mautic_expires_in');
    $settings['refreshToken']       = get_option('_mautic_refresh_token');


    $initAuth = new ApiAuth();
    $auth     = $initAuth->newAuth($settings);
    $apiUrl   = get_option('_mautic_api_url');
    $api      = new MauticApi();

    $data = array(
        'firstname' => $data_user['firstname'],
        'lastname'  => $data_user['surname'],
        'email'     => $data_user['emailaddress'],
        'ipAddress' => $_SERVER['REMOTE_ADDR'],
        'mobile'    => $data_user['userprofilemobile'],
       // 'phone'     => $data_user['userprofilephone'],
        'position'  => $data_user['userprofileposition'],
        'company'   => $company_name,
        'overwriteWithBlank' => true,
    );

    if($data_user['newsletters'] == 'on') {
        $data['newsletter_subscriber'] = "yes";
    } else {
        $data['newsletter_subscriber'] = "no";
    }

    $data['registered_user'] = "yes";
    $data['member'] = "yes";

    $contactApi = $api->newApi("contacts", $auth, $apiUrl);
    $contact = $contactApi->create($data);

    json_logger([
      'method' => 'vc_mautic_create_account_general_register',
      'contact' => $contact,
      'data' => $data
    ]);

    return $contact;
}


function vc_mautic_search_contacts_by_email_user( $email_address ) {
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

    $initAuth = new ApiAuth();
    $auth     = $initAuth->newAuth($settings);
    $apiUrl   = get_option('_mautic_api_url');  //"https://m.iabaustralia.com.au/";
    $api      = new MauticApi();

    $contactApi = $api->newApi("contacts", $auth, $apiUrl);
    $contact = $contactApi->getList($email_address, 0, 1, 'date_identified', 'asc', '', '');

    return $contact;
}

// add_action( 'profile_update', array( $this, 'ironikus_trigger_user_update_init' ), 10, 2 );
// add_action( 'profile_update', 'vc_send_profile_update', 10, 2 );
// function vc_send_profile_update($user_id, $old_user_data ) {

// }


function vc_get_mautic_companies_cron($starting = 0) {
    $settings = array(
        'baseUrl'      => get_option('_mautic_api_url'),
        'version'      => 'OAuth2',
        'clientKey'    => get_option('_mautic_client_key'),
        'clientSecret' => get_option('_mautic_client_secret'),
        'callback'     => get_option('_mautic_callback')
    );

    $settings['accessToken']        = get_option('_mautic_access_token');
    $settings['accessTokenExpires'] = get_option('_mautic_expires_in');
    $settings['refreshToken']       = get_option('_mautic_refresh_token');

    $initAuth = new ApiAuth();
    $auth     = $initAuth->newAuth($settings);
    $apiUrl   = get_option('_mautic_api_url');
    $api      = new MauticApi();
    $companyApi = $api->newApi("companies", $auth, $apiUrl);

    $searchFilter = '';
    $step = 100;
    $start = 0;

    if($starting > 0) {
      $start = ($step * $starting) + 1;
    }

    $orderBy = '';
    $orderByDir = 'ASC';
    $publishedOnly = false;
    $minimal = false;

    $companies = $companyApi->getList(
        $searchFilter,
        $start,
        $step,
        $orderBy,
        $orderByDir,
        $publishedOnly,
        $minimal
    );

    json_logger([
      'method' => 'vc_get_mautic_companies_cron',
      'companies' => $companies
    ]);

    $member_companies = array();
    $non_member_companies = array();

    $companies_array = array();
    $companies_hash = array();

    foreach($companies['companies'] as $company) {
        $all_fields = $company['fields']['all'];
        $domain_1 = $all_fields['company_email_domain_1'];
        $domain_2 = $all_fields['company_email_domain_11'];
        $domain_3 = $all_fields['company_email_domain_111'];
        $domain_4 = $all_fields['company_email_domain_1111'];
        $domain_5 = $all_fields['company_email_domain_11111'];
        $company_name = $all_fields['companyname'];
        $member_organisation_bool = $all_fields['member_organisation'];

        $is_member_org = !empty($member_organisation_bool) && intval($member_organisation_bool) === 1;

        if( !$is_member_org ) {
          $non_member_companies[] = $company_name;
          continue;
        } else {
          $member_companies[] = $company_name;
        }

        $companies_hash[$company_name] = array();
        if( !empty($domain_1) ) { $companies_array[] = $companies_hash[$company_name][] = substr($domain_1, 1); }
        if( !empty($domain_2) ) { $companies_array[] = $companies_hash[$company_name][] = substr($domain_2, 1); }
        if( !empty($domain_3) ) { $companies_array[] = $companies_hash[$company_name][] = substr($domain_3, 1); }
        if( !empty($domain_4) ) { $companies_array[] = $companies_hash[$company_name][] = substr($domain_4, 1); }
        if( !empty($domain_5) ) { $companies_array[] = $companies_hash[$company_name][] = substr($domain_5, 1); }
    }    

    $result = array(
      'member' => $member_companies,
      'non_member' => $non_member_companies,
      'array' => $companies_array,
      'map'  => $companies_hash
    );

    json_logger([
      'method' => 'vc_mautic_companies_cron_return',
      '$searchFilter' => $searchFilter,
      '$start' => $start,
      '$step' => $step,
      '$orderBy' => $orderBy,
      '$orderByDir' => $orderByDir,
      '$publishedOnly' => $publishedOnly,
      '$minimal' => $minimal,
      'result' => $result,
    ]);

    return $result;
}

function vc_get_mautic_companies() {
     $settings = array(
        'baseUrl'      => get_option('_mautic_api_url'),
        'version'      => 'OAuth2',
        'clientKey'    => get_option('_mautic_client_key'),
        'clientSecret' => get_option('_mautic_client_secret'),
        'callback'     => (get_option('_mautic_callback'))
    );

    $settings['accessToken']        = get_option('_mautic_access_token');
    $settings['accessTokenExpires'] = get_option('_mautic_expires_in');
    $settings['refreshToken']       = get_option('_mautic_refresh_token');

    $initAuth = new ApiAuth();
    $auth     = $initAuth->newAuth($settings);
    $apiUrl   = get_option('_mautic_api_url');
    $api      = new MauticApi();
    $companyApi = $api->newApi("companies", $auth, $apiUrl);

    $array_companies = array();
    $array_companies_simple = array();
    $start = 0;

    $companies = $companyApi->getList( $searchFilter, 0, '500', $orderBy, $orderByDir, $publishedOnly, $minimal);

    json_logger([
      'method' => 'vc_get_mautic_companies',
      'companies' => $companies
    ]);

    foreach ($companies as $key => $value) {
        foreach ($value as $key2 => $value2) {

            $company_id = $value2['id'];
            $company_email = $value2['fields']['core']['companyemail']['value'];
            $member_organisation = $value2['fields']['member_organisation'];
            $company_name = $value2['fields']['all']['companyname'];

            $member_organisation_bool =  $value2['fields']['all']['member_organisation'];

            if($member_organisation_bool == "1" || !empty($member_organisation_bool) ) {
                if(!empty($value2['fields']['all']['company_email_domain_1'])) {
                    $array_companies[$company_name][] =  substr($value2['fields']['all']['company_email_domain_1'], 1);
                    $array_companies_simple[] = substr($value2['fields']['all']['company_email_domain_1'], 1);
                }

                if(!empty($value2['fields']['all']['company_email_domain_11'])) {
                    $array_companies[$company_name][] = substr($value2['fields']['all']['company_email_domain_11'], 1);
                    $array_companies_simple[] = substr($value2['fields']['all']['company_email_domain_11'], 1);
                }

                if(!empty($value2['fields']['all']['company_email_domain_111'])) {
                    $array_companies[$company_name][] = substr($value2['fields']['all']['company_email_domain_111'], 1);
                    $array_companies_simple[] = substr($value2['fields']['all']['company_email_domain_111'], 1);
                }

                if(!empty($value2['fields']['all']['company_email_domain_1111'])) {
                    $array_companies[$company_name][] = substr($value2['fields']['all']['company_email_domain_1111'], 1);
                     $array_companies_simple[] = substr($value2['fields']['all']['company_email_domain_1111'], 1);
                }

                if(!empty($value2['fields']['all']['company_email_domain_11111'])) {
                    $array_companies[$company_name][] = substr($value2['fields']['all']['company_email_domain_11111'], 1);
                    $array_companies_simple[] = substr($value2['fields']['all']['company_email_domain_11111'], 1);
                }
            }
        }
    }

    if(empty($array_companies) || empty($array_companies_simple)) {
        $headers[]     = 'From: '.get_bloginfo('name').' <'. get_bloginfo('admin_email') .'>';
        $headers[]     = 'Content-Type: text/html; charset=UTF-8';
       // $mail          = wp_mail('oana@verycreative.info', 'Error Iab Comapany List', 'Please manual run the cron and generate new tokens.' , $headers);
    }

    //var_dump($array_companies);
    if(sizeof($array_companies) > 10) {
        update_field('field_5f048812a415b', json_encode($array_companies, JSON_UNESCAPED_SLASHES), 'options'); // gouped
        update_field('field_5f04b447e8edc', json_encode($array_companies_simple, JSON_UNESCAPED_SLASHES), 'options' );
        update_field('field_5f048822a415c', date('Y-m-d H:i:s'), 'options');
    }

    return $array_companies;

   // $contactApi = $api->newApi("contacts", $auth, $apiUrl);
}

function vc_process_company() {
    //[DEV] - Getting the file path of the text needed and store it in variable.
    $fp = fopen('/home/stagingialia/public_html/users/info-emails-companies.txt', 'w');

    //[DEV] - Getting the array of companies and store it in variable.
    $array_companies    = vc_get_mautic_companies();
    $user_query         = new WP_User_Query( array( 'role' => 'Subscriber' ) );
    $authors            = $user_query->get_results();
    if ( ! empty( $authors ) ) {
        
        //Loop the user and store in variables. [DEV]
        foreach ( $authors as $key => $author ) {
            
            //[DEV] - This is the list of the user info and store them in variable
            //[DEV] - User ID
            $author_info = get_userdata( $author->ID );
            //[DEV] - User Email
            $email  = $author_info->user_email;
            $contact_mautic = vc_mautic_search_contacts_by_email_user( $email );
            //[DEV] - Contact (Depends on what is the output of the first array inside the $contact_mautic)
            $mautic_id = array_keys($contact_mautic['contacts'])[0] ;

            $domain_name = substr(strrchr($email, "@"), 1);

            //[DEV] - Update the user to member account in mautic by looping and getting information from the stored info from the variable above.
            if(in_array($email, $array_companies)){ // update user to member account
                update_field('field_5ee86fdc8dde3', 'yes', 'user_'. $author->ID );

                $user_data = array();
                $user_data['member'] = 'yes';

                //[DEV] - Connect to the mautic contacts api
                $contactApi = vc_mautic_connection_contacts();
                $id   = get_field('mautic_user_id', 'user_' . $author->ID);
                $createIfNotFound = false;
                $contact = $contactApi->edit($id, $user_data, $createIfNotFound);

                //[DEV] - Output the user matic ID, email and domain
                fwrite($fp, $key . 'User mautic : ' . $mautic_id . ' ' .  $email  . ' -> ' . $domain_name . PHP_EOL);

            } else {
                 //[DEV] - Fallback conditions if the company is not found.
                 fwrite($fp, $key . 'User mautic : ' . $mautic_id . ' ' .  $email  . ' NOT FOUND COMPANY ' . $domain_name . PHP_EOL);
            }



        }

    } else {

    }
    //[DEV] - Close the connection
    fclose($fp);

}

function find_by_email_and_update_member_info($email, $is_member, $first_name = null, $last_name = null, $company_name = null) {
  $user = get_user_by('email', $email);

  json_logger([
    'method' => 'find_by_email_and_update_member_status',
    'email' => $email,
    'is_member' => $is_member,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'company_name' => $company_name,
    'user' => $user ? $user->ID : null
  ]);

  if(!$user) {
    return [
      'success' => false,
      'msg' => "User not found"
    ];
  }

  try {
    $result_status = update_field('field_5ee86fdc8dde3', $is_member, 'user_' . $user->ID);

    // if(!empty($company_name)) { update_field('field_5ed7912f53507', $company_name, 'user_' . $user->ID); }
    // if(!empty($first_name)) { wp_update_user(['ID' => $user->ID, 'first_name' => $first_name]); }
    // if(!empty($last_name)) { wp_update_user(['ID' => $user->ID, 'last_name' => $last_name]); }

    return [
      'success' => true,
      'msg' => "Updated Successfully | User ID - " . " " . $user->ID . " | Member Value - " . $is_member . " | Result - " . $result_status
    ];
  } catch(Exception $e) {
    return [
      'success' => false,
      'msg' => $e->getMessage()
    ];
  }
}

// Added By Mohammad Abu Musa to update a is_member field
add_filter( 'wpwhpro/run/actions/custom_action/return_args', 'update_member_from_mautic', 10, 3 );
function update_member_from_mautic( $return_args, $identifier, $response_body ) {
  if( $identifier !== 'change_update_user' ) {
    $return_args['success'] = false;
    $return_args['msg'] = "Invalid Action";
    return $return_args;
  }

  $response_body = WPWHPRO()->helpers->get_response_body();
  $payload       = WPWHPRO()->helpers->validate_request_value( $response_body['content'], 'mautic.lead_post_save_update');

  json_logger([
    'method' => 'update_member_from_mautic',
    'payload' => $payload
  ]);

  if(is_string($payload)) {
    $records = json_decode($payload);
    $results = [];
    foreach ($records as $record) {
      $email  = $record->contact->fields->core->email->value;
      $member = $record->contact->fields->core->member->value == 1;
      $firstname = $record->contact->fields->core->firstname->value;
      $lastname = $record->contact->fields->core->lastname->value;
      $company_name = $record->contact->fields->core->company->value;

      $result = find_by_email_and_update_member_info($email, $member, $firstname, $lastname, $company_name);
      $results['email'] = $result;
    }

    foreach ($results as $email => $result) {
      $return_args['success'] = $return_args['success'] ?? true;
      $return_args['success'] = $return_args['success'] && $result['success'];

      $return_args['msg'] = $return_args['msg'] ?? '';
      $return_args['msg'] .= 'Email: ' . $email . ' - ' . $result['msg'] . ' | ';
    }

    return $return_args;
  } else {
    $email  = $payload->contact->fields->core->email->value;
    $member = $payload->contact->fields->core->member->value == 1;
    $firstname = $payload->contact->fields->core->firstname->value;
    $lastname = $payload->contact->fields->core->lastname->value;
    $company_name = $payload->contact->fields->core->company->value;

    $result = find_by_email_and_update_member_info($email, $member, $firstname, $lastname, $company_name);

    $return_args['success'] = $result['success'];
    $return_args['msg'] = $result['msg'];

    return $return_args;
  }
}

add_action( 'wpb_udpate_mautic_refresh_token', 'wpb_udpate_mautic_refresh_token' );
function wpb_udpate_mautic_refresh_token() {

    global $wpdb;
    $prefix = $wpdb->prefix;

  $db_query   =   "SELECT option_value
            FROM ib_options
            WHERE option_name = '_mautic_refresh_token'
          LIMIT 10";
  $results_valid = $wpdb->get_results($db_query, ARRAY_A );


    // get access token
  $url = 'https://m.iabaustralia.com.au/oauth/v2/token';
  $fields = array(
    'client_id'   => '7_l28pg5coee8kgks8888swoskwgwco44sg008oo00sw0ckswoc', // '2_4n9yex0k04g0ok8kgc4g8woggkcow4g4ogww0kk84ss4kgs48k',
    'client_secret' => '5l9f2dji624owgokcwgggg4k4000cw4g0048k4w4okg8oso444',  //'2r5kr81yc6gw400w04w4gkgkss80oo04wkg4848gw4ooc8skos',
    'grant_type'   => 'refresh_token',
    'refresh_token' => $results_valid[0]['option_value'],
  //  'redirect_uri'   => urlencode('https://iabaustralia.com.au/wp-content/plugins/wp-mautic-api/includes/callback.php'),

  );

  //url-ify the data for the POST
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  rtrim($fields_string, '&');

  //open connection
  $ch = curl_init();

  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch,CURLOPT_POST, count($fields));
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

  //execute post
  $result = curl_exec($ch);

    $out = json_decode($result);


   $new_access_token = $out->access_token;
  $new_refresh_token =  $out->refresh_token;

  if(!empty($new_access_token ) && !empty($new_refresh_token)) {

        update_option('_mautic_refresh_token',   $new_refresh_token  );
        update_option('_mautic_access_token', $new_access_token );

  } else {
      // send email to infor error
      $headers[]     = 'From: '.get_bloginfo('name').' <'. get_bloginfo('admin_email') .'>';
      $headers[]     = 'Content-Type: text/html; charset=UTF-8';
     // $mail       = wp_mail('oana@verycreative.info', 'Error Iab Token', 'Please manual update the tokens.' , $headers);
  }



  //close connection
  curl_close($ch);

}
