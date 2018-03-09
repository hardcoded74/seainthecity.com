<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.4
 * 
 * Background Image Uploader
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


if ($_POST['url']){ $uploaddir = $_POST['url']; }

$first_filename = $_FILES['uploadfile']['name'];

$filename = md5($first_filename);

$ext = substr($first_filename, 1 + strrpos($first_filename, '.'));

$file = $uploaddir . basename($filename.'.'.$ext);

if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)){
	$thumb = imagecreatetruecolor(20, 20);
	
	if ($ext == 'png'){
		$image = imagecreatefrompng(get_template_directory_uri().'/images/bgs/'.$filename.'.'.$ext);
	} elseif ($ext == 'gif'){
		$image = imagecreatefromgif(get_template_directory_uri().'/images/bgs/'.$filename.'.'.$ext);
	} else {
		$image = imagecreatefromjpeg(get_template_directory_uri().'/images/bgs/'.$filename.'.'.$ext);
	}
	
	list($width, $height) = getimagesize(get_template_directory_uri().'/images/bgs/'.$filename.'.'.$ext);
	
	imagecopyresampled($thumb, $image, 0, 0, 0, 0, 20, 20, $width, $height);
	
	$filename_thumb = $filename.'_thumb';
	
	$file_thumb = $uploaddir . basename($filename_thumb.'.jpg');
	
	imagejpeg($thumb, $file_thumb, 100);
	
	echo basename($filename.'.'.$ext.','.$filename_thumb.'.jpg');
} else {
	echo 'error';
}

