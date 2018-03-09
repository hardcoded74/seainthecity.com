<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Contact Form Shortcode Popup
 * Created by CMSMasters
 * 
 */


global $wpdb, $shortname;

require_once('../../../../../../../wp-load.php');
require_once('../../../../../../../wp-admin/includes/admin.php');

do_action('admin_init');

if (!is_user_logged_in()) {
	die(__('You must be logged in to access this page', 'cmsmasters') . '.');
}

if (isset($_GET['content']) && $_GET['content'] != '') {
	$content = htmlspecialchars(stripslashes($_GET['content']));
} else {
	$content = ''; 
}

$get_forms = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . $shortname . "_forms WHERE type='form'");

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
    } );
    
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				email_form = jQuery('#email_form').val(), 
				email_address = jQuery('#email_address').val();
            
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
            
            
			shortcode_tag = '[contactform formname="' + email_form + '" email="' + email_address + '"]';
            
            window.tinyMCE.activeEditor.selection.setContent(shortcode_tag);
            edInsertContent('', shortcode_tag);
            
            tb_remove();
        }
        
        return false;
    }
    
    function closePopup() {
        tb_remove();
        
        return false;
    }
</script>
<div class="popup_content">
    <h3 class="media-title" style="width:598px;"><?php echo __('Set Your Custom', 'cmsmasters') . ' ' . __('Contact Form', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes'); ?></h3>
    <div id="media-items" class="media-upload-form">
        <div class="media-item">
            <table class="describe">
                <tbody>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="email_form"><?php _e('Form Name', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <select name="email_form" id="email_form" aria-required="true" class="popup_tr_value">
                                <option value=""><?php _e('Choose Form Name Here', 'cmsmasters'); ?>&nbsp;</option>
                                <?php
                                foreach ($get_forms as $form) {
                                    echo '<option value="' . $form->slug . '">' . $form->label . '&nbsp;</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="email_address"><?php _e('Email Address', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="<?php echo $content; ?>" name="email_address" id="email_address" aria-required="true" class="popup_tr_value" />
                            <p class="help"><?php _e('You can enter multiple email addresses separated by commas', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
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
