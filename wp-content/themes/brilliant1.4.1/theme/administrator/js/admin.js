/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Admin Panel Custom Scripts
 * Created by CMSMasters
 * 
 */


jQuery.noConflict();

function sidebar_rm_ajax() {
    jQuery('input[name^="sidebar_rm"]').live('click', function () {
        var sidebarId = jQuery(this).attr('id').replace('sdbr_', '');
        var sidebarName = jQuery('#sidebar_generator_' + sidebarId).val();
        
        jQuery('#sidebar_generator_' + sidebarId).remove();
        
        var arraySidebarInputs = new Array;
        
        jQuery('#side_del input[name^="sidebar_generator_"]').each(function (id) {
            var updateSidebars = jQuery('#side_del input[name^="sidebar_generator_"]').get(id);
            
            arraySidebarInputs.push(updateSidebars.value);
        });
	
        var sidebarInputsStr = arraySidebarInputs.join(',');
	
        jQuery.ajax( {
            type : 'post', 
            url : rmSidebarAjaxUrl, 
            data : {
                action : 'sidebar_rm', 
                sidebar : sidebarInputsStr, 
                sidebar_id : sidebarId, 
                sidebar_name : sidebarName, 
                _ajax_nonce : ajaxNonce
            },
            beforeSend : function () {
                jQuery('.sidebar_rm_' + sidebarId).css( { display : '' } );
            },
            success : function () {
                jQuery('#sidebar_table_' + sidebarId).fadeOut('fast');
            }
        } );
	
        return false;
    } );
}


function sidebar_add_ajax() {
    var loaderImageUrl = jQuery('input[name="loader_image_url"]').val();
    
    jQuery('input[name^="sidebar_add"]').bind('click', function () {
        if (jQuery('#sidebar_generator_0').val() !== '' && jQuery('#sidebar_generator_0').val() !== ' ') {
            var sidebarId, sidebarName;
            
            if (jQuery('#sidebar_options .sidebar_table:last').attr('id') !== undefined) {
                sidebarId = jQuery('#sidebar_options .sidebar_table:last').attr('id');
                sidebarId = sidebarId.replace(/sidebar_table_/g, '');
                sidebarId = (sidebarId * 1) + 1;
                sidebarName = jQuery('#sidebar_generator_0').val();
		
                jQuery('#sidebar_options .sidebar_table:last').parent().find('tr:last').prev().after('<tr id="sidebar_table_' + sidebarId + '" class="sidebar_table">' + 
                    '<td style="padding-bottom:0;">' + 
                        '<div style="width:217px;" class="sidename fl">' + sidebarName + '</div>' + 
                        '<input type="button" value="Delete" class="button fl" id="sdbr_' + sidebarId + '" name="sidebar_rm_' + sidebarId + '" style="padding:5px 13px;" />' + 
                        '<div style="margin:7px 0 0 10px;" class="fl">' + 
                            '<img alt="Loading" src="' + loaderImageUrl + '/theme/administrator/images/wpspin_light.gif" style="display:none;" class="sidebar_rm_' + sidebarId + '">' + 
                        '</div>' + 
                    '</td>' + 
                    '<input type="hidden" value="' + sidebarName + '" name="sidebar_generator_' + sidebarId + '" id="sidebar_generator_' + sidebarId + '">' + 
                '</tr>');
            } else { 
                sidebarId = 1;
                sidebarName = jQuery('#sidebar_generator_0').val();
		
                jQuery('#side_del').append('<tbody>' + 
                    '<tr valign="top">' + 
                        '<td style="padding:0;">' + 
                            '<h3 style="margin:10px 0 0; padding:25px 0 10px;">Sidebars that you create</h3>' + 
                        '</td>' + 
                    '</tr>' + 
                    '<tr id="sidebar_table_' + sidebarId + '" class="sidebar_table">' + 
                        '<td style="padding-bottom:0;">' + 
                            '<div style="width:217px;" class="sidename fl">' + sidebarName + '</div>' + 
                            '<input type="button" value="Delete" class="button fl" id="sdbr_' + sidebarId + '" name="sidebar_rm_' + sidebarId + '" style="padding:5px 13px;" />' + 
                            '<div style="margin:7px 0 0 10px;" class="fl">' + 
                                '<img alt="Loading" src="' + loaderImageUrl + '/theme/administrator/images/wpspin_light.gif" style="display:none;" class="sidebar_rm_' + sidebarId + '">' + 
                            '</div>' + 
                        '</td>' + 
                        '<input type="hidden" value="' + sidebarName + '" name="sidebar_generator_' + sidebarId + '" id="sidebar_generator_' + sidebarId + '">' + 
                    '</tr>' + 
                    '<tr valign="top">' + 
                        '<td style="padding:0;">&nbsp;</td>' + 
                    '</tr>' + 
                '</tbody>');
            }
            
            var arraySidebarInputs = new Array;
            
            jQuery('#side_del input[name^="sidebar_generator_"]').each(function (id) {
                var updateSidebars = jQuery('#side_del input[name^="sidebar_generator_"]').get(id);
		
                arraySidebarInputs.push(updateSidebars.value);
            } );
            
            var sidebarInputsStr = arraySidebarInputs.join(',');
            
            jQuery.ajax( {
                type : 'post',
                url : rmSidebarAjaxUrl,
                data : {
                    action : 'sidebar_add', 
                    sidebar : sidebarInputsStr, 
                    sidebar_id : sidebarId, 
                    sidebar_name : sidebarName, 
                    _ajax_nonce : ajaxNonce
                },
                beforeSend : function () {
                    jQuery('.sidebar_rm_' + sidebarId).css( { display : '' } );
                },
                success : function () {
                    jQuery('.sidebar_rm_' + sidebarId).fadeOut('fast');
                }
            } );
            
            jQuery('#sidebar_generator_0').val('');
        }
	
        return false;
    } );
}


