<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Divider Quick Tags Script
 * Created by CMSMasters
 * 
 */


require_once('../../../../../../../wp-load.php');
require_once('../../../../../../../wp-admin/includes/admin.php');

do_action('admin_init');

if (!is_user_logged_in()) {
	die(__('You must be logged in to access this script', 'cmsmasters') . '.');
}

?>
edButtons[edButtons.length] = new edButton(
    'cmsms_divider_top', 
    'divider top', 
    '[divider_top]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_divider', 
    'divider', 
    '[divider]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_clear', 
    'clear', 
    '[clear]' 
);
