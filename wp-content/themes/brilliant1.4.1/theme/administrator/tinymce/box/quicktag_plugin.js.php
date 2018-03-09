<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Information Box Quick Tags Script
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
    'cmsms_success_box', 
    'success box', 
    '[success_box]', 
    '[/success_box]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_error_box', 
    'error box', 
    '[error_box]', 
    '[/error_box]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_notice_box', 
    'notice box', 
    '[notice_box]', 
    '[/notice_box]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_warning_box', 
    'warning box', 
    '[warning_box]', 
    '[/warning_box]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_download_box', 
    'download box', 
    '[download_box]', 
    '[/download_box]' 
);
