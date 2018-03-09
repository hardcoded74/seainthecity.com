<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Content Slider Shortcode Popup
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
		
		jQuery('#slider_height').spinner( {
			min : 10, 
			max : 9999, 
			step : 10, 
			allowNull : false 
		} );
        
        jQuery('#slider_speed').spinner( {
            min : 0.1, 
            max : 100, 
            step : 0.1, 
			allowNull : false 
        } );
        
        jQuery('#slider_pause').spinner( {
            min : 0, 
            max : 100, 
            step : 0.5, 
			allowNull : true 
        } );
        
        jQuery('#active_slide').spinner( {
            min : 1, 
            max : 100, 
            step : 1, 
			allowNull : false 
        } );
        
        jQuery('input[name="slider_height_type"]').change(function () {
            if (jQuery('input[name="slider_height_type"]:checked').val() === 'auto') {
                jQuery('#slider_height').parent().parent().parent().hide();
            } else if (jQuery('input[name="slider_height_type"]:checked').val() === 'fixed') {
                jQuery('#slider_height').parent().parent().parent().show();
            }
        } );
        
        jQuery('#slides_control').change(function () {
            if (jQuery(this).is(':checked')) {
                jQuery('#slides_control_hover').parent().parent().show();
            } else {
                jQuery('#slides_control_hover').parent().parent().hide();
            }
        } );
        
        jQuery('#arrow_control').change(function () {
            if (jQuery(this).is(':checked')) {
                jQuery('#arrow_control_hover').parent().parent().show();
            } else {
                jQuery('#arrow_control_hover').parent().parent().hide();
            }
        } );
		
		jQuery('#slider_height').parent().parent().parent().hide();
		
		jQuery('.open_images_list').click(function () { 
			jQuery(this).hide();
			jQuery('.close_images_list').show();
			
			jQuery('.image_list_parent').load('<?php echo get_template_directory_uri() ?>/theme/functions/attachment_list.php?offset=0', function () { 
				var all = Number(jQuery('#image_list_all').val());
				
				if (all > 10) { 
					jQuery('.older_images').show();
				}
			} );
			
			return false;
		} );
		
		jQuery('.close_images_list').click(function () { 
			jQuery(this).hide();
			jQuery('.newer_images').hide();
			jQuery('.older_images').hide();
			jQuery('.open_images_list').show();
			jQuery('.image_list_parent').empty();
			
			return false;
		} );
		
		jQuery('.older_images').click(function () { 
			var offset = Number(jQuery('#image_list_offset').val());
			
			jQuery('.image_list_parent').empty();
			jQuery('.image_list_parent').load('<?php echo get_template_directory_uri() ?>/theme/functions/attachment_list.php?offset=' + (offset + 10), function () { 
				var all = Number(jQuery('#image_list_all').val()), 
					offset = Number(jQuery('#image_list_offset').val());
				
				jQuery('.newer_images').show();
				
				if (offset + 10 > all) { 
					jQuery('.older_images').hide();
				}
			} );
			
			return false;
		} );
		
		jQuery('.newer_images').click(function () { 
			var offset = Number(jQuery('#image_list_offset').val());
			
			jQuery('.image_list_parent').empty();
			jQuery('.image_list_parent').load('<?php echo get_template_directory_uri() ?>/theme/functions/attachment_list.php?offset=' + (offset - 10), function () { 
				var offset = Number(jQuery('#image_list_offset').val());
				
				jQuery('.older_images').show();
				
				if (offset - 10 < 0) { 
					jQuery('.newer_images').hide();
				}
			} );
			
			return false;
		} );
		
		jQuery('.image_list_parent').delegate('a', 'click', function () { 
			var li_id = jQuery(this).parent().attr('id'), 
				a_href = jQuery(this).attr('href'), 
				img_src = jQuery(this).find('>img').attr('src'), 
				imgs_val = jQuery('#slider_images').val();
			
			if (imgs_val.replace(a_href, '') === imgs_val) { 
				jQuery('.selected_list').append('<li id="' + li_id + '">' + 
					'<a href="' + a_href + '">' + 
						'<img src="' + img_src + '" alt="" />' + 
						'<span></span>' + 
					'</a>' + 
				'</li>');
				
				if (imgs_val !== '') { 
					jQuery('#slider_images').val(imgs_val + ',' + a_href);
				} else { 
					jQuery('#slider_images').val(a_href);
				}
			}
			
			return false;
		} );
		
		jQuery('.selected_list').delegate('a', 'click', function () { 
			var a_href = jQuery(this).attr('href'), 
				imgs_val = jQuery('#slider_images').val();
			
			imgs_val = imgs_val.replace(a_href + ',', '');
			imgs_val = imgs_val.replace(',' + a_href, '');
			imgs_val = imgs_val.replace(a_href, '');
			
			jQuery('#slider_images').val(imgs_val);
			
			jQuery(this).parent().remove();
			
			return false;
		} );
    } );
    
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				slider_images = jQuery('#slider_images').val(), 
				slider_height_type = jQuery('input[name="slider_height_type"]:checked').val(), 
				slider_height = jQuery('#slider_height').val(), 
				slider_speed = jQuery('#slider_speed').val(), 
				slider_effect = jQuery('input[name="slider_effect"]:checked').val(), 
				slider_easing = jQuery('#slider_easing').val(), 
				slider_pause = jQuery('#slider_pause').val(), 
				active_slide = jQuery('#active_slide').val(), 
				pause_on_hover = jQuery('#pause_on_hover'), 
				touch_control = jQuery('#touch_control'), 
				slides_control = jQuery('#slides_control'), 
				slides_control_hover = jQuery('#slides_control_hover'), 
				arrow_control = jQuery('#arrow_control'), 
				arrow_control_hover = jQuery('#arrow_control_hover');
            
            for (var i = 0, ilength = popup_tr_value.length; i < ilength; i += 1) {
                popup_tr_value[i].style.removeProperty('border');
                
                if (popup_tr_value.eq(i).attr('aria-required') === 'true' && popup_tr_value.eq(i).parent().parent().css('display') !== 'none' && popup_tr_value.eq(i).parent().parent().parent().css('display') !== 'none') {
                    if (popup_tr_value.eq(i).val() === '' || popup_tr_value.eq(i).val() === ' ') {
                        alert('<?php _e('Enter required fields!', 'cmsmasters'); ?>');
                        
                        popup_tr_value.eq(i).css('border', '1px solid #ff0000').focus();
                        
                        return false;
                    }
                }
            }
            
            shortcode_tag = '[content_slider height="' + ((slider_height_type === 'auto') ? 'auto' : slider_height) + 
				'" animation_speed="' + slider_speed + 
				'" effect="' + slider_effect + 
				'" easing="' + slider_easing + 
				'" pause_time="' + slider_pause + 
				'" active_slide="' + active_slide + 
				'" pause_on_hover="' + ((pause_on_hover.is(':checked')) ? 'true' : 'false') + 
				'" touch_control="' + ((touch_control.is(':checked')) ? 'true' : 'false') + 
				'" slides_control="' + ((slides_control.is(':checked')) ? 'true' : 'false') + 
				'" slides_control_hover="' + ((slides_control.is(':checked') && slides_control_hover.is(':checked')) ? 'true' : 'false') + 
				'" arrow_control="' + ((arrow_control.is(':checked')) ? 'true' : 'false') + 
				'" arrow_control_hover="' + ((arrow_control.is(':checked') && arrow_control_hover.is(':checked')) ? 'true' : 'false') + '"]' + 
				slider_images + '[/content_slider]';
            
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
    <h3 class="media-title" style="width:598px;"><?php echo __('Set Your Custom', 'cmsmasters') . ' ' . __('Content Slider', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes'); ?></h3>
    <div id="media-items" class="media-upload-form">
        <div class="media-item">
            <table class="describe">
                <tbody>
					<tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label><?php _e('Slider Images', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:17px;">
							<a href="<?php ?>" class="open_images_list"><?php _e('Select slider images', 'cmsmastres'); ?></a>
							<a href="<?php ?>" class="close_images_list">[x] <?php _e('Close images list', 'cmsmastres'); ?></a>
							<div class="image_list_parent"></div>
							<a href="<?php ?>" class="older_images"><?php _e('Older images', 'cmsmastres'); ?> &rarr;</a>
							<a href="<?php ?>" class="newer_images">&larr; <?php _e('Newer images', 'cmsmastres'); ?></a>
							<ul class="lighbox_image_list selected_list"></ul>
                            <input type="hidden" value="" name="slider_images" id="slider_images" aria-required="true" class="popup_tr_value" />
						</td>
					</tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="slider_height_type_1"><?php _e('Height Type', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="radio" value="auto" name="slider_height_type" id="slider_height_type_1" aria-required="true" class="popup_tr_value" checked="checked" />
                            <label for="slider_height_type_1"><?php _e('Use automatic height', 'cmsmasters'); ?></label>
                            <br />
                            <input type="radio" value="fixed" name="slider_height_type" id="slider_height_type_2" aria-required="true" class="popup_tr_value" />
                            <label for="slider_height_type_2"><?php _e('Use fixed height', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="slider_height"><?php _e('Height', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="300" name="slider_height" id="slider_height" aria-required="true" class="popup_tr_value" style="width:45px; position:relative; z-index:1;" />
                            <p class="help"><?php _e('in pixels', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="slider_speed"><?php _e('Animation Speed', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="0.5" name="slider_speed" id="slider_speed" aria-required="true" class="popup_tr_value" style="width:45px; position:relative; z-index:1;" />
                            <p class="help"><?php _e('in seconds', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="slider_effect_1"><?php _e('Animation Effect', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="radio" value="slide" name="slider_effect" id="slider_effect_1" aria-required="true" class="popup_tr_value" checked="checked" />
                            <label for="slider_effect_1"><?php _e('Slide', 'cmsmasters'); ?></label>
                            <br />
                            <input type="radio" value="fade" name="slider_effect" id="slider_effect_2" aria-required="true" class="popup_tr_value" />
                            <label for="slider_effect_2"><?php _e('Fade', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="slider_easing"><?php _e('Animation Effect', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <select name="slider_easing" id="slider_easing" aria-required="true" class="popup_tr_value">
                                <option value="linear"><?php _e('None', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="easeInQuad">Ease-In-Quad&nbsp;</option>
                                <option value="easeOutQuad">Ease-Out-Quad&nbsp;</option>
                                <option value="easeInOutQuad">Ease-In-Out-Quad&nbsp;</option>
                                <option value="easeInCubic">Ease-In-Cubic&nbsp;</option>
                                <option value="easeOutCubic">Ease-Out-Cubic&nbsp;</option>
                                <option value="easeInOutCubic">Ease-In-Out-Cubic&nbsp;</option>
                                <option value="easeInQuart">Ease-In-Quart&nbsp;</option>
                                <option value="easeOutQuart">Ease-Out-Quart&nbsp;</option>
                                <option value="easeInOutQuart">Ease-In-Out-Quart&nbsp;</option>
                                <option value="easeInQuint">Ease-In-Quint&nbsp;</option>
                                <option value="easeOutQuint">Ease-Out-Quint&nbsp;</option>
                                <option value="easeInOutQuint">Ease-In-Out-Quint&nbsp;</option>
                                <option value="easeInSine">Ease-In-Sine&nbsp;</option>
                                <option value="easeOutSine">Ease-Out-Sine&nbsp;</option>
                                <option value="easeInOutSine">Ease-In-Out-Sine&nbsp;</option>
                                <option value="easeInExpo">Ease-In-Expo&nbsp;</option>
                                <option value="easeOutExpo">Ease-Out-Expo&nbsp;</option>
                                <option value="easeInOutExpo" selected="selected">Ease-In-Out-Expo&nbsp;</option>
                                <option value="easeInCirc">Ease-In-Circ&nbsp;</option>
                                <option value="easeOutCirc">Ease-Out-Circ&nbsp;</option>
                                <option value="easeInOutCirc">Ease-In-Out-Circ&nbsp;</option>
                                <option value="easeInElastic">Ease-In-Elastic&nbsp;</option>
                                <option value="easeOutElastic">Ease-Out-Elastic&nbsp;</option>
                                <option value="easeInOutElastic">Ease-In-Out-Elastic&nbsp;</option>
                                <option value="easeInBack">Ease-In-Back&nbsp;</option>
                                <option value="easeOutBack">Ease-Out-Back&nbsp;</option>
                                <option value="easeInOutBack">Ease-In-Out-Back&nbsp;</option>
                                <option value="easeInBounce">Ease-In-Bounce&nbsp;</option>
                                <option value="easeOutBounce">Ease-Out-Bounce&nbsp;</option>
                                <option value="easeInOutBounce">Ease-In-Out-Bounce&nbsp;</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="slider_pause"><?php _e('Pause Time', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="7" name="slider_pause" id="slider_pause" aria-required="true" class="popup_tr_value" style="width:45px; position:relative; z-index:1;" />
                            <p class="help"><?php _e('in seconds', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="active_slide"><?php _e('Active Slide', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="1" name="active_slide" id="active_slide" aria-required="true" class="popup_tr_value" style="width:45px; position:relative; z-index:1;" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="pause_on_hover"><?php _e('Pause on Hover', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="pause_on_hover" id="pause_on_hover" class="popup_tr_value" />
                            <label for="pause_on_hover"><?php _e('Pause slider on mouseover', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr style="border-top:1px dotted #dfdfdf; border-bottom:1px dotted #dfdfdf;">
                        <th class="label" valign="top" style="width:130px;" scope="row"></th>
                        <td class="field" style="font-weight:bold; padding-top:7px;">
                            <p class="help"><?php _e('Choose Content Slider Controls', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="touch_control"><?php _e('Touch Control', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="touch_control" id="touch_control" class="popup_tr_value" checked="checked" />
                            <label for="touch_control"><?php _e('Use touch control', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="slides_control"><?php _e('Slides Control', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="slides_control" id="slides_control" class="popup_tr_value" checked="checked" />
                            <label for="slides_control"><?php _e('Use slides control', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="slides_control_hover"><?php _e('Slides C. Hover', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="slides_control_hover" id="slides_control_hover" class="popup_tr_value" />
                            <label for="slides_control_hover"><?php _e('Show slides control only on mouseover', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="arrow_control"><?php _e('Arrow Control', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="arrow_control" id="arrow_control" class="popup_tr_value" />
                            <label for="arrow_control"><?php _e('Use arrow control', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr style="display:none;">
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="arrow_control_hover"><?php _e('Arrow C. Hover', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="arrow_control_hover" id="arrow_control_hover" class="popup_tr_value" />
                            <label for="arrow_control_hover"><?php _e('Show arrow control only on mouseover', 'cmsmasters'); ?></label>
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
