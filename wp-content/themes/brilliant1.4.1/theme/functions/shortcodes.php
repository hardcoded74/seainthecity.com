<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * CMSMasters Shortcodes
 * Created by CMSMasters
 * 
 */


/**
 * Dropcaps Shortcodes
 */
function cmsmasters_dropcap($atts, $content = null) {
    return '<span class="dropcap">' . do_shortcode($content) . '</span>';
}

add_shortcode('dropcap', 'cmsmasters_dropcap');


function cmsmasters_dropcap2($atts, $content = null) {
    return '<span class="dropcap2">' . do_shortcode($content) . '</span>';
}

add_shortcode('dropcap2', 'cmsmasters_dropcap2');



/**
 * Button Shortcode
 */
function cmsmasters_button($atts, $content = null) {
    extract(shortcode_atts(array(
        'link' => '#',
        'type' => 'button',
        'target' => '',
        'lightbox' => '',
        'tooltip' => ''
    ), $atts));
    
    $out = '';
    
    $out .= '<a href="' . $link . '"';
    
    $out .= ' class="' . $type . '';
    
    if ($tooltip != '') {
        $out .= ' link_tooltip';
    }
    
    $out .= '"';
    
    if ($target == '_blank') {
        $out .= ' target="' . $target . '"';
    }
    
    if ($lightbox == 'true') {
        $out .= ' rel="prettyPhoto"';
    }
    
    if ($tooltip != '') {
        $out .= ' title="' . $tooltip . '"';
    }
    
    $out .= ' alt="';
    $out .= do_shortcode($content);
    $out .= '">' . 
		'<span>';
	
    $out .= do_shortcode($content);
	
	$out .= '</span>' . 
	'</a>';
    
    return $out;
}

add_shortcode('button', 'cmsmasters_button');



/**
 * Information Boxes Shortcodes
 */
function cmsmasters_success_box($atts, $content = null) {
    return '<aside class="box success_box">' . 
        '<table>' . 
            '<tbody>' . 
                '<tr>' . 
                    '<td>&nbsp;</td>' . 
                    '<td>' . do_shortcode($content) . '</td>' . 
                '</tr>' . 
            '</tbody>' . 
        '</table>' . 
    '</aside>';
}

add_shortcode('success_box', 'cmsmasters_success_box');


function cmsmasters_error_box($atts, $content = null) {
    return '<aside class="box error_box">' . 
        '<table>' . 
            '<tbody>' . 
                '<tr>' . 
                    '<td>&nbsp;</td>' . 
                    '<td>' . do_shortcode($content) . '</td>' . 
                '</tr>' . 
            '</tbody>' . 
        '</table>' . 
    '</aside>';
}

add_shortcode('error_box', 'cmsmasters_error_box');


function cmsmasters_download_box($atts, $content = null) {
    return '<aside class="box download_box">' . 
        '<table>' . 
            '<tbody>' . 
                '<tr>' . 
                    '<td>&nbsp;</td>' . 
                    '<td>' . do_shortcode($content) . '</td>' . 
                '</tr>' . 
            '</tbody>' . 
        '</table>' . 
    '</aside>';
}

add_shortcode('download_box', 'cmsmasters_download_box');


function cmsmasters_warning_box($atts, $content = null) {
    return '<aside class="box warning_box">' . 
        '<table>' . 
            '<tbody>' . 
                '<tr>' . 
                    '<td>&nbsp;</td>' . 
                    '<td>' . do_shortcode($content) . '</td>' . 
                '</tr>' . 
            '</tbody>' . 
        '</table>' . 
    '</aside>';
}

add_shortcode('warning_box', 'cmsmasters_warning_box');


function cmsmasters_notice_box($atts, $content = null) {
    return '<aside class="box notice_box">' . 
        '<table>' . 
            '<tbody>' . 
                '<tr>' . 
                    '<td>&nbsp;</td>' . 
                    '<td>' . do_shortcode($content) . '</td>' . 
                '</tr>' . 
            '</tbody>' . 
        '</table>' . 
    '</aside>';
}

add_shortcode('notice_box', 'cmsmasters_notice_box');



/**
 * Tabs & Toggles Shortcodes
 */
function cmsmasters_tabs($atts, $content = null) {
    $content = str_replace('[tab]', '<div class="tabs_tab">', str_replace('[/tab]', '</div>', do_shortcode($content)));
    
    $out = '<div class="tab">' . 
        '<ul class="tabs">';
    
    foreach ($atts as $tab) {
        $out .= '<li>' . 
            '<a class="button" href="#"><span>' . $tab . '</span></a>' . 
        '</li>';
    }
    
    $out .= '</ul>' . 
        '<div class="tab_content">' . $content . '</div>' . 
    '</div>';
    
    return $out;
}

add_shortcode('tabs', 'cmsmasters_tabs');


function cmsmasters_toggle($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => ''
    ), $atts));
    
    $out = '<div class="togg">' . 
		'<a class="tog" href="#">' . 
			'<span class="cmsms_plus">' . 
				'<span class="cmsms_plus_inner">' . 
					'<span class="vert_line"></span>' . 
					'<span class="horiz_line"></span>' . 
				'</span>' . 
			'</span>' . 
			$title . 
		'</a>' . 
		'<div class="tab_content" style="display: none;">' . 
			do_shortcode($content) . 
		'</div>' . 
    '</div>';
    
    return $out;
}

add_shortcode('toggle', 'cmsmasters_toggle');


function cmsmasters_accordion($atts, $content = null) {
    $content = str_replace('<div class="togg">', '<div class="acc">', do_shortcode($content));
    $content = str_replace('<a class="tog" href="#">', '<a class="tog" href="#">', do_shortcode($content));
	
    $out = '<div class="accordion">' . $content . '</div>';
    
    return $out;
}

add_shortcode('accordion', 'cmsmasters_accordion');


function cmsmasters_tour($atts, $content = null) {
    $content = str_replace('[tour_tab]', '<div class="tour_box"><div class="tour_box_inner">', str_replace('[/tour_tab]', '</div></div>', do_shortcode($content)));
    
    $out = '<div class="tour_content">' . 
        '<ul class="tour fl">';
    
    foreach ($atts as $tour) {
        $out .= '<li>' . 
			'<a href="#">' . 
				$tour . 
				'<span class="arrow_block"></span>' . 
			'</a>' . 
		'</li>';
    }
    
    $out .= '</ul>' . 
        $content . 
    '</div>';
    
    return $out;
}

add_shortcode('tour', 'cmsmasters_tour');



/**
 * Columns Shortcodes
 */
function cmsmasters_one_third($atts, $content = null) {
    return '<div class="one_third">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_third', 'cmsmasters_one_third');


function cmsmasters_one_third_last($atts, $content = null) {
    return '<div class="one_third last">' . do_shortcode($content) . '</div>' . 
    '<div class="cl"></div>';
}

