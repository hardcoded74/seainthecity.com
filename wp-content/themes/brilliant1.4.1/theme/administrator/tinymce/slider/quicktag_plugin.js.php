<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Content Slider Quick Tag Script
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
    'cmsms_slider', 
    'slider', 
    '[content_slider height="auto" animation_speed="0.5" effect="slide" easing="easeInOutExpo" pause_time="7" active_slide="1" pause_on_hover="false touch_control="true" slides_control="true" slides_control_hover="false" arrow_control="false" arrow_control_hover="false"]', 
	'[/content_slider]' 
);
