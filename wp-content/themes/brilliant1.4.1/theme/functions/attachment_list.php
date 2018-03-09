<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Slider Shortcode Attachments Loader
 * Created by CMSMasters
 * 
 */


require('../../../../../wp-load.php');

global $posts;

if (isset($_GET['offset'])) {
	$offset = $_GET['offset'];
	
	$all_args = array( 
		'numberposts' => -1, 
		'offset' => 0, 
		'post_type' => 'attachment', 
		'orderby' => 'date', 
		'order' => 'DESC', 
		'post_status' => null 
	);
	
	$args = array( 
		'numberposts' => 10, 
		'offset' => $offset, 
		'post_type' => 'attachment', 
		'orderby' => 'date', 
		'order' => 'DESC', 
		'post_status' => null 
	);
	
	$all = count(get_posts($all_args));
	$attachments = get_posts($args);
	
	echo '<ul class="lighbox_image_list choose_list">';
	
	foreach ($attachments as $attachment) {
		$image = wp_get_attachment_image_src($attachment->ID, 'thumbnail');
		$image_link = wp_get_attachment_image_src($attachment->ID, 'full');
		
		echo '<li id="img_' . $attachment->ID . '">' . 
			'<a href="' . $image_link[0] . '">' . 
				'<img src="' . $image[0] . '" alt="" />' . 
				'<span></span>' . 
			'</a>' . 
		'</li>';
	}
	
	echo '</ul>' . 
	'<input type="hidden" id="image_list_all" nane="image_list_all" value="' . $all . '" />' . 
	'<input type="hidden" id="image_list_offset" nane="image_list_offset" value="' . $offset . '" />';
}

?>