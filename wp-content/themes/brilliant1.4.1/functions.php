<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Main Theme Functions File
 * Created by CMSMasters
 * 
 */


// CMSMasters Directories
define('CMSMASTERS_THEME', TEMPLATEPATH . '/theme');
define('CMSMASTERS_PAGES', CMSMASTERS_THEME . '/pages');
define('CMSMASTERS_CLASSES', CMSMASTERS_THEME . '/classes');
define('CMSMASTERS_FUNCTIONS', CMSMASTERS_THEME . '/functions');
define('CMSMASTERS_ADMIN', CMSMASTERS_THEME . '/administrator');
define('CMSMASTERS_ADMIN_TMCE', CMSMASTERS_ADMIN . '/tinymce');
define('CMSMASTERS_ADMIN_CSS', get_template_directory_uri() . '/theme/administrator/css');
define('CMSMASTERS_ADMIN_JS', get_template_directory_uri() . '/theme/administrator/js');
define('CMSMASTERS_ADMIN_TINYMCE', get_template_directory_uri() . '/theme/administrator/tinymce');



// Load Theme Local File
$locale = get_locale();

if (is_admin()) {
    load_theme_textdomain('cmsmasters', CMSMASTERS_ADMIN . '/languages');
	
    $locale_file = CMSMASTERS_ADMIN . '/languages/' . $locale . '.php';
} else {
    load_theme_textdomain('cmsmasters', CMSMASTERS_THEME . '/languages');
	
    $locale_file = CMSMASTERS_THEME . '/languages/' . $locale . '.php';
}

if (is_readable($locale_file)) {
    require_once($locale_file);
}



// Load Theme Options
require_once(CMSMASTERS_ADMIN . '/admin-options.php');

// Load Admin Interface
require_once(CMSMASTERS_ADMIN . '/admin-interface.php');

// Load Admin Meta Boxes
require_once(CMSMASTERS_ADMIN . '/post-options.php');

// Load Slider Manager
require_once(CMSMASTERS_ADMIN . '/slider-manager.php'); 

// Load Form Builder
require_once(CMSMASTERS_ADMIN . '/form-builder.php');

// Load Admin Scripts and Styles
require_once(CMSMASTERS_ADMIN . '/admin-scripts.php');

// Load TinyMCE and QuickTag Plugins
require_once(CMSMASTERS_ADMIN_TMCE . '/tinymce-buttons.php');

// Load Theme Functions
require_once(CMSMASTERS_FUNCTIONS . '/theme-functions.php');

// Load Likes
require_once(CMSMASTERS_FUNCTIONS . '/likes.php');

// Load Navigation Select
require_once(CMSMASTERS_CLASSES . '/nav-select.php');

// Load Options from the Database
require_once(CMSMASTERS_CLASSES . '/var.php');

// Load Pagination
require_once(CMSMASTERS_CLASSES . '/wp-pagenavi.php');

// Load Breadcrumbs
require_once(CMSMASTERS_CLASSES . '/breadcrumb.php');

// Load Sidebar Generator Class
require_once(CMSMASTERS_CLASSES . '/sidebar-generator.php');

// Load CMSMasters Portfolio Post Type
require_once(CMSMASTERS_CLASSES . '/portfolio-posttype.php');

// Load Custom CMSMasters Widgets Classes
require_once(CMSMASTERS_CLASSES . '/widgets.php');

// Load Custom Default Widgets Classes
require_once(CMSMASTERS_CLASSES . '/widgets-default.php');

// Load Slider Manager Data Access
require_once(CMSMASTERS_CLASSES . '/slider-manager.php');

// Load Slider Manager Controller
require_once(CMSMASTERS_CLASSES . '/slider-controller.php');

// Load Theme Update Notifire
require_once(CMSMASTERS_FUNCTIONS . '/update-notifier.php');

// Load Template Functions
require_once(CMSMASTERS_FUNCTIONS . '/template-functions.php');