function show_hide_meta_boxes() {
    jQuery('.cmsmasters-post-control .switch').click(function () {
        jQuery(this).parents('div p').siblings('.description').toggle('slow');
	
        return false;
    } );
}


function exclude_include_checkbox() {
    var box_select = jQuery('.cmsmasters_box_select');
    
    box_select.each(function () {
        var box_select_id = jQuery(this).attr('id');
        var toshow = '.select_' + box_select_id;
        var class_toshow = jQuery(this).find(toshow);
	
        class_toshow.each(function () {
            var catid = jQuery(this).attr('name');
            
            jQuery(this).bind('change', function () {
                var original_pgstoshow = jQuery('input[name=' + box_select_id + ']').val();
		
                if (jQuery(this).attr('checked')) {
                    if (jQuery(this).val()) {
                        if (original_pgstoshow === ''){
                            jQuery('input[name=' + box_select_id + ']').val(catid);
                        } else {
                            jQuery('input[name=' + box_select_id + ']').val(original_pgstoshow + ',' + catid);
                        }
                    }
                } else {
                    original_pgstoshow = ',' + original_pgstoshow + ',';
                    original_pgstoshow = original_pgstoshow.replace(',' + catid + ',',',');
                    
                    if (original_pgstoshow.charAt(0) === ',') {
                        if (original_pgstoshow === ',') {
                            original_pgstoshow = '';
                        } else {
                            original_pgstoshow = original_pgstoshow.substr(1);
                        }
                    }
                    
                    if (original_pgstoshow.charAt((original_pgstoshow.length - 1)) === ',') {
                        original_pgstoshow = original_pgstoshow.substr(0, (original_pgstoshow.length - 1));
                    }
                    
                    jQuery('input[name=' + box_select_id + ']').val(original_pgstoshow);
                }
            } );
        } );
    } );
}


