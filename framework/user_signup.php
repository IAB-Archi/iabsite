<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

// ajax for register user
function vc_register_user() {
	$without_action = !isset($_POST['action']) || string_empty($_POST['action']);

	if($without_action) {
		log_and_die(
			array('message' => '<span class="error">No action passed</span>' , 'loggedin' => false),
			'vc_register_user'
		);
	}

	$first_name = $_POST['user_fname'];
	$last_name  = $_POST['user_lname'];
	$email      = $_POST['user_email'];
	$password   = $_POST['user_password'];

  lc_register_user($first_name, $last_name, $email, $password);
}

function lc_register_user($first_name, $last_name, $email, $password) {
  $incomplete_details = string_empty($first_name) || string_empty($last_name) || string_empty($email) || string_empty($password);
  if($incomplete_details) {
    log_and_die(
      array('message' => '<span class="error">All the fields are required.</span>' , 'loggedin' => false),
      'lc_register_user'
    );
  }

  if(strlen($password) < 8) {
    log_and_die(
      array('message' => '<span class="error">Please use a password more than 8 characters long.</span>' , 'loggedin' =>  false),
      'lc_register_user'
    );
  }

  if(!checkemail($email)) {
    log_and_die(
      array('message' => '<span class="error">Invalid email address!</span>' , 'loggedin' => false),
      'lc_register_user'
    );
  }

  //create account wp
  $user_info = array(
    "user_pass"     => $password,
    "user_login"    => $email,
    "user_nicename" => $email,
    "user_email"    => $email,
    "display_name"  => $first_name . ' ' . $last_name,
    "first_name"    => $first_name,
    "last_name"     => $last_name,
  );

  $insert_user_result = wp_insert_user($user_info);

  if (is_wp_error($insert_user_result)) {
    log_and_die(
      array('message' => '<span class="error">'. $insert_user_result->get_error_message() .'</span>' , 'loggedin' => false),
      'lc_register_user'
    );
  }

  $email_domain 	 = explode('@', $email)[1];
  $companies_array = json_decode( get_field('mautic_domain_names_full_copy', 'options'), true );

  if( in_array($email_domain, $companies_array) ) {
      // create account on mautic
      $company_name  = lc_search_company_by_domain($email_domain);

      $data = array(
        'user_fname' => $first_name,
        'user_lname' => $last_name,
        'user_email' => $email,
      );

      $create_mautic = vc_mautic_create_account_member( $first_name, $last_name, $email, $company_name );  // create account member
      update_field('field_5ed7912f53507', $company_name, 'user_' . $insert_user_result );  // company name
      update_field('field_5ee86fdc8dde3', 'yes', 'user_'. $insert_user_result );  // member
  } else {
    // create account mautic - no member
    $newsletter = false;
    $registered = true;
    $create_mautic = vc_mautic_create_account_newsletter(
      $first_name,
      $last_name,
      $email,
      $newsletter,
      $registered
    );
  }

  update_field('field_5ed41bd3f98a9', $create_mautic['contact']['dateAdded'], 'user_' . $insert_user_result );
  update_field('field_5ed42271bab73', $create_mautic['contact']['id'], 'user_' . $insert_user_result );

  $creds = array(
    'user_login'    => $email,
    'user_password' => $password,
    'remember'      => true
  );

  $user_login = wp_signon($creds, is_ssl());
  wp_set_current_user($insert_user_result , $user_login);
  wp_set_auth_cookie($insert_user_result , true, false);
  //do_action( 'wp_login', $user_login );

  // send welcome email
  vc_send_email_register($email);

  log_and_die(
    array(
      'message' => '<span class="success">Account successfully created. You will be redirected in 3 seconds... </span>',
      'loggedin' =>  true
    ),
    'lc_register_user'
  );
}

add_action('wp_ajax_vc_register_user', 'vc_register_user'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_vc_register_user', 'vc_register_user'); // wp_ajax_nopriv_{action}
