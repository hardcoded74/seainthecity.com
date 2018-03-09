<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Tab Quick Tags Script
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
    'cmsms_tabs', 
    'tabs', 
    '[tabs tab1="<?php echo __('Tab', 'cmsmasters') . ' #1 ' . __('Title', 'cmsmasters'); ?>" tab2="<?php echo __('Tab', 'cmsmasters') . ' #2 ' . __('Title', 'cmsmasters'); ?>"] [tab]', 
    '[/tab] [tab]<?php echo __('Insert you text here', 'cmsmasters') . '...'; ?>[/tab] [/tabs]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_toggle', 
    'toggle', 
    '[toggle title="<?php echo __('Toggle', 'cmsmasters') . ' ' . __('Title', 'cmsmasters'); ?>"]', 
    '[/toggle]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_accordion', 
    'accordion', 
    '[accordion] [toggle title="<?php echo __('Toggle', 'cmsmasters') . ' #1 ' . __('Title2', 'cmsmasters'); ?>"]', 
    '[/toggle] [toggle title="<?php echo __('Toggle', 'cmsmasters') . ' #2 ' . __('Title', 'cmsmasters'); ?>"]<?php echo __('Insert you text here', 'cmsmasters') . '...'; ?>[/toggle] [/accordion]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_tour', 
    'tour', 
    '[tour tour_tab1="<?php echo __('Tab', 'cmsmasters') . ' #1 ' . __('Title', 'cmsmasters'); ?>" tour_tab2="<?php echo __('Tab', 'cmsmasters') . ' #2 ' . __('Title', 'cmsmasters'); ?>"] [tour_tab]', 
    '[/tour_tab] [tour_tab]<?php echo __('Insert you text here', 'cmsmasters') . '...'; ?>[/tour_tab] [/tour]' 
);
