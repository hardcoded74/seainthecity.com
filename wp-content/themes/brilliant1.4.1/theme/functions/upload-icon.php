<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.4
 * 
 * Icons Uploader
 * Created by CMSMasters
 * 
 */


define('DOING_AJAX', true);
define('WP_ADMIN', true);


require_once('../../../../../wp-load.php');
require_once('../../../../../wp-admin/includes/admin.php');


do_action('admin_init');


if (!is_user_logged_in()) {
	die(__('You must be logged in to access this script.', 'cmsmasters'));
}


if ($_POST['url']) { 
	$uploaddir = $_POST['url']; 
}

$first_filename = $_FILES['uploadfile']['name'];
$filename = md5($first_filename);
$ext = substr($first_filename, 1 + strrpos($first_filename, '.'));
$file = $uploaddir . basename($filename . '.' . $ext); 

if (file_exists($file)) {
	echo 'warning';
} elseif (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
	echo basename($filename . '.' . $ext);
} else {
	echo 'error';
}

