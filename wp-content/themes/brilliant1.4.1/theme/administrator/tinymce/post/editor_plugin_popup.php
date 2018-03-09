<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Post Type Shortcode Popup
 * Created by CMSMasters
 * 
 */


define('DOING_AJAX', true);
define('WP_ADMIN', true);

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
        
        jQuery('#post_number').spinner( {
            min : 1, 
            max : 100, 
            step : 1
        } );
        
        jQuery('#post_type_val').change(function () {
			if (jQuery('#post_sort').val() === 'category') {
				if (jQuery(this).val() === 'post') {
					jQuery('#post_cat').parent().parent().show();
					jQuery('#portfolio_cat').parent().parent().hide();
				} else if (jQuery(this).val() === 'portfolio') {
					jQuery('#portfolio_cat').parent().parent().show();
					jQuery('#post_cat').parent().parent().hide();
				}
			}
        } );
        
        jQuery('#post_sort').change(function () {
            if (jQuery(this).val() === 'category') {
            	if (jQuery('#post_type_val').val() === 'post') {
					jQuery('#post_cat').parent().parent().show();
					jQuery('#portfolio_cat').parent().parent().hide();
        		} else if (jQuery('#post_type_val').val() === 'portfolio') {
					jQuery('#portfolio_cat').parent().parent().show();
					jQuery('#post_cat').parent().parent().hide();
    			}
            } else {
                jQuery('#portfolio_cat').parent().parent().hide();
                jQuery('#post_cat').parent().parent().hide();
            }
        } );
    } );
    
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '';
            var popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value');
            var post_type_val = jQuery('#post_type_val').val();
            var post_sort = jQuery('#post_sort').val();
            var post_cat = jQuery('#post_cat').val();
            var portfolio_cat = jQuery('#portfolio_cat').val();
            var post_number = jQuery('#post_number').val();
            var post_image_check = jQuery('#post_image_check');
            var post_content_check = jQuery('#post_content_check');
            var post_info_check = jQuery('#post_info_check');
            var post_scroll = jQuery('#post_scroll');
            var shortcode_title = jQuery('#shortcode_title');
            
            for (var i = 0, ilength = popup_tr_value.length; i < ilength; i += 1) {
                popup_tr_value[i].style.removeProperty('border');
                
                if (popup_tr_value.eq(i).attr('aria-required') === 'true' && popup_tr_value.eq(i).parent().parent().css('display') !== 'none') {
                    if (popup_tr_value.eq(i).val() === '' || popup_tr_value.eq(i).val() === ' ') {
                        alert('<?php _e('Enter required fields!', 'cmsmasters'); ?>');
                        
                        popup_tr_value.eq(i).css('border', '1px solid #ff0000').focus();
                        
                        return false;
                    }
                }
            }
            
            shortcode_tag = '[posttype post_type="' + post_type_val + '" post_sort="' + post_sort + '"';
            
            if (post_sort === 'category') {
                if (post_type_val === 'post' && post_cat !== '') {
                    shortcode_tag += ' post_category="' + post_cat + '"';
                } else if (post_type_val === 'portfolio' && portfolio_cat !== '') {
                    shortcode_tag += ' post_category="' + portfolio_cat + '"';
                } else if ((post_type_val === 'post' && post_cat === '') || (post_type_val === 'portfolio' && portfolio_cat === '')) {
                    alert('<?php _e('Error! Choose another posts sorting.', 'cmsmasters'); ?>');
                    
                    jQuery('#post_sort').css('border', '1px solid #ff0000').focus();
                    
                    return false;
                }
            }
            
            shortcode_tag += ' post_number="' + post_number + '"';
            
            if (post_image_check.is(':checked')) {
                shortcode_tag += ' show_images="' + post_image_check.val() + '"';
            }
            
            if (post_content_check.is(':checked')) {
                shortcode_tag += ' show_content="' + post_content_check.val() + '"';
            }
            
            if (post_info_check.is(':checked')) {
                shortcode_tag += ' show_info="' + post_info_check.val() + '"';
            }
            
            if (post_scroll.is(':checked')) {
                shortcode_tag += ' post_scroll="' + post_scroll.val() + '"';
            }
            
            shortcode_tag += ' shortcode_title="' + shortcode_title.val() + '"';
            
            shortcode_tag += ']';
            
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
    <h3 class="media-title" style="width:598px;"><?php echo __('Set Your Custom', 'cmsmasters') . ' ' . __('Post Types', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes'); ?></h3>
    <div id="media-items" class="media-upload-form">
        <div class="media-item">
            <table class="describe">
                <tbody>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="post_type_val"><?php _e('Posts Type', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <select name="post_type_val" id="post_type_val" aria-required="true" class="popup_tr_value">
                                <option value="post"><?php _e('Blog', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="portfolio"><?php _e('Portfolio', 'cmsmasters'); ?>&nbsp;</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="post_sort"><?php _e('Posts Sorting', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <select name="post_sort" id="post_sort" aria-required="true" class="popup_tr_value">
                                <option value="latest"><?php _e('Latest', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="popular"><?php _e('Popular', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="category"><?php _e('Category', 'cmsmasters'); ?>&nbsp;</option>
                            </select>
                        </td>
                    </tr>
                    <tr style="display:none;">
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="post_cat"><?php _e('Posts Category', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
							<?php 
							$categs = get_categories('orderby=name&hide_empty=0');
							
							if (sizeof($categs) > 0) { 
                            ?>
                            <select name="post_cat" id="post_cat" aria-required="true" class="popup_tr_value">
                            <?php 
							foreach ($categs as $categ) {
								echo '<option  value="' . $categ->slug . '">' . $categ->name . '&nbsp;</option>';
							}
							?>
                            </select>
							<?php 
							} else { 
							?>
                            <p id="post_cat" class="help" style="padding-top:7px;"><?php _e('You need to create posts category before using this sorting type', 'cmsmasters'); ?></p>
                            <?php 
                            } 
                            ?>
                        </td>
                    </tr>
                    <tr style="display:none;">
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="portfolio_cat"><?php _e('Portfolio Type', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <?php 
							$pt_categs = get_terms('pt-categ', 'orderby=name&hide_empty=0');
							
							if (sizeof($pt_categs) > 0) { 
							?>
							<select name="portfolio_cat" id="portfolio_cat" aria-required="true" class="popup_tr_value">
                            <?php 
							foreach($pt_categs as $pt_categ) {
								echo '<option  value="' . $pt_categ->slug . '">' . $pt_categ->name . '&nbsp;</option>';
							}
                            ?>
                            </select>
							<?php 
							} else { 
							?>
                            <p id="portfolio_cat" class="help" style="padding-top:7px;"><?php _e('You need to create portfolio type before using this sorting type', 'cmsmasters'); ?></p>
                            <?php 
                            } 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="post_number"><?php _e('Posts Number', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="" name="post_number" id="post_number" aria-required="true" class="popup_tr_value" style="width:45px; position:relative; z-index:1;" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="post_image_check"><?php _e('Posts Images', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="post_image_check" id="post_image_check" class="popup_tr_value" />
                            <label for="post_image_check"><?php _e('Show posts featured images', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="post_content_check"><?php _e('Posts Content', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="post_content_check" id="post_content_check" class="popup_tr_value" />
                            <label for="post_content_check"><?php _e('Show posts content', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="post_info_check"><?php _e('Posts Info', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="post_info_check" id="post_info_check" class="popup_tr_value" />
                            <label for="post_info_check"><?php _e('Show posts additional information', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                     <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="post_scroll"><?php _e('Scrollable content', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="post_scroll" id="post_scroll" class="popup_tr_value" />
                            <label for="post_scroll"><?php _e('Add scroll to content area', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                     <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="shortcode_title"><?php _e('Title', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="text" name="shortcode_title" id="shortcode_title" class="popup_tr_value" />
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
