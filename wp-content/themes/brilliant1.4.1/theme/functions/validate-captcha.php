<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Contact Form reCAPTCHA Validator
 * Changed by CMSMasters
 * 
 */


require('../../../../../wp-load.php');
require_once(CMSMASTERS_CLASSES . '/recaptchalib.php');
global $recaptcha_private_key;

$resp = recaptcha_check_answer($recaptcha_private_key, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);

if (!$resp->is_valid) {
	echo 'error';
} else {
	echo 'success';
}

?>