<?php /*

Plugin Name:  Ustream
Version:      1.0.6
Description:  Adds support for easily embedding Ustream.tv content.
Author:       Ustream, Inc.
Author URI:   http://ustream.tv

*/

if ( function_exists('wp_oembed_add_provider') ) {
	add_action( 'plugins_loaded', 'enable_oembed_ustream', 7 );
}

function enable_oembed_ustream() {
	wp_oembed_add_provider( '#http://(www\.)?ustream.tv/*#i', 'http://www.ustream.tv/oembed', true );
}
?>