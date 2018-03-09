<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Navigation Select
 * Changed by CMSMasters
 * 
 */


class Nav_Select extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth) {
		$output .= "$indent";
	}
	
	function end_lvl(&$output, $depth) {
		$output .= "$indent";
	}
	
    function start_el(&$output, $item, $depth, $args) {
        $classes = (empty($item->classes)) ? array() : (array) $item->classes;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		
        if ($depth == 0) { 
			$class_names = (!empty($class_names)) ? ' class="' . esc_attr($class_names) . ' main_item"' : '';
		} else { 
			$class_names = (!empty($class_names)) ? ' class="' . esc_attr($class_names) . '"' : '';
        }
		
        $title = apply_filters('the_title', $item->title, $item->ID);
		
		$depth_title = str_repeat(' - -', $depth);
		
		if ($depth > 0) { 
			$title = $depth_title . ' ' . $title;
		}
		
		$link = !empty($item->url) ? esc_attr($item->url) : '';
        
        $item_output = '<option id="menu-item-resp-' . $item->ID . '" ' . $class_names . ' value="' . $link . '">' . $title . '</option>';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
	
	function end_el(&$output, $item, $depth) {
		$output .= "";
	}
}

?>