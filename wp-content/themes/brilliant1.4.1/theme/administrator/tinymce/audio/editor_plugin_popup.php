<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Audio Shortcodes Popup
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
	$type = 'html5audio'; 
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
        
        jQuery('.add_audio').delegate('#add_audio', 'click', function () {
            var i = (jQuery('#TB_ajaxContent .popup_tr_value').length / 3) + 1, 
				html = '';
            
            html = '<tr style="border-top:1px dotted #dfdfdf;">' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="audio_player_mp3' + i + '"><?php _e('URL', 'cmsmasters'); ?> (mp3) ' + i + '</label>' + 
                    '</span>' + 
                    '<span class="alignright">' + 
                        '<abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>' + 
                    '</span>' + 
                '</th>' +
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="audio_player_mp3' + i + '" id="audio_player_mp3' + i + '" aria-required="true" class="popup_tr_value" />' + 
                    '<p class="help"><?php _e('For Internet Explorer, Google Chrome and Apple Safari', 'cmsmasters'); ?></p>' + 
                '</td>' + 
            '</tr>' + 
            '<tr>' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="audio_player_ogg' + i + '"><?php _e('URL', 'cmsmasters'); ?> (ogg) ' + i + '</label>' + 
                    '</span>' + 
                    '<span class="alignright">' + 
                        '<abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>' + 
                    '</span>' + 
                '</th>' +
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="audio_player_ogg' + i + '" id="audio_player_ogg' + i + '" aria-required="true" class="popup_tr_value" />' + 
                    '<p class="help"><?php _e('For Firefox, Google Chrome and Opera', 'cmsmasters'); ?></p>' + 
                '</td>' + 
            '</tr>' + 
            '<tr>' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="audio_player_name' + i + '"><?php _e('Name', 'cmsmasters'); ?> ' + i + '</label>' + 
                    '</span>' + 
                    '<span class="alignright">' + 
                        '<abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>' + 
                    '</span>' + 
                '</th>' +
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="audio_player_name' + i + '" id="audio_player_name' + i + '" aria-required="true" class="popup_tr_value" />' + 
                '</td>' + 
            '</tr>';
            
            jQuery('tr.add_audio').before(html);
        } );
    } );
    
    <?php 
    if ($type == 'html5audio') { 
    ?>
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				audio_mp3 = jQuery('#audio_mp3').val(), 
				audio_ogg = jQuery('#audio_ogg').val(), 
				audio_support = jQuery('#audio_support').val(), 
				audio_preload = jQuery('#audio_preload').val(), 
				audio_control = jQuery('#audio_control'), 
				audio_autoplay = jQuery('#audio_autoplay'), 
				audio_loop = jQuery('#audio_loop');
            
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
            
            shortcode_tag = '[html5audio mp3="' + audio_mp3 + '" ogg="' + audio_ogg + '" preload="' + audio_preload + '"';
            
            if (audio_control.is(':checked')) {
                shortcode_tag += ' controls="' + audio_control.val() + '"';
            }
            
            if (audio_autoplay.is(':checked')) {
                shortcode_tag += ' autoplay="' + audio_autoplay.val() + '"';
            }
            
            if (audio_loop.is(':checked')) {
                shortcode_tag += ' loop="' + audio_loop.val() + '"';
            }
            
            shortcode_tag += ']' + audio_support + '[/html5audio]';
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } elseif ($type == 'single_audio_player') { 
    ?>
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				audio_mp3 = jQuery('#audio_player_mp3').val(), 
				audio_ogg = jQuery('#audio_player_ogg').val(), 
				audio_name = jQuery('#audio_player_name').val();
            
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
            
            shortcode_tag = '[single_audio_player mp3="' + audio_mp3 + '" ogg="' + audio_ogg + '" title="' + audio_name + '"]';
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } elseif ($type == 'multiple_audio_player') { 
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
            
            shortcode_tag = '[multiple_audio_player]' + "\n";
            
            for (var i = 0, ilength = tr.length - 1; i < ilength; i += 3) {
                shortcode_tag += '[audio_playlist mp3="' + tr.eq(i).find('.popup_tr_value').val() + '" ogg="' + tr.eq(i + 1).find('.popup_tr_value').val() + '" title="' + tr.eq(i + 2).find('.popup_tr_value').val() + '"],' + "\n";
            }
            
            shortcode_tag += '[/multiple_audio_player]';
            
            shortcode_tag = shortcode_tag.replace("],\n[/multiple_audio_player]", "]\n[/multiple_audio_player]");
            
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
if ($type == 'html5audio') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('HTML 5 Audio', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
} elseif ($type == 'single_audio_player') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Audio Player', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
} elseif ($type == 'multiple_audio_player') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Audio Player With Playlist', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
}
?>
    <div id="media-items" class="media-upload-form">
        <div class="media-item">
            <table class="describe">
                <tbody>
                <?php 
                if ($type == 'html5audio') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_mp3"><?php _e('URL', 'cmsmasters'); ?> (mp3)</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php echo $content; ?>" name="audio_mp3" id="audio_mp3" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Internet Explorer (9+), Google Chrome and Apple Safari', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_ogg"><?php _e('URL', 'cmsmasters'); ?> (ogg)</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="audio_ogg" id="audio_ogg" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Firefox, Google Chrome and Opera', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_support"><?php _e('Not Support Text', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php _e('Your browser does not support the audio tag', 'cmsmasters'); ?>." name="audio_support" id="audio_support" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_preload"><?php _e('Preloading', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <select name="audio_preload" id="audio_preload" aria-required="true" class="popup_tr_value">
                                <option value="none"><?php _e('Not preload', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="auto"><?php _e('Preload auto', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="metadata"><?php _e('Preload as metadata', 'cmsmasters'); ?>&nbsp;</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_control"><?php _e('Controls', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="controls" name="audio_control" id="audio_control" checked="checked" class="popup_tr_value" />
                            <label for="audio_control"><?php _e('Show controls', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_autoplay"><?php _e('Autoplay', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="autoplay" name="audio_autoplay" id="audio_autoplay" class="popup_tr_value" />
                            <label for="audio_autoplay"><?php _e('Autoplay audio', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_loop"><?php _e('Repeat', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="loop" name="audio_loop" id="audio_loop" class="popup_tr_value" />
                            <label for="audio_loop"><?php _e('Repeat audio', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                <?php 
                } elseif ($type == 'single_audio_player') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_player_mp3"><?php _e('URL', 'cmsmasters'); ?> (mp3)</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php echo $content; ?>" name="audio_player_mp3" id="audio_player_mp3" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Internet Explorer, Google Chrome and Apple Safari', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_player_ogg"><?php _e('URL', 'cmsmasters'); ?> (ogg)</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="audio_player_ogg" id="audio_player_ogg" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Firefox, Google Chrome and Opera', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_player_name"><?php _e('Name', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="audio_player_name" id="audio_player_name" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                <?php 
                } elseif ($type == 'multiple_audio_player') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_player_mp31"><?php _e('URL', 'cmsmasters'); ?> (mp3) 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php echo $content; ?>" name="audio_player_mp31" id="audio_player_mp31" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Internet Explorer, Google Chrome and Apple Safari', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_player_ogg1"><?php _e('URL', 'cmsmasters'); ?> (ogg) 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="audio_player_ogg1" id="audio_player_ogg1" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('For Firefox, Google Chrome and Opera', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="audio_player_name1"><?php _e('Name', 'cmsmasters'); ?> 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="audio_player_name1" id="audio_player_name1" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr class="add_audio" style="border-top:1px dotted #dfdfdf;">
                        <th class="label" style="width:130px; padding-top:15px;" scope="row"></th>
                        <td class="field" style="padding-top:10px;">
                            <input type="button" value="<?php _e('Add Audio to Playlist', 'cmsmasters'); ?>" name="add_audio" id="add_audio" />
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
