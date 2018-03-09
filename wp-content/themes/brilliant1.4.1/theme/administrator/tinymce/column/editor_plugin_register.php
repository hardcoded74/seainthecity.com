<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Column Shortcodes & Quick Tags Register
 * Created by CMSMasters
 * 
 */


if (!class_exists('CMSMastersColumn')) {
    class CMSMastersColumn {
        var $buttonName;
        var $buttonTitle;
        var $buttonArray;
        
        function __construct() {
            $this->buttonName = 'column';
			$this->buttonTitle = __('Columns', 'cmsmasters');
            $this->buttonArray = array(
                0 => array(__('One Half', 'cmsmasters'), 'one_half'),
                1 => array(__('One Half Last', 'cmsmasters'), 'one_half_last'),
                2 => array(__('One Third', 'cmsmasters'), 'one_third'),
                3 => array(__('One Third Last', 'cmsmasters'), 'one_third_last'),
                4 => array(__('Two Third', 'cmsmasters'), 'two_third'),
                5 => array(__('Two Third Last', 'cmsmasters'), 'two_third_last'),
                6 => array(__('One Fourth', 'cmsmasters'), 'one_fourth'),
                7 => array(__('One Fourth Last', 'cmsmasters'), 'one_fourth_last'),
                8 => array(__('Three Fourth', 'cmsmasters'), 'three_fourth'),
                9 => array(__('Three Fourth Last', 'cmsmasters'), 'three_fourth_last')
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

if (!isset($cmsmasters_shortcode_column)) {
    $cmsmasters_shortcode_column = new CMSMastersColumn();
    
    add_action('admin_head', array($cmsmasters_shortcode_column, 'addDropdown'));
    add_action('admin_enqueue_scripts', array($cmsmasters_shortcode_column, 'registerQtagPluginButton'));
}

?>