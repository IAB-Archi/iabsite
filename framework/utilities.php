<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

function json_logger(array $data, $logFile = "/home/stagingialia/logs/custom_json_logs.log") {
  $data['logger_timestamp'] = date(DATE_RFC2822);
  $message = json_encode($data);
  $message .= PHP_EOL;

  return file_put_contents($logFile, $message, FILE_APPEND);
}

function log_and_die($message, $caller = 'log_and_die') {
	echo json_encode($message);
	json_logger([
		'method' => 'log_and_die',
		'caller' => $caller,
		'message' => $message
	]);
  die();
}

function string_empty($string) {
	return strlen($string) == 0;
}

function checkemail($str) {
  return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function get_first_from_array($array) {
  $values = array_values($array);
  return array_shift($values);
}
