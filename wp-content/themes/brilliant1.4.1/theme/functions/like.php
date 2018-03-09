<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Likes Operator
 * Changed by CMSMasters
 * 
 */


require_once('../../../../../wp-load.php');
global $wpdb, $shortname;

$post_ID = $_POST['id'];
$ip = $_SERVER['REMOTE_ADDR'];
$likes = get_post_meta($post_ID, 'cmsms_likes', true);

if ($post_ID != '') { 
	$ipCheck = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . $shortname . "_likes WHERE post_id = '" . $post_ID . "' AND ip = '" . $ip . "'");
	
    if (!isset($_COOKIE['like-' . $post_ID]) && $ipCheck == 0) {
		$plusLike = $likes + 1;
		
		update_post_meta($post_ID, 'cmsms_likes', $plusLike);
		
		setcookie('like-' . $post_ID, time(), time() + 31536000, '/');
		
		$wpdb->query("INSERT INTO " . $wpdb->prefix . $shortname . "_likes VALUES ('', NOW(), '" . $post_ID . "', '" . $ip . "')");
		
		echo $plusLike;
	} else { 
		echo $likes;
	}
}

?>