<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0.1
 * 
 * Theme Functions
 * Created by CMSMasters
 * 
 */


/* Register JS Scripts */
function register_js_scripts() {
    if (!is_admin()) {
        wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr.custom.all.min.js', array(), '2.5.2', false);
        wp_register_script('css3MediaQueries', get_template_directory_uri() . '/js/css3MediaQueries.min.js', array(), '1.0.0', false);
        wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.min.js', array('jquery'), '1.3.0', false);
        wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.min.js', array('jquery'), '3.1.2', true);
        wp_register_script('script', get_template_directory_uri() . '/js/jquery.script.js', array('jquery'), '1.0.0', true);
        wp_register_script('jPlayer', get_template_directory_uri() . '/js/jquery.jPlayer.min.js', array('jquery'), '2.1.0', true);
        wp_register_script('jPlayerPlaylist', get_template_directory_uri() . '/js/jquery.jPlayer.playlist.min.js', array('jquery', 'jPlayer'), '1.0.0', true);
        wp_register_script('validator', get_template_directory_uri() . '/js/jquery.validationEngine.min.js', array('jquery'), '2.2.4', true);
        wp_register_script('validatorLanguage', get_template_directory_uri() . '/js/jquery.validationEngine-lang.php', array('jquery', 'validator'), '1.0.0', true);
        wp_register_script('twitter', get_template_directory_uri() . '/js/jquery.tweet.min.js', array('jquery'), '1.3.1', true);
        wp_register_script('gMapAPI', 'http://maps.google.com/maps/api/js?sensor=false', array('jquery'), '1.0.0', true);
        wp_register_script('gMap', get_template_directory_uri() . '/js/jquery.gMap.min.js', array('jquery', 'gMapAPI'), '3.2.0', true);
		
        wp_register_script('slider', get_template_directory_uri() . '/js/jquery.cmsmsResponsiveSlider.min.js', array('jquery'), '1.1.0', true);
        wp_register_script('isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery'), '1.5.14', true);
        wp_register_script('isotopeRun', get_template_directory_uri() . '/js/jquery.isotope.run.js', array('jquery', 'isotope'), '1.0.0', true);
		
        wp_enqueue_script('modernizr');
        wp_enqueue_script('css3MediaQueries');
        wp_enqueue_script('easing');
        wp_enqueue_script('prettyPhoto');
        wp_enqueue_script('script');
        wp_enqueue_script('jPlayer');
        wp_enqueue_script('jPlayerPlaylist');
        wp_enqueue_script('twitter');
    }
}

add_action('init', 'register_js_scripts');



/* Register CSS Styles */
function register_css_styles() {
    if (!is_admin()) {
        wp_register_style('theme-fonts', get_template_directory_uri() . '/css/fonts.php', array(), '1.0.0', 'screen');
        wp_register_style('prettyPhoto', get_template_directory_uri() . '/css/jquery.prettyPhoto.min.css', array(), '3.1.2', 'screen');
        wp_register_style('jPlayer', get_template_directory_uri() . '/css/jquery.jPlayer.css', array(), '2.1.0', 'screen');
        wp_register_style('isotope', get_template_directory_uri() . '/css/jquery.isotope.css', array(), '1.5.14', 'screen');

        wp_enqueue_style('theme-fonts');
        wp_enqueue_style('prettyPhoto');
        wp_enqueue_style('jPlayer');
        wp_enqueue_style('isotope');
    }
}

add_action('wp_print_styles', 'register_css_styles');



/* Register Admin Panel Favicon */
function admin_favicon() {
    echo '<link rel="shortcut icon" type="image/x-icon" href="' . get_template_directory_uri() . '/images/favicon.ico" />';
}

add_action('admin_head', 'admin_favicon');