function include_type() {
    var checkbox = jQuery('.check_container li a');
    
    checkbox.live('click', function () {
        var item = jQuery(this).text();
        var field = jQuery(this).parent().parent().parent().find('input');
        var fieldval = field.val();
        var newfieldval;
	
        if (jQuery(this).parent().hasClass('selected')){
            jQuery(this).parent().removeClass('selected');
            newfieldval = fieldval.replace(item + ',', '');
            newfieldval = newfieldval.replace(',' + item, '');
            newfieldval = newfieldval.replace(item, '');
            field.val(newfieldval);
        } else {
            jQuery(this).parent().addClass('selected');
            
            if (fieldval === ''){
                newfieldval = item;
            } else {
                newfieldval = fieldval + ',' + item;
            }
            
            field.val(newfieldval);
        }
	
        return false;
    } );
}


function include_type_add() {
    var checkbox = jQuery('.include_container li span.include a');
    
    checkbox.live('click', function () {
        var item = jQuery(this).attr('href');
        var field = jQuery(this).parent().parent().parent().parent().find('input');
        var fieldval = field.val();
        var newfieldval;
	
        if (jQuery(this).parent().parent().hasClass('selected')) {
            jQuery(this).parent().parent().removeClass('selected');
            jQuery('#iconlink_' + item).parent().hide();
            newfieldval = fieldval.replace(item + ',', '');
            newfieldval = newfieldval.replace(',' + item, '');
            newfieldval = newfieldval.replace(item, '');
            field.val(newfieldval);
        } else {
            jQuery(this).parent().parent().addClass('selected');
            
            jQuery('#iconlink_' + item).parent().show();
            
            if (fieldval === ''){
                newfieldval = item;
            } else {
                newfieldval = fieldval + ',' + item;
            }
            
            field.val(newfieldval);
        }
	
        return false;
    } );
}


function exclude_include_sync() {
    var box_select = jQuery('.cmsmasters_box_select');
    
    box_select.each(function () {
        var box_select_id = jQuery(this).attr('id');
        var catstoshow = jQuery('input[name=' + box_select_id + ']').val();
        var catstoshow_array = new Array();
	
        if (catstoshow) {
            catstoshow_array = catstoshow.split(',');
        }
	
        var l = catstoshow_array.length;
	
        for (var i = 0; i < l; i++) {
            jQuery('#' + box_select_id + '_' + catstoshow_array[i]).attr('checked', 'checked');
        }
    } );
}


jQuery(document).ready(function () {
    sidebar_rm_ajax();
    sidebar_add_ajax();
    show_hide_meta_boxes();
    exclude_include_checkbox();
    include_type();
    include_type_add();
    exclude_include_sync();
} );



/* Theme settings scripts */

jQuery(function () { //Logo show/hide
    if (jQuery('input#site_name').is(':not(:checked)')) {
        jQuery('input#custom_logo').parent().parent().hide();
        jQuery('input#custom_logo').parent().parent().prev().hide();
    } else {
        jQuery('input#custom_title_text').parent().parent().hide();
        jQuery('input#custom_title_text').parent().parent().prev().hide();
        jQuery('input#site_descr').parent().parent().parent().hide();
        jQuery('input#site_descr').parent().parent().parent().prev().hide();
        jQuery('input#custom_descr_text').parent().parent().hide();
        jQuery('input#custom_descr_text').parent().parent().prev().hide();
    }
    
    jQuery('input[name="site_name"]').change(function () {
        if (jQuery('input#site_name_2').is(':checked')) {
            jQuery('input#custom_logo').parent().parent().hide();
            jQuery('input#custom_logo').parent().parent().prev().hide();
            jQuery('input#custom_title_text').parent().parent().show();
            jQuery('input#custom_title_text').parent().parent().prev().show();
            jQuery('input#site_descr').parent().parent().parent().show();
            jQuery('input#site_descr').parent().parent().parent().prev().show();
            
            if (jQuery('input#site_descr').is(':checked')) {
                jQuery('input#custom_descr_text').parent().parent().show();
                jQuery('input#custom_descr_text').parent().parent().prev().show();
            }
        } else {
            jQuery('input#custom_title_text').parent().parent().hide();
            jQuery('input#custom_title_text').parent().parent().prev().hide();
            jQuery('input#site_descr').parent().parent().parent().hide();
            jQuery('input#site_descr').parent().parent().parent().prev().hide();
            jQuery('input#custom_descr_text').parent().parent().hide();
            jQuery('input#custom_descr_text').parent().parent().prev().hide();
            jQuery('input#custom_logo').parent().parent().show();
            jQuery('input#custom_logo').parent().parent().prev().show();
        }
    } );
    
    jQuery('input#site_descr').change(function () {
        if (jQuery(this).is(':checked')) {
            jQuery('input#custom_descr_text').parent().parent().show();
            jQuery('input#custom_descr_text').parent().parent().prev().show();
        } else {
            jQuery('input#custom_descr_text').parent().parent().hide();
            jQuery('input#custom_descr_text').parent().parent().prev().hide();
        }
    } ); 
} );


