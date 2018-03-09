<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Google Map Shortcode Popup
 * Created by CMSMasters
 * 
 */


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
        
        jQuery('#map_zoom').spinner( {
            min : 1, 
            max : 19, 
            step : 1 
        } );
        
        jQuery('input[name="map_coord_type"]').change(function () {
            if (jQuery('input[name="map_coord_type"]:checked').val() === 'address') {
                jQuery('#map_address').parent().parent().show();
                jQuery('#map_latitude').parent().parent().hide();
                jQuery('#map_longitude').parent().parent().hide();
            } else if (jQuery(this).val() === 'coordinates') {
                jQuery('#map_latitude').parent().parent().show();
                jQuery('#map_longitude').parent().parent().show();
                jQuery('#map_address').parent().parent().hide();
            }
        } );
        
        jQuery('#map_marker').change(function () {
            if (jQuery(this).is(':checked')) {
                jQuery('#map_html').parent().parent().show();
                jQuery('#map_popup').parent().parent().show();
            } else {
                jQuery('#map_html').parent().parent().hide();
                jQuery('#map_popup').parent().parent().hide();
            }
        } );
    } );
    
    function insertShortcode() {
        if (window.tinyMCE) {
            var shortcode_tag = '', 
				popup_tr_value = jQuery('#TB_ajaxContent .popup_tr_value'), 
				map_type = jQuery('#map_type').val(), 
				map_zoom = jQuery('#map_zoom').val(), 
				map_coord_type = jQuery('input[name="map_coord_type"]:checked').val(), 
				map_address = jQuery('#map_address').val(), 
				map_latitude = jQuery('#map_latitude').val(), 
				map_longitude = jQuery('#map_longitude').val(), 
				map_marker = jQuery('#map_marker'), 
				map_html = jQuery('#map_html').val(), 
				map_popup = jQuery('#map_popup'), 
				map_scroll_wheel = jQuery('#map_scroll_wheel'), 
				map_type_control = jQuery('#map_type_control'), 
				map_zoom_control = jQuery('#map_zoom_control'), 
				map_pan_control = jQuery('#map_pan_control'), 
				map_scale_control = jQuery('#map_scale_control'), 
				map_street_control = jQuery('#map_street_control');
            
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
            
            shortcode_tag = '[googlemap map_type="' + map_type + '" zoom="' + map_zoom + '"';
            
            if (map_coord_type === 'address') {
                shortcode_tag += ' address="' + map_address + '"';
            } else if (map_coord_type === 'coordinates') {
                shortcode_tag += ' latitude="' + map_latitude + '" longitude="' + map_longitude + '"';
            }
            
            if (map_marker.is(':checked')) {
                shortcode_tag += ' marker="' + map_marker.val() + '" popup_html="' + map_html + '"';
                
                if (map_popup.is(':checked')) {
                    shortcode_tag += ' popup="' + map_popup.val() + '"';
                } else {
                    shortcode_tag += ' popup="false"';
                }
            }
            
            if (map_scroll_wheel.is(':checked')) {
                shortcode_tag += ' scroll_wheel="' + map_scroll_wheel.val() + '"';
            } else {
                shortcode_tag += ' scroll_wheel="false"';
            }
            
            if (map_scroll_wheel.is(':checked')) {
                shortcode_tag += ' map_type_control="' + map_type_control.val() + '"';
            } else {
                shortcode_tag += ' map_type_control="false"';
            }
            
            if (map_zoom_control.is(':checked')) {
                shortcode_tag += ' zoom_control="' + map_zoom_control.val() + '"';
            } else {
                shortcode_tag += ' zoom_control="false"';
            }
            
            if (map_pan_control.is(':checked')) {
                shortcode_tag += ' pan_control="' + map_pan_control.val() + '"';
            } else {
                shortcode_tag += ' pan_control="false"';
            }
            
            if (map_scale_control.is(':checked')) {
                shortcode_tag += ' scale_control="' + map_scale_control.val() + '"';
            } else {
                shortcode_tag += ' scale_control="false"';
            }
            
            if (map_street_control.is(':checked')) {
                shortcode_tag += ' street_view_control="' + map_street_control.val() + '"';
            } else {
                shortcode_tag += ' street_view_control="false"';
            }
            
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
    <h3 class="media-title" style="width:598px;"><?php echo __('Set Your Custom', 'cmsmasters') . ' ' . __('Google Map', 'cmsmasters') . ' ' . __('Shortcode Options', 'cmsmastes'); ?></h3>
    <div id="media-items" class="media-upload-form">
        <div class="media-item">
            <table class="describe">
                <tbody>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_type"><?php _e('Map Type', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <select name="map_type" id="map_type" aria-required="true" class="popup_tr_value">
                                <option value="ROADMAP"><?php _e('Roadmap', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="TERRAIN"><?php _e('Terrain', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="HYBRID"><?php _e('Hybrid', 'cmsmasters'); ?>&nbsp;</option>
                                <option value="SATELLITE"><?php _e('Satellite', 'cmsmasters'); ?>&nbsp;</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_zoom"><?php _e('Map Zoom', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="text" value="14" name="map_zoom" id="map_zoom" aria-required="true" class="popup_tr_value" style="width:45px; position:relative; z-index:1;" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_coord_type_1"><?php _e('Address Type', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:10px;">
                            <input type="radio" value="address" name="map_coord_type" id="map_coord_type_1" aria-required="true" class="popup_tr_value" checked="checked" />
                            <label for="map_coord_type_1"><?php _e('Use address', 'cmsmasters'); ?></label>
                            <br />
                            <input type="radio" value="coordinates" name="map_coord_type" id="map_coord_type_2" aria-required="true" class="popup_tr_value" />
                            <label for="map_coord_type_2"><?php _e('Use coordinates', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_address"><?php _e('Address', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="text" value="" name="map_address" id="map_address" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr style="display:none;">
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_latitude"><?php _e('Latitude', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="text" value="" name="map_latitude" id="map_latitude" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr style="display:none;">
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_longitude"><?php _e('Longitude', 'cmsmasters'); ?></label>
                            </span>
                            <span class="alignright">
                                <abbr class="required" title="<?php _e('required', 'cmsmasters'); ?>">*</abbr>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="text" value="" name="map_longitude" id="map_longitude" aria-required="true" class="popup_tr_value" />
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_marker"><?php _e('Marker', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="map_marker" id="map_marker" class="popup_tr_value" />
                            <label for="map_marker"><?php _e('Use marker', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr style="display:none;">
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_html"><?php _e('Popup HTML', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <textarea name="map_html" id="map_html" class="popup_tr_value"><?php echo $content; ?></textarea>
                        </td>
                    </tr>
                    <tr style="display:none;">
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_popup"><?php _e('Popup Visibility', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="map_popup" id="map_popup" class="popup_tr_value" />
                            <label for="map_popup"><?php _e('Open popup on load', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr style="border-top:1px dotted #dfdfdf; border-bottom:1px dotted #dfdfdf;">
                        <th class="label" valign="top" style="width:130px;" scope="row"></th>
                        <td class="field" style="font-weight:bold; padding-top:7px;">
                            <p class="help"><?php _e('Choose Google Map Controls', 'cmsmasters'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_scroll_wheel"><?php _e('Scroll Wheel', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="map_scroll_wheel" id="map_scroll_wheel" class="popup_tr_value" />
                            <label for="map_scroll_wheel"><?php _e('Use scroll wheel', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_type_control"><?php _e('Map Type', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="map_type_control" id="map_type_control" class="popup_tr_value" />
                            <label for="map_type_control"><?php _e('Enable control', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_zoom_control"><?php _e('Zoom', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="map_zoom_control" id="map_zoom_control" class="popup_tr_value" />
                            <label for="map_zoom_control"><?php _e('Enable control', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_pan_control"><?php _e('Pan', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="map_pan_control" id="map_pan_control" class="popup_tr_value" />
                            <label for="map_pan_control"><?php _e('Enable control', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_scale_control"><?php _e('Scale', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="map_scale_control" id="map_scale_control" class="popup_tr_value" />
                            <label for="map_scale_control"><?php _e('Enable control', 'cmsmasters'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th class="label" valign="top" style="width:130px; padding-top:15px;" scope="row">
                            <span class="alignleft">
                                <label for="map_street_control"><?php _e('Street View', 'cmsmasters'); ?></label>
                            </span>
                        </th>
                        <td class="field" style="padding-top:15px;">
                            <input type="checkbox" value="true" name="map_street_control" id="map_street_control" class="popup_tr_value" />
                            <label for="map_street_control"><?php _e('Enable control', 'cmsmasters'); ?></label>
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