/* Register Default Theme Sidebars */
function the_widgets_init() {
    if (!function_exists('register_sidebars')) {
        return;
    }
    
    register_sidebar(
        array(
            'name' => __('Sidebar', 'cmsmasters'), 
            'id' => 'sidebar_default', 
            'description' => __('Widgets in this area will be shown in all left and right sidebars till you don\'t use custom sidebar.', 'cmsmasters'), 
            'before_widget' => '<aside id="%1$s" class="widget %2$s">', 
            'after_widget' => '</aside>', 
            'before_title' => '<h3 class="widgettitle">', 
            'after_title' => '</h3>'
        )
    );
    
    register_sidebar(
        array(
            'name' => __('Top Sidebar', 'cmsmasters'), 
            'id' => 'sidebar_top', 
            'description' => __('Widgets in this area will be shown at the top of middle block, above the content.', 'cmsmasters'), 
            'before_widget' => '<aside id="%1$s" class="widget %2$s">', 
            'after_widget' => '</aside>', 
            'before_title' => '<h3 class="widgettitle">', 
            'after_title' => '</h3>'
        )
    );
    
    register_sidebar(
        array(
            'name' => __('Middle Sidebar', 'cmsmasters'), 
            'id' => 'sidebar_middle', 
            'description' => __('Widgets in this area will be shown at the bottom of middle block below the content, but above bottom sidebar and footer.', 'cmsmasters'), 
            'before_widget' => '<aside id="%1$s" class="widget %2$s">', 
            'after_widget' => '</aside>', 
            'before_title' => '<h4 class="widgettitle">', 
            'after_title' => '</h4>'
        )
    );
    
    register_sidebar(
        array(
            'name' => __('Bottom Sidebar', 'cmsmasters'), 
            'id' => 'sidebar_bottom', 
            'description' => __('Widgets in this area will be shown at the bottom of middle block below the content and middle sidebar, but above footer.', 'cmsmasters'), 
            'before_widget' => '<aside id="%1$s" class="widget %2$s">', 
            'after_widget' => '</aside>', 
            'before_title' => '<h3 class="widgettitle">', 
            'after_title' => '</h3>'
        )
    );
}

add_action('init', 'the_widgets_init');



/* Register Theme Navigations */
register_nav_menus(array(
    'primary' => __('Primary Navigation', 'cmsmasters'),
    'footer' => __('Footer Navigation', 'cmsmasters')
));



/* Register Post Formats, Feed Links, Post Thumbnails and Set Image Sizes*/
if (function_exists('add_theme_support')) {
    add_theme_support('post-formats', array('aside', 'quote', 'link', 'image', 'image-list', 'gallery', 'video', 'audio'));
    
    
    add_theme_support('automatic-feed-links');
	
	
    add_theme_support('post-thumbnails');
    
    set_post_thumbnail_size(750, 420, true);
}

if (function_exists('add_image_size')) {
	add_image_size('project-thumb', 440, 250, true);
	add_image_size('slider-thumb', 750, 9999);
	add_image_size('full-thumb', 1160, 650, true);
	add_image_size('full-slider-thumb', 1160, 9999);
}



/* Register Full Screen Content Editor Width & Visual Content Editor CSS Stylesheet */
if (!isset($content_width)) {
    $content_width = 750;
}


add_editor_style('theme/administrator/css/custom-editor-style.css');



/* Register Content Limit Function */
function the_content_limit($post_cont, $max_char, $more_link_text = '...', $stripteaser = 0, $more_file = '') {
    $content = $post_cont;
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = str_replace('<p>', '', $content);
    $content = str_replace('</p>', '', $content);
    
    if ($post_cont != '' && (strlen($content) > $max_char) && ($espacio = strpos($content, ' ', $max_char))) {
        $content = substr($content, 0, $espacio);
        
        echo '<p>' . $content . '</p>' . $more_link_text;
    } elseif ($post_cont != '') {
        echo '<p>' . $content . '</p>';
    }
}



