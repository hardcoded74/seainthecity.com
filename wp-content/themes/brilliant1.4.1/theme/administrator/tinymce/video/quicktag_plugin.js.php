<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Video Quick Tags Script
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
    'cmsms_video', 
    'video', 
    '[video url="<?php echo __('Insert your url here', 'cmsmasters') . '...'; ?>"]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_html5video', 
    'html5 video', 
    '[html5video mp4="<?php echo __('Insert your mp4 file url here', 'cmsmasters') . '...'; ?>" ogv="<?php echo __('Insert your ogv file url here', 'cmsmasters') . '...'; ?>" proload="none" controls="controls" autoplay="" loop=""]<?php echo __('Your browser does not support the video tag', 'cmsmasters') . '. '; ?>[/html5video]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_single_video_player', 
    'single video player', 
    '[single_video_player mp4="<?php echo __('Insert your mp4 file url here', 'cmsmasters') . '...'; ?>" ogg="<?php echo __('Insert your ogv file url here', 'cmsmasters') . '...'; ?>" title="<?php echo __('Insert your video title here', 'cmsmasters') . '...'; ?>" poster="<?php echo __('Insert your video poster here', 'cmsmasters') . '...'; ?>"]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_multiple_video_player', 
    'multiple video player', 
    '[multiple_video_player] [video_playlist mp4="<?php echo __('Insert your', 'cmsmasters') . ' #1 ' . __('mp4 file url here', 'cmsmasters') . '...'; ?>" ogg="<?php echo __('Insert your', 'cmsmasters') . ' #1 ' . __('ogv file url here', 'cmsmasters') . '...'; ?>" title="<?php echo __('Insert your', 'cmsmasters') . ' #1 ' . __('video title here', 'cmsmasters') . '...'; ?>" poster="<?php echo __('Insert your', 'cmsmasters') . ' #1 ' . __('video poster here', 'cmsmasters') . '...'; ?>"], [video_playlist mp4="<?php echo __('Insert your', 'cmsmasters') . ' #2 ' . __('mp4 file url here', 'cmsmasters') . '...'; ?>" ogg="<?php echo __('Insert your', 'cmsmasters') . ' #2 ' . __('ogv file url here', 'cmsmasters') . '...'; ?>" title="<?php echo __('Insert your', 'cmsmasters') . ' #2 ' . __('video title here', 'cmsmasters') . '...'; ?>" poster="<?php echo __('Insert your', 'cmsmasters') . ' #2 ' . __('video poster here', 'cmsmasters') . '...'; ?>"] [/multiple_video_player]' 
);
