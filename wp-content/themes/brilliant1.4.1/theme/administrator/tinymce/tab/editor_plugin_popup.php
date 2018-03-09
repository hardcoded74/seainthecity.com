<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Tab Shortcodes Popup
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
	$type = 'tabs'; 
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
	
    #TB_ajaxContent textarea {
		min-height:50px;
        resize:vertical;
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
        
        jQuery('.add_tab').delegate('#add_tab', 'click', function () {
            var i = (jQuery('#TB_ajaxContent .popup_tr_value').length / 2) + 1, 
				html = '';
            
            html = '<tr style="border-top:1px dotted #dfdfdf;">' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="tab_label' + i + '"><?php _e('Tab Label', 'cmsmasters'); ?> ' + i + '</label>' + 
                    '</span>' + 
                    '<span class="alignright">' + 
                        '<abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>' + 
                    '</span>' + 
                '</th>' +
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="tab_label' + i + '" id="tab_label' + i + '" aria-required="true" class="popup_tr_value" />' + 
                '</td>' + 
            '</tr>' + 
            '<tr>' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="tab_content' + i + '"><?php _e('Tab Content', 'cmsmasters'); ?> ' + i + '</label>' + 
                    '</span>' + 
                '</th>' + 
                '<td class="field" style="padding-top:10px;">' + 
                    '<textarea type="text" name="tab_content' + i + '" id="tab_content' + i + '" class="popup_tr_value"></textarea>' + 
                '</td>' + 
            '</tr>';
            
            jQuery('tr.add_tab').before(html);
        } );
        
        jQuery('.add_toggle').delegate('#add_toggle', 'click', function () {
            var i = (jQuery('#TB_ajaxContent .popup_tr_value').length / 2) + 1, 
				html = '';
            
            html = '<tr style="border-top:1px dotted #dfdfdf;">' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="toggle_label' + i + '"><?php _e('Toggle Label', 'cmsmasters'); ?> ' + i + '</label>' + 
                    '</span>' + 
                    '<span class="alignright">' + 
                        '<abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>' + 
                    '</span>' + 
                '</th>' +
                '<td class="field" style="padding-top:10px;">' + 
                    '<input type="text" value="" name="toggle_label' + i + '" id="toggle_label' + i + '" aria-required="true" class="popup_tr_value" />' + 
                '</td>' + 
            '</tr>' + 
            '<tr>' + 
                '<th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">' + 
                    '<span class="alignleft">' + 
                        '<label for="toggle_content' + i + '"><?php _e('Toggle Content', 'cmsmasters'); ?> ' + i + '</label>' + 
                    '</span>' + 
                '</th>' + 
                '<td class="field" style="padding-top:10px;">' + 
                    '<textarea type="text" name="toggle_content' + i + '" id="toggle_content' + i + '" class="popup_tr_value"></textarea>' + 
                '</td>' + 
            '</tr>';
            
            jQuery('tr.add_toggle').before(html);
        } );
    } );
    
    <?php 
    if ($type == 'tabs') { 
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
            
            shortcode_tag += '[tabs';
            
            for (var i = 0, j = 1, ilength = tr.length - 1; i < ilength; i += 2) {
                shortcode_tag += ' tab' + j + '="' + tr.eq(i).find('.popup_tr_value').val() + '"';
                
                j += 1;
            }
            
            shortcode_tag += ']' + "\n";
            
            for (var i = 1, ilength = tr.length; i < ilength; i += 2) {
                shortcode_tag += '[tab]';
				
				if (tr.eq(i).find('.popup_tr_value').val() !== '') {
					shortcode_tag += tr.eq(i).find('.popup_tr_value').val();
				} else {
					shortcode_tag += '<?php echo __('Insert you text here', 'cmsmasters') . '...'; ?>';
				}
				
				shortcode_tag += '[/tab]' + "\n";
            }
            
            shortcode_tag += '[/tabs]';
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } elseif ($type == 'toggle') { 
    ?>
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				tog_label = jQuery('#toggle_label').val(), 
				tog_content = jQuery('#toggle_content').val();
            
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
            
            shortcode_tag += '[toggle title="' + tog_label + '"]';
            
			if (tog_content !== '') {
				shortcode_tag += tog_content;
			} else {
				shortcode_tag += '<?php echo __('Insert you text here', 'cmsmasters') . '...'; ?>';
			}
			
			shortcode_tag += '[/toggle]';
			
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } elseif ($type == 'accordion') { 
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
            
            shortcode_tag += '[accordion]' + "\n";
            
            for (var i = 0, j = 1, ilength = tr.length - 1; i < ilength; i += 2) {
                shortcode_tag += '[toggle title="' + tr.eq(i).find('.popup_tr_value').val() + '"]';
				
				if (tr.eq(i + 1).find('.popup_tr_value').val() !== '') {
					shortcode_tag += tr.eq(i + 1).find('.popup_tr_value').val();
				} else {
					shortcode_tag += '<?php echo __('Insert you text here', 'cmsmasters') . '...'; ?>';
				}
				
                shortcode_tag += '[/toggle]' + "\n";
                
                j += 1;
            }
            
            shortcode_tag += '[/accordion]';
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    <?php 
    } elseif ($type == 'tour') { 
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
            
            shortcode_tag += '[tour';
            
            for (var i = 0, j = 1, ilength = tr.length - 1; i < ilength; i += 2) {
                shortcode_tag += ' tour_tab' + j + '="' + tr.eq(i).find('.popup_tr_value').val() + '"';
                
                j += 1;
            }
            
            shortcode_tag += ']' + "\n";
            
            for (var i = 1, ilength = tr.length; i < ilength; i += 2) {
                shortcode_tag += '[tour_tab]';
				
				if (tr.eq(i).find('.popup_tr_value').val() !== '') {
					shortcode_tag += tr.eq(i).find('.popup_tr_value').val();
				} else {
					shortcode_tag += '<?php echo __('Insert you text here', 'cmsmasters') . '...'; ?>';
				}
				
                shortcode_tag += '[/tour_tab]' + "\n";
            }
            
            shortcode_tag += '[/tour]';
            
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
if ($type == 'tabs') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Tabs', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
} elseif ($type == 'toggle') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Toggle', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
} elseif ($type == 'accordion') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Accordion', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
} elseif ($type == 'tour') { 
	echo '<h3 class="media-title" style="width:598px;">' . __('Set Your Custom', 'cmsmasters') . ' ' . __('Tour', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes') . '</h3>';
}
?>
    <div id="media-items" class="media-upload-form">
        <div class="media-item">
            <table class="describe">
                <tbody>
                <?php 
                if ($type == 'tabs') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="tab_label1"><?php _e('Tab Label', 'cmsmasters'); ?> 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="tab_label1" id="tab_label1" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="tab_content1"><?php _e('Tab Content', 'cmsmasters'); ?> 1</label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <textarea type="text" name="tab_content1" id="tab_content1" class="popup_tr_value"><?php echo $content; ?></textarea>
                        </td>
                    </tr>
                    <tr class="add_tab" style="border-top:1px dotted #dfdfdf;">
                        <th class="label" style="width:130px; padding-top:15px;" scope="row"></th>
                        <td class="field" style="padding-top:10px;">
                            <input type="button" value="<?php _e('Add New Tab', 'cmsmasters'); ?>" name="add_tab" id="add_tab" />
                        </td>
                    </tr>
                <?php 
                } elseif ($type == 'toggle') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="toggle_label"><?php _e('Toggle Label', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="toggle_label" id="toggle_label" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="toggle_content"><?php _e('Toggle Content', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <textarea type="text" name="toggle_content" id="toggle_content" class="popup_tr_value"><?php echo $content; ?></textarea>
                        </td>
                    </tr>
                <?php 
                } elseif ($type == 'accordion') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="toggle_label1"><?php _e('Toggle Label', 'cmsmasters'); ?> 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="toggle_label1" id="toggle_label1" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="toggle_content1"><?php _e('Toggle Content', 'cmsmasters'); ?> 1</label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <textarea type="text" name="toggle_content1" id="toggle_content1" class="popup_tr_value"><?php echo $content; ?></textarea>
                        </td>
                    </tr>
                    <tr class="add_toggle" style="border-top:1px dotted #dfdfdf;">
                        <th class="label" style="width:130px; padding-top:15px;" scope="row"></th>
                        <td class="field" style="padding-top:10px;">
                            <input type="button" value="<?php _e('Add New Toggle', 'cmsmasters'); ?>" name="add_toggle" id="add_toggle" />
                        </td>
                    </tr>
                <?php 
                } elseif ($type == 'tour') { 
                ?>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="tab_label1"><?php _e('Tab Label', 'cmsmasters'); ?> 1</label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="tab_label1" id="tab_label1" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="tab_content1"><?php _e('Tab Content', 'cmsmasters'); ?> 1</label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <textarea type="text" name="tab_content1" id="tab_content1" class="popup_tr_value"><?php echo $content; ?></textarea>
                        </td>
                    </tr>
                    <tr class="add_tab" style="border-top:1px dotted #dfdfdf;">
                        <th class="label" style="width:130px; padding-top:15px;" scope="row"></th>
                        <td class="field" style="padding-top:10px;">
                            <input type="button" value="<?php _e('Add New Tab', 'cmsmasters'); ?>" name="add_tab" id="add_tab" />
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
