<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Audio Quick Tags Script
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
    'cmsms_html5audio', 
    'html5 audio', 
    '[html5audio mp3="<?php echo __('Insert your mp3 file url here', 'cmsmasters') . '...'; ?>" ogg="<?php echo __('Insert your ogg file url here', 'cmsmasters') . '...'; ?>" proload="none" controls="controls" autoplay="" loop=""]<?php echo __('Your browser does not support the audio tag', 'cmsmasters') . '. '; ?>[/html5audio]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_single_audio_player', 
    'single audio player', 
    '[single_audio_player mp3="<?php echo __('Insert your mp3 file url here', 'cmsmasters') . '...'; ?>" ogg="<?php echo __('Insert your ogg file url here', 'cmsmasters') . '...'; ?>" title="<?php echo __('Insert your audio title here', 'cmsmasters') . '...'; ?>"]' 
);

edButtons[edButtons.length] = new edButton(
    'cmsms_multiple_audio_player', 
    'multiple audio player', 
    '[multiple_audio_player] [audio_playlist mp3="<?php echo __('Insert your', 'cmsmasters') . ' #1 ' . __('mp3 file url here', 'cmsmasters') . '...'; ?>" ogg="<?php echo __('Insert your', 'cmsmasters') . ' #1 ' . __('ogg file url here', 'cmsmasters') . '...'; ?>" title="<?php echo __('Insert your', 'cmsmasters') . ' #1 ' . __('audio title here', 'cmsmasters') . '...'; ?>"], [audio_playlist mp3="<?php echo __('Insert your', 'cmsmasters') . ' #2 ' . __('mp3 file url here', 'cmsmasters') . '...'; ?>" ogg="<?php echo __('Insert your', 'cmsmasters') . ' #2 ' . __('ogg file url here', 'cmsmasters') . '...'; ?>" title="<?php echo __('Insert your', 'cmsmasters') . ' #2 ' . __('audio title here', 'cmsmasters') . '...'; ?>"] [/multiple_audio_player]' 
);
