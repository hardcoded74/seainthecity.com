<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Video Shortcodes & Quick Tags Register
 * Created by CMSMasters
 * 
 */


if (!class_exists('CMSMastersVideo')) {
	class CMSMastersVideo {
		var $buttonName;
        var $buttonTitle;
        var $buttonArray;
		
		function __construct() {
			$this->buttonName = 'video';
			$this->buttonTitle = __('Video', 'cmsmasters');
			$this->buttonArray = array(
                0 => array(__('Embeded Video', 'cmsmasters'), 'video'), 
                1 => array(__('HTML5 Video', 'cmsmasters'), 'html5video'), 
                2 => array(__('Single Video Player', 'cmsmasters'), 'single_video_player'), 
                3 => array(__('Multiple Video Player', 'cmsmasters'), 'multiple_video_player') 
            );
		}
		
		function addDropdown() {
			if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
				return;
			}
			
			if (get_user_option('rich_editing') == 'true') {
				add_filter('mce_external_plugins', array($this, 'registerTmcePlugin'));
				add_filter('mce_buttons_4', array($this, 'registerButton'));
				add_filter('wp_fullscreen_buttons', array($this, 'registerFscreenButton'));
			}
		}
		
		function registerButton($buttons) {
			array_push($buttons, $this->buttonName);
			
			return $buttons;
		}
		
		function registerTmcePlugin($buttons) {
			$buttons[$this->buttonName] = CMSMASTERS_ADMIN_TINYMCE . '/' . $this->buttonName . '/editor_plugin.js.php';
			
			return $buttons;
		}
		
		function registerFscreenButton($buttons) {
			$buttons[] = 'separator';
            
            foreach ($this->buttonArray as $val) {
                $buttons[$val[1]] = array(
                    'title' => $val[0],
                    'onclick' => "tinyMCE.execCommand('" . $val[1] . "_command');",
                    'both' => true
                );
            }
			
			return $buttons;
		}
		
		function registerQtagPluginButton($hook) {
			if ( 
				($hook == 'post.php') || 
				($hook == 'post-new.php') || 
				($hook == 'page.php') || 
				($hook == 'page-new.php') 
			) {
				wp_enqueue_script('cmsms_' . $this->buttonName . '_quicktag', CMSMASTERS_ADMIN_TINYMCE . '/' . $this->buttonName . '/quicktag_plugin.js.php', array('quicktags'));
			}
		}
	}
}

if (!isset($cmsmasters_shortcode_video)) {
	$cmsmasters_shortcode_video = new CMSMastersVideo();
	
	add_action('admin_head', array($cmsmasters_shortcode_video, 'addDropdown'));
    add_action('admin_enqueue_scripts', array($cmsmasters_shortcode_video, 'registerQtagPluginButton'));
}

?>