jQuery(function () { //Favicon show/hide
    if (jQuery('input#site_favicon').is(':not(:checked)')) {
        jQuery('input#custom_favicon').parent().parent().hide();
        jQuery('input#custom_favicon').parent().parent().prev().hide();
    }
    
    jQuery('input#site_favicon').change(function () {
        if (jQuery(this).is(':checked')) {
            jQuery('input#custom_favicon').parent().parent().show();
            jQuery('input#custom_favicon').parent().parent().prev().show();
        } else {
            jQuery('input#custom_favicon').parent().parent().hide();
            jQuery('input#custom_favicon').parent().parent().prev().hide();
        }
    } ); 
} );


jQuery(function () { //Footer show/hide
    if (jQuery('input#site_footer').is(':checked')) {
        if (jQuery('input#site_footer_content_0').is(':checked') || jQuery('input#site_footer_content_1').is(':checked')) { 
            jQuery('textarea#footer_html').parent().parent().hide();
            jQuery('textarea#footer_html').parent().parent().prev().hide();
        }
    } else { 
        jQuery('input#site_footer_content_0').parent().parent().parent().parent().hide();
        jQuery('input#site_footer_content_0').parent().parent().parent().parent().prev().hide();
        jQuery('textarea#footer_html').parent().parent().hide();
        jQuery('textarea#footer_html').parent().parent().prev().hide();
    }
    
    jQuery('input[name="site_footer_content"]').change(function () {
        if (jQuery('input#site_footer_content_2').is(':checked')) {
            jQuery('textarea#footer_html').parent().parent().show();
            jQuery('textarea#footer_html').parent().parent().prev().show();
        } else { 
            jQuery('textarea#footer_html').parent().parent().hide();
            jQuery('textarea#footer_html').parent().parent().prev().hide();
        }
    } );
    
    jQuery('input[name="site_footer"]').change(function () {
        if (jQuery('input#site_footer').is(':checked')) {
            jQuery('input#site_footer_content_0').parent().parent().parent().parent().show();
            jQuery('input#site_footer_content_0').parent().parent().parent().parent().prev().show();
            
            if (jQuery('input#site_footer_content_2').is(':checked')) {
                jQuery('textarea#footer_html').parent().parent().show();
                jQuery('textarea#footer_html').parent().parent().prev().show();
            }
        } else {
            jQuery('input#site_footer_content_0').parent().parent().parent().parent().hide();
            jQuery('input#site_footer_content_0').parent().parent().parent().parent().prev().hide();
            jQuery('textarea#footer_html').parent().parent().hide();
            jQuery('textarea#footer_html').parent().parent().prev().hide();
        }
    } );
} );


