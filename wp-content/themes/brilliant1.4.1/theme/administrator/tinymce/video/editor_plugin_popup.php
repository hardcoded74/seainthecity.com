<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Video Shortcodes Popup
 * Created by CMSMasters
 * 
 */


require_once('../../../../../../../wp-load.php');
require_once('../../../../../../../wp-admin/includes/admin.php');

do_action('admin_init');

if (!is_user_logged_in()) {
	die(__('You must be logged in to access this page', 'cmsmasters') . '.');
}

if (isset($_GET['type']) && $_GET['type'] != '') {
	$type = $_GET['type'];
} else {
	$type = 'video'; 
}

if (isset($_GET['content']) && $_GET['content'] != '') {
	$content = htmlspecialchars(stripslashes($_GET['content']));
} else {
	$content = ''; 
}

?>
<style type="text/css">
    #TB_window {
        font:13px sans-serif;
        overflow-x:hidden;
        overflow-y:auto;
    }
	
    #TB_ajaxContent h3 {
        margin-bottom:1em;
    }
    
    #TB_ajaxContent .media-item .describe {
        border-top:0;
    }
	
    #TB_ajaxContent input[type="button"] {
		cursor:pointer;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery(window).resize(function () {
            if (jQuery('#TB_window').height() - 44 > jQuery('.popup_content').height() + 20) {
                jQuery('#TB_ajaxContent').height(jQuery('#TB_window').height() - 44);
            } else {
                jQuery('#TB_ajaxContent').height(jQuery('.popup_content').height() + 20);
            }
        } );
        
        jQuery('.add_video').delegate('#add_video', 'click', function () {
            var i = (jQuery('#TB_ajaxContent .popup_tr_value').length / 4) + 1, 
				html = '';
            
            html = '<tr style="border-top:1px dotted #dfdfdf;">' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="video_player_mp4' + i + '"><?php _e('URL', 'cmsmasters'); ?> (mp4/m4v) ' + i + '</label>' + 
                    '</span>' + 
                    '<span class="alignright">' + 
                        '<abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>' + 
                    '</span>' + 
                '</th>' +
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="video_player_mp4' + i + '" id="video_player_mp4' + i + '" aria-required="true" class="popup_tr_value" />' + 
                    '<p class="help"><?php _e('For Internet Explorer, Google Chrome, Apple Safari', 'cmsmasters'); ?></p>' + 
                '</td>' + 
            '</tr>' + 
            '<tr>' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="video_player_ogg' + i + '"><?php _e('URL', 'cmsmasters'); ?> (ogg/ogv) ' + i + '</label>' + 
                    '</span>' + 
                    '<span class="alignright">' + 
                        '<abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>' + 
                    '</span>' + 
                '</th>' + 
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="video_player_ogg' + i + '" id="video_player_ogg' + i + '" aria-required="true" class="popup_tr_value" />' + 
                    '<p class="help"><?php _e('For Firefox, Google Chrome, Opera', 'cmsmasters'); ?></p>' + 
                '</td>' + 
            '</tr>' + 
            '<tr>' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="video_player_name' + i + '"><?php _e('Name', 'cmsmasters'); ?> ' + i + '</label>' + 
                    '</span>' + 
                    '<span class="alignright">' + 
                        '<abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>' + 
                    '</span>' + 
                '</th>' +
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="video_player_name' + i + '" id="video_player_name' + i + '" aria-required="true" class="popup_tr_value" />' + 
                '</td>' + 
            '</tr>' + 
            '<tr>' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="video_player_poster' + i + '"><?php _e('Poster image', 'cmsmasters'); ?> ' + i + '</label>' + 
                    '</span>' + 
                '</th>' +
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="video_player_poster' + i + '" id="video_player_poster' + i + '" class="popup_tr_value" />' + 
                '</td>' + 
            '</tr>';
            
            jQuery('tr.add_video').before(html);
        } );
    } );
    
    <?php 
    if ($type == 'video') { 
    ?>
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				video_url = jQuery('#video_url').val();
            
            for (var i = 0, ilength = popup_tr_value.length; i < ilength; i += 1) {
                popup_tr_value[i].style.removeProperty('border');
                
                if (popup_tr_value.eq(i).attr('aria-required') === 'true') {
                    if (popup_tr_value.eq(i).val() === '' || popup_tr_value.eq(i).val() === ' ') {
                        alert('<?php _e('Enter required fields!', 'cmsmasters'); ?>');
                        
                        popup_tr_value.eq(i).css('border', '1px solid #ff0000').focus();
                        
                        return false;
                    }
                }
            }
            
            shortcode_tag = '[video url="' + video_url + '"]';
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } elseif ($type == 'html5video') { 
    ?>
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				video_mp4 = jQuery('#video_mp4').val(), 
				video_ogv = jQuery('#video_ogv').val(), 
				video_support = jQuery('#video_support').val(), 
				video_preload = jQuery('#video_preload').val(), 
				video_poster = jQuery('#video_poster').val(), 
				video_control = jQuery('#video_control'), 
				video_autoplay = jQuery('#video_autoplay'), 
				video_loop = jQuery('#video_loop');
            
            for (var i = 0, ilength = popup_tr_value.length; i < ilength; i += 1) {
                popup_tr_value[i].style.removeProperty('border');
                
                if (popup_tr_value.eq(i).attr('aria-required') === 'true') {
                    if (popup_tr_value.eq(i).val() === '' || popup_tr_value.eq(i).val() === ' ') {
                        alert('<?php _e('Enter required fields!', 'cmsmasters'); ?>');
                        
                        popup_tr_value.eq(i).css('border', '1px solid #ff0000').focus();
                        
                        return false;
                    }
                }
            }
            
            shortcode_tag = '[html5video mp4="' + video_mp4 + '" ogv="' + video_ogv + '" preload="' + video_preload + '"';
            
            if (video_poster !== '' && video_poster !== ' ') {
                shortcode_tag += ' poster="' + video_poster + '"';
            }
            
            if (video_control.is(':checked')) {
                shortcode_tag += ' controls="' + video_control.val() + '"';
            }
            
            if (video_autoplay.is(':checked')) {
                shortcode_tag += ' autoplay="' + video_autoplay.val() + '"';
            }
            
            if (video_loop.is(':checked')) {
                shortcode_tag += ' loop="' + video_loop.val() + '"';
            }
            
            shortcode_tag += ']' + video_support + '[/html5video]';
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } elseif ($type == 'single_video_player') { 
    ?>
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				video_player_mp4 = jQuery('#video_player_mp4').val(), 
				video_player_ogg = jQuery('#video_player_ogg').val(), 
				video_player_name = jQuery('#video_player_name').val(), 
				video_player_poster = jQuery('#video_player_poster').val();
            
            for (var i = 0, ilength = popup_tr_value.length; i < ilength; i += 1) {
                popup_tr_value[i].style.removeProperty('border');
                
                if (popup_tr_value.eq(i).attr('aria-required') === 'true') {
                    if (popup_tr_value.eq(i).val() === '' || popup_tr_value.eq(i).val() === ' ') {
                        alert('<?php _e('Enter required fields!', 'cmsmasters'); ?>');
                        
                        popup_tr_value.eq(i).css('border', '1px solid #ff0000').focus();
                        
                        return false;
                    }
                }
            }
            
            shortcode_tag = '[single_video_player mp4="' + video_player_mp4 + '" ogg="' + video_player_ogg + '" title="' + video_player_name + '"';
			
			if (video_player_poster !== '' && video_player_poster !== ' ') {
				shortcode_tag += ' poster="' + video_player_poster + '"';
			}
			
			shortcode_tag += ']';
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } elseif ($type == 'multiple_video_player') { 
    ?>
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				tr = jQuery('#TB_ajaxContent tr');
            
            for (var i = 0, ilength = popup_tr_value.length; i < ilength; i += 1) {
                popup_tr_value[i].style.removeProperty('border');
                
                if (popup_tr_value.eq(i).attr('aria-required') === 'true') {
                    if (popup_tr_value.eq(i).val() === '' || popup_tr_value.eq(i).val() === ' ') {
                        alert('<?php _e('Enter required fields!', 'cmsmasters'); ?>');
                        
                        popup_tr_value.eq(i).css('border', '1px solid #ff0000').focus();
                        
                        return false;
                    }
                }
            }
            
            shortcode_tag = '[multiple_video_player]' + "\n";
            
            for (var i = 0, ilength = tr.length - 1; i < ilength; i += 4) {
                shortcode_tag += '[video_playlist mp4="' + tr.eq(i).find('.popup_tr_value').val() + '" ogg="' + tr.eq(i + 1).find('.popup_tr_value').val() + '" title="' + tr.eq(i + 2).find('.popup_tr_value').val() + '" poster="' + tr.eq(i + 3).find('.popup_tr_value').val() + '"],' + "\n";
            }
            
            shortcode_tag += '[/multiple_video_player]';
            
            shortcode_tag = shortcode_tag.replace("],\n[/multiple_video_player]", "]\n[/multiple_video_player]");
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } 
    ?>

    function closePopup() {
        tb_remove();
        
        return false;
    }
