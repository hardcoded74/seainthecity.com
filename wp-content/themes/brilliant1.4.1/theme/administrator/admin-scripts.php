<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.3
 * 
 * Admin Panel Scripts & Styles
 * Created by CMSMasters
 * 
 */


function cmsmasters_admin_enqueue_scripts($hook) {
    global $page_handle, 
		$form_handle, 
		$slider_handle;
    
    if ( 
		($hook == 'post.php') || 
		($hook == 'post-new.php') || 
		($hook == 'page.php') || 
		($hook == 'page-new.php') || 
		(isset($_GET['page']) && $_GET['page'] == $page_handle) || 
		(isset($_GET['page']) && $_GET['page'] == $form_handle) || 
		(isset($_GET['page']) && $_GET['page'] == $slider_handle) 
	) {
        wp_enqueue_style('media');
		
        wp_enqueue_style('cmsmasters-admin', CMSMASTERS_ADMIN_CSS . '/admin.css', false, '1.0.0', 'screen');
        wp_enqueue_style('cmsmasters-lightbox', CMSMASTERS_ADMIN_CSS . '/cmsmasters.lightbox.css', false, '1.0.0', 'screen');
		
        wp_register_script('cmsmasters-admin', CMSMASTERS_ADMIN_JS . '/admin.js', array('jquery'), '1.0.0');
        wp_register_script('cmsmasters-colorpicker', CMSMASTERS_ADMIN_JS . '/jquery.mColorPicker.min.js', array('jquery'), '1.0.0');
        wp_register_script('cmsmasters-lightbox', CMSMASTERS_ADMIN_JS . '/cmsmasters.lightbox.js', array('jquery'), '1.0.0');
        wp_enqueue_script('cmsmasters-upload', CMSMASTERS_ADMIN_JS . '/ajaxupload.3.5.js', array('jquery'), '1.0.0');
		
		wp_enqueue_script('cmsmasters-colorpicker');
		
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-droppable');
        wp_enqueue_script('jquery-ui-draggable');
		
		if (version_compare(get_bloginfo('version'), '3.5') >= 0) {
			wp_enqueue_script('jquery-ui-spinner');
		}
    }
    
    function cmsmasters_admin_print_scripts() {
        $nonce = wp_create_nonce('sidebar_rm');
        
        wp_print_scripts('cmsmasters-lightbox');
        wp_print_scripts('cmsmasters-upload');
        wp_print_scripts('cmsmasters-colorpicker');
        
        echo '<script type="text/javascript">' .
            'jQuery(document).ready(function () {' .
                "jQuery('.helpbox').lightbox();" .
            '});' .
        '</script>';
        
        echo '<script type="text/javascript">' .
            'var rmSidebarAjaxUrl = "' . admin_url('admin-ajax.php') . '", ' .
				'ajaxNonce = "' . $nonce . '";' .
        '</script>';
        
        if (isset($_GET['template']) && $_GET['template']) {
            echo '<script type="text/javascript">' . 
                'document.ready = function () {' . 
                    "document.getElementById('page_template').selectedIndex = '" . $_GET['template'] . "';" . 
					"if (document.getElementById('page_template').value === 'blog.php' || document.getElementById('page_template').value === 'portfolio.php') { " . 
						"document.getElementById('selected_order_type_meta').style.display = 'block';" . 
						"document.getElementById('selected_order_meta').style.display = 'block';" . 
						"document.getElementById('selected_perpage_meta').style.display = 'block';" . 
						"if (document.getElementById('page_template').value === 'blog.php') {" . 
							"document.getElementById('blog_categ_meta').style.display = 'block';" . 
						"} else if (document.getElementById('page_template').value === 'portfolio.php') {" . 
							"document.getElementById('portfolio_categ_meta').style.display = 'block';" . 
							"document.getElementById('filter_active_meta').style.display = 'block';" . 
							"document.getElementById('selected_numbercolumns_sidebar_meta').style.display = 'block';" . 
						'}' . 
					'}' . 
                '}' . 
            '</script>';
        }
        
        wp_print_scripts('cmsmasters-admin');
    }	
}



function cmsmasters_admin_scripts_hook() {
    global $page_handle, 
		$form_handle, 
		$slider_handle;
    
    $svr_uri = $_SERVER['REQUEST_URI'];
    
    if (
		strstr($svr_uri, 'post.php') || 
		strstr($svr_uri, 'post-new.php') || 
		strstr($svr_uri, 'page.php') || 
		strstr($svr_uri, 'page-new.php') || 
		strstr($svr_uri, $page_handle) || 
		strstr($svr_uri, $form_handle) || 
		strstr($svr_uri, $slider_handle)
	) {
        return true;
    }
}

add_action('admin_enqueue_scripts', 'cmsmasters_admin_enqueue_scripts');



if (cmsmasters_admin_scripts_hook()) {
    add_action('admin_print_scripts', 'cmsmasters_admin_print_scripts');
}


	
function slider_admin_scripts() {
    wp_register_script('slider-manager', CMSMASTERS_ADMIN_JS . '/slider-manager.js');
	
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('slider-manager');
}

function slider_admin_styles() {
    wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'slider-manager') {
    add_action('admin_print_scripts', 'slider_admin_scripts');
    add_action('admin_print_styles', 'slider_admin_styles');
}



function cnsmasters_widget_js($hook) {
    wp_register_script('widget-icon-text', CMSMASTERS_ADMIN_JS . '/widgets-icons.php');
    wp_register_script('cmsmasters-colorpicker', CMSMASTERS_ADMIN_JS . '/jquery.mColorPicker.min.js', array('jquery'), '1.0.0');
	
    if ($hook == 'widgets.php') {
		wp_enqueue_script('cmsmasters-colorpicker');
		wp_enqueue_script('widget-icon-text');
	}
}

add_action('admin_enqueue_scripts', 'cnsmasters_widget_js');

?>