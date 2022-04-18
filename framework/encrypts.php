<?php 
/**
 * Simple PHP Encryption functions
 *
 * Attempts to be as secure as possible given:
 *
 * - Key can be any string
 * - No knowledge of encryption is required
 * - Only key and raw/encrypted string is needed at each end
 * - Metadata can be anything (string, array, etc.)
 *
 * If possible, always prefer a library like https://github.com/defuse/php-encryption
 * and only use these functions if that isn't possible
 *
 * Adapted from http://stackoverflow.com/a/30239440/1562799
 */
/**
 * Encrypts a string
 *
 * @param string $key  Encryption key, also required for decryption
 * @param string $raw  Raw string to be encrypted
 * @param mixed  $meta Associated data that must be provided during decryption
 *
 * @return string Raw data encrypted with key
 */
function encrypt(  $plaintext ) { // encrypt( $key, $plaintext, $meta = '' )

	$key = "iabaccesscoursekey";
 	$secret_iv =  "dc9d14b9588c96bf9a40b34c6256b707";

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    $output = base64_encode( openssl_encrypt( $plaintext, $encrypt_method, $key, 0, $iv ) );
    return $output;
}


/**
 * Decrypts an encrypted string
 *
 * @param string $key       Encryption key, also used during encryption
 * @param string $encrypted Encrypted string to be decrypted
 * @param mixed  $meta      Associated data that must be the same as when encrypted
 *
 * @return string Decrypted string or `null` if key/meta has been tampered with
 */
function decrypt( $ciphertext ) { //decrypt( $key, $ciphertext, $meta = '' )

	$key = "iabaccesscoursekey";
	$secret_iv =  "dc9d14b9588c96bf9a40b34c6256b707";
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	$output = openssl_decrypt( base64_decode( $ciphertext ), $encrypt_method, $key, 0, $iv );

    return $output;

}