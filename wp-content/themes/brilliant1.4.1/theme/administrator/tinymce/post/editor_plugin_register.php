<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Post Type Shortcode & Quick Tag Register
 * Created by CMSMasters
 * 
 */


if (!class_exists('CMSMastersPost')) {
	class CMSMastersPost {
		var $buttonName;
		var $buttonTitle;
        
		function __construct() {
			$this->buttonName = 'post';
			$this->buttonTitle = __('Post Types', 'cmsmasters');
		}
		
		function addButton() {
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
			array_push($buttons, 'separator', $this->buttonName);
			
			return $buttons;
		}
		
		function registerTmcePlugin($buttons) {
			$buttons[$this->buttonName] = CMSMASTERS_ADMIN_TINYMCE . '/' . $this->buttonName . '/editor_plugin.js.php';
			
			return $buttons;
		}
		
		function registerFscreenButton($buttons) {
			$buttons[] = 'separator';
			
			$buttons[$this->buttonName] = array(
				'title' => $this->buttonTitle,
				'onclick' => "tinyMCE.execCommand('" . $this->buttonName . "_command');",
				'both' => true
			);
			
			return $buttons;
		}
		
		function registerQtagPluginButton() {
			wp_enqueue_script('cmsms_' . $this->buttonName .'_quicktag', CMSMASTERS_ADMIN_TINYMCE . '/' . $this->buttonName . '/quicktag_plugin.js.php', array('quicktags'));
		}
	}
}

if (!isset($cmsmasters_shortcode_post)) {
	$cmsmasters_shortcode_post = new CMSMastersPost();
	
	add_action('admin_head', array($cmsmasters_shortcode_post, 'addButton'));
    add_action('admin_print_scripts', array($cmsmasters_shortcode_post, 'registerQtagPluginButton'));
}

?>