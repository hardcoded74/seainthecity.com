<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Sidebar Generator
 * Changed by CMSMasters
 * 
 */


class sidebar_generator_cmsmasters {
    function sidebar_generator_cmsmasters() {
        add_action('init', array('sidebar_generator_cmsmasters', 'init'));
    }
    
    function init() {
        $sidebars = sidebar_generator_cmsmasters::get_sidebars();
        
        if (is_array($sidebars)) {
            $z = 1;
            
            foreach ($sidebars as $sidebar) {
                $sidebar_class = sidebar_generator_cmsmasters::name_to_class($sidebar);
                
                register_sidebar(
                    array(
                        'name' => $sidebar,
                        'id' => "cmsmasters_sidebar-$z",
                        'before_widget' => '<aside id="%1$s" class="widget scg_widget ' . $sidebar_class . ' %2$s">',
                        'after_widget' => '</aside>',
                        'before_title' => '<h3 class="widgettitle">',
                        'after_title' => '</h3>'
                    )
                );
                
                $z++;
            }
        }
    }
    
    function get_sidebar($index) {
        wp_reset_query();
        
        global $wp_query;
        
        $post = $wp_query->get_queried_object();
        $selected_sidebar = get_post_meta($post->ID, 'selected_sidebar', true);
        
        if ($selected_sidebar != '' && $selected_sidebar != '0') {
            echo "\n\n<!-- begin generated sidebar [$selected_sidebar] -->\n";
            
            dynamic_sidebar($selected_sidebar);
            
            echo "\n<!-- end generated sidebar -->\n\n";
        } else {
            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar_default')) :
                echo '<div class="one_first">' . 
					'<aside id="search" class="widget widget_search">';
                
                get_search_form();
                
                echo '</aside>' . 
				'</div>';
                
                $args = array(
                    'title' => '', 
                    'before_widget' => '<div class="one_first">' . '<aside id="custom-recent-widget" class="widget widget_recent_entries">', 
                    'after_widget' => '</aside>' . '</div>', 
                    'before_title' => '<h3 class="widgettitle">', 
                    'after_title' => '</h3>'
                );
                
                $recent_default = new WP_Widget_Recent_Posts();
                
                $recent_default->widget($args, '');
            endif;
        }
    }
    
    function get_sidebars() {
        global $shortname;
        
        $sidebars = get_option($shortname . '_sidebar_generator');
        
        return $sidebars;
    }
    
    function name_to_class($name) {
        $class = str_replace(array(' ', ',', '.', '"', "'", '/', "\\", '+', '=', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '~', '`', '<', '>', '?', '[', ']', '{', '}', '|', ':',), '', $name);
        
        return $class;
    }
}

$sbg = new sidebar_generator_cmsmasters;

function generated_dynamic_sidebar_cmsmasters($index) {
    sidebar_generator_cmsmasters::get_sidebar($index);
    
    return true;
}

?>