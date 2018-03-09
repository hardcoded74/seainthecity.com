<?php
/**
 * Plugin Name: WooSocio
 * Plugin URI: http://genialsouls.com/
 * Description: This plugin will upload/post your Woo products to facebook wall, pages and groups on publish. Also adds like/share buttons in Woo products.
 * Author: Qamar Sheeraz
 * Author URI: http://genialsouls.com/
 * Version: 1.4.3
 * Stable tag: 1.4.3
 * License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 require_once( 'classes/class-woo-socio.php' );
 require_once( 'classes/woosocio_widget.php' );

 // FaceBook integrations.
 require_once( 'classes/facebook.php' );
 require_once( 'facebook/autoload.php' );

 global $woosocio;
 $woosocio = new Woo_Socio( __FILE__ );
 $woosocio->version = '1.4.3';
 $woosocio->init();
?>