<?php defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );

function json_logger(array $data, $logFile = "/home/stagingialia/logs/custom_json_logs.log") {
  $data['logger_timestamp'] = date(DATE_RFC2822);
  $message = json_encode($data);
  $message .= PHP_EOL;

  return file_put_contents($logFile, $message, FILE_APPEND);
}
