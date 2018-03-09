<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Envato Theme Upgrader
 * Changed by CMSMasters
 * 
 */


function on_admin_init() {
	global $envato_username, $envato_key;
	
    include_once(CMSMASTERS_CLASSES . '/theme-upgrader.php');
    
    $upgrader = new Envato_WordPress_Theme_Upgrader($envato_username, $envato_key);
    
    $upgrader->check_for_theme_update();
}

add_action('admin_init', 'on_admin_init');

?>