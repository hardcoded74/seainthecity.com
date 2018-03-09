/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 */

/**
 * Slider Manager v1.1 - jQuery Slider Manager
 * 
 * (c) Copyright Steven "cmsmasters" Masters
 * http://cmsmastrs.net/
 * For sale on ThemeForest.net
 */


var sliderManager = {
    _counter : 0,
    _oSliderFormData : {},
    _oSlideInputId : {},
    _oSlideImgUrl : {},
    _page : {},
    _pageConfig : function () {
        this.config = {
            _oResponsiveSliderFields : {
                'slider_animation' : {
                    title : 'Slider Animation Speed (in seconds)',
                    value : '0.6',
                    category : 'slider_anim',
                    type : 'spinner',
					min : 0.1,
					max : 999,
					step : 0.1,
					null : false,
                    description : 'Some description'
                },
                'slider_pause' : {
                    title : 'Slider Pause Time (in seconds)',
                    value : '7',
                    category : 'slider_anim',
                    type : 'spinner',
					min : 0,
					max : 999,
					step : 0.1,
					null : true,
                    description : 'Some description'
                },
                'slider_effect' : {
                    title : 'Slider Animation Effect',
                    value : 'slide',
                    category : 'slider_anim',
                    type : 'select',
                    select : {
                        "slide" : "Slide",
                        "fadeSlide" : "Fade-Slide",
                        "fade" : "Fade"
                    },
                    description : 'Some description'
                },
                'slider_easing' : {
                    title : 'Slider Animation Easing',
                    value : 'easeInOutExpo',
                    category : 'slider_anim',
                    type : 'select',
                    select : {
                        "linear" : "None",
						"easeInQuad" : "Ease-In-Quad",
						"easeOutQuad" : "Ease-Out-Quad",
						"easeInOutQuad" : "Ease-In-Out-Quad",
						"easeInCubic" : "Ease-In-Cubic",
						"easeOutCubic" : "Ease-Out-Cubic",
						"easeInOutCubic" : "Ease-In-Out-Cubic",
						"easeInQuart" : "Ease-In-Quart",
						"easeOutQuart" : "Ease-Out-Quart",
						"easeInOutQuart" : "Ease-In-Out-Quart",
						"easeInQuint" : "Ease-In-Quint",
						"easeOutQuint" : "Ease-Out-Quint",
						"easeInOutQuint" : "Ease-In-Out-Quint",
						"easeInSine" : "Ease-In-Sine",
						"easeOutSine" : "Ease-Out-Sine",
						"easeInOutSine" : "Ease-In-Out-Sine",
						"easeInExpo" : "Ease-In-Expo",
						"easeOutExpo" : "Ease-Out-Expo",
						"easeInOutExpo" : "Ease-In-Out-Expo",
						"easeInCirc" : "Ease-In-Circ",
						"easeOutCirc" : "Ease-Out-Circ",
						"easeInOutCirc" : "Ease-In-Out-Circ",
						"easeInElastic" : "Ease-In-Elastic",
						"easeOutElastic" : "Ease-Out-Elastic",
						"easeInOutElastic" : "Ease-In-Out-Elastic",
						"easeInBack" : "Ease-In-Back",
						"easeOutBack" : "Ease-Out-Back",
						"easeInOutBack" : "Ease-In-Out-Back",
						"easeInBounce" : "Ease-In-Bounce",
						"easeOutBounce" : "Ease-Out-Bounce",
						"easeInOutBounce" : "Ease-In-Out-Bounce"
                    },
                    description : 'Some description'
                },
                'slides_caption' : {
                    title : 'Show Slides Captions',
                    value : 'true',
                    type : 'checkbox',
                    category : 'slider_anim',
                    description : 'Some description'
                },
                'active_slide' : {
                    title : 'Active Slide',
                    value : '1',
                    category : 'slider_anim',
                    type : 'spinner',
					min : 1,
					max : 999,
					step : 1,
					null : false,
                    description : 'Some description'
                },
                'touch_controls' : {
                    title : 'Enable Touch Control',
                    value : 'true',
                    category : 'slider_contr',
                    type : 'checkbox',
                    description : 'Some description'
                },
                'button_controls' : {
                    title : 'Enable Keyboard Buttons Control',
                    value : 'true',
                    category : 'slider_contr',
                    type : 'checkbox',
                    description : 'Some description'
                },
                'slides_navigation' : {
                    title : 'Show Slides Navigation',
                    value : 'true',
                    category : 'slider_contr',
                    type : 'checkbox',
                    description : 'Some description'
                },
                'arrow_navigation' : {
                    title : 'Show Arrow Navigation',
                    value : 'false',
                    category : 'slider_contr',
                    type : 'checkbox',
                    description : 'Some description'
                },
                'slider_timer' : {
                    title : 'Show Timer',
                    value : 'true',
                    type : 'checkbox',
                    category : 'slider_contr',
                    description : 'Some description'
                },
                'pause_on_hover' : {
                    title : 'Pause on Mouseover',
                    value : '',
                    type : 'checkbox',
                    category : 'slider_hov',
                    description : 'Some description'
                },
                'slides_navigation_hover' : {
                    title : 'Show Slides Navigation Only on Mouseover',
                    value : 'false',
                    type : 'checkbox',
                    category : 'slider_hov',
                    description : 'Some description'
                },
                'arrow_navigation_hover' : {
                    title : 'Show Arrow Navigation Only on Mouseover',
                    value : 'false',
                    type : 'checkbox',
                    category : 'slider_hov',
                    description : 'Some description'
                },
                'slider_timer_hover' : {
                    title : 'Show Timer Only on Mouseover',
                    value : 'false',
                    type : 'checkbox',
                    category : 'slider_hov',
                    description : 'Some description'
                }
            },
            _oSliderFields : {
                'slider_name' : {
                    title : 'Slider Name',
                    value : '',
                    type : 'text',
                    description : 'Some description'
                }
            },
            _oResponsiveSlideFields : {
                'slide_title' : {
                    title : 'Slide Title',
                    value : 'You can enter slide name here',
                    type : 'text',
                    category : 'general',
                    description : 'Some description'
                },
                'slide_add_video' : {
                    title : 'Add Video To Slide',
                    value : 'false',
                    type : 'checkbox',
                    category : 'video',
                    description : 'Some description'
                },
                'slide_video_url' : {
                    title : 'Video URL',
                    value : '',
                    type : 'text',
                    category : 'video',
                    description : 'Some description'
                },
                'slide_img_pos' : {
                    title : 'Slide Image Size & Position',
                    value : 'fullwidth',
                    type : 'select',
                    select : {
                        "full-img" : "Full Width Slide Image",
                        "left-img" : "Left Slide Image",
                        "right-img" : "Right Slide Image"
                    },
                    category : 'slideaslink',
                    description : 'Some description'
                },
                'slide_as_link_add' : {
                    title : 'Use Slide Image As Link',
                    value : 'false',
                    type : 'checkbox',
                    category : 'slideaslink',
                    description : 'Some description'
                },
                'slide_as_link_url' : {
                    title : 'Slide Image Link URL',
                    value : '',
                    type : 'text',
                    category : 'slideaslink',
                    description : 'Some description'
                },
                'slide_as_link_target' : {
                    title : 'Open Slide Image Link In New Tab',
                    value : 'false',
                    type : 'checkbox',
                    category : 'slideaslink',
                    description : 'Some description'
                },
            },
            _oSlideFields : {
                'slide_link' : {
                    title : 'Slide Link',
                    value : '',
                    type : 'text',
                    category : 'general',
                    description : 'Some description'
                },
                'show_caption' : {
                    title : 'Show Caption',
                    value : 'false',
                    type : 'checkbox',
                    category : 'caption',
                    description : 'Some description'
                },
                'slide_caption_pos' : {
                    title : 'Caption Position',
                    value : 'bottom',
                    type : 'select',
                    select : {
                        "top" : "Top",
                        "bottom" : "Bottom",
                        "left" : "Left",
                        "right" : "Right"
                    },
                    category : 'caption',
                    description : 'Some description'
                },
                'caption_title' : {
                    title : 'Caption Title',
                    value : '',
                    type : 'text',
                    category : 'caption',
                    description : 'Some description'
                },
                'caption_text' : {
                    title : 'Caption Text',
                    value : '',
                    type : 'textarea',
                    category : 'caption',
                    description : 'Some description'
                },
                'caption_link_enable' : {
                    title : 'Enable Caption Link/Button',
                    value : 'false',
                    type : 'checkbox',
                    category : 'caption',
                    description : 'Some description'
                },
                'slide_caption_text_or_button' : {
                    title : 'Use Text Link or Button',
                    value : 'true',
                    type : 'select',
                    select : {
                        'button' : 'Use Button',
                        'link' : 'Use Text Link'
                    },
                    category : 'caption',
                    description : 'Some description'
                },
                'slide_caption_url_text' : {
                    title : 'Link/Button Text',
                    value : '',
                    type : 'text',
                    category : 'caption',
                    description : 'Some description'
                },
                'slide_link_text_value' : {
                    title : 'Link/Button URL',
                    value : '',
                    type : 'text',
                    category : 'caption',
                    description : 'Some description'
                },
                'slide_link_target' : {
                    title : 'Open Link In New Tab',
                    value : 'false',
                    type : 'checkbox',
                    category : 'caption',
                    description : 'Some description'
                }
            }
        };
    },
    init : function () {
        this._registerEvents();
		
		sliderManager._counter = jQuery('#slides_counter').val();
		
        sliderManager.initConfig();
		
        jQuery('#slider_id').val('');
    }, 
    initConfig : function () {
        this._page = new this._pageConfig();
    },
    _registerEvents : function () { 
        jQuery(document).delegate('.slide_title_show', 'click', function () {
            jQuery(this).hide();
            jQuery(this).next().show().focus();
        } );
		
		jQuery(document).delegate('.slide_title_inp', 'focusin', function () {
            if (jQuery(this).val() === 'You can enter slide name here') {
				jQuery(this).val('');
			}
        } );
		
        jQuery(document).delegate('.slide_title_inp', 'focusout', function () {
            if (jQuery(this).val() === '') {
				jQuery(this).val('You can enter slide name here');
			}
        } );
		
        jQuery(document).delegate('.slide_title_inp', 'blur', function () {
            var title_name = jQuery(this).val();
			
            jQuery(this).hide();
            jQuery(this).prev().text(title_name);
            jQuery(this).parent().parent().parent().find('input[name="slide_title"]').val(title_name);
            jQuery(this).prev().show();
        } );
		
        jQuery(document).delegate('[name="slide_upload_button"]', 'click', function () {
            sliderManager._oSlideInputId = jQuery(this).parent().parent().parent().find('[name="slide_link"]');
            
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			
            return false;
        } );
	
        jQuery(document).delegate('[class="img_choose_image"]', 'click', function () {
            sliderManager._oSlideInputId = jQuery(this).parent().parent().parent().find('[name="slide_link"]');
            
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			
            return false;
        } );
        
        jQuery(document).delegate('#slide_link', 'click', function () {
            sliderManager._oSlideInputId = jQuery(this);
			
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			
            return false;
        } );
		
        window.send_to_editor = function (html) {
            var imgurl = jQuery('img', html).attr('src'), 
				input = sliderManager._oSlideInputId;
            
            jQuery(input).val(imgurl);
			
            sliderManager._oSlideImgUrl.url = imgurl;
			
            sliderManager.appendImage();
			
            tb_remove();
        }
        
        jQuery('#cancel_slider').click(function () {
			if (confirm('Are you sure? All data will be lost.') === false) {
				return false;
			}
			
			jQuery('#slider_id').val('');
			jQuery('.clsep').slideUp(0);
			
			sliderManager.clearContentBlock();
			
			jQuery('#saveAsSlider').hide();
			jQuery(this).hide();
			jQuery(this).prev().show();
        } );
		
        jQuery(document).delegate('.save_slider', 'click', function () {
			if (sliderManager.checker() === false) {
                return false;
            }
			
            var id = jQuery('#slider_id').val();
			
			if (id === '') {
                var sn = jQuery('#slider_name').val();
				
				if (sliderManager.checkName(sn) === false) {
					return false;
				}
            }
			
            jQuery('#saveAsSlider').hide();
            jQuery('#cancel_slider').hide();
            jQuery('#addSlider').show();
			
            jQuery.ajaxSetup( { 
				async : false 
			} );
			
            sliderManager.prepareData();
			
            if (id !== '') {
                sliderManager._addSlider('updateSlider', id);
            } else {
                sliderManager._addSlider('insertSlider');
            }
			
			jQuery('#slider_id').val('');
            jQuery('.clsep').slideUp(0);
			
            sliderManager.clearContentBlock();
            sliderManager.getSliderSelect();
			
			jQuery('#settings_save').slideDown('fast').delay(5000).slideUp('slow');
            jQuery('html, body').animate( { 
				scrollTop : 0 
			}, 100);
        } );
		
        jQuery('#saveAsSlider').click(function () {
			var sn = prompt('Please enter slider name');
			
			if (sn === null || sn === '') {
				return false;
			}
			
			if (sliderManager.checkName(sn) === false) {
				return false;
			}
			
			jQuery('#slider_name').val(sn);
			
			if (sliderManager.checker() === false) {
				return false;
            }
			
            jQuery('#saveAsSlider').hide();
            jQuery('#cancel_slider').hide();
            jQuery('#addSlider').show();
            
            jQuery.ajaxSetup( { 
				async : false 
			} );
			
            sliderManager.prepareData();
	
            sliderManager._addSlider('insertSlider');
            jQuery('.clsep').slideUp(0);
			
            sliderManager.clearContentBlock();
            sliderManager.getSliderSelect();
			
            jQuery('#slider_id').val('');
            jQuery('#settings_save').slideDown('fast').delay(5000).slideUp('slow');
			
            jQuery('html, body').animate( { 
				scrollTop : 0 
			}, 100);
        } );
		
        jQuery('#addSlider').click(function () {
            if (!jQuery('#slider_manager_tab').is(':empty')) {
                if (confirm('Are you sure? All data will be lost.') === false) {
                    return false;
                }
            }
			
            var slider_n = prompt('Please enter slider name');
			
            if (slider_n === '' || slider_n === null) {
                return false;
            }
			
			if (sliderManager.checkName(slider_n) === false) {
				return false;
			}
			
            jQuery('#slider_id').val('');
            jQuery('#slides_counter').val(0);
            jQuery(this).hide();
            jQuery(this).next().show();
            
            sliderManager.initConfig();
            sliderManager.clearContentBlock();
            sliderManager.appendHeadBlock();
            sliderManager.appendSlideBlock();
            sliderManager.appendSlideNav();
            sliderManager.appendSliderBlock();
            sliderManager.appendNavBlock();
            sliderManager.hideNextAll();
			
            jQuery('#slider_name').val(slider_n);
			
            jQuery('html, body').animate( { 
				scrollTop : 0 
			}, 100);
        } );
        
        jQuery('#deleteSlider').click(function () {
            var id = jQuery('#sliderChoose').val();
			
            if (id === '') {
                alert('Choose slider to delete');
				
                return false;
            }

            if (confirm('Are you sure? All data will be lost.') === false) {
                return false;
            }

            jQuery.ajaxSetup( { 
				async : false 
			} );
			
            sliderManager.deleteSlider(id);
			
            if (jQuery('#slider_id').val() === id) {
                jQuery('.clsep').slideUp(0);
				
                sliderManager.clearContentBlock();
				
                jQuery('#saveAsSlider').hide();
                jQuery('#cancel_slider').hide();
                jQuery('#addSlider').show();
            }
			
			sliderManager.getSliderSelect();
			
            jQuery('#settings_error').slideDown('fast').delay(5000).slideUp('slow');
        } );
		
		jQuery('#editSlider').click(function () {
            if (jQuery('#sliderChoose').is(':empty')) {
                return false;
            }
			
            var id = jQuery('#sliderChoose').val();
            
            if (jQuery('#slider_id').val() === id && id !== '') {
                alert('You are already editing this slider');
				
                return false;
            } else if (id === '') {
                alert('Please choose a slider or create a new');
				
                return false;
            }
            
            if (!jQuery('#slider_manager_tab').is(':empty')) {
                if (confirm('Are you sure? All data will be lost.') === false) {
                    return false;
                }
            }
			
            jQuery('#addSlider').hide();
            jQuery('#addSlider').next().show();
            jQuery('#saveAsSlider').show();
			
            jQuery.ajaxSetup( { 
				async : false 
			} );
			
            jQuery('#slides_counter').val(0);
			
            sliderManager.clearContentBlock();
			
            jQuery('#slider_id').val(id);
			
            sliderManager.loadData(id);
            sliderManager.sortableInit();
            sliderManager.hideNextAll();
        } );
		
        jQuery(document).delegate('#add_new_slide' , 'click', function () {
            sliderManager.initConfig();
            sliderManager.appendSlideBlock();
            sliderManager.sortableInit();
        } );
		
        jQuery(document).delegate('[name="delete_slide"]', 'click', function () {
            jQuery(this).parent().parent().parent().parent().parent().remove();
        } );
		
        jQuery(document).delegate('[name="expand_slide_button"]', 'click', function () {
            jQuery(this).hide();
            jQuery(this).next().show();
            jQuery(this).parent().parent().parent().find('[name="expandable"]').show();
			
            sliderManager.hideNextAll();
        } );
		
        jQuery(document).delegate('[name="hide_slide_button"]', 'click', function () {
            jQuery(this).hide();
            jQuery(this).prev().show();
            jQuery(this).parent().parent().parent().find('[name="expandable"]').hide();
        } );
        
        jQuery(document).delegate('#min_all', 'click', function () {
            jQuery('[name="hide_slide_button"]').hide();
            jQuery('[name="expand_slide_button"]').show();
            jQuery('[name="expandable"]').hide();
        } );
        
        jQuery(document).delegate('#max_all', 'click', function () {
            jQuery('[name="hide_slide_button"]').show();
            jQuery('[name="expand_slide_button"]').hide();
            jQuery('[name="expandable"]').show();
			
            sliderManager.hideNextAll();
        } );
		
        jQuery(document).delegate('[name="slide_add_video"]', 'click', function () {
            jQuery(this).parent().nextAll().toggle();
        } );
		
        jQuery(document).delegate('[name="slide_as_link_add"]', 'click', function () {
            jQuery(this).parent().nextAll().toggle();
        } );
		
        jQuery(document).delegate('[name="show_caption"]', 'click', function () {
            jQuery(this).parent().nextAll().toggle();
			
            sliderManager.hideNextAll();
        } );
		
        jQuery(document).delegate('[name="caption_link_enable"]', 'click', function () {
            jQuery(this).parent().nextAll().toggle();
        } );
		
        jQuery(document).delegate('[name="slides_navigation"]', 'click', function () {
            jQuery('[name="slides_navigation_hover"]').parent().toggle();
			
            sliderManager.hideNextAll();
        } );
		
        jQuery(document).delegate('[name="arrow_navigation"]', 'click', function () {
            jQuery('[name="arrow_navigation_hover"]').parent().toggle();
			
            sliderManager.hideNextAll();
        } );
		
        jQuery(document).delegate('[name="slider_timer"]', 'click', function () {
            jQuery('[name="slider_timer_hover"]').parent().toggle();
			
            sliderManager.hideNextAll();
        } );
		
		
    },
    hideNextAll : function () {
        jQuery('[name="show_caption"]').each(function () {
            if (!(jQuery(this).is(':checked'))) {
                jQuery(this).parent().nextAll('div, :input, span, label').hide();
            }
        } );
        
        jQuery('[name="slide_add_video"]').each(function () {
            if (!(jQuery(this).is(':checked'))) {
                jQuery(this).parent().nextAll('div, :input, span, label').hide();
            }
        } );
        
        jQuery('[name="slide_as_link_add"]').each(function () {
            if (!(jQuery(this).is(':checked'))) {
                jQuery(this).parent().nextAll('div, :input, span, label').hide();
            }
        } );
        
        jQuery('[name="caption_link_enable"]').each(function () {
            if (!(jQuery(this).is(':checked'))) {
                jQuery(this).parent().nextAll().hide();
            }
        } );
        
        jQuery('[name="slides_navigation"]').each(function () {
            if (!(jQuery(this).is(':checked'))) {
				jQuery('[name="slides_navigation_hover"]').parent().hide();
            }
        } );
		
        jQuery('input[name="arrow_navigation"]').each(function () {
            if (!(jQuery(this).is(':checked'))) {
				jQuery('[name="arrow_navigation_hover"]').parent().hide();
            }
        } );
        
        jQuery('[name="slider_timer"]').each(function () {
            if (!(jQuery(this).is(':checked'))) {
				jQuery('[name="slider_timer_hover"]').parent().hide();
            }
        } );
    },
    clearContentBlock : function () {
        jQuery('#slider_manager_tab').empty();
    },
    deleteSlider : function (id) {
        var actionUri = jQuery('#actionUri').val();
		
        jQuery.post(actionUri + '/theme/functions/slider-manager-operator.php', { 
			'action' : 'deleteSlider', 
			'id' : id 
		}, function (data) { }, 'json');
    },
    getSliderSelect : function () {
        var actionUri = jQuery('#actionUri').val();
		
        jQuery.post(actionUri + '/theme/functions/slider-manager-operator.php', { 
			'action' : 'getSliders' 
		}, function (data) { 
			sliderManager.updateSliderSelect(data); 
        }, 'json'); 
    },
    checker : function () {
        var status = '';
		
        jQuery('[name="expandable"]').show();
		
        sliderManager.hideNextAll();
		
        jQuery('input[type="text"]').filter(":visible").each(function () {
            if ( 
				jQuery(this).attr('name') === 'caption_title' || 
				jQuery(this).attr('name') === 'caption_subtitle' || 
				(jQuery(this).attr('name') === 'slide_link_text_value' && jQuery(this).next().next().children('[name="slide_as_link"]').is(':checked') === false) 
			) { 
                return true;
            }
			
            if (jQuery(this).val() === '') {
                status += 'error';
				
                jQuery(this).css( { 
					border : '1px solid #ff0000' 
				} );
            }
        } );
		
		if (status === '') {
            jQuery('[name="expandable"]').hide();
			
			return true;
        } else {
            jQuery('html, body').animate( { 
				scrollTop : 0 
			}, 100);
			
            return false;
        }
    },
    updateSliderSelect : function (data) {
        jQuery('#sliderChoose').empty();
		jQuery('#sliderChoose').append(jQuery('<option />').attr('value', '').text('Select your slider here'));
		
        if (data.length === 0) {
            return false;
        }
		
        for (var i = 0, il = data.length; i < il; i += 1) {
            jQuery('#sliderChoose').append(jQuery('<option />').attr('value', data[i].slider_id).text(data[i].option_value));
        }
    },
    _addSlider : function (action, id) {
        var actionUri = jQuery('#actionUri').val();
		
        this._oSliderFormData['action'] = action;
        this._oSliderFormData['id'] = id;
		
        jQuery.post(actionUri + '/theme/functions/slider-manager-operator.php', this._oSliderFormData, function (data) { 
			if (data.status !== 'success') { 
				alert('Error!!!');
			} 
		}, 'json');
    },
	checkName : function (name) {
		var options = jQuery('#sliderChoose').find('option'), 
			err = false;
		
		jQuery(options).each(function () {
			if (name === this.text) {
				err = true;
				
				return false;
			}
		} );
		
		if (err === true) {
			alert('Slider name already exist');
			
			return false;
		} else {
			return true;
		}
	},
    loadData : function (id) {
        var actionUri = jQuery('#actionUri').val();
		
        jQuery.post(actionUri + '/theme/functions/slider-manager-operator.php', { 
			'action' : 'getSlider', 
			'id' : id 
		}, function (data) {
            sliderManager.setDataContent(data);
        }, 'json');
    },
    prepareData : function () {
        var sliderName = jQuery('#slider_name').val(),
			sliderOtions = jQuery('#slider_options :input'),
			slides = jQuery('#sortable_slides li'),
			odata = {},
			oslide = {},
			c = 0,
			name = '',
			value = '',
            slidename = '',
			slidevalue = '';
        
        for (var i = 0, il = sliderOtions.length; i < il; i += 1) {
            name = sliderOtions[i].name;
			
            if (sliderOtions[i].type === 'checkbox') {
                value = sliderOtions[i].checked;
            } else {
                value = sliderOtions[i].value;
            }
			
            odata[name] = value;
        }
        
        slides.each(function () {
            oslide[c] = jQuery(this).find(':input');
            
            c += 1;
        } );
        
        odata['slides'] = {};
        
        for (var x in oslide) {
            odata['slides']['slide' + x] = {};
			
            for (var z = 0, zl = oslide[x].length; z < zl; z += 1) {
                slidename = oslide[x][z].name;
				
                if (oslide[x][z].type === 'checkbox') {
                    slidevalue = oslide[x][z].checked;
                } else {
                    slidevalue = oslide[x][z].value;
                }
				
                odata['slides']['slide' + x][slidename] = slidevalue; 
            }
        }
		
        this._oSliderFormData.slider = {};
        this._oSliderFormData.slider = odata;
        this._oSliderFormData.slider.slider_name = sliderName;
    },
    sortableInit : function () {
        jQuery('#sortable_slides').sortable( { 
            handle : '[class="sortableImg"]', 
            cursor : 'move' 
        } );
    },
    setDataContent : function (data) {
        sliderManager.appendHeadBlock();
		
        for (var x in data['slider']['slides']) {
            for (var i in this._page.config._oSlideFields) {
                this._page.config._oSlideFields[i].value = data['slider']['slides'][x][i];
            }
			
            for (var i in this._page.config._oResponsiveSlideFields) {
                this._page.config._oResponsiveSlideFields[i].value = data['slider']['slides'][x][i];
            }
			
            sliderManager.appendSlideBlock();
        }
		
        for (var i in this._page.config._oSliderFields) {
            this._page.config._oSliderFields[i].value = data['slider'][i]; 
        }
		
        for (var i in this._page.config._oResponsiveSliderFields) {
            this._page.config._oResponsiveSliderFields[i].value = data['slider'][i]; 
        }
		
        sliderManager.appendSlideNav();
        sliderManager.appendSliderBlock();
        sliderManager.appendNavBlock();
    },
    appendImage : function (id) {
		var actionUri = jQuery('#actionUri').val(), 
			imgdiv = '<div class="img_choose_image"></div>';
		
		if (sliderManager._oSlideImgUrl.url !== '') {
			imgdiv = '<div class="img_choose_image">' + 
				'<img src="' + sliderManager._oSlideImgUrl.url + '" width="100" height="50" alt="" />' + 
			'</div>';
		}
		
        if (!id) {
            jQuery(sliderManager._oSlideInputId).parent().parent().prev().prev().find('[class="img_choose_image"]').replaceWith(imgdiv);
        } else {
            jQuery('#slide_default_' + id).append(imgdiv);
        }
    },
    appendSlideHeadBlock : function (id) {
        var c = sliderManager._counter, 
			slideHeadP = '<input type="button" value="Upload Image" id="slide_upload_button' + id + '" name="slide_upload_button" class="upload" style="height:30px; float:left; margin:18px 20px 0 10px;" />', 
			slideHeadA = '<input type="button" class="delete small_but" name="delete_slide" id="delete_slide' + id + '" style="height:30px; float:right; margin:18px 0 0;" value="" />', 
			sortableImg = '<div class="sortableImg" name="sortableImg" id="sortableImg' + id + '" style="float:right;"></div>';
		
        slideHeadA += '<input type="button" value="Advanced View" class="edit" name="expand_slide_button" id="expand_slide_button' + id + '" style="height:30px; float:right; margin:18px 15px 0 30px;" />' + 
		'<input type="button" value="Hide Details" name="hide_slide_button" id="hide_slide_button' + id + '" class="hide" style="height:30px; display:none; float:right; margin:18px 15px 0 30px;" />';
		
        jQuery('#slide_default_' + id).append(sortableImg);
        jQuery('#slide_default_' + id).prepend(slideHeadP);
        jQuery('#slide_default_' + id).append(slideHeadA);
    },
    appendHeadBlock : function () {
        var sliderBlock = '';
        
        sliderBlock = '<table id="slider_head_block" class="form-table cmsmasters-options">' + 
			'<tbody>' + 
				'<tr>' + 
					'<td>' + 
						'<div class="fr">' + 
							'<p style="font-weight:normal;">Drag and Drop to change fields order</p>' + 
							'<input type="button" id="save_slider_top" style="height:30px; float:right; margin-top:10px;" value="Save Slider" name="save_top" class="save_slider" />' + 
							'<div class="cl"></div>' + 
						'</div>' + 
						'<div class="fl">' + 
							'<h2 class="fb_h2">Slider Name <span style="color:#ff0000;">*</span></h2>' + 
							'<input id="slider_name" type="text" size="50" value="" />' + 
						'</div>' + 
					'</td>' + 
				'</tr>' + 
				'<tr>' + 
					'<td style="padding-top:0;">' + 
						'<input class="fr" id="min_all" value="Minimize All" type="button" style="height:30px; margin:30px 0 0 12px;" />' + 
						'<input class="fr" id="max_all" value="Maximize All" type="button" style="height:30px; margin:30px 0 0 12px;" />' + 
						'<h3 style="padding-bottom:5px;">Add / Remove / Edit Slides</h3>' + 
					'</td>' + 
				'</tr>' + 
			'</tbody>' + 
		'</table>' + 
		'<ul id="sortable_slides" class="ui-sortable slides_block sep_bold"></ul>';
		
        jQuery('#slider_manager_tab').append(sliderBlock);
        jQuery('.clsep').show();
    },
    appendSliderBlock : function () {
        var sliderBlock = '', 
			current = '', 
            slider = '', 
			_oData = jQuery.extend({}, this._page.config._oSliderFields, this._page.config._oResponsiveSliderFields), 
			count = jQuery("#slides_counter").val();
			
        sliderBlock ='<table id="slider_options" class="form-table cmsmasters-options">' + 
			'<tbody>' + 
				'<tr>' + 
					'<td class="sep_bold" colspan="3" style="padding-right:0; padding-left:0;">' + 
						'<h2>General Slider Settings</h2>' + 
					'</td>' + 
				'</tr>' + 
				'<tr>' + 
					'<td id="slider_anim" name="slider_default">' + 
						'<h4>Animation Settings</h4>' + 
					'</td>' + 
					'<td id="slider_contr" name="slider_pause" style="font-weight:normal;">' + 
						'<h4>Controls Settings</h4>' + 
					'</td>' + 
					'<td id="slider_hov" name="slider_canvas" style="font-weight:normal;">' + 
						'<h4>Mouseover Settings</h4>' + 
					'</td>' + 
				'</tr>' + 
			'</tbody>' + 
		'</table>';
		
        jQuery('#slider_manager_tab').append(sliderBlock);
		
        for (var i in _oData) {
            current = _oData[i];
			
            if (i === 'slider_name') {
                jQuery('#slider_name').val(current.value);
				
                continue;
            }
			
            slider = sliderManager.inputHandler(current, i);
			
            jQuery('#' + current.category).append(slider);
			
            if (current.type === 'spinner') { 
                jQuery("#" + i + count).spinner( { 
                    min : ((current.min != '') ? current.min : 0), 
                    max : ((current.max != '') ? current.max : 999), 
                    step : ((current.step != '') ? current.step : 0.1), 
                    allowNull : ((current.null) ? current.null : false) 
                } ); 
            }
        }
    },
    appendSlideBlock : function () {
        var _oData = jQuery.extend({}, this._page.config._oSlideFields, this._page.config._oResponsiveSlideFields), 
			slideBlock = '', 
			current = '', 
			slide = '', 
			count = jQuery("#slides_counter").val();
		
        slideBlock = '<li>' + 
			'<table class="form-table cmsmasters-options">' + 
				'<tbody>' + 
					'<tr>' + 
						'<td id="slide_default_' + count + '" name="slide_default" colspan="3" class="sep sep_bot"></td>' + 
					'</tr>' + 
					'<tr style="background-color:#f1f1f2;">' + 
						'<td id="caption_' + count + '" name="expandable" rowspan="2" style="display:none; padding-left:25px;">' + 
							'<h4>Caption Settings</h4>' + 
						'</td>' + 
						'<td id="video_' + count + '" name="expandable" rowspan="2" style="display:none; padding-left:25px;">' + 
							'<h4>Video Settings</h4>' + 
						'</td>' + 
						'<td id="slideaslink_' + count + '" name="expandable" rowspan="2" style="display:none; padding-left:25px;">' + 
							'<h4>Slide Image Settings</h4>' + 
						'</td>' + 
					'</tr>' + 
					'<tr style="background-color:#f1f1f2;" class="sep">' + 
						'<td id="general_' + count + '" style="padding:30px 15px 0; display:none;">' + 
							'<h4>General Settings</h4>' + 
						'</td>' + 
					'</tr>' + 
				'</tbody>' + 
			'</table>' + 
		'</li>';
		
        jQuery('#sortable_slides').append(slideBlock);
		
        for (var i in _oData) {
            current = _oData[i];
			
            if (i === 'slide_link') {
                sliderManager._oSlideImgUrl.url = current.value;
                sliderManager.appendImage(count);
            } else if (i === 'slide_title') {
                jQuery('#slide_default_' + count).append('<h4 id="slide_title_show' + count + '" class="slide_title_show" style="float:left; width:200; padding:0; margin:24px 20px 0;">' + current.value + '</h4>' + '<input id="slide_title_inp' + count + '" name="slide_title_inp" class="slide_title_inp" type="text" value="' + current.value + '" size="36" style="margin:18px 20px 0; float:left; display:none;" />');
            }
			
            slide = sliderManager.inputHandler(current, i);
			
            if (current.position && current.position === 'fl1') {
                jQuery('#' + current.category + '_' + count + ' .fl1').append(slide);
            } else if (current.position && current.position === 'fl2') {
                jQuery('#' + current.category + '_' + count + ' .fl2').append(slide);
            } else {
                jQuery('#' + current.category + '_' + count).append(slide);
            }
			
            if (current.type === 'spinner') { 
                jQuery('#' + i + count).spinner( { 
                    min : ((current.min != '') ? current.min : 0), 
                    max : ((current.max != '') ? current.max : 999), 
                    step : ((current.step != '') ? current.step : 0.1), 
                    allowNull : ((current.null) ? current.null : false) 
                } ); 
            }
        }
		
        sliderManager.appendSlideHeadBlock(count);
		
        jQuery('#slides_counter').val(parseInt(count) + 1);
    },
    appendSlideNav : function () {
        var navBlock = '';
		
        navBlock = '<table class="form-table cmsmasters-options">' + 
			'<tbody>' + 
				'<tr>' + 
					'<td>' + 
						'<input class="add" name="add_field" id="add_new_slide" value="Add New Slide" style="height:30px; float:right; margin-left:12px;" type="button" />' + 
					'</td>' + 
				'</tr>' + 
			'</tbody>' + 
		'</table>';
		
        jQuery('#slider_manager_tab').append(navBlock);
    },
    appendNavBlock : function () {
		var actionUri = jQuery('#actionUri').val(),
			navBlock = '';
		
        navBlock = '<table class="form-table cmsmasters-options">' + 
			'<tbody>' + 
				'<tr>' + 
					'<td>' + 
						'<div style="padding-top:20px;" class="cl">' + 
							'<input type="button" id="save_slider" style="height:30px; float:left; margin-left:0;" value="Save Slider" name="save" class="save_slider" />' + 
							'<div style="margin:7px 0 0 10px;" class="fl">' + 
								'<img alt="Loading" src="' + actionUri + '/theme/administrator/images/wpspin_light.gif" style="display:none;" class="submit_loader" />' + 
							'</div>' + 
						'</div>' + 
					'</td>' + 
				'</tr>' + 
			'</tbody>' + 
		'</table>';
		
        jQuery('#slider_manager_tab').append(navBlock);
    },
    inputHandler : function (data, id) {
        var c = jQuery('#slides_counter').val(), 
			type = data.type, 
			input = '', 
			current = '';
		
        switch (type) {
		case 'text':
			input = '<span class="label">' + data.title + '</span>' + 
			'<div class="cl"></div>' + 
			'<input id="' + id + c + '" name="' + id + '" type="text" value="' + data.value + '" size="50" style="margin:14px 0;" />' + 
			'<div class="cl"></div>' + 
			'<br />';
			
			break;
		case 'select':
			input = '<span class="label">' + data.title + '</span>' + 
			'<div class="cl"></div>' + 
			'<select name="' + id + '" id="' + id + c + '" style="width:300px; margin:14px 0;">';
			
			for (var i in data.select) {
				if (data.value !== '' && i === data.value) {
					input += '<option value="' + i + '" selected="selected">' + data.select[i] + '</option>';
				} else {
					input += '<option value="' + i + '">' + data.select[i] + '</option>';
				}
			}
			
			input += '</select>' + 
			'<div class="cl"></div>' + 
			'<br />';
			
			break;
		case 'checkbox':
			var checked = '';
			
			if (data.value === 'true') {
				checked = ' checked="checked"';
			}
			
			input = '<div class="check_parent">' + 
				'<input name="' + id + '" id="' + id + c + '"' + checked + ' type="checkbox" />' + 
				'<label for="' + id + c + '" style="margin:14px 0;">' + 
					'<span class="labelon">' + data.title + '</span>' + 
				'</label>' + 
			'</div>';
			
			break;
		case 'spinner':
			input = '<span class="label" style="margin: 0 0 10px 0;">' + data.title + '</span>' + 
			'<div class="cl"></div>' + 
			'<span class="spinner-wrpr" style="margin: 0 0 20px 0;">' + 
				'<input type="text" value="' + data.value + '" id="' + id + c +  '" name="' + id + '" size="5" maxlength="5" style="margin-right:30px; margin-left:30px; text-align:center; float:none; margin-top:0px;" />' + 
			'</span>';
			
			break;
		case 'hidden':
			input = '<input type="hidden" value="' + data.value + '" name="' + id + '" id="' + id + c + '" />';
			
			break;
		case 'textarea':
			input = '<div class="cl"></div>' + 
			'<span class="label">' + data.title + '</span>' + 
			'<div class="cl"></div>' + 
			'<textarea id="' + id + c + '" name="' + id + '" type="text" style="margin:14px 0; width:300px; min-width:300px; height:100px; min-height:100px; resize:vertical;">' + data.value + '</textarea>' + 
			'<br />';
			
			break;
        }
        
        return input;
    }
};

jQuery(function () { 
    sliderManager.init(); 
} );

