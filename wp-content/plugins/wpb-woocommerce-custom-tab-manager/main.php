<?php
/**
 * Plugin Name:       WPB WooCommerce Custom Tab Manager
 * Plugin URI:        http://wpbean.com/wpb-woocommerce-custom-tab-manager
 * Description:       Customizing WooCommerce product tab is super easy with this plugin.
 * Version:           1.0.4
 * Author:            wpbean
 * Author URI:        http://wpbean.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpb-woocommerce-custom-tab-manager
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * Localization
 */

add_action( 'init', 'wpb_wctm_textdomain' );

if( !function_exists('wpb_wctm_textdomain') ):
	function wpb_wctm_textdomain() {
		load_plugin_textdomain( 'wpb-woocommerce-custom-tab-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
endif;



/**
 * Plugin Action Links
 */

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'wpb_wctm_add_action_links' );

function wpb_wctm_add_action_links ( $links ) {

	$links[] = '<a style="color: red; font-weight: bold" target="_blank" href="'. esc_url( 'http://bit.ly/1VYKvqV' ) .'">'. __( 'Go PRO!', 'wpb-woocommerce-custom-tab-manager' ) .'</a>';

	return $links;
}


/**
 * Required Files
 */

require_once dirname( __FILE__ ) . '/inc/class.wpb-woocommerce-custom-tab-manager.php';
require_once dirname( __FILE__ ) . '/admin/meta-box/meta_box.php';
require_once dirname( __FILE__ ) . '/admin/meta-box/class.wpb-wctm-meta-box-config.php';