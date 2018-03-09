<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Table Shortcode Popup
 * Created by CMSMasters
 * 
 */


require_once('../../../../../../../wp-load.php');
require_once('../../../../../../../wp-admin/includes/admin.php');

do_action('admin_init');

if (!is_user_logged_in()) {
	die(__('You must be logged in to access this page', 'cmsmasters') . '.');
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
        
        jQuery('#table_cols, #table_rows').spinner( {
            min : 1, 
            max : 100, 
            step : 1
        } );
    } );
    
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				table_cols = jQuery('#table_cols').val(), 
				table_rows = jQuery('#table_rows').val(), 
				table_head = jQuery('#table_head'), 
				table_foot = jQuery('#table_foot');
            
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
            
            
			shortcode_tag = '<table class="table">' + "\n";
            
            if (table_head.is(':checked')) {
				var n = 1;
                
                shortcode_tag += '<thead>' + 
                    '<tr>' + "\n";
                
				for (var i = 0; i < table_cols; i += 1) {
					shortcode_tag += '<th>Header ' + n + '</th>' + "\n";
                    
                    n += 1;
				}
                
				shortcode_tag += '</tr>' + 
                '</thead>' + "\n";
			}
            
			shortcode_tag += '<tbody>' + "\n";
            
			for (var i = 0; i < table_rows; i += 1) {
				var k = 1;
                
                shortcode_tag += '<tr>' + "\n";
                
				for (var j = 0; j < table_cols; j += 1) {
					shortcode_tag += '<td>Division ' + k + '</td>' + "\n";
                    
                    k += 1;
				}
                
				shortcode_tag += '</tr>' + "\n";
			}
            
			shortcode_tag += '</tbody>' + "\n";
            
            if (table_foot.is(':checked')) {
				var m = 1;
                
                shortcode_tag += '<tfoot>' + 
                    '<tr>' + "\n";
                
				for (var i = 0; i < table_cols; i += 1) {
					shortcode_tag += '<th>Footer ' + m + '</th>' + "\n";
                    
                    m += 1;
				}
                
				shortcode_tag += '</tr>' + 
                '</tfoot>' + "\n";
			}
            
			shortcode_tag += '</table>';
            
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
    <h3 class="media-title" style="width:598px;"><?php echo __('Set Your Custom', 'cmsmasters') . ' ' . __('Table', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes'); ?></h3>
    <div id="media-items" class="media-upload-form">
        <div class="media-item">
            <table class="describe">
                <tbody>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="table_cols"><?php _e('Columns Count', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="2" name="table_cols" id="table_cols" aria-required="true" class="popup_tr_value" style="width:45px; position:relative; z-index:1;" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="table_rows"><?php _e('Rows Count', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="2" name="table_rows" id="table_rows" aria-required="true" class="popup_tr_value" style="width:45px; position:relative; z-index:1;" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="table_head"><?php _e('Table Header', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="table_head" id="table_head" class="popup_tr_value" />
                            <label for="table_head"><?php echo __('Show', 'cmsmasters') . ' ' . __('Table Header', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="table_foot"><?php _e('Table Footer', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="table_foot" id="table_foot" class="popup_tr_value" />
                            <label for="table_foot"><?php echo __('Show', 'cmsmasters') . ' ' . __('Table Footer', 'cmsmasters'); ?></label>
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