jQuery(function () { //SEO show/hide
    if (jQuery('input#seo_enable').is(':not(:checked)')) {
        jQuery('input#seo_title').parent().parent().hide();
        jQuery('input#seo_title').parent().parent().prev().hide();
        jQuery('textarea#seo_description').parent().parent().hide();
        jQuery('textarea#seo_description').parent().parent().prev().hide();
        jQuery('textarea#seo_keywords').parent().parent().hide();
        jQuery('textarea#seo_keywords').parent().parent().prev().hide();
    }
    
    jQuery('input#seo_enable').change(function () {
        if (jQuery('input#seo_enable').is(':checked')) {
            jQuery('input#seo_title').parent().parent().show();
            jQuery('input#seo_title').parent().parent().prev().show();
            jQuery('textarea#seo_description').parent().parent().show();
            jQuery('textarea#seo_description').parent().parent().prev().show();
            jQuery('textarea#seo_keywords').parent().parent().show();
            jQuery('textarea#seo_keywords').parent().parent().prev().show();
        } else {
            jQuery('input#seo_title').parent().parent().hide();
            jQuery('input#seo_title').parent().parent().prev().hide();
            jQuery('textarea#seo_description').parent().parent().hide();
            jQuery('textarea#seo_description').parent().parent().prev().hide();
            jQuery('textarea#seo_keywords').parent().parent().hide();
            jQuery('textarea#seo_keywords').parent().parent().prev().hide();
        }
    } ); 
} );


jQuery(function () { //Sitemap show/hide
    if (jQuery('input#error_sitemap_show').is(':not(:checked)')) { 
        jQuery('input#error_sitemap_link').parent().parent().hide();
        jQuery('input#error_sitemap_link').parent().parent().prev().hide();
    }
    
    jQuery('input#error_sitemap_show').change(function () {
        if (jQuery('input#error_sitemap_show').is(':checked')) {
            jQuery('input#error_sitemap_link').parent().parent().show();
            jQuery('input#error_sitemap_link').parent().parent().prev().show();
        } else {
            jQuery('input#error_sitemap_link').parent().parent().hide();
            jQuery('input#error_sitemap_link').parent().parent().prev().hide();
        }
    } );
} );


jQuery(document).ready(function () { //Color choose
    jQuery('.slider .rght .colrs a').click(function () {
        var bgcol = jQuery(this).attr('href');
        var id = jQuery(this).parent().attr('id').replace('_colrs', '');
	
        jQuery('.slider .rght .colrs a').removeClass('selected');
        jQuery(this).addClass('selected');
        jQuery('#' + id).val(bgcol).css( { backgroundColor : bgcol } );
	
        return false;
    } );
} );


jQuery(document).ready(function(){ //Background choose
    jQuery('.slider .rght .select_bgs a').click(function () {
        var bgimg = jQuery(this).attr('href');
        var id = jQuery(this).parent().attr('id').replace('_patterns_bgs', '').replace('_transparents_bgs', '').replace('_images_bgs', '');
	
        jQuery('.slider .rght .select_bgs a').removeClass('selected');
        jQuery(this).addClass('selected');
        jQuery('#' + id).val(bgimg);
	
        return false;
    } );
} );


jQuery(document).ready(function () { //Messages autohide
    jQuery('#settings_active').delay(10000).slideUp('slow');
    jQuery('#settings_save_ie').delay(10000).slideUp('slow');
} );


jQuery(window).load(function () { //Shortcodes buttons show/hide
    if (jQuery('#content_toolbar2').css('display') !== 'none') {
        jQuery('#content_toolbar3').show();
        jQuery('#content_wp_adv').addClass('mceButtonActive');
    }
    
    jQuery('#content_wp_adv').click(function () {
        if (jQuery('#content_toolbar2').css('display') !== 'none') {
            jQuery('#content_toolbar3').show();
            jQuery(this).addClass('mceButtonActive');
        } else {
            jQuery('#content_toolbar3').hide();
            jQuery(this).removeClass('mceButtonActive');
        }
    } );
} );



/* Admin pages scripts */

