<?php
/*
Plugin Name: Simple Youtube Shortcode
Plugin URI: http://www.marichiba.com/simple-youtube-shortcode
Description: Simple Youtube Shortcode embeds youtube videos or playlists, with options for width, height, and CSS styling.
Version: 1.1.3
Author: Matthew Marichiba
Author URI: http://www.marichiba.com/about-matthew
License: GPL2
*/

 /* Simple Youtube Shortcode
  * Embeds a youtube player by means of a simple shortcode. 
  * Input arguments: 
  * 	src - the src part of the iframe code given by YouTube. 
  *       Looks like: http://www.youtube.com/embed/4r7wHMg5Yjg 
  *   width - in px or %
  *   height - in px or %
  *   class - name of a CSS class
  *   id - name of a CSS id
  *   debug - Set to "true" to echo all arguments after the embedded player.
  * Returns: HTML code to embed the video player <iframe> 
  */
 
 /*  Copyright 2011  Matthew Marichiba  (email : matthew atsign marichiba dot com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function simple_youtube_shortcode($atts) 
//  Potential indexes of $atts = "src", "width", "height", "class", "id", "debug" 
  {
	if (!isset($atts['width'])) {$atts['width']="100%";}
	if (!isset($atts['height'])) {$atts['height']="400px";}
	if (!isset($atts['class'])) {$atts['class']="";}
    if (!isset($atts['id'])) {$atts['id']="";}
	$thesrc = $atts['src'];
	$width=$atts['width'];
	$height=$atts['height'];
    $class=$atts['class'];
    $id=$atts['id'];
	// Model output to look like the following:
	// <iframe width="425" height="349" class="myclass" id="myid" 
	// src="http://www.youtube.com/embed/olB56IEXpvE" 
	// frameborder="0" allowfullscreen></iframe>
	$embed_string =
		"<iframe width=\"". $width . "\" " . 
		"height=\"" . $height . "\" " .
		"class=\"" . $class . "\" " .
        "id=\"" . $id . "\" " .
		"src=\"" . $thesrc . "\" " . 
		"frameborder=\"0\" allowfullscreen>" . 
		"</iframe>" .
		"";

	if ( isset($atts['debug']) ) {
	    $embed_string = $embed_string . "<br>Here are the parameters:<br> width=".$width." height=".$height." class=".$class." id=".$id." src=".$thesrc." debug=".$atts['debug']."<br>";
    } 

	return $embed_string;  
}

add_shortcode("embed_youtube", "simple_youtube_shortcode");

?>