add_shortcode('one_third_last', 'cmsmasters_one_third_last');


function cmsmasters_two_third($atts, $content = null) {
    return '<div class="two_third">' . do_shortcode($content) . '</div>';
}

add_shortcode('two_third', 'cmsmasters_two_third');


function cmsmasters_two_third_last($atts, $content = null) {
    return '<div class="two_third last">' . do_shortcode($content) . '</div>' . 
    '<div class="cl"></div>';
}

add_shortcode('two_third_last', 'cmsmasters_two_third_last');


function cmsmasters_one_half($atts, $content = null) {
    return '<div class="one_half">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_half', 'cmsmasters_one_half');


function cmsmasters_one_half_last($atts, $content = null) {
    return '<div class="one_half last">' . do_shortcode($content) . '</div>' . 
    '<div class="cl"></div>';
}

add_shortcode('one_half_last', 'cmsmasters_one_half_last');


function cmsmasters_one_fourth($atts, $content = null) {
    return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_fourth', 'cmsmasters_one_fourth');


function cmsmasters_one_fourth_last($atts, $content = null) {
    return '<div class="one_fourth last">' . do_shortcode($content) . '</div>' . 
    '<div class="cl"></div>';
}

add_shortcode('one_fourth_last', 'cmsmasters_one_fourth_last');


function cmsmasters_three_fourth($atts, $content = null) {
    return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}

add_shortcode('three_fourth', 'cmsmasters_three_fourth');


function cmsmasters_three_fourth_last($atts, $content = null) {
    return '<div class="three_fourth last">' . do_shortcode($content) . '</div>' . 
    '<div class="cl"></div>';
}

add_shortcode('three_fourth_last', 'cmsmasters_three_fourth_last');



/**
 * Dividers Shortcodes
 */
function cmsmasters_divider() {
    return '<div class="divider"></div>';
}

add_shortcode('divider', 'cmsmasters_divider');


function cmsmasters_divider_top() {
    return '<div class="divider">' . 
        '<a class="fr" href="#"><small class="color_2">' . __('Top', 'cmsmasters') . ' &uarr;</small></a>' . 
        '<div class="cl"></div>' . 
    '</div>';
}

add_shortcode('divider_top', 'cmsmasters_divider_top');


function cmsmasters_clear() {
    return '<div class="cl"></div>';
}

add_shortcode('clear', 'cmsmasters_clear');



/**
 * Video Shortcodes
 */
function cmsmasters_video_widget($atts) {
    extract(shortcode_atts(array(
        'url' => '' 
    ), $atts));
    
    $out = '<div class="resizable_block">' . 
		get_video_iframe($url) . 
	'</div>';
    
    return $out;
}

add_shortcode('video', 'cmsmasters_video_widget');


function cmsmasters_html5video_widget($atts, $content = null) {
    extract(shortcode_atts(array(
		'mp4' => '',
		'm4v' => '',
		'ogg' => '',
		'ogv' => '',
		'webm' => '',
		'webmv' => '',
		'poster' => '',
		'controls' => '',
		'autoplay' => '',
		'loop' => '',
		'preload' => ''
	), $atts));
	
    $out = '<div class="resizable_block">' . 
		'<video class="fullwidth"';
	
    if ($poster != '') {
        $out .= ' poster="' . $poster . '"';
    }
	
    if ($controls != '') {
        $out .= ' controls="controls"';
    }
	
    if ($autoplay != '') {
        $out .= ' autoplay="autoplay"';
    }
	
    if ($loop != '') {
        $out .= ' loop="loop"';
    }
	
    if ($preload != '') {
        $out .= ' preload="' . $preload . '"';
    }
	
    $out .= '>';
	
	if ($mp4 != '') {
        $out .= '<source src="' . $mp4 . '" type="video/mp4" />';
	}
	
	if ($m4v != '') {
        $out .= '<source src="' . $m4v . '" type="video/mp4" />';
	}
	
	if ($ogg != '') {
        $out .= '<source src="' . $ogg . '" type="video/ogg" />';
	}
	
	if ($ogv != '') {
        $out .= '<source src="' . $ogv . '" type="video/ogg" />';
	}
	
	if ($webm != '') {
        $out .= '<source src="' . $webm . '" type="video/webm" />';
	}
	
	if ($webmv != '') {
        $out .= '<source src="' . $webmv . '" type="video/webm" />';
	}
	
	$out .= do_shortcode($content) . 
		'</video>' . 
	'</div>';
	
    return $out;
}

add_shortcode('html5video', 'cmsmasters_html5video_widget');


function cmsmastersSingleVideoPlayer($atts, $content = null) {
    extract(shortcode_atts(array(
		'mp4' => '', 
		'm4v' => '', 
		'ogg' => '', 
		'ogv' => '', 
		'webm' => '', 
		'webmv' => '', 
		'poster' => '' 
	), $atts));
	
    $unique_id = uniqid();
	
    $out = '<script type="text/javascript"> ' . 
        'jQuery(document).ready(function () { ' . 
            "jQuery('#jquery_jplayer_" . $unique_id . "').jPlayer( { " . 
                'ready : function () { ' . 
                    "jQuery(this).jPlayer('setMedia', { ";

                    if ($mp4 != '') {
                        $out .= "m4v : '" . $mp4 . "', ";
                    }

                    if ($m4v != '') {
                        $out .= "m4v : '" . $m4v . "', ";
                    }

                    if ($ogg != '') {
                        $out .= "ogv : '" . $ogg . "', ";
                    }

                    if ($ogv != '') {
                        $out .= "ogv : '" . $ogv . "', ";
                    }

                    if ($webm != '') {
                        $out .= "webmv : '" . $webm . "', ";
                    }

                    if ($webmv != '') {
                        $out .= "webmv : '" . $webmv . "', ";
                    }

                        $out .= "poster : '" . $poster . "' " . 
                    '} ); ' . 
                '}, ' . 
                "cssSelectorAncestor : '#jp_container_" . $unique_id . "', " . 
                "swfPath : '" . get_template_directory_uri() . "/css/', " . 
                "supplied : 'mp4, m4v, ogg, ogv, webm, webmv', " . 
				'size : { ' . 
					"width : '100%', " . 
					"height : '100%' " . 
				'} ' . 
            '} ); ' . 
        '} ); ' . 
    '</script>' . 
    '<div id="jp_container_' . $unique_id . '" class="jp-video fullwidth">' . 
        '<div class="jp-type-single">' . 
			'<div id="jquery_jplayer_' . $unique_id . '" class="jp-jplayer"></div>' .
			'<div class="jp-gui">' . 
				'<div class="jp-video-play">' . 
					'<a href="javascript:;" class="jp-video-play-icon" tabindex="1" title="' . __('Play', 'cmsmasters') . '">' . __('Play', 'cmsmasters') . '</a>' . 
				'</div>' . 
				'<div class="jp-interface">' . 
					'<div class="jp-progress">' . 
						'<div class="jp-seek-bar">' . 
							'<div class="jp-play-bar"></div>' . 
						'</div>' . 
					'</div>' . 
					'<div class="jp-duration"></div>' . 
					'<div class="jp-time-sep">/</div>' . 
					'<div class="jp-current-time"></div>' . 
					'<div class="jp-controls-holder">' . 
						'<ul class="jp-controls">' . 
							'<li><a href="javascript:;" class="jp-play" tabindex="1" title="' . __('Play', 'cmsmasters') . '"><span>' . __('Play', 'cmsmasters') . '</span></a></li>' . 
							'<li><a href="javascript:;" class="jp-pause" tabindex="1" title="' . __('Pause', 'cmsmasters') . '"><span>' . __('Pause', 'cmsmasters') . '</span></a></li>' . 
							'<li class="li-jp-stop"><a href="javascript:;" class="jp-stop" tabindex="1" title="' . __('Stop', 'cmsmasters') . '"><span>' . __('Stop', 'cmsmasters') . '</span></a></li>' . 
						'</ul>' . 
						'<div class="jp-volume-bar">' . 
							'<div class="jp-volume-bar-value"></div>' . 
						'</div>' . 
						'<ul class="jp-toggles">' . 
							'<li><a href="javascript:;" class="jp-mute" tabindex="1" title="' . __('Mute', 'cmsmasters') . '"><span>' . __('Mute', 'cmsmasters') . '</span></a></li>' . 
							'<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="' . __('Unmute', 'cmsmasters') . '"><span>' . __('Unmute', 'cmsmasters') . '</span></a></li>' . 
							'<li class="li-jp-full-screen"><a href="javascript:;" class="jp-full-screen" tabindex="1" title="' . __('Full Screen', 'cmsmasters') . '"><span>' . __('Full Screen', 'cmsmasters') . '</span></a></li>' . 
							'<li class="li-jp-restore-screen"><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="' . __('Restore Screen', 'cmsmasters') . '"><span>' . __('Restore Screen', 'cmsmasters') . '</span></a></li>' . 
						'</ul>' . 
						'<div class="jp-title">' . 
							'<ul>' . 
								'<li></li>' . 
							'</ul>' . 
						'</div>' . 
					'</div>' . 
				'</div>' . 
				'<div class="jp-no-solution">' . 
					'<span>' . __('Update Required', 'cmsmasters') . ' </span>' . 
					__('To play the media you will need to either update your browser to a recent version or update your', 'cmsmasters') . ' <a href="http://get.adobe.com/flashplayer/" target="_blank">' . __('Flash plugin', 'cmsmasters') . '</a>.' . 
				'</div>' . 
			'</div>' . 
        '</div>' . 
    '</div>';
	
    return $out;
}

add_shortcode('single_video_player', 'cmsmastersSingleVideoPlayer');


function cmsmastersMultipleVideoPlayer($atts, $content = null) {
    $unique_id = uniqid();
	
	$out = '<script type="text/javascript"> ' . 
        'jQuery(document).ready(function () { ' . 
            'new jPlayerPlaylist( { ' . 
				"jPlayer : '#jquery_jplayer_" . $unique_id . "', " . 
                "cssSelectorAncestor : '#jp_container_" . $unique_id . "', " . 
			'}, [' . do_shortcode($content) . '], { ' . 
                "swfPath : '" . get_template_directory_uri() . "/css/', " . 
                "supplied : 'mp4, m4v, ogg, ogv, webm, webmv', " . 
				'size : { ' . 
					"width : '100%', " . 
					"height : '100%' " . 
				'} ' . 
            '} ); ' . 
        '} ); ' . 
    '</script>' . 
    '<div id="jp_container_' . $unique_id . '" class="jp-video fullwidth playlist">' . 
		'<div class="jp-type-playlist">' . 
			'<div class="jp-type-list-parent">' . 
				'<div class="jp-type-list">' . 
					'<div id="jquery_jplayer_' . $unique_id . '" class="jp-jplayer"></div>' . 
					'<div class="jp-gui">' . 
						'<div class="jp-video-play">' . 
							'<a href="javascript:;" class="jp-video-play-icon" tabindex="1" title="' . __('Play', 'cmsmasters') . '">' . __('Play', 'cmsmasters') . '</a>' . 
						'</div>' . 
						'<div class="jp-interface">' . 
							'<div class="jp-progress">' . 
								'<div class="jp-seek-bar">' . 
									'<div class="jp-play-bar"></div>' . 
								'</div>' . 
							'</div>' . 
							'<div class="jp-duration"></div>' . 
							'<div class="jp-time-sep">/</div>' . 
							'<div class="jp-current-time"></div>' . 
							'<div class="jp-controls-holder">' . 
								'<ul class="jp-controls">' . 
									'<li><a href="javascript:;" class="jp-play" tabindex="1" title="' . __('Play', 'cmsmasters') . '"><span>' . __('Play', 'cmsmasters') . '</span></a></li>' . 
									'<li><a href="javascript:;" class="jp-pause" tabindex="1" title="' . __('Pause', 'cmsmasters') . '"><span>' . __('Pause', 'cmsmasters') . '</span></a></li>' . 
									'<li class="li-jp-stop"><a href="javascript:;" class="jp-stop" tabindex="1" title="' . __('Stop', 'cmsmasters') . '"><span>' . __('Stop', 'cmsmasters') . '</span></a></li>' . 
									'<li class="li-jp-previous"><a href="javascript:;" class="jp-previous" tabindex="1" title="' . __('Previous', 'cmsmasters') . '"><span>' . __('Previous', 'cmsmasters') . '</span></a></li>' . 
									'<li class="li-jp-next"><a href="javascript:;" class="jp-next" tabindex="1" title="' . __('Next', 'cmsmasters') . '"><span>' . __('Next', 'cmsmasters') . '</span></a></li>' . 
								'</ul>' . 
								'<div class="jp-volume-bar">' . 
									'<div class="jp-volume-bar-value"></div>' . 
								'</div>' . 
								'<ul class="jp-toggles">' . 
									'<li><a href="javascript:;" class="jp-mute" tabindex="1" title="' . __('Mute', 'cmsmasters') . '"><span>' . __('Mute', 'cmsmasters') . '</span></a></li>' . 
									'<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="' . __('Unmute', 'cmsmasters') . '"><span>' . __('Unmute', 'cmsmasters') . '</span></a></li>' . 
									'<li class="li-jp-full-screen"><a href="javascript:;" class="jp-full-screen" tabindex="1" title="' . __('Full Screen', 'cmsmasters') . '"><span>' . __('Full Screen', 'cmsmasters') . '</span></a></li>' . 
									'<li class="li-jp-restore-screen"><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="' . __('Restore Screen', 'cmsmasters') . '"><span>' . __('Restore Screen', 'cmsmasters') . '</span></a></li>' . 
								'</ul>' . 
								'<div class="jp-title">' . 
									'<ul>' . 
										'<li></li>' . 
									'</ul>' . 
								'</div>' . 
							'</div>' . 
						'</div>' . 
						'<div class="jp-no-solution">' . 
							'<span>' . __('Update Required', 'cmsmasters') . '</span>' . 
							__('To play the media you will need to either update your browser to a recent version or update your', 'cmsmasters') . ' <a href="http://get.adobe.com/flashplayer/" target="_blank">' . __('Flash plugin', 'cmsmasters') . '</a>.' . 
						'</div>' . 
					'</div>' . 
				'</div>' . 
			'</div>' . 
			'<div class="jp-playlist">' . 
				'<ul>' . 
					'<li>' . 
						'<div>' . 
							'<a href="javascript:;" class="jp-playlist-item-remove"></a>' . 
							'<a href="javascript:;" class="jp-playlist-item"></a>' . 
						'</div>' . 
					'</li>' . 
				'</ul>' . 
			'</div>' . 
		'</div>' . 
    '</div>';
	
    return $out;
}

add_shortcode('multiple_video_player', 'cmsmastersMultipleVideoPlayer');


function cmsmastersPlaylistVideo($atts, $content = null) {
    extract(shortcode_atts(array(
		'mp4' => '',
		'm4v' => '',
		'ogg' => '',
		'ogv' => '',
		'webm' => '',
		'webmv' => '',
		'poster' => '',
		'title' => ''
	), $atts));
	
    $out = '{ ';

    if ($mp4 != '') {
        $out .= "m4v : '" . $mp4 . "', ";
    }

    if ($m4v != '') {
        $out .= "m4v : '" . $m4v . "', ";
    }

    if ($ogg != '') {
        $out .= "ogv : '" . $ogg . "', ";
    }

    if ($ogv != '') {
        $out .= "ogv : '" . $ogv . "', ";
    }

    if ($webm != '') {
        $out .= "webmv : '" . $webm . "', ";
    }

    if ($webmv != '') {
        $out .= "webmv : '" . $webmv . "', ";
    }

        $out .= "poster : '" . $poster . "', " . 
        "title : '" . $title . "' " . 
    '}';
	
    return $out;
}

add_shortcode('video_playlist', 'cmsmastersPlaylistVideo');



/**
 * Audio Shortcodes
 */
function cmsmasters_html5audio_widget($atts, $content = null) {
    extract(shortcode_atts(array(
        'mp3' => '',
        'mp4' => '',
        'm4a' => '',
        'ogg' => '',
        'oga' => '',
        'webm' => '',
        'webma' => '',
        'wav' => '',
		'preload' => 'none',
		'controls' => '',
		'autoplay' => '',
		'loop' => ''
	), $atts));
	
    $out = '<audio style="width:100%;"';
	
    if ($controls != '') {
        $out .= ' controls="' . $controls . '"';
    }
	
    if ($autoplay != '') {
        $out .= ' autoplay="' . $autoplay . '"';
    }
	
    if ($loop != '') {
        $out .= ' loop="' . $loop . '"';
    }
	
    if ($preload != 'preload') {
        $out .= ' preload="' . $preload . '"';
    } else {
        $out .= ' preload=""';
    }
	
    $out .= '>';
	
    if ($mp3 != '') {
        $out .= '<source src="' . $mp3 . '" type="audio/mpeg" />';
    }
	
    if ($mp4 != '') {
        $out .= '<source src="' . $mp4 . '" type="audio/mpeg" />';
    }
	
    if ($m4a != '') {
        $out .= '<source src="' . $m4a . '" type="audio/mpeg" />';
    }
	
    if ($ogg != '') {
        $out .= '<source src="' . $ogg . '" type="audio/ogg" />';
    }
	
    if ($oga != '') {
        $out .= '<source src="' . $oga . '" type="audio/ogg" />';
    }
	
    if ($webm != '') {
        $out .= '<source src="' . $webm . '" type="audio/webm" />';
    }
	
    if ($webma != '') {
        $out .= '<source src="' . $webma . '" type="audio/webm" />';
    }
	
    if ($wav != '') {
        $out .= '<source src="' . $wav . '" type="audio/wav" />';
    }
	
    $out .= do_shortcode($content) . 
    '</audio>';
	
    return $out;
}

add_shortcode('html5audio', 'cmsmasters_html5audio_widget');


function cmsmastersSingleAudioPlayer($atts, $content = null) {
    extract(shortcode_atts(array(
        'mp3' => '',
        'mp4' => '',
        'm4a' => '',
        'ogg' => '',
        'oga' => '',
        'webma' => '',
        'webm' => '',
        'wav' => '' 
    ), $atts));
    
    $unique_id = uniqid();
    
    $out = '<script type="text/javascript"> ' . 
        'jQuery(document).ready(function () { ' . 
            "jQuery('#jquery_jplayer_" . $unique_id . "').jPlayer( { " . 
                'ready : function () { ' . 
                    "jQuery(this).jPlayer('setMedia', { ";

                    if ($mp3 != '') {
                        $out .= "m4a : '" . $mp3 . "', ";
                    }

                    if ($mp4 != '') {
                        $out .= "m4a : '" . $mp4 . "', ";
                    }

                    if ($m4a != '') {
                        $out .= "m4a : '" . $m4a . "', ";
                    }

                    if ($ogg != '') {
                        $out .= "oga : '" . $ogg . "', ";
                    }

                    if ($oga != '') {
                        $out .= "oga : '" . $oga . "', ";
                    }

                    if ($webma != '') {
                        $out .= "webma : '" . $webma . "', ";
                    }

                    if ($webm != '') {
                        $out .= "webma : '" . $webm . "', ";
                    }

                    if ($wav != '') {
                        $out .= "wav : '" . $wav . "', ";
                    }

                    $out .= '} ); ';

                    $out = str_replace(', }', ' }', $out);

                $out .= '} , ' . 
                "cssSelectorAncestor : '#jp_container_" . $unique_id . "', " . 
                "swfPath : '" . get_template_directory_uri() . "/css/', " . 
                "supplied : 'mp3, m4a, ogg, oga, webm, webma, wav', " . 
                "wmode : 'window' " . 
            '} ); ' . 
        '} ); ' . 
    '</script>' . 
    '<div id="jquery_jplayer_' . $unique_id . '" class="jp-jplayer" style="display:none;"></div>' . 
    '<div id="jp_container_' . $unique_id . '" class="jp-audio">' . 
        '<div class="jp-type-single">' . 
			'<div class="jp-gui jp-interface">' . 
				'<div class="jp-progress">' . 
					'<div class="jp-seek-bar">' . 
						'<div class="jp-play-bar"></div>' . 
					'</div>' . 
				'</div>' . 
				'<div class="jp-duration"></div>' . 
				'<div class="jp-time-sep">/</div>' . 
				'<div class="jp-current-time"></div>' .
				'<div class="jp-controls-holder">' .  
					'<ul class="jp-controls">' . 
						'<li><a href="javascript:;" class="jp-play" tabindex="1" title="' . __('Play', 'cmsmasters') . '"><span>' . __('Play', 'cmsmasters') . '</span></a></li>' . 
						'<li><a href="javascript:;" class="jp-pause" tabindex="1" title="' . __('Pause', 'cmsmasters') . '"><span>' . __('Pause', 'cmsmasters') . '</span></a></li>' . 
						'<li><a href="javascript:;" class="jp-stop" tabindex="1" title="' . __('Stop', 'cmsmasters') . '"><span>' . __('Stop', 'cmsmasters') . '</span></a></li>' . 
					'</ul>' . 
					'<div class="jp-volume-bar">' . 
						'<div class="jp-volume-bar-value"></div>' . 
					'</div>' . 
					'<ul class="jp-toggles">' . 
						'<li><a href="javascript:;" class="jp-mute" tabindex="1" title="' . __('Mute', 'cmsmasters') . '"><span>' . __('Mute', 'cmsmasters') . '</span></a></li>' . 
						'<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="' . __('Unmute', 'cmsmasters') . '"><span>' . __('Unmute', 'cmsmasters') . '</span></a></li>' . 
					'</ul>' . 
				'</div>' . 
			'</div>' . 
			'<div class="jp-title">' . 
				'<ul>' . 
					'<li></li>' . 
				'</ul>' . 
			'</div>' . 
			'<div class="jp-no-solution">' . 
				'<span>' . __('Update Required', 'cmsmasters') . '</span>' . 
				__('To play the media you will need to either update your browser to a recent version or update your', 'cmsmasters') . ' <a href="http://get.adobe.com/flashplayer/" target="_blank">' . __('Flash plugin', 'cmsmasters') . '</a>.' . 
			'</div>' . 
        '</div>' . 
    '</div>';
    
    return $out;
}

add_shortcode('single_audio_player', 'cmsmastersSingleAudioPlayer');


function cmsmastersMultipleAudioPlayer($atts, $content = null) {
    $unique_id = uniqid();

    $out = '<script type="text/javascript"> ' . 
        'jQuery(document).ready(function () { ' . 
            'new jPlayerPlaylist( { ' . 
				"jPlayer : '#jquery_jplayer_" . $unique_id . "', " . 
                "cssSelectorAncestor : '#jp_container_" . $unique_id . "' " . 
			'} , [' . do_shortcode($content) . '], { ' . 
                "swfPath : '" . get_template_directory_uri() . "/css/', " . 
                "supplied : 'mp3, m4a, ogg, oga, webm, webma, wav', " . 
                "wmode : 'window' " . 
            '} ); ' . 
        '} ); ' . 
    '</script>' . 
    '<div id="jquery_jplayer_' . $unique_id . '" class="jp-jplayer" style="display:none;"></div>' . 
	'<div id="jp_container_' . $unique_id . '" class="jp-audio">' . 
		'<div class="jp-type-playlist">' . 
			'<div class="jp-gui jp-interface">' . 
				'<div class="jp-progress">' . 
					'<div class="jp-seek-bar">' . 
						'<div class="jp-play-bar"></div>' . 
					'</div>' . 
				'</div>' . 
				'<div class="jp-duration"></div>' . 
				'<div class="jp-time-sep">/</div>' . 
				'<div class="jp-current-time"></div>' . 
				'<div class="jp-controls-holder">' .  
					'<ul class="jp-controls">' . 
						'<li><a href="javascript:;" class="jp-play" tabindex="1" title="' . __('Play', 'cmsmasters') . '"><span>' . __('Play', 'cmsmasters') . '</span></a></li>' . 
						'<li><a href="javascript:;" class="jp-pause" tabindex="1" title="' . __('Pause', 'cmsmasters') . '"><span>' . __('Pause', 'cmsmasters') . '</span></a></li>' . 
						'<li><a href="javascript:;" class="jp-stop" tabindex="1" title="' . __('Stop', 'cmsmasters') . '"><span>' . __('Stop', 'cmsmasters') . '</span></a></li>' . 
						'<li><a href="javascript:;" class="jp-previous" tabindex="1" title="' . __('Previous', 'cmsmasters') . '"><span>' . __('Previous', 'cmsmasters') . '</span></a></li>' . 
						'<li><a href="javascript:;" class="jp-next" tabindex="1" title="' . __('Next', 'cmsmasters') . '"><span>' . __('Next', 'cmsmasters') . '</span></a></li>' . 
					'</ul>' . 
					'<div class="jp-volume-bar">' . 
						'<div class="jp-volume-bar-value"></div>' . 
					'</div>' . 
					'<ul class="jp-toggles">' . 
						'<li><a href="javascript:;" class="jp-mute" tabindex="1" title="' . __('Mute', 'cmsmasters') . '"><span>' . __('Mute', 'cmsmasters') . '</span></a></li>' . 
						'<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="' . __('Unmute', 'cmsmasters') . '"><span>' . __('Unmute', 'cmsmasters') . '</span></a></li>' . 
					'</ul>' . 
				'</div>' . 
            '</div>' . 
			'<div class="jp-title">' . 
				'<ul>' . 
					'<li></li>' . 
				'</ul>' . 
			'</div>' . 
			'<div class="jp-no-solution">' . 
				'<span>' . __('Update Required', 'cmsmasters') . '</span>' . 
				__('To play the media you will need to either update your browser to a recent version or update your', 'cmsmasters') . ' <a href="http://get.adobe.com/flashplayer/" target="_blank">' . __('Flash plugin', 'cmsmasters') . '</a>.' . 
			'</div>' . 
        '</div>' . 
		'<div class="jp-playlist">' . 
			'<ul>' . 
				'<li>' . 
					'<div>' . 
						'<a href="javascript:;" class="jp-playlist-item-remove"></a>' . 
						'<a href="javascript:;" class="jp-playlist-item"></a>' . 
					'</div>' . 
				'</li>' . 
			'</ul>' . 
		'</div>' . 
    '</div>';
    
    return $out;
}

add_shortcode('multiple_audio_player', 'cmsmastersMultipleAudioPlayer');


function cmsmastersPlaylistAudio($atts, $content = null) {
    extract(shortcode_atts(array(
        'mp3' => '',
        'mp4' => '',
        'm4a' => '',
        'ogg' => '',
        'oga' => '',
        'webm' => '',
        'webma' => '',
        'wav' => '',
        'title' => ''
    ), $atts));
    
    $out = '{ ';

    if ($mp3 != '') {
        $out .= "m4a : '" . $mp3 . "', ";
    }

    if ($mp4 != '') {
        $out .= "m4a : '" . $mp4 . "', ";
    }

    if ($m4a != '') {
        $out .= "m4a : '" . $m4a . "', ";
    }

    if ($ogg != '') {
        $out .= "oga : '" . $ogg . "', ";
    }

    if ($oga != '') {
        $out .= "oga : '" . $oga . "', ";
    }

    if ($webma != '') {
        $out .= "webma : '" . $webma . "', ";
    }

    if ($webm != '') {
        $out .= "webma : '" . $webm . "', ";
    }

    if ($wav != '') {
        $out .= "wav : '" . $wav . "', ";
    }

    $out .= "title : '" . $title . "' " . 
    '}';
    
    return $out;
}

add_shortcode('audio_playlist', 'cmsmastersPlaylistAudio');



/**
 * Post Types Shortcodes
 */
function posttype_shortcode($atts, $content = null) {
    extract(shortcode_atts(array( 
        'post_type' => 'post',
        'post_sort' => 'latest',
        'post_category' => '',
        'post_number' => '3',
        'show_images' => 'false',
        'show_content' => 'false',
        'show_info' => 'false', 
        'read_more' => 'false',
		'post_scroll' => 'false',
		'shortcode_title' => ''
    ), $atts));
    
	global $page_layout;
	
	$uuid = uniqid();
	
    $queryArgs = array( 
		'posts_per_page' => $post_number, 
		'post_status' => 'publish', 
		'ignore_sticky_posts' => 1, 
		'post_type' => $post_type 
	);
	
    switch ($post_sort) {
    case 'category':
        if ($post_type == 'post') {
            $queryArgs['category_name'] = $post_category;
        } else {
            $queryArgs['tax_query'] = array(
                array( 
                    'taxonomy' => 'pt-categ', 
                    'field' => 'slug', 
                    'terms' => array($post_category) 
                )
            );
        }
        
        break;
    case 'popular':
        $queryArgs['order'] = 'DESC';
        $queryArgs['orderby'] = 'meta_value';
        $queryArgs['meta_key'] = 'cmsms_likes';
        
        break;
    }
	
	$col_width = ($page_layout == 'nobg') ? 'one_fourth' : 'one_third';
    
	if ($post_scroll == 'true') {
		$out = '<section id="portfolio_shortcode_' . $uuid . '" class="post_type_shortcode">' . 
			'<h3 class="cms_title">';
		
		if ($shortcode_title != '') {
			$out .= $shortcode_title;
		}
		
		if ($post_scroll == 'true') {
			$out .= '<span class="widget_navi">' . 
				'<a href="#" class="cmsms_content_prev_slide"></a>' . 
				'<a href="#" class="cmsms_content_next_slide"></a>' . 
			'</span>';
		}
		
		$out .= '</h3>' . 
		'<script type="text/javascript"> ' . 
			'jQuery(document).ready(function () { ' . 
				"jQuery('#portfolio_shortcode_$uuid .post_type_list').cmsmsResponsiveContentSlider( { " . 
					"sliderWidth : '100%', " . 
					"sliderHeight : 'auto', " . 
					'animationSpeed : 500, ' . 
					"animationEffect : 'slide', " . 
					"animationEasing : 'easeInOutExpo', " . 
					'pauseTime : 0, ' . 
					'activeSlide : 1, ' . 
					'touchControls : true, ' . 
					'pauseOnHover : false, ' . 
					'arrowNavigation : true, ' . 
					'slidesNavigation : false ' . 
				'} ); ' . 
			'} ); ' . 
		'</script>' . 
		'<ul class="post_type_list portfolio_container responsiveContentSlider">' . 
			'<li class="latest_item">';
    } else {
		$out = '<section class="post_type_shortcode short">';
	}
    
	$col_counter = 0;
    $posttype_query = new WP_Query($queryArgs);
    
    if ($posttype_query->have_posts()) :
        while ($posttype_query->have_posts()) : $posttype_query->the_post();
			if ($post_type == 'portfolio') {
				$type = get_post_meta(get_the_ID(), 'pt_format', true);
			} else {
				$type = get_post_format();
			}
			
			if (isset($counter)) {
				unset($counter);
			}
			
			$classes = '';
			
			if ($post_type == 'portfolio') {
				$new_classes = $col_width . ' format-' . $type;
			} else {
				$new_classes = $col_width;
			}
			
			foreach (get_post_class(array($new_classes)) as $class) {
				$classes .= ' ' . $class;
			}
			
			if ($post_scroll == 'true') {
				if ($page_layout == 'nobg' && $col_counter == 4) {
					$out .= '</li><li class="latest_item">';
					
					$col_counter = 0;
				} elseif ($page_layout != 'nobg' && $col_counter == 3) {
					$out .= '</li><li class="latest_item">';
					
					$col_counter = 0;
				}
			} else {
				if ($page_layout == 'nobg' && $col_counter == 4) {
					$out .= '<div class="cl"></div>';
					
					$col_counter = 0;
				} elseif ($page_layout != 'nobg' && $col_counter == 3) {
					$out .= '<div class="cl"></div>';
					
					$col_counter = 0;
				}
			}
			
			$out .= '<article class="' . ltrim($classes) . '">';
			
			$attachments =& get_children(array(
				'post_type' => 'attachment', 
				'post_mime_type' => 'image', 
				'post_parent' => get_the_ID(), 
				'orderby' => 'menu_order', 
				'order' => 'ASC' 
			));
			
			$post_link_text = get_post_meta(get_the_ID(), 'post_link_text', true);
			$post_link_link = get_post_meta(get_the_ID(), 'post_link_link', true);
			
			if ($show_images == 'true') {
				if ($type == 'slider' || $type == 'album' || $type == 'gallery') {
					if (has_post_thumbnail()) {
						$out .= cmsms_thumb(get_the_ID(), 'project-thumb', true, false, true, false, true, false, false, false, true);
					} elseif (sizeof($attachments) > 0) {
						foreach ($attachments as $attachment) {
							if (!isset($counter) && $counter = true) {
								$out .= cmsms_thumb(get_the_ID(), 'project-thumb', true, false, true, false, true, false, $attachment->ID, false, true);
							}
						}
					} else {
						$out .= '<figure class="image_border">' . 
							'<a class="preloader" href="' . get_permalink() . '"' . ' title="' . cmsms_title(get_the_ID(), false) . '">' . 
								'<img src="' . get_template_directory_uri() . '/images/PT-gallery.jpg' . '" alt="' . cmsms_title(get_the_ID(), false) . '" title="' . cmsms_title(get_the_ID(), false) . '" class="fullwidth" />' . 
							'</a>' . 
						'</figure>';
					}
				} else {
					if (has_post_thumbnail()) {
						$out .= cmsms_thumb(get_the_ID(), 'project-thumb', true, false, true, false, true, false, false, false, true);
					} else {
						$out .= '<figure class="image_border">' . 
							'<a class="preloader" href="' . get_permalink() . '"' . ' title="' . cmsms_title(get_the_ID(), false) . '">' . 
								'<img src="' . get_template_directory_uri() . '/images/PT-' . (($type == 'image' || $type == '') ? 'placeholder' : $type) . '.jpg' . '" alt="' . cmsms_title(get_the_ID(), false) . '" title="' . cmsms_title(get_the_ID(), false) . '" class="fullwidth" />' . 
							'</a>' . 
						'</figure>';
					}
				}
			}
			
			if ($type != 'aside' && $type != 'link' && $type != 'quote') {
				$out .= '<header class="entry-header">' . 
					'<h6 class="entry-title">' . 
						'<a href="' . get_permalink() . '" title="' . cmsms_title(get_the_ID(), false) . '">' . cmsms_title(get_the_ID(), false) . '</a>' . 
					'</h6>' . 
					'<div class="divider"></div>' .
				'</header>';
			} elseif ($type == 'link') {
				$out .= '<header class="entry-header">' . 
					'<h6 class="entry-title">' . 
						'<a href="' . $post_link_link . '" title="' . $post_link_text . '">[' . __('Link', 'cmsmasters') . '] ' . $post_link_text . '</a>' . 
					'</h6>' . 
					'<div class="divider"></div>' .
				'</header>';
			} elseif ($type == 'aside' || $type == 'quote') {
				$out .= '<header class="entry-header">' . 
					'<h6 class="entry-title">' . theme_excerpt(20, false) . '</h6>' . 
					'<div class="divider"></div>' .
				'</header>';
			} elseif ($type == 'quote') {
				$out .= '<header class="entry-header">';
				
				if (has_excerpt()) {
					$out .= '<h6 class="entry-title">' . get_the_excerpt() . '</h6>' . '<div class="divider"></div>';
				} else {
					$out .= '<h6 class="entry-title">' . __('Enter post excerpt', 'cmsmasters') . '</h6>' . '<div class="divider"></div>';
				}
				
				$out .= '</header>';
			}
			
			if ($show_info == 'true') {
				$out .= '<footer class="entry-meta no_margin">';
				
				if ($post_type == 'post') {
					
					if (get_the_category()) {
						$output = '';
						
						$out .= '<ul class="post-categories">';
						
						foreach (get_the_category() as $category) {
							$output .= '<li>' . ', ' . 
								'<a href="' . esc_url(get_category_link($category->cat_ID)) . '" title="' . __('View all posts in', 'cmsmasters') . ' ' . $category->cat_name . '" rel="category tag">' . $category->cat_name . '</a>' . 
							'</li>';
						}
						
						$output = substr($output, 6);
						
						$out .= '<li>' . $output . 
						'</ul>';
					} 
					
				} else {
					if (get_the_terms(get_the_ID(), 'pt-sort-categ')) {
						$out .= '<ul class="post-categories">' . 
							get_the_term_list(get_the_ID(), 'pt-sort-categ', '<li>', ',&nbsp;</li><li>', '</li>') . 
						'</ul>';
					}
				}
				
				$out .= '</footer>';
			}
			
			if ($show_content == 'true' && $type != 'aside' && $type != 'link' && $type != 'quote') {
				$out .= '<div class="entry-content">' . 
					'<p>' . theme_excerpt(20, false) . '</p>' . 
				'</div>';
			}
			
			if ($read_more == 'true' && $type != 'aside' && $type != 'link' && $type != 'quote') {
				$post_more_text = get_post_meta(get_the_ID(), 'post_more_text', true);
				
				if ($post_more_text == '') {
					$post_more_text = __('Read More', 'cmsmasters');
				}
				
				$out .= '<a class="button" href="' . get_permalink(get_the_ID()) . '">' . 
					'<span>' . $post_more_text . '</span>' . 
				'</a>';
			}
			
			$out .= '</article>';
			
			$col_counter++;
        endwhile;
		
		if ($post_scroll == 'true') {
			$out .= '</li></ul>';
		}
    endif;
    
    $out .= '<div class="cl"></div>' . 
    '</section>';
    
    wp_reset_postdata();
    
    return $out;
}

add_shortcode('posttype', 'posttype_shortcode');



/**
 * Contact Form Shortcode
 */
function custom_contact_form_sc($atts, $content = null) {
    extract(shortcode_atts(array(
        'formname' => '',
        'email' => ''
    ), $atts));
	
	wp_enqueue_script('validator');
	wp_enqueue_script('validatorLanguage');
    
    $out = cmsmasters_contact_form($formname, $email);
    
    return $out;
}

add_shortcode('contactform', 'custom_contact_form_sc');



/**
 * Google Map Shortcode
 */
function cmsmasters_googlemap($atts, $content = null) {
    extract(shortcode_atts(array(
        'map_type' => 'ROADMAP',
        'zoom' => '14',
        'address' => '',
        'latitude' => '',
        'longitude' => '',
        'marker' => '',
        'popup_html' => '',
        'popup' => 'false',
        'scroll_wheel' => 'false',
        'map_type_control' => 'false',
        'zoom_control' => 'false',
        'pan_control' => 'false',
        'scale_control' => 'false',
        'street_view_control' => 'false'
    ), $atts));
    
	wp_enqueue_script('gMapAPI');
	wp_enqueue_script('gMap');
    
    $id = uniqid();
	
    if (isset($latitude) && isset($longitude) && !empty($latitude) && !empty($longitude)) {
        $l = 'latitude : ' . $latitude . ', ' . 
        'longitude : ' . $longitude . ', ';
    } else {
        $l = '';
    }
    
    if (isset($marker) && $marker == 'true') {
        if (isset($latitude) && isset($longitude) && !empty($latitude) && !empty($longitude)) {
            $location = 'markers : [ { ' . 
                $l . 
                'html : "' . $popup_html . '", ' . 
                'popup : ' . $popup . 
            ' } ] , ';
        } else {
            $location = 'markers : [ { ' . 
                'address : "' . $address . '", ' . 
                'html : "' . $popup_html . '", ' . 
                'popup : ' . $popup . 
            ' } ] , ';
        }
    } else {
        if (isset($latitude) && isset($longitude) && !empty($latitude) && !empty($longitude)) {
            $location = $l;
        } else {
            $location = 'address : "' . $address . '", ';
        }
    }
    
    $options = $location . 
    'zoom : ' . $zoom . ', ' . 
    'maptype : google.maps.MapTypeId.' . $map_type . ', ' . 
    'scrollwheel : ' . $scroll_wheel . ', ' . 
    'mapTypeControl : ' . $map_type_control . ', ' . 
    'zoomControl : ' . $zoom_control . ', ' . 
    'panControl : ' . $pan_control . ', ' . 
    'scaleControl : ' . $scale_control . ', ' . 
    'streetViewControl : ' . $street_view_control;
    
    $out = '<div class="resizable_block">' . 
		'<div id="google_map_' . $id . '" class="google_map fullwidth"></div>' . 
	'</div>' . 
    '<script type="text/javascript">' . 
        'jQuery(document).ready(function () { ' . 
            'jQuery("#google_map_' . $id . '").gMap( { ' . $options . ' } );' . 
        ' } );' . 
    '</script>';
    
    return $out;
}

add_shortcode('googlemap', 'cmsmasters_googlemap');



/**
 * Content Slider Shortcode
 */
function cmsmasters_content_slider($atts, $content = null) {
    extract(shortcode_atts(array(
		'height' => 'auto', 
		'animation_speed' => '500', 
		'effect' => 'slide', 
		'easing' => 'easeInOutExpo', 
		'pause_time' => '7000', 
		'active_slide' => '1', 
		'pause_on_hover' => 'false', 
		'touch_control' => 'true', 
		'slides_control' => 'true', 
		'slides_control_hover' => 'false', 
		'arrow_control' => 'false', 
		'arrow_control_hover' => 'false' 
	), $atts));
	
    $id = uniqid();
	$images = explode(',', do_shortcode($content));
	
    $out = '<div class="shortcode_slideshow slider_shortcode" id="slideshow_' . $id . '">' . 
		'<div class="shortcode_slideshow_body">' . 
			'<script type="text/javascript">' . 
				'jQuery(document).ready(function () { ' . 
					"jQuery('#slideshow_" . $id . " .shortcode_slideshow_slides').cmsmsResponsiveContentSlider( { " . 
						"sliderWidth : '100%', " . 
						"sliderHeight : " . (($height == 'auto') ? "'auto'" : $height) . ", " . 
						'animationSpeed : ' . ($animation_speed * 1000) . ', ' . 
						"animationEffect : '" . $effect . "', " . 
						"animationEasing : '" . $easing . "', " . 
						'pauseTime : ' . ($pause_time * 1000) . ', ' . 
						'activeSlide : ' . $active_slide . ', ' . 
						'pauseOnHover : ' . (($pause_on_hover == 'true') ? 'true' : 'false') . ', ' . 
						'touchControls : ' . (($touch_control == 'true') ? 'true' : 'false') . ', ' . 
						'slidesNavigation : ' . (($slides_control == 'true') ? 'true' : 'false') . ', ' . 
						'slidesNavigationHover : ' . (($slides_control_hover == 'true') ? 'true' : 'false') . ', ' . 
						'arrowNavigation : ' . (($arrow_control == 'true') ? 'true' : 'false') . ', ' . 
						'arrowNavigationHover : ' . (($arrow_control_hover == 'true') ? 'true' : 'false') . ' ' . 
					'} ); ' . 
				'} );' . 
			'</script>' . 
			'<div class="shortcode_slideshow_container">' . 
				'<ul class="shortcode_slideshow_slides responsiveContentSlider">';
	
	foreach ($images as $image) { 
		$out .= '<li>' . 
			'<figure>' . 
				'<img src="' . $image . '" alt="" class="fullwidth" />' . 
			'</figure>' . 
		'</li>';
	}
	
    $out .= '</ul>' . 
			'</div>' . 
		'</div>' . 
	'</div>' . 
	'<br />';
	
    return $out;
}

add_shortcode('content_slider', 'cmsmasters_content_slider');



/**
 * Main Slider Shortcode
 */
function cmsmasters_slider($atts, $content = null) {
    extract(shortcode_atts(array(
		'slider_id' => '' 
	), $atts));
	
    $sliderManager = new cmsmsSliderManager();
    $sliderOptions = $sliderManager->getSlider($slider_id);
	
    $out = '<ul id="slider" class="responsiveSlider">';
	
    foreach ($sliderOptions['slider']['slides'] as $slide) {
        $slide_link = $slide['slide_link'];
        $slide_title = $slide['slide_title'];
        $show_caption = $slide['show_caption'];
        $slide_caption_pos = $slide['slide_caption_pos'];
        $caption_title = $slide['caption_title'];
        $caption_text = $slide['caption_text'];
        $caption_link_enable = $slide['caption_link_enable'];
        $slide_caption_text_or_button = $slide['slide_caption_text_or_button'];
        $slide_caption_url_text = $slide['slide_caption_url_text'];
        $slide_link_text_value = $slide['slide_link_text_value'];
        $slide_link_target = $slide['slide_link_target'];
        $slide_add_video = $slide['slide_add_video'];
        $slide_video_url = $slide['slide_video_url'];
        $slide_img_pos = $slide['slide_img_pos'];
        $slide_as_link_add = $slide['slide_as_link_add'];
        $slide_as_link_url = $slide['slide_as_link_url'];
        $slide_as_link_target = $slide['slide_as_link_target'];
		
        $out .= '<li class="' . $slide_img_pos . '"';
		
        if ($slide_add_video == 'true' && $slide_video_url != '') {
            $out .= ' data-video="' . $slide_video_url . '"';
		}
		
        $out .= '>';
		
		if ($slide_as_link_target == 'true') {
			$slide_target = ' target="_blank"';
		} else {
			$slide_target = '';
		}
		
		if ($slide_as_link_add == 'true' && $slide_as_link_url != '') { 
			$out .= '<a href="' . $slide_as_link_url . '"' . (($caption_title != '') ? ' title="' . $caption_title . '"' : '') . $slide_target . '>';
		}
		
		$out .= '<img src="' . $slide['slide_link'] . '" alt="' . $slide['slide_title'] . '" />';
		
		if ($slide_as_link_add == 'true' && $slide_as_link_url != '') { 
			$out .= '</a>';
		}
		
        if ($show_caption == 'true') {
            $out .= '<div class="slideCaption ' . $slide_caption_pos . '">' . 
				'<div class="slideCaptionInner">' . 
					'<div class="slideCaptionInnerBlock">';
			
            if ($caption_title != '') {
                $out .= '<h1>' . $caption_title . '</h1>';
            }
			
            if ($caption_text != '') {
				$out .= '<h6>' . strip_tags($caption_text) . '</h6>';
            }
			
            if ($slide_link_target == 'true') {
                $target = ' target="_blank"';
            } else {
                $target = '';
            }
            
            if ($caption_link_enable == 'true' && $slide_caption_text_or_button == 'link') {
                $out .= '<a' . $target . ' href="' . $slide_link_text_value . '" class="with_arrow">' . $slide_caption_url_text . '</a>';
            } elseif ($caption_link_enable == 'true' && $slide_caption_text_or_button == 'button') {
                $out .= '<a class="button"' . $target . ' href="' . $slide_link_text_value . '"><span>' . $slide_caption_url_text . '</span></a>';
            }
			
            $out .= '</div>' . 
				'</div>' . 
			'</div>';
        }
		
        $out .= '</li>';
    }
	
    $out .= '</ul>';
	
    echo $out;
}

add_shortcode('cmsmasters_slider', 'cmsmasters_slider');

