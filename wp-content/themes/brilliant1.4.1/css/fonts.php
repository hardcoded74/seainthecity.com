<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Fonts & Colors Settings File
 * Created by CMSMasters
 * 
 */


header('Content-type: text/css');
require('../../../../wp-load.php');
require('../theme/classes/var.php');

$colors = str_replace('#', '', $slider_top_bottom_color);
$color1 = hexdec(substr($colors, 0, 2));
$color2 = hexdec(substr($colors, 2, 2));
$color3 = hexdec(substr($colors, 4, 2));

$rgba = 'rgba(' . $color1 . ', ' . $color2 . ', ' . $color3 . ', .3)';
?>
/* Fonts */

body, 
li p,
input[type="submit"],
.widget_custom_recent_entries ul li .published,
.widget_custom_comments_entries ul li .published, 
.widget_custom_popular_entries ul li .published, 
.widget_custom_twitter_entries ul li .published {
	font : <?php $content_font_new = explode(':', stripslashes($content_font));
	
	echo $content_font_size . 'px/' . 
	$content_line_height . 'px ' . 
	((strpos($content_font_new[0], '+')) ? "'" . str_replace('+', ' ', $content_font_new[0]) . "'" : $content_font_new[0]); ?>;
}

h1,
a.logo span.title {
	font : <?php $h1_font_new = explode(':', stripslashes($h1_font));
	
	echo $h1_font_size . 'px/' . 
	$h1_line_height . 'px ' . 
	((strpos($h1_font_new[0], '+')) ? "'" . str_replace('+', ' ', $h1_font_new[0]) . "'" : $h1_font_new[0]);
	
	if (str_replace('+', ' ', $h1_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

h1,
a.logo span.title {
	font-weight:300;
}

h2 {
	font : <?php $h2_font_new = explode(':', stripslashes($h2_font));
	
	echo $h2_font_size . 'px/' . 
	$h2_line_height . 'px ' . 
	((strpos($h2_font_new[0], '+')) ? "'" . str_replace('+', ' ', $h2_font_new[0]) . "'" : $h2_font_new[0]);
	
	if (str_replace('+', ' ', $h2_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

h2 {
	font-weight:300;
}

h3, 
.sitemap > li > span a {
	font : <?php $h3_font_new = explode(':', stripslashes($h3_font));
	
	echo $h3_font_size . 'px/' . 
	$h3_line_height . 'px ' . 
	((strpos($h3_font_new[0], '+')) ? "'" . str_replace('+', ' ', $h3_font_new[0]) . "'" : $h3_font_new[0]);
	
	if (str_replace('+', ' ', $h3_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

h3, 
.sitemap > li > span a {
	font-weight:300;
}

h4 {
	font : <?php $h4_font_new = explode(':', stripslashes($h4_font));
	
	echo $h4_font_size . 'px/' . 
	$h4_line_height . 'px ' . 
	((strpos($h4_font_new[0], '+')) ? "'" . str_replace('+', ' ', $h4_font_new[0]) . "'" : $h4_font_new[0]);
	
	if (str_replace('+', ' ', $h4_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

h5,
.tog, 
.sitemap > li > ul > li > span a, 
.cms_archive li {
	font : <?php $h5_font_new = explode(':', stripslashes($h5_font));
	
	echo $h5_font_size . 'px/' . 
	$h5_line_height . 'px ' . 
	((strpos($h5_font_new[0], '+')) ? "'" . str_replace('+', ' ', $h5_font_new[0]) . "'" : $h5_font_new[0]);
	
	if (str_replace('+', ' ', $h5_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

h5,
.tog, 
.sitemap > li > ul > li > span a, 
.cms_archive li {
	font-style:italic;
}

h6,
.table th {
	font : <?php $h6_font_new = explode(':', stripslashes($h6_font));
				
	echo $h6_font_size . 'px/' . 
	$h6_line_height . 'px ' . 
	((strpos($h6_font_new[0], '+')) ? "'" . str_replace('+', ' ', $h6_font_new[0]) . "'" : $h6_font_new[0]);
	
	if (str_replace('+', ' ', $h6_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

li {
	line-height:24px;
}

q, 
blockquote,
q:before, 
q:after, 
blockquote:before, 
blockquote:after,
.format-quote .entry-title {
	font : <?php $bqt_font_new = explode(':', stripslashes($bqt_font));
	
	echo $bqt_font_size . 'px/' . 
	$bqt_line_height . 'px ' . 
	((strpos($bqt_font_new[0], '+')) ? "'" . str_replace('+', ' ', $bqt_font_new[0]) . "'" : $bqt_font_new[0]);
	
	if (str_replace('+', ' ', $bqt_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

q, 
blockquote,
q:before, 
q:after, 
blockquote:before, 
blockquote:after,
.format-quote .entry-title {
	font-style:italic;
}

q:before, 
blockquote:before {
	font-size:28px;
	line-height:1em;
}

code {
	font : <?php $code_font_new = explode(':', stripslashes($code_font));
	
	echo $code_font_size . 'px/' . 
	$code_line_height . 'px ' . 
	((strpos($code_font_new[0], '+')) ? "'" . str_replace('+', ' ', $code_font_new[0]) . "'" : $code_font_new[0]);
	
	if (str_replace('+', ' ', $code_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

small, 
abbr,
.user_name,
.cmsms_comments,
.cmsms_tags li a,
.cmsms_category li a,
.post-categories li a,
.cmsms-form-builder span.db {
	font : <?php $small_font_new = explode(':', stripslashes($small_font));
	
	echo $small_font_size . 'px/' . 
	$small_line_height . 'px ' . 
	((strpos($small_font_new[0], '+')) ? "'" . str_replace('+', ' ', $small_font_new[0]) . "'" : $small_font_new[0]);
	
	if (str_replace('+', ' ', $small_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

input, 
textarea, 
select, 
option, 
.cmsms-form-builder .check_parent input[type="checkbox"]+label, 
.cmsms-form-builder .check_parent input[type="radio"]+label, 
.wpcf7 .wpcf7-list-item input[type="checkbox"]+span, 
.wpcf7 .wpcf7-list-item input[type="radio"]+span {
	font : <?php $input_font_new = explode(':', stripslashes($input_font));
	
	echo $input_font_size . 'px/' . 
	$input_line_height . 'px ' . 
	((strpos($input_font_new[0], '+')) ? "'" . str_replace('+', ' ', $input_font_new[0]) . "'" : $input_font_new[0]);
	
	if (str_replace('+', ' ', $input_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

#bottom .widget.widget_archive ul li a, 
#bottom .widget.widget_nav_menu ul li a, 
#bottom .widget.widget_links ul li a, 
#bottom .widget.widget_meta ul li a, 
#bottom .widget.widget_pages ul li a, 
#bottom .widget.widget_recent_entries ul li a, 
#bottom .widget.widget_categories ul li a {
	font-family : <?php $bottom_list_font_new = explode(':', stripslashes($bottom_list_font));
	
	echo ((strpos($bottom_list_font_new[0], '+')) ? "'" . str_replace('+', ' ', $bottom_list_font_new[0]) . "'" : $bottom_list_font_new[0]);
	
	if (str_replace('+', ' ', $bottom_list_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

.social_block,
#navigation > li > a, 
#navigation > li.current-menu-ancestor > a, 
#navigation > li.current_page_item > a, 
#navigation > li:hover > a {
	font : <?php $nav_title_font_new = explode(':', stripslashes($nav_title_font));
	
	echo $nav_title_font_size . 'px/' . 
	$nav_title_line_height . 'px ' . 
	((strpos($nav_title_font_new[0], '+')) ? "'" . str_replace('+', ' ', $nav_title_font_new[0]) . "'" : $nav_title_font_new[0]);
	
	if (str_replace('+', ' ', $nav_title_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

#navigation > li > a, 
#navigation > li.current-menu-ancestor > a, 
#navigation > li.current_page_item > a, 
#navigation > li:hover > a {
	font-weight : bold;
}

#navigation ul li a {
	font-family : <?php $nav_dropdown_font_new = explode(':', stripslashes($nav_dropdown_font));
	
	echo ((strpos($nav_dropdown_font_new[0], '+')) ? "'" . str_replace('+', ' ', $nav_dropdown_font_new[0]) . "'" : $nav_dropdown_font_new[0]);
	
	if (str_replace('+', ' ', $nav_dropdown_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
		echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
	} ?>;
}

#navigation ul li a {
	font-size:<?php echo $nav_dropdown_font_size; ?>px;
	line-height:<?php echo $nav_dropdown_line_height; ?>px;
}

#navigation ul li a {
	font-weight:bold;
}

@media only screen and (min-width: 541px) and (max-width: 1023px) {
	
	#navigation > li > a, 
	#navigation > li.current-menu-ancestor > a, 
	#navigation > li.current_page_item > a, 
	#navigation > li:hover > a,
	#navigation ul li a	{
		font-size : 1em;
		font-weight : normal;
	}
	
}


/* Colors */

body,
.color_1,
.tog.current,
.entry h5 a,
.sitemap > li span a,
.blog .format-link .entry-content h6 {
	color : <?php echo $text_color; ?>;
}

a,
.color_2,
.cmsmsLike:hover span,
.sitemap > li > span a:hover,
.sitemap > li > ul li span a,
.entry h5 a:hover,
.post-categories li a:hover,
.cmsms_category li a:hover,
.cmsms_tags a:hover,
.sitemap > li span a:hover,
ul.p_filter li a:hover,
ul.p_filter li.current a,
.user_name a:hover,
a.cmsms_comments:hover,
.related_posts_content .one_half a,
div.jp-playlist li a,
.tour li a {
	color : <?php echo $link_color; ?>;
}

a:hover,
div.jp-playlist li:hover a,
div.jp-playlist li.jp-playlist-current a,
.sitemap > li > ul li span a:hover,
.cms_archive li span a:hover,
.related_posts_content .one_half a:hover {
	color : <?php echo $link_hover_color; ?>;
}

h1 {
	color : <?php echo $h1_color; ?>;
}

h2 {
	color : <?php echo $h2_color; ?>;
}

h3 {
	color : <?php echo $h3_color; ?>;
}

h4 {
	color : <?php echo $h4_color; ?>;
}

h5 {
	color : <?php echo $h5_color; ?>;
}

h6 {
	color : <?php echo $h6_color; ?>;
}

#navigation li > a {
	color : <?php echo $nav_title_color; ?>;
}

#navigation li.current-menu-ancestor > a, 
#navigation li.current-menu-item > a, 
#navigation li:hover > a:hover, 
#navigation li:hover > a {
	color : <?php echo $nav_title_active_color; ?>;
}

#navigation li li > a {
	color : <?php echo $nav_dropdown_color; ?>;
}

#navigation li li.current-menu-ancestor > a, 
#navigation li li.current-menu-item > a, 
#navigation li li:hover > a:hover, 
#navigation ul li:hover > a {
	color : <?php echo $nav_dropdown_active_color; ?>;
}

q, 
blockquote,
span.dropcap,
.format-quote .entry-title,
.opened-article aside h3,
.post.hentry aside h3, 
.post.hentry #commentform h3,
.blog aside h5,
.post.hentry aside h5,
.comment-authorinfo .name {
	color : <?php echo $bqt_color; ?>;
}

code,
.color_3,
.table tbody td,
.comment-content,
.cmsms-form-builder span.db,
#middle label {
	color : <?php echo $code_color; ?>;
}

small, 
abbr,
.user_name,
.user_name a,
a.cmsms_comments,
.cmsms_tags a,
.post-categories li,
.post-categories li a,
.cmsms_category li,
.cmsms_category li a,
.cmsms_info {
	color : <?php echo $small_color; ?>;
}

input, 
textarea, 
select, 
option, 
.cmsms-form-builder .check_parent input[type="checkbox"]+label, 
.cmsms-form-builder .check_parent input[type="radio"]+label, 
.wpcf7 .wpcf7-list-item input[type="checkbox"]+span, 
.wpcf7 .wpcf7-list-item input[type="radio"]+span {
	color : <?php echo $input_color; ?>;
}

.social_block,
.responsiveSlider,
.responsiveSlider h1, 
.responsiveSlider h2, 
.responsiveSlider h3, 
.responsiveSlider h4, 
.responsiveSlider h5, 
.responsiveSlider h6,
#top_sidebar,
#top_sidebar h1, 
#top_sidebar h2, 
#top_sidebar h3, 
#top_sidebar h4, 
#top_sidebar h5, 
#top_sidebar h6,
#top_sidebar label,
#top_sidebar input, 
#top_sidebar textarea, 
#top_sidebar select, 
#top_sidebar option, 
#top_sidebar .cmsms-form-builder .check_parent input[type="checkbox"]+label, 
#top_sidebar .cmsms-form-builder .check_parent input[type="radio"]+label, 
#top_sidebar .wpcf7 .wpcf7-list-item input[type="checkbox"]+span, 
#top_sidebar .wpcf7 .wpcf7-list-item input[type="radio"]+span,
#bottom,
#bottom h1, 
#bottom h2, 
#bottom h3, 
#bottom h4, 
#bottom h5, 
#bottom h6,
#bottom label,
#bottom input, 
#bottom textarea,
#bottom select,
#bottom option,
#bottom .cmsms-form-builder .check_parent input[type="checkbox"]+label, 
#bottom .cmsms-form-builder .check_parent input[type="radio"]+label, 
#bottom .wpcf7 .wpcf7-list-item input[type="checkbox"]+span, 
#bottom .wpcf7 .wpcf7-list-item input[type="radio"]+span,
#footer {
	color : <?php echo $slider_top_bottom_color; ?>;
}

.responsiveSlider a,
#top_sidebar a,
#bottom a,
.logo {
	color : <?php echo $slider_top_bottom_link_color; ?>;
}

.responsiveSlider a:hover,
#top_sidebar a:hover,
#bottom a:hover,
.logo:hover {
	color : <?php echo $slider_top_bottom_link_hover_color; ?>;
}

.responsiveSlider .button,
.responsiveSlider .button:hover,
#top_sidebar .button, 
#top_sidebar .button_medium, 
#top_sidebar .button_large,
#top_sidebar .button:hover, 
#top_sidebar .button_medium:hover, 
#top_sidebar .button_large:hover,
#bottom .button, 
#bottom .button_medium, 
#bottom .button_large,
#bottom .button:hover, 
#bottom .button_medium:hover, 
#bottom .button_large:hover,
.pj_sort_wrap .button,
.tags li a:hover,
.dropcap2,
ul.p_filter li a,
.slide-description-short h1,
.formError .formErrorContent,
.blackPopup .formErrorContent,
.blackPopup .formErrorArrow div,
.wp-pagenavi a,
.wp-pagenavi a:hover,
.table thead th,
.table tfoot th {
	color:#ffffff;
}

code {border-top-color : <?php echo $link_color; ?>;}

#commentform input[type="text"]:focus,
#commentform textarea:focus,
.cmsms_input input[type="text"]:focus,
.cmsms_textarea textarea:focus,
.error .search_line input:focus,
.widget_search .search_line input:focus,
.wpcf7 input[type="file"],
input[type="text"]:focus, 
input[type="password"]:focus, 
textarea:focus, 
select:focus,
.pj_sort_wrap .pj_sort .button {
	border-color : <?php echo $link_color; ?>;
}

#top_sidebar .cmsms-form-builder input[type="text"]:focus,
#top_sidebar input[type="password"]:focus,
#top_sidebar .cmsms-form-builder textarea:focus,
#top_sidebar .widget_search .search_line input:focus,
#top_sidebar select:focus,
#bottom .cmsms-form-builder input[type="text"]:focus,
#bottom input[type="password"]:focus,
#bottom .cmsms-form-builder textarea:focus,
#bottom .widget_search .search_line input:focus,
#bottom select:focus {
	border-color : <?php echo $rgba; ?>;
}

#navigation > li.current_page_item > a, 
#navigation > li.current-menu-ancestor > a,
#navigation > li:hover > a,
.resp_navigation:hover,
.resp_navigation.active {
	background-color : <?php echo $nav_title_active_bg_color; ?>;
}

#navigation li:hover ul li:hover > a,
#navigation ul li.current_page_item > a,
#navigation ul li.current-menu-ancestor > a {
	background-color : <?php echo $nav_dropdown_active_bg_color; ?>;
}

.button,
.button_medium,
.button_large,
input[type="submit"], 
.comment-reply-link, 
.cmsms_plus, 
div.jp-playlist li.jp-playlist-current span, 
.tour li.current span,
#slide_top,
.shortcode_slideshow_container .cmsms_slides_nav a {
	background-color : #ffffff;
}

.responsiveSlider .button:hover,
#top_sidebar .button:hover, 
#top_sidebar .button_medium:hover, 
#top_sidebar .button_large:hover, 
#bottom .button:hover, 
#bottom .button_medium:hover, 
#bottom .button_large:hover,
a.cmsms_close_video, 
.table thead th, 
.table tfoot th, 
.dropcap2, 
.cmsmsLike:hover, 
a.cmsms_close_video:hover,
.wp-pagenavi a,
.shortcode_slideshow_container .cmsms_slides_nav a:hover,
.shortcode_slideshow_container .cmsms_slides_nav li.active a,
.content_wrap .widget_custom_portfolio_entries_container .cmsms_content_slider_parent .cmsms_slides_nav li a:hover,
.content_wrap .widget_custom_portfolio_entries_container .cmsms_content_slider_parent .cmsms_slides_nav li.active a,
.middle_sidebar .widget_custom_portfolio_entries_container .cmsms_content_slider_parent .cmsms_slides_nav li a:hover,
.middle_sidebar .widget_custom_portfolio_entries_container .cmsms_content_slider_parent .cmsms_slides_nav li.active a,
.p_sort .button,
.p_filter .button {
	background-color : <?php echo $link_color; ?>;
}

.content_wrap .widget_links li:before,
.content_wrap .widget_nav_menu li:before,
.content_wrap .widget_categories li:before,
.content_wrap .widget_archive li:before,
.content_wrap .widget_meta li:before,
.content_wrap .widget_pages li:before,
.content_wrap .widget_recent_comments li:before,
.content_wrap .widget_recent_entries li:before,
.content_wrap .widget_rss li:before,
.middle_sidebar .widget_links li:before,
.middle_sidebar .widget_nav_menu li:before,
.middle_sidebar .widget_categories li:before,
.middle_sidebar .widget_archive li:before,
.middle_sidebar .widget_meta li:before,
.middle_sidebar .widget_pages li:before,
.middle_sidebar .widget_recent_comments li:before,
.middle_sidebar .widget_recent_entries li:before,
.middle_sidebar .widget_rss li:before,
.content_wrap .widget_custom_portfolio_entries_container .cmsms_content_slider_parent .cmsms_slides_nav li a,
.middle_sidebar .widget_custom_portfolio_entries_container .cmsms_content_slider_parent .cmsms_slides_nav li a {
	background-color : <?php echo $text_color; ?>;
}

.widget_links li:before,
.widget_nav_menu li:before,
.widget_categories li:before,
.widget_archive li:before,
.widget_meta li:before,
.widget_pages li:before,
.widget_recent_comments li:before,
.widget_recent_entries li:before,
.widget_rss li:before {
	background-color : <?php echo $slider_top_bottom_color; ?>;
}

.cmsmsLike {
	background-color : #cccccc;
}

/* ---------- Mobile (Note: Design for a width less than 541px) ---------- */

@media only screen and (max-width: 540px) {
	
	#navigation li:hover ul li:hover > a,
	#navigation > li:hover > a {
		background-color:transparent;
		background-position:0 -50px;
	}
	
	#navigation > li > a:hover, 
	#navigation li:hover ul li > a:hover,
	#navigation li.current_page_item > a,
	#navigation li.current-menu-ancestor > a,
	#navigation > li.current_page_item:hover > a,
	#navigation > li.current-menu-ancestor:hover > a,
	#navigation li:hover ul li.current_page_item > a,
	#navigation li:hover ul li.current-menu-ancestor > a {
		background-color:#1baddf;
	}
	
	#navigation ul li a {
		font : <?php $nav_title_font_new = explode(':', stripslashes($nav_title_font));
	
		echo $nav_title_font_size . 'px/' . 
		$nav_title_line_height . 'px ' . 
		((strpos($nav_title_font_new[0], '+')) ? "'" . str_replace('+', ' ', $nav_title_font_new[0]) . "'" : $nav_title_font_new[0]);
		
		if (str_replace('+', ' ', $nav_title_font_new[0]) !== str_replace('+', ' ', $content_font_new[0])) { 
			echo ((strpos($content_font_new[0], '+')) ? ", '" . str_replace('+', ' ', $content_font_new[0]) . "'" : ', ' . $content_font_new[0]);
		} ?>;
		
		font-weight:bold;
	}
	
}

