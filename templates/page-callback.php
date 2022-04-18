<?php 
/**
 * Template Name: Callback Template
 */
 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' ); 

// echo '<pre>';
// var_dump($_POST);

// var_dump($_GET);
// var_dump($_SESSION);


$code = $_GET['code']; 
$state_2 = $_GET['state'];

if(isset($_GET['code']) && isset($_GET['state'])) {

	// get access token 
	$url = get_option('_mautic_api_url') . '/oauth/v2/token';
	$fields = array(
		'client_id' 	=> get_option('_mautic_client_key'),
		'client_secret' => get_option('_mautic_client_secret'),
		'grant_type' 	=> 'authorization_code', 
		'redirect_uri' 	=> urlencode(get_option('_mautic_callback')),
		'code' 			=> $_GET['code'],
	);

	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');

	//open connection
	$ch = curl_init(); 

	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	//curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

	// Set the content type to application/json
	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

	// Return response instead of outputting
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$result = curl_exec($ch);

	//var_dump($result);
	// $_SESSION['code'] = $_GET['code'];
	// $_SESSION['state'] = $_GET['state'];
	// var_dump($result);

	if($result == false ) { 
		echo 'Erros with API communication.';
	} else {
		$result_data = json_decode($result, true);
		//echo '<pre>';
		//var_dump($result_data); 

		update_option('_mautic_code', $_GET['code'], '', true );
        update_option('_mautic_state', $_GET['state'], '', true );

        update_option('_mautic_access_token', $result_data['access_token'], '', true );
        update_option('_mautic_expires_in', $result_data['expires_in'], '', true );
        update_option('_mautic_refresh_token', $result_data['refresh_token'], '', true );

        // 
        header("Location: ". esc_url(home_url()) . '/wp-admin/options-general.php?page=wp-mautic-api'); 
        die();

	}
	///var_dump($fields);

	//close connection
	curl_close($ch);

} else {
	echo 'Error on receiving data from API';
}