jQuery(function () { //Custom breadcrumbs show/hide
    if (jQuery('input#selected_breadcrumbs_active_2').is(':checked')) {
        jQuery('#selected_breadcrumbs_meta, #selected_breadcrumbs_link_meta').slideDown('fast');
        jQuery('#selected_breadcrumbs_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
    }
    
    jQuery('input[name="selected_breadcrumbs_active"]').change(function () {
        if (jQuery('input#selected_breadcrumbs_active_2').is(':checked')) {
            jQuery('#selected_breadcrumbs_meta, #selected_breadcrumbs_link_meta').slideDown('fast');
            jQuery('#selected_breadcrumbs_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
        } else {
            jQuery('#selected_breadcrumbs_meta, #selected_breadcrumbs_link_meta').slideUp('fast');
            jQuery('#selected_breadcrumbs_active_meta').find('p.add_margin').addClass('remove_margin').removeClass('add_margin');
        }
    } );
} );


jQuery(function () { //Custom backgroung show/hide
    if (jQuery('input#bgtools_active_2').is(':checked')) {
        jQuery('#bgtools_color_meta, #bgtools_image_meta').slideDown('fast');
        jQuery('#bgtools_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
    }
    
    jQuery('input[name="bgtools_active"]').change(function () {
        if (jQuery('input#bgtools_active_2').is(':checked')) {
            jQuery('#bgtools_color_meta, #bgtools_image_meta').slideDown('fast');
            jQuery('#bgtools_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
        } else {
            jQuery('#bgtools_color_meta, #bgtools_image_meta').slideUp('fast');
            jQuery('#bgtools_active_meta').find('p.add_margin').addClass('remove_margin').removeClass('add_margin');
        }
    } );
} );


jQuery(function () { //Custom SEO show/hide
    if (jQuery('input#seotools_active_2').is(':checked')) {
        jQuery('#seotools_title_meta, #seotools_description_meta, #seotools_keywords_meta').slideDown('fast');
        jQuery('#seotools_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
    }
    
    jQuery('input[name="seotools_active"]').change(function () {
        if (jQuery('input#seotools_active_2').is(':checked')) {
            jQuery('#seotools_title_meta, #seotools_description_meta, #seotools_keywords_meta').slideDown('fast');
            jQuery('#seotools_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
        } else {
            jQuery('#seotools_title_meta, #seotools_description_meta, #seotools_keywords_meta').slideUp('fast');
            jQuery('#seotools_active_meta').find('p.add_margin').addClass('remove_margin').removeClass('add_margin');
        }
    } );
} );


jQuery(function () { //Post formats show/hide
    if (jQuery('input#post-format-link').is(':checked')) {
        jQuery('#post_link_text_meta').slideDown('fast');
        jQuery('#post_link_link_meta').slideDown('fast');
    }
    
    if (jQuery('input#post-format-video').is(':checked')) {
        jQuery('#post_video_link_meta').slideDown('fast');
    }
    
    if (jQuery('input#post-format-audio').is(':checked')) {
        jQuery('#post_audio_link_meta').slideDown('fast');
    }
    
    jQuery('input[name="post_format"]').change(function () {
        if (jQuery('input#post-format-link').is(':checked')) {
            jQuery('#post_link_text_meta').slideDown('fast');
            jQuery('#post_link_link_meta').slideDown('fast');
        } else {
            jQuery('#post_link_text_meta').slideUp('fast');
            jQuery('#post_link_link_meta').slideUp('fast');
        }
        
        if (jQuery('input#post-format-video').is(':checked')) {
            jQuery('#post_video_link_meta').slideDown('fast');
        } else {
            jQuery('#post_video_link_meta').slideUp('fast');
        }
        
        if (jQuery('input#post-format-audio').is(':checked')) {
            jQuery('#post_audio_link_meta').slideDown('fast');
        } else {
            jQuery('#post_audio_link_meta').slideUp('fast');
        }
    } );
} );


jQuery(function () { //Project formats show/hide
    if (jQuery('input#project-format-video').is(':checked')) {
        jQuery('#project_video_link_meta').slideDown('fast');
    }
    
    if (jQuery('input#project-format-album').is(':checked') && jQuery('input#page_layout_3').is(':checked')) {
		jQuery('#selected_numbercolumns_full_album_meta').slideDown('fast');
	} else if (jQuery('input#project-format-album').is(':checked') && jQuery('input#page_layout_3').is(':not(:checked)')) {
		jQuery('#selected_numbercolumns_sidebar_album_meta').slideDown('fast');
    }
    
    jQuery('input[name="pt_format"]').change(function () {
        if (jQuery('input#project-format-video').is(':checked')) {
            jQuery('#project_video_link_meta').slideDown('fast');
        } else {
            jQuery('#project_video_link_meta').slideUp('fast');
        }
        
        if (jQuery('input#project-format-album').is(':checked') && jQuery('input#page_layout_3').is(':checked')) {
			jQuery('#selected_numbercolumns_sidebar_album_meta').slideUp('fast');
			jQuery('#selected_numbercolumns_full_album_meta').slideDown('fast');
		} else if (jQuery('input#project-format-album').is(':checked') && jQuery('input#page_layout_3').is(':not(:checked)')) {
			jQuery('#selected_numbercolumns_sidebar_album_meta').slideDown('fast');
			jQuery('#selected_numbercolumns_full_album_meta').slideUp('fast');
        } else {
			jQuery('#selected_numbercolumns_sidebar_album_meta').slideUp('fast');
			jQuery('#selected_numbercolumns_full_album_meta').slideUp('fast');
        }
    } );
    
    jQuery('input[name="page_layout"]').change(function () {
		if (jQuery('input#project-format-album').is(':checked') && jQuery('input#page_layout_3').is(':checked')) {
			jQuery('#selected_numbercolumns_sidebar_album_meta').slideUp('fast');
			jQuery('#selected_numbercolumns_full_album_meta').slideDown('fast');
		} else if (jQuery('input#project-format-album').is(':checked') && jQuery('input#page_layout_3').is(':not(:checked)')) {
			jQuery('#selected_numbercolumns_sidebar_album_meta').slideDown('fast');
			jQuery('#selected_numbercolumns_full_album_meta').slideUp('fast');
		}
    } );
} );


jQuery(function () { //Custom sidebar show/hide
    if (jQuery('input#page_layout_3').is(':not(:checked)')) {
        jQuery('#selected_sidebar_meta').slideDown('fast');
    }
    
    jQuery('input[name="page_layout"]').change(function () {
        if (jQuery('input#page_layout_3').is(':checked')) {
            jQuery('#selected_sidebar_meta').slideUp('fast');
        } else {
            jQuery('#selected_sidebar_meta').slideDown('fast');
        }
    } );
} );


jQuery(function () { //Custom heading show/hide
    if (jQuery('input#headingtools_active_2').is(':checked')) {
        jQuery('#headingtools_title_meta, #headingtools_description_meta, #headingtools_icon_meta').slideDown('fast');
        jQuery('#headingtools_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
    }
    
    jQuery('input[name="headingtools_active"]').change(function () {
        if (jQuery('input#headingtools_active_2').is(':checked')) {
            jQuery('#headingtools_title_meta, #headingtools_description_meta, #headingtools_icon_meta').slideDown('fast');
            jQuery('#headingtools_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
        } else {
            jQuery('#headingtools_title_meta, #headingtools_description_meta, #headingtools_icon_meta').slideUp('fast');
            jQuery('#headingtools_active_meta').find('p.add_margin').addClass('remove_margin').removeClass('add_margin');
        }
    } );
} );


jQuery(function () { //Custom slider show/hide
    if (jQuery('input#slidertools_active_2').is(':checked')) {
        jQuery('#slidertools_slider_id_meta').slideDown('fast');
		jQuery('#slidertools_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
    }
    
    jQuery('input[name="slidertools_active"]').change(function () {
        if (jQuery('input#slidertools_active_2').is(':checked')) {
            jQuery('#slidertools_slider_id_meta').slideDown('fast');
            jQuery('#slidertools_active_meta').find('p.remove_margin').addClass('add_margin').removeClass('remove_margin');
        } else {
            jQuery('#slidertools_slider_id_meta').slideUp('fast');
            jQuery('#slidertools_active_meta').find('p.add_margin').addClass('remove_margin').removeClass('add_margin');
        }
    } );
} );


jQuery(function () { //Page Templates show/hide
    if (jQuery('select#page_template').val() === 'blog.php') {
        jQuery('#selected_order_type_meta, #selected_order_meta, #selected_perpage_meta, #blog_categ_meta').slideDown('fast');
    } else if (jQuery('select#page_template').val() === 'portfolio.php'){
        jQuery('#selected_order_type_meta, #selected_order_meta, #selected_perpage_meta, #portfolio_categ_meta, #filter_active_meta').slideDown('fast');
        
        if (jQuery('#page_layout_3').is(':checked')) {
            jQuery('#selected_numbercolumns_full_meta').slideDown('fast');
        } else {
            jQuery('#selected_numbercolumns_sidebar_meta').slideDown('fast');
        }
    }
    
    jQuery('select#page_template').change(function () {
        if (jQuery('select#page_template').val() === 'blog.php') {
            jQuery('#portfolio_categ_meta, #filter_active_meta, #selected_numbercolumns_sidebar_meta, #selected_numbercolumns_full_meta').slideUp('fast');
            jQuery('#selected_order_type_meta, #selected_order_meta, #selected_perpage_meta, #blog_categ_meta').slideDown('fast');
        } else if (jQuery('select#page_template').val() == 'portfolio.php'){
            jQuery('#blog_categ_meta, #selected_numbercolumns_sidebar_meta, #selected_numbercolumns_full_meta').slideUp('fast');
            jQuery('#selected_order_type_meta, #selected_order_meta, #selected_perpage_meta, #portfolio_categ_meta, #filter_active_meta').slideDown('fast');
            
            if (jQuery('#page_layout_3').is(':checked')) {
                jQuery('#selected_numbercolumns_full_meta').slideDown('fast');
            } else {
                jQuery('#selected_numbercolumns_sidebar_meta').slideDown('fast');
            }
        } else {
            jQuery('#blog_categ_meta, #portfolio_categ_meta, #selected_order_type_meta, #selected_order_meta, #selected_perpage_meta, #filter_active_meta, #selected_numbercolumns_sidebar_meta, #selected_numbercolumns_full_meta').slideUp('fast');
        }
    } );
    
    jQuery('input[name="page_layout"]').change(function () {
        if (jQuery('select#page_template').val() === 'portfolio.php') {
            if (jQuery('#page_layout_3').is(':checked')) {
                jQuery('#selected_numbercolumns_sidebar_meta').slideUp('fast');
                jQuery('#selected_numbercolumns_full_meta').slideDown('fast');
            } else {
                jQuery('#selected_numbercolumns_full_meta').slideUp('fast');
                jQuery('#selected_numbercolumns_sidebar_meta').slideDown('fast');
            }
        }
    } );
} );


jQuery(function () { //Project link show/hide
    if (jQuery('input#project_linking_2').is(':checked')) {
        jQuery('#project_url_meta').slideDown('fast');
    }
    
    jQuery('input[name="project_linking"]').change(function () {
        if (jQuery('input#project_linking_2').is(':checked')) {
            jQuery('#project_url_meta').slideDown('fast');
        } else {
            jQuery('#project_url_meta').slideUp('fast');
        }
    } );
} );


jQuery(function () { //Project video show/hide
    if (jQuery('input#project_content_type_3').is(':checked')) {
        jQuery('#project_video_url_meta').slideDown('fast');
    }
    
    jQuery('input[name="project_content_type"]').change(function () {
        if (jQuery('input#project_content_type_3').is(':checked')) {
            jQuery('#project_video_url_meta').slideDown('fast');
        } else {
            jQuery('#project_video_url_meta').slideUp('fast');
        }
    } );
} );