/* Register Theme Options Menu Items in Admin Bar */
function theme_admin_bar_render() {
    global $wp_admin_bar, $shortname, $themename;
    
    $wp_admin_bar->add_menu( 
        array( 
            'id' => $shortname . '_options', 
            'title' => $themename . ' ' . __('Options', 'cmsmasters'), 
            'href' => admin_url('admin.php?page=' . $shortname . '-options')
        ) 
    );
    
    $wp_admin_bar->add_menu( 
        array( 
            'parent' => $shortname . '_options', 
            'id' => $shortname . '_theme_settings', 
            'title' => __('Theme Settings', 'cmsmasters'), 
            'href' => admin_url('admin.php?page=' . $shortname . '-options')
        ) 
    );
    
    $wp_admin_bar->add_menu( 
        array( 
            'parent' => $shortname . '_options', 
            'id' => $shortname . '_slider_manager', 
            'title' => __('Slider Manager', 'cmsmasters'), 
            'href' => admin_url('admin.php?page=slider-manager')
        ) 
    );
    
    $wp_admin_bar->add_menu( 
        array( 
            'parent' => $shortname . '_options', 
            'id' => $shortname . '_form_builder', 
            'title' => __('Form Builder', 'cmsmasters'), 
            'href' => admin_url('admin.php?page=form-builder')
        ) 
    );
}

add_action('wp_before_admin_bar_render', 'theme_admin_bar_render');



/* Register Portfolio Post Type Menu Item Position in Admin Panel Navigation */
function add_admin_menu_separator() {
    global $menu;
    
    $menu1 = $menu;
    $menu2 = array();
    
    unset($menu[59]);
    
    foreach ($menu1 as $offset => $section) {
        if ($offset === 51) {
            $menu2[50] = array('', 'read', 'separator2', '', 'wp-menu-separator');
            $menu2[$offset] = array($section[0], $section[1], $section[2], $section[3], $section[4]);
        } elseif ($offset === 59) {
            $menu2[59] = array($section[0], $section[1], 'separator3', $section[3], $section[4]);
        } else {
            $menu2[$offset] = array($section[0], $section[1], $section[2], $section[3], $section[4]);
        }
    }
    
    $menu = $menu2;
}

//add_action('admin_head', 'add_admin_menu_separator');



/* Unregister Default Wordpress Widgets */
function my_unregister_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Nav_Menu_Widget');
}

add_action('widgets_init', 'my_unregister_widgets');



/* Register Shortcodes for Excerpts and Widgets */
add_filter('the_excerpt', 'do_shortcode');

add_filter('widget_text', 'do_shortcode');



/* Register Removing 'More Text' From Excerpt */
function new_excerpt_more($more) {
	return '...';
}

add_filter('excerpt_more', 'new_excerpt_more');



/* Register Custom Excerpt Length Function */
class Excerpt {
	public static $length = 55;
	
	function __construct($length) {
		Excerpt::$length = $length;
		
		add_filter('excerpt_length', array(Excerpt, new_length));
	}
	
	public function new_length() {
		return Excerpt::$length;
	}
	
	function output() {
		the_excerpt();
	}
	
	function return_out() {
		return get_the_excerpt();
	}
}

function theme_excerpt($length = 55, $show = true) {
	if ($show) {
		$result = new Excerpt($length);
		
		$result->output();
	} else {
		$result = new Excerpt($length);
		
		return $result->return_out();
	}
}



/* Register Transformation from Empty 'p' Tags to 'br' Tags */
function ptobr_content($content) {
    global $post;
	
    $content = str_replace('<p>&nbsp;</p>', '<br />', $content);
	
    return $content;
}

add_filter('the_content', 'ptobr_content');



/* Register Removing 'p' Tags that Wrap Shortcodes */
function shortpdel_content($content) {
    global $post;
	
    $content = str_replace(']</p>', ']', $content);
    $content = str_replace('<p>[/', '[/', $content);
	
    return $content;
}

add_filter('the_content', 'shortpdel_content');



/* Register Showing Home Page on Default Wordpress Pages Menu */
function cmsmasters_page_menu_args($args) {
    $args['show_home'] = true;
    
    return $args;
}

add_filter('wp_page_menu_args', 'cmsmasters_page_menu_args');



/* Register Post Thumbnail Functions for Multisite */
function get_image_path($post_id = null) {
    if ($post_id == null) {
        global $post;
        
        $post_id = $post->ID;
    }
    
    $theImageSrc = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), array(5000, 5000), false);
    
    global $blog_id;
    
    if (isset($blog_id) && $blog_id > 0) {
        $imageParts = explode('/files/', $theImageSrc[0]);
        
        if (isset($imageParts[1])) {
            $theImageSrc[0] = home_url() . '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
        }
    }
    
    return $theImageSrc[0];
}


