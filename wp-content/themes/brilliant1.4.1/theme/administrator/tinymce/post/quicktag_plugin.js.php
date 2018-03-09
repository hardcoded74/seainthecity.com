<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Post Type Quick Tag Script
 * Created by CMSMasters
 * 
 */


define('DOING_AJAX', true);
define('WP_ADMIN', true);

require_once('../../../../../../../wp-load.php');
require_once('../../../../../../../wp-admin/includes/admin.php');

do_action('admin_init');

if (!is_user_logged_in()) {
	die(__('You must be logged in to access this script', 'cmsmasters') . '.');
}

?>
edButtons[edButtons.length] = new edButton(
    'cmsms_post', 
    'post types', 
    '[posttype post_type="post" post_sort="latest" post_category="" post_number="3" show_images="true" show_content="true" show_info="true" post_scroll="true" shortcode_title="Latest Posts"]' 
);
