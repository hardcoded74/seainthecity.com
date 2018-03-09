<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Column Quick Tags Script
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
    'cmsms_one_half', 
    '1/2', 
    '[one_half]', 
    '[/one_half]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_one_half_last', 
    '1/2 last', 
    '[one_half_last]', 
    '[/one_half_last]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_one_third', 
    '1/3', 
    '[one_third]', 
    '[/one_third]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_one_third_last', 
    '1/3 last', 
    '[one_third_last]', 
    '[/one_third_last]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_two_third', 
    '2/3', 
    '[two_third]', 
    '[/two_third]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_two_third_last', 
    '2/3 last', 
    '[two_third_last]', 
    '[/two_third_last]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_one_fourth', 
    '1/4', 
    '[one_fourth]', 
    '[/one_fourth]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_one_fourth_last', 
    '1/4 last', 
    '[one_fourth_last]', 
    '[/one_fourth_last]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_three_fourth', 
    '3/4', 
    '[three_fourth]', 
    '[/three_fourth]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_three_fourth_last', 
    '3/4 last', 
    '[three_fourth_last]', 
    '[/three_fourth_last]' 
);