function get_image_path_array($post_id = null) {
    if ($post_id == null) {
        global $post;
        
        $post_id = $post->ID;
    }
    
    $theImageSrc = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), array(5000, 5000), false);
    
    return $theImageSrc[0];
}


function get_image_path_attachments($image_url) {
    global $blog_id;
    
    if (isset($blog_id) && $blog_id > 0) {
        $imageParts = explode('/files/', $image_url);
        
        if (isset($imageParts[1])) {
            $image_url = home_url() . '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
        }
    }
    
    return $image_url;
}


function get_image_path_fullsize($post_id = null) {
    if ($post_id == null) {
        global $post;
        
        $post_id = $post->ID;
    }
    
    $theImageSrc = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full', false);
    
    global $blog_id;
    
    if (isset($blog_id) && $blog_id > 0) {
        $imageParts = explode('/files/', $theImageSrc[0]);
        
        if (isset($imageParts[1])) {
            $theImageSrc[0] = home_url() . '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
        }
    }
    
    return $theImageSrc[0];
}



/* Register Theme Background Function */
function get_theme_bg($url) {
    global $wpdb, $shortname;
    
    $theme_bg = $wpdb->get_results('SELECT bg_type, bg_url, bg_position_y, bg_position_x, bg_repeat, bg_attachment FROM ' . $wpdb->prefix . $shortname . '_bgs WHERE bg_url = "' . $url . '"');
    
    return $theme_bg[0];
}



/* Register Google Fonts Function */
function get_google_fonts() {
    global $wpdb, $shortname;
    
    $google_fonts = $wpdb->get_results('SELECT font_parameter FROM ' . $wpdb->prefix . $shortname . '_fonts WHERE font_type = "heading"');
    
    return $google_fonts;
}



/* Register Social Icons Function */
function get_social_icons() {
    global $wpdb, $shortname;
    
    $social_icons = $wpdb->get_results('SELECT icon_name, icon_file, icon_tooltip, icon_link FROM ' . $wpdb->prefix . $shortname . '_icons');
    
    return $social_icons;
}



/* Register Portfolio Post Type */
function PortfolioInit() {
    global $pt;
    
    $pt = new Portfolio();
}

add_action('init', 'PortfolioInit');



/* Register Saving Function for Portfolio Project Images Order */
function cmsmasters_save_imgs_order() {
    global $wpdb;
    
    $order = explode(',', $_POST['order']);
    $counter = 0;
    
    foreach ($order as $img_id) {
        $wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $img_id));
        
        $counter++;
    }
    
    die(1);
}

add_action('wp_ajax_imgs_sort', 'cmsmasters_save_imgs_order');



/* Register Portfolio Projects Order Scripts and Saving Function */
global $pagenow;

if (in_array($pagenow, array('post.php'))) {
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('cmsmasters_slides', get_template_directory_uri() . '/theme/administrator/js/sorting.js');
}


require_once('projects-sorting.php');



/* Register Admin Panel Navigation Custom Styles */
function plugin_header() {
    global $post_type, $shortname;
    ?>
    <style type="text/css">
        #adminmenu li.toplevel_page_<?php echo $shortname; ?>-options div.wp-menu-image a img {display:none;}
		
        #adminmenu li.toplevel_page_<?php echo $shortname; ?>-options div.wp-menu-image {background:url(<?php echo get_home_url(); ?>/wp-admin/images/menu.png) no-repeat scroll -330px -33px;}
		
        #adminmenu li.wp-has-current-submenu.toplevel_page_<?php echo $shortname; ?>-options div.wp-menu-image, 
		#adminmenu li.toplevel_page_<?php echo $shortname; ?>-options:hover div.wp-menu-image {background:url(<?php echo get_home_url(); ?>/wp-admin/images/menu.png) no-repeat scroll -330px -1px;}
    </style>
    <?php
}

add_action('admin_head', 'plugin_header');

?>