// Load Custom Shortcodes
require_once(CMSMASTERS_FUNCTIONS . '/shortcodes.php');

// Load Custom Comments Template
require_once(CMSMASTERS_FUNCTIONS . '/comments.php');


// Create Database Tables Backggounds, Fonts, Icons, Forms, Sliders, Likes & Redirect to Theme Options Page on Theme Activation
if (isset($_GET['activated'])) {
	require_once(CMSMASTERS_FUNCTIONS . '/database-import.php');
}

//woocommerce //

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

// Removes tabs from their original loaction

add_action('init', 'avf_move_product_output');
function avf_move_product_output() {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    remove_action(    'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );
}
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

    $tabs['additional_information']['title'] = __( 'Parameters' );	// Rename the additional information tab

    return $tabs;

}
add_filter('woocommerce_product_additional_information_heading',

    'change_heading');

function change_heading() {

    echo '<h2>Parameters</h2>';

}


add_filter ( 'woocommerce_product_description_heading', 'custom_product_description_heading' ) ;
function custom_product_description_heading() {
    return 'Description'; // Change Me!
}
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
// Remove add to cart button on Category pages.
function remove_loop_button(){
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
//add_action('init','remove_loop_button');
//remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

add_filter( 'woocommerce_product_subcategories_hide_empty', 'show_empty_categories', 10, 1 );
function show_empty_categories ( $show_empty ) {
    $show_empty  =  true;
    // You can add other logic here too
    return $show_empty;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['additional_information'] );   // Remove the additional information tab

    return $tabs;
}

/**
 * These functions will add WooCmmerce or Easy Digital Downloads cart icons/menu items to the "top_nav" WordPress menu area (if it exists).
 * Please customize the following code to fit your needs.
 */
/**
 * This function adds the WooCommerce or Easy Digital Downloads cart icons/items to the top_nav menu area as the last item.
 */
add_filter( 'wp_nav_menu_items', 'my_wp_nav_menu_items', 10, 2 );
function my_wp_nav_menu_items( $items, $args, $ajax = false ) {
	// Top Navigation Area Only
	if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && $args->theme_location === 'top_nav' ) ) {
		// WooCommerce
		if ( class_exists( 'woocommerce' ) ) {
			$css_class = 'menu-item menu-item-type-cart menu-item-type-woocommerce-cart';
			// Is this the cart page?
			if ( is_cart() )
				$css_class .= ' current-menu-item';
			$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<a class="cart-contents" href="' . esc_url( WC()->cart->get_cart_url() ) . '">';
					$items .= wp_kses_data( WC()->cart->get_cart_total() ) . ' - <span class="count">' .  wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'simple-shop' ), WC()->cart->get_cart_contents_count() ) ) . '</span>';
				$items .= '</a>';
			$items .= '</li>';
		}
		// Easy Digital Downloads
		else if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			$css_class = 'menu-item menu-item-type-cart menu-item-type-edd-cart';
			// Is this the cart page?
			if ( edd_is_checkout() )
				$css_class .= ' current-menu-item';
			$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<a class="cart-contents" href="' . esc_url( edd_get_checkout_uri() ) . '">';
					$items .= wp_kses_data( edd_cart_subtotal() ) . ' - <span class="count">' .  wp_kses_data( sprintf( _n( '%d item', '%d items', edd_get_cart_quantity(), 'simple-shop' ), edd_get_cart_quantity() ) ) . '</span>';
				$items .= '</a>';
			$items .= '</li>';
		}
	}
	return $items;
}
/**
 * This function updates the Top Navigation WooCommerce cart link contents when an item is added via AJAX.
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'my_woocommerce_add_to_cart_fragments' );
function my_woocommerce_add_to_cart_fragments( $fragments ) {
	// Add our fragment
	$fragments['li.menu-item-type-woocommerce-cart'] = my_wp_nav_menu_items( '', new stdClass(), true );
	return $fragments;
}
add_action( 'woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1 );





?>