</script>
<div class="popup_content">
<?php 
if ($type == 'video') { 
    echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Embeded Video', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
} elseif ($type == 'html5video') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('HTML 5 Video', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
} elseif ($type == 'single_video_player') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Video Player', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
} elseif ($type == 'multiple_video_player') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Video Player With Playlist', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
}
?>
    <div id="media-items" class="media-upload-form">
        <div class="media-item">
            <table class="describe">
                <tbody>
                <?php 
                if ($type == 'video') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_url"><?php _e('URL', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php echo $content; ?>" name="video_url" id="video_url" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('You can use YouTube, Vimeo, DailyMotion or Screenr video here', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                <?php 
                } elseif ($type == 'html5video') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_mp4"><?php _e('URL', 'cmsmasters'); ?> (mp4/m4v)</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php echo $content; ?>" name="video_mp4" id="video_mp4" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Internet Explorer (9+), Google Chrome and Apple Safari', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_ogv"><?php _e('URL', 'cmsmasters'); ?> (ogg/ogv)</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="video_ogv" id="video_ogv" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Firefox, Google Chrome and Opera', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_support"><?php _e('Not Support Text', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php _e('Your browser does not support the video tag', 'cmsmasters'); ?>." name="video_support" id="video_support" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_preload"><?php _e('Preloading', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <select name="video_preload" id="video_preload" aria-required="true" class="popup_tr_value">
                                <option value="none"><?php _e('Not preload', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="auto"><?php _e('Preload auto', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="metadata"><?php _e('Preload as metadata', 'cmsmasters'); ?>&nbsp;</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_poster"><?php _e('Poster', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="video_poster" id="video_poster" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_control"><?php _e('Controls', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="controls" name="video_control" id="video_control" checked="checked" class="popup_tr_value" />
                            <label for="video_control"><?php _e('Show controls', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_autoplay"><?php _e('Autoplay', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="autoplay" name="video_autoplay" id="video_autoplay" class="popup_tr_value" />
                            <label for="video_autoplay"><?php _e('Autoplay video', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_loop"><?php _e('Repeat', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="loop" name="video_loop" id="video_loop" class="popup_tr_value" />
                            <label for="video_loop"><?php _e('Repeat video', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                <?php 
                } elseif ($type == 'single_video_player') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_player_mp4"><?php _e('URL', 'cmsmasters'); ?> (mp4/m4v)</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php echo $content; ?>" name="video_player_mp4" id="video_player_mp4" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Internet Explorer, Google Chrome and Apple Safari', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_player_ogg"><?php _e('URL', 'cmsmasters'); ?> (ogg/ogv)</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="video_player_ogg" id="video_player_ogg" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Firefox, Google Chrome and Opera', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_player_name"><?php _e('Name', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="video_player_name" id="video_player_name" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_player_poster"><?php _e('Poster', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="video_player_poster" id="video_player_poster" class="popup_tr_value" />
                        </td>
                    </tr>
                <?php 
                } elseif ($type == 'multiple_video_player') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_player_mp41"><?php _e('URL', 'cmsmasters'); ?> (mp4/m4v) 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php echo $content; ?>" name="video_player_mp41" id="video_player_mp41" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Internet Explorer, Google Chrome and Apple Safari', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_player_ogg1"><?php _e('URL', 'cmsmasters'); ?> (ogg/ogv) 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="video_player_ogg1" id="video_player_ogg1" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Firefox, Google Chrome and Opera', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_player_name1"><?php _e('Name', 'cmsmasters'); ?> 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="video_player_name1" id="video_player_name1" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="video_player_poster1"><?php _e('Poster', 'cmsmasters'); ?> 1</label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="video_player_poster1" id="video_player_poster1" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr class="add_video" style="border-top:1px dotted #dfdfdf;">
                        <th class="label" style="width:130px; padding-top:15px;" scope="row"></th>
                        <td class="field" style="padding-top:10px;">
                            <input type="button" value="<?php _e('Add Video to Playlist', 'cmsmasters'); ?>" name="add_video" id="add_video" />
                        </td>
                    </tr>
                <?php 
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div style="overflow:hidden; width:598px; padding:15px 10px 0 15px;">
        <div style="float: left">
            <input type="button" id="cancel" class="button" name="cancel" value="<?php _e('Cancel', 'cmsmasters'); ?>" onclick="closePopup();" />
        </div>
        <div style="float: right">
            <input type="submit" id="insert" class="button-primary" name="insert" value="<?php _e('Insert Shortcode', 'cmsmasters'); ?>" onclick="insertShortcode();" />
        </div>
    </div>
</div>
