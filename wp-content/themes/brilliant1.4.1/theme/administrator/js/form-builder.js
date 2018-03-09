/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 */

/**
 * Form Builder v1.2.1 - jQuery Form Builder
 * 
 * (c) Copyright Steven "cmsmasters" Masters
 * http://cmsmastrs.net/
 * For sale on ThemeForest.net
 */


jQuery(document).ready(function () {
    var insaving = false, 
		loaderImageUrl = jQuery('input[name="loader_image_url"]').val();
    
    
    // Save/Update Form Function
    function saveAction(saveOption, formName) {
        jQuery('input[name="form_name"], input[name="field_label"], input[name="opt_label"], textarea[name="composer_message"], textarea[name="composer_subject"], textarea[name="composer_success"]').removeAttr('style');
	
        if (saveOption === 'add') {
            var form_try_label = '', 
				offsetTop = 0;
            
            if (jQuery('input[name="form_name"]').val() === '' || jQuery('input[name="form_name"]').val() === ' ') {
                form_try_label = (formName) ? formName : '';
                
                alert('Enter Form Name!');
		
                jQuery('input[name="form_name"]').css( {
                    border : '1px solid #ff0000'
                } );
                
                offsetTop = jQuery('input[name="form_name"]').offset().top - 50;
                
                jQuery('html, body').animate( {
                    scrollTop : offsetTop
                }, 'slow');
                jQuery('input[name="form_name"]').focus();
                jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
		
                insaving = false;
                
                return false;
            } else {
                form_try_label = jQuery('input[name="form_name"]').val();
            }
            
            if (jQuery('textarea[name="composer_message"]').val() === '' || jQuery('textarea[name="composer_message"]').val() === ' ') {
                alert('Enter your message text!');
		
                jQuery('textarea[name="composer_message"]').css( {
                    border : '1px solid #ff0000'
                } );
                
                offsetTop = jQuery('textarea[name="composer_message"]').offset().top - 50;
                
                jQuery('html, body').animate( {
                    scrollTop : offsetTop
                }, 'slow');
                jQuery('textarea[name="composer_message"]').focus();
                jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
		
                insaving = false;
                
                return false;
            }
            
            if (jQuery('textarea[name="composer_subject"]').val() === '' || jQuery('textarea[name="composer_subject"]').val() === ' ') {
                alert('Enter your message subject text!');
		
                jQuery('textarea[name="composer_subject"]').css( {
                    border : '1px solid #ff0000'
                } );
                
                offsetTop = jQuery('textarea[name="composer_subject"]').offset().top - 50;
                
                jQuery('html, body').animate( {
                    scrollTop : offsetTop
                }, 'slow');
                jQuery('textarea[name="composer_subject"]').focus();
                jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
		
                insaving = false;
                
                return false;
            }
            
            if (jQuery('textarea[name="composer_success"]').val() === '' || jQuery('textarea[name="composer_success"]').val() === ' ') {
                alert('Enter your message successful sending text!');
		
                jQuery('textarea[name="composer_success"]').css( {
                    border : '1px solid #ff0000'
                } );
                
                offsetTop = jQuery('textarea[name="composer_success"]').offset().top - 50;
                
                jQuery('html, body').animate( {
                    scrollTop : offsetTop
                }, 'slow');
                jQuery('textarea[name="composer_success"]').focus();
                jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
		
                insaving = false;
                
                return false;
            }
            
            var save_field_label = jQuery('input[name="field_label"]');
            
            for (var i = 0, ilength = save_field_label.length; i < ilength; i += 1) {
                if (save_field_label.eq(i).val() === '' || save_field_label.eq(i).val() === ' ') {
                    alert('Please fill all field labels!');
                    
                    save_field_label.eq(i).css( {
                        border : '1px solid #ff0000'
                    } );
                    
                    offsetTop = save_field_label.eq(i).offset().top - 50;
                    
                    jQuery('html, body').animate( {
                        scrollTop : offsetTop
                    }, 'slow');
                    save_field_label.eq(i).focus();
                    jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                    
                    insaving = false;
                    
                    return false;
                }
            }
            
            var save_opt_label = jQuery('input[name="opt_label"]');
            
            for (var j = 0, jlength = save_opt_label.length; j < jlength; j += 1) {
                if (save_opt_label.eq(j).val() === '' || save_opt_label.eq(j).val() === ' ') {
                    alert('Please fill all field options!');
                    
                    save_opt_label.eq(j).css( {
                        border : '1px solid #ff0000'
                    } );

                    offsetTop = save_opt_label.eq(j).offset().top - 50;

                    jQuery('html, body').animate( {
                        scrollTop : offsetTop
                    }, 'slow');
                    save_opt_label.eq(j).focus();
                    jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                    
                    insaving = false;
                    
                    return false;
                }
            }
            
            function addForm(tryVal) {
                var form_label = tryVal, 
					form_name = form_label.toLowerCase().replace(/ /g, '_').replace(/[^a-zA-Z0-9_]/g, '');
		
                if (form_name == '' || form_name == '_'){
                    form_name = 'form_' + Math.random() * 1000000000000000000;
                } else {
                    form_name = form_name + '_' + Math.random() * 1000000000000000000;
                }
		
                jQuery.post(loaderImageUrl + '/theme/functions/form-builder-operator.php', {
                    type : 'form', 
                    option : 'try', 
                    data : form_name
                }).error(function () {
                    jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                    
                    alert('Error on page! Please reload page and try again.');
                    
                    return false;
                }).complete(function (data) {
                    if (data.responseText === form_name) {
                        var newName = prompt('Form with this name already exists, try another name.');
						
                        if (newName && newName !== '' && newName !== ' ') {
                            addForm(newName);
                        } else {
                            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                        }
			
                        insaving = false;
                        
                        return false;
                    } else {
                        var form_value = jQuery('textarea[name="composer_message"]').val(), 
							form_descr = [
								jQuery('textarea[name="composer_subject"]').val(), 
								jQuery('textarea[name="composer_success"]').val()
							], 
							form_params = [];
			
                        if (jQuery('input[name="composer_use_captcha"]').is(':checked')) { 
                            form_params[0] = jQuery('input[name="composer_use_captcha"]:checked').val();
                        }
			
                        if (jQuery('input[name="composer_reset_button"]').is(':checked')) { 
                            form_params[1] = jQuery('input[name="composer_reset_button"]:checked').val();
                        }
			
                        var savedForm = { 
                            number : "0", 
                            slug : form_name, 
                            parent_slug : form_name, 
                            type : "form", 
                            label : form_label, 
                            value : form_value, 
                            description : form_descr, 
                            parameters : form_params 
                        }, 
							savedFields = [];
                        
                        savedFields[0] = savedForm;
			
                        for (var i = 0, ilength = jQuery('#fields-list li').length; i < ilength; i += 1) {
                            var field_number = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_order"]').val(), 
								field_type = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_type"]').val(), 
								field_label = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_label"]').val(), 
								field_name = 'field_' + Math.random() * 1000000000000000000, 
								field_descr = jQuery('#fields-list li:eq(' + i + ')').find('textarea[name="field_descr"]').val(), 
								min = jQuery('#fields-list li:eq(' + i + ')').find('input[name="min_size"]').val(), 
								max = jQuery('#fields-list li:eq(' + i + ')').find('input[name="max_size"]').val(), 
								verify = jQuery('#fields-list li:eq(' + i + ')').find('select[name="field_verify"]').val(), 
								field_value = [], 
								field_params = [];
                            
                            if (jQuery('#fields-list li:eq(' + i + ')').find('.opt_cont').is('div')) {
                                for (var j = 0, jlength = jQuery('#fields-list li:eq(' + i + ') .opt_cont .opt_item').length; j < jlength; j += 1) {
                                    field_value[j] = jQuery('#fields-list li:eq(' + i + ') .opt_cont .opt_item:eq(' + j + ')').find('input[name="opt_label"]').val();
                                }
                            }
                            
                            if (jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_required"]').is(':checked')) { 
                                field_params[0] = jQuery('input[name="field_required"]:checked').val();
                            }
                            
                            if (min !== '' && min !== '0' && min !== undefined) { 
                                field_params[1] = 'minSize[' + min + ']';
                            }
                            
                            if (max !== '' && max !== '0' && max !== undefined) { 
                                field_params[2] = 'maxSize[' + max + ']';
                            }
                            
                            if (verify !== '' && verify !== undefined) { 
                                field_params[3] = verify;
                            }
                            
                            var savedField = {
                                number : field_number, 
                                slug : field_name, 
                                parent_slug : form_name, 
                                type : field_type, 
                                label : field_label, 
                                value : field_value, 
                                description : field_descr, 
                                parameters : field_params
                            }
                            
                            savedFields[i + 1] = savedField;
                        }
			
                        jQuery.post(loaderImageUrl + '/theme/functions/form-builder-operator.php', {
                            type : 'fields', 
                            option : 'add', 
                            data : JSON.stringify(savedFields)
                        } ).error(function () {
                            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                            
                            alert('Error on page! Please reload page and try again.');
                            
                            insaving = false;
                            
                            return false;
                        } ).complete(function (data) {
                            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('slow');
                            
                            if (data.responseText === 'error') {
                                alert('Form saving error was detected! Please try again.');
				
                                insaving = false;
                                
                                return false;
                            } else {
                                jQuery('select#form_choose').append('<option value="' + form_name + '">' + form_label + '</option>');
				
                                jQuery('html, body').animate( {
                                    scrollTop : 0
                                }, 'slow');
                                jQuery('#settings_save').slideDown('fast').delay(5000).slideUp('slow');
				
                                insaving = false;
				
                                jQuery('.rght .tabb input[name="cancel_form"]').hide();
                                jQuery('.rght .tabb input[name="save_as_form"]').hide();
                                jQuery('.rght .tabb input[name="add_form"]').show();
                                jQuery('#form_build_tab').empty();
                                jQuery('.slider .rght .tabb.bot').parent().slideUp('fast');
                            }
                        } );
                    }
                } );
            }
            
            addForm(form_try_label);
        } else if (saveOption === 'update') {
            jQuery('input[name="form_name"], input[name="field_label"], input[name="opt_label"], textarea[name="composer_message"], textarea[name="composer_subject"], textarea[name="composer_success"]').removeAttr('style');
            
            var form_try_name = jQuery('input[name="form_name"]').attr('id'), 
				posTop = 0;
            
            if (form_try_name === '' || form_try_name === ' ') {
                alert('Error on page! Please reload page and try again.');
		
                insaving = false;
                
                return false;
            }
            
            if (jQuery('input[name="form_name"]').val() === '' || jQuery('input[name="form_name"]').val() === ' ') {
                alert('Enter Form Name!');
		
                jQuery('input[name="form_name"]').css( {
                    border : '1px solid #ff0000'
                } );
                
                offsetTop = jQuery('input[name="form_name"]').offset().top - 50;
                
                jQuery('html, body').animate( {
                    scrollTop : offsetTop
                }, 'slow');
                jQuery('input[name="form_name"]').focus();
                jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
		
                insaving = false;
                
                return false;
            }
            
            if (jQuery('textarea[name="composer_message"]').val() === '' || jQuery('textarea[name="composer_message"]').val() === ' ') {
                alert('Enter your message text!');
		
                jQuery('textarea[name="composer_message"]').css( {
                    border : '1px solid #ff0000'
                } );
                
                posTop = jQuery('textarea[name="composer_message"]').offset().top - 50;
                
                jQuery('html, body').animate( {
                    scrollTop : posTop
                }, 'slow');
                jQuery('textarea[name="composer_message"]').focus();
                jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
		
                insaving = false;
                
                return false;
            }
            
            if (jQuery('textarea[name="composer_subject"]').val() === '' || jQuery('textarea[name="composer_subject"]').val() === ' ') {
                alert('Enter your message subject text!');
		
                jQuery('textarea[name="composer_subject"]').css( {
                    border : '1px solid #ff0000'
                } );
                
                posTop = jQuery('textarea[name="composer_subject"]').offset().top - 50;
                
                jQuery('html, body').animate( {
                    scrollTop : posTop
                }, 'slow');
                jQuery('textarea[name="composer_subject"]').focus();
                jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
		
                insaving = false;
                
                return false;
            }
            
            if (jQuery('textarea[name="composer_success"]').val() === '' || jQuery('textarea[name="composer_success"]').val() === ' ') {
                alert('Enter your message successful sending text!');
		
                jQuery('textarea[name="composer_success"]').css( {
                    border : '1px solid #ff0000'
                } );
                
                posTop = jQuery('textarea[name="composer_success"]').offset().top - 50;
                
                jQuery('html, body').animate( {
                    scrollTop : posTop
                }, 'slow');
                jQuery('textarea[name="composer_success"]').focus();
                jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
		
                insaving = false;
                
                return false;
            }
            
            var field_label = jQuery('input[name="field_label"]');
            
            for (var k = 0, klength = field_label.length; k < klength; k += 1) {
                if (field_label.eq(k).val() === '' || field_label.eq(k).val() === ' ') {
                    alert('Please fill all field labels!');
                    
                    field_label.eq(k).css( {
                        border : '1px solid #ff0000'
                    } );
                    
                    posTop = field_label.eq(k).offset().top - 50;
                    
                    jQuery('html, body').animate( {
                        scrollTop : posTop
                    }, 'slow');
                    field_label.eq(k).focus();
                    jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                    
                    insaving = false;
                    
                    return false;
                }
            }
            
            var opt_label = jQuery('input[name="opt_label"]');
            
            for (var l = 0, llength = opt_label.length; l < llength; l += 1) {
                if (opt_label.eq(l).val() === '' || opt_label.eq(l).val() === ' ') {
                    alert('Please fill all field options!');
                    
                    opt_label.eq(l).css( {
                        border : '1px solid #ff0000'
                    } );
                    
                    posTop = opt_label.eq(l).offset().top - 50;
                    
                    jQuery('html, body').animate( {
                        scrollTop : posTop
                    }, 'slow');
                    opt_label.eq(l).focus();
                    jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                    
                    insaving = false;
                    
                    return false;
                }
            }
            
            function updateForm(tryVal) {
                var form_label = jQuery('input[name="form_name"]').val(), 
					form_name = tryVal;
		
                jQuery.post(loaderImageUrl + '/theme/functions/form-builder-operator.php', {
                    type : 'form', 
                    option : 'try', 
                    data : form_name
                } ).error(function () {
                    jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                    
                    alert('Error on page! Please reload page and try again.');
					
                    insaving = false;
                    return false;
                } ).complete(function (data) {
                    if (data.responseText !== form_name) {
                        var ask = confirm('It is no form with this name in your database. Save this form as "' + form_label + '"?');
			
                        if (ask && form_label !== '' && form_label !== ' ') {
                            jQuery('input[name="form_option"]').val('add');
                            
                            saveAction('add');
                        } else {
                            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                            
                            insaving = false;
                        }
			
                        return false;
                    } else {
                        var form_id = jQuery('input[name="form_id"]').val(), 
							form_value = jQuery('textarea[name="composer_message"]').val(), 
							form_descr = [
								jQuery('textarea[name="composer_subject"]').val(), 
								jQuery('textarea[name="composer_success"]').val()
							], 
							form_params = [];
			
                        if (jQuery('input[name="composer_use_captcha"]').is(':checked')) { 
                            form_params[0] = jQuery('input[name="composer_use_captcha"]:checked').val();
                        }
			
                        if (jQuery('input[name="composer_reset_button"]').is(':checked')) { 
                            form_params[1] = jQuery('input[name="composer_reset_button"]:checked').val();
                        }
                        
                        var savedForm = { 
                            id : form_id, 
                            number : "0", 
                            slug : form_name, 
                            parent_slug : form_name, 
                            type : "form", 
                            label : form_label, 
                            value : form_value, 
                            description : form_descr, 
                            parameters : form_params
                        }, 
							savedFields = [];
                        
                        savedFields[0] = savedForm;
						
                        for (var i = 0, ilength = jQuery('#fields-list li').length; i < ilength; i += 1) {
                            var field_id = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_id"]').val(), 
								field_number = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_order"]').val(), 
								field_type = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_type"]').val(), 
								field_label = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_label"]').val(), 
								field_name = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_label"]').attr('id'), 
								field_descr = jQuery('#fields-list li:eq(' + i + ')').find('textarea[name="field_descr"]').val(), 
								min = jQuery('#fields-list li:eq(' + i + ')').find('input[name="min_size"]').val(), 
								max = jQuery('#fields-list li:eq(' + i + ')').find('input[name="max_size"]').val(), 
								verify = jQuery('#fields-list li:eq(' + i + ')').find('select[name="field_verify"]').val(), 
								field_value = [], 
								field_params = [];
                            
                            if (field_name === '' || field_name === '_') { 
                                field_name = 'field_' + Math.random() * 1000000000000000000;
                            }
                            
                            if (jQuery('#fields-list li:eq(' + i + ')').find('.opt_cont').is('div')) {
                                for (var j = 0, jlength = jQuery('#fields-list li:eq(' + i + ') .opt_cont .opt_item').length; j < jlength; j += 1) {
                                    field_value[j] = jQuery('#fields-list li:eq(' + i + ') .opt_cont .opt_item:eq(' + j + ')').find('input[name="opt_label"]').val();
                                }
                            }
                            
                            if (jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_required"]').is(':checked')) { 
                                field_params[0] = jQuery('input[name="field_required"]:checked').val();
                            }
                            
                            if (min !== '' && min !== '0' && min !== undefined) { 
                                field_params[1] = 'minSize[' + min + ']';
                            }
                            
                            if (max !== '' && max !== '0' && max !== undefined) { 
                                field_params[2] = 'maxSize[' + max + ']';
                            }
                            
                            if (verify !== '' && verify !== undefined) { 
                                field_params[3] = verify;
                            }
                            
                            var savedField = {
                                id : field_id, 
                                number : field_number, 
                                slug : field_name, 
                                parent_slug : form_name, 
                                type : field_type, 
                                label : field_label, 
                                value : field_value, 
                                description : field_descr, 
                                parameters : field_params
                            }
                            
                            savedFields[i + 1] = savedField;
                        }
                        
                        jQuery.post(loaderImageUrl + '/theme/functions/form-builder-operator.php', {
                            type : 'fields', 
                            option : 'update', 
                            data : JSON.stringify(savedFields)
                        } ).error(function () {
                            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                            
                            alert('Error on page! Please reload page and try again.');
                            
                            insaving = false;
                            
                            return false;
                        } ).complete(function (data) {
                            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('slow');
                            
                            if (data.responseText === 'error') {
                                alert('Form saving error was detected! Please try again.');
								
                                insaving = false;
                                
                                return false;
                            } else {
                                jQuery('select#form_choose').find('option[value="' + form_name + '"]').text(form_label);
				
                                jQuery('html, body').animate( {
                                    scrollTop : 0
                                }, 'slow');
                                jQuery('#settings_save').slideDown('fast').delay(5000).slideUp('slow');
								
                                insaving = false;
								
                                jQuery('.rght .tabb input[name="cancel_form"]').hide();
                                jQuery('.rght .tabb input[name="save_as_form"]').hide();
                                jQuery('.rght .tabb input[name="add_form"]').show();
                                jQuery('#form_build_tab').empty();
                                jQuery('.slider .rght .tabb.bot').parent().slideUp('fast');
                            }
                        } );
                    }
                } );
            }
            
            updateForm(form_try_name);
        }
    }
    
    
    // Choose Field Type
    function fieldChoose(type, parameters) {
        var field_html = '', 
			id = (parameters) ? parameters.id : '', 
			number = (parameters) ? parameters.number : jQuery('#fields-list li').length + 1, 
			name = (parameters) ? parameters.slug : '', 
			par_sl = (parameters) ? parameters.parent_slug : jQuery('input[name="form_name"]').attr('id'), 
			ps_n = (parameters) ? par_sl + '_' + number : par_sl + '_' + Math.random() * 1000000000000000000, 
			label = (parameters) ? parameters.label : '', 
			value = (parameters) ? parameters.value : '', 
			descr = (parameters && parameters.description !== false) ? parameters.description : '', 
			params = (parameters && parameters.parameters !== false) ? parameters.parameters : '', 
			minSize = '', 
			maxSize = '', 
			required = '', 
			customEmail = '', 
			customUrl = '', 
			customNumber = '', 
			customOnlyNumberSp = '', 
			customOnlyLetterSp = '';
        
        if (parameters) {
            required = (jQuery.inArray('required', params) !== -1) ? ' checked="checked"' : '';
            customEmail = (jQuery.inArray('custom[email]', params) !== -1) ? ' selected="selected"' : '';
            customUrl = (jQuery.inArray('custom[url]', params) !== -1) ? ' selected="selected"' : '';
            customNumber = (jQuery.inArray('custom[number]', params) !== -1) ? ' selected="selected"' : '';
            customOnlyNumberSp = (jQuery.inArray('custom[onlyNumberSp]', params) !== -1) ? ' selected="selected"' : '';
            customOnlyLetterSp = (jQuery.inArray('custom[onlyLetterSp]', params) !== -1) ? ' selected="selected"' : '';
            
            for (var n = 0, nlength = params.length; n < nlength; n += 1) {
                if (params[n] !== null && jQuery.inArray('minSize', params[n].split('[')) !== -1) {
                    minSize = params[n].replace(']', '').replace('minSize[', '');
                }
            }
            
            for (var x = 0, xlength = params.length; x < xlength; x += 1) {
                if (params[x] !== null && jQuery.inArray('maxSize', params[x].split('[')) !== -1) {
                    maxSize = params[x].replace(']', '').replace('maxSize[', '');
                }
            }
        }
	
        switch (type) {
        case 'text' :
            field_html += '<li>' +
                '<table class="form-table cmsmasters-options">' +
                    '<tr>' +
                        '<td class="sep">' +
                            '<input class="delete small_but" type="button" name="delete_field" value="" style="height:30px; float:right; margin-left:0;" />' +
                            '<input type="hidden" name="field_id" value="' + id + '" />' +
                            '<input type="hidden" name="field_order" value="' + number + '" />' +
                            '<input type="hidden" name="field_type" value="text" />' +
                            '<div class="fl_field">' +
                                '<span class="label">Text Field Label <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Text Field Label" href="?lightbox[width]=350&amp;lightbox[height]=150#field_label_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_label_' + ps_n + '_light">Enter your field label here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<input size="36" name="field_label" type="text" value="' + label + '" id="' + name + '" />' +
                                '<div class="cl"><br /></div>' +
                                '<div class="check_parent">' +
                                    '<input type="checkbox" name="field_required" id="field_required_' + ps_n + '" value="required"' + required + ' />' +
                                    '<label for="field_required_' + ps_n + '"><span class="labelon">Required</span></label>' +
                                '</div>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Text Field Description</span>' +
                                '<a class="helpbox" title="Text Field Description" href="?lightbox[width]=350&amp;lightbox[height]=150#field_descr_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_descr_' + ps_n + '_light">Enter your field description here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<textarea name="field_descr" cols="36" rows="5">' + descr + '</textarea>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Text Field Options</span>' +
                                '<a class="helpbox" title="Text Field Options" href="?lightbox[width]=350&amp;lightbox[height]=150#field_opts_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_opts_' + ps_n + '_light">Choose your field options here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<div class="td_spinner">' +
                                    '<div class="fl">' +
                                        '<input size="3" name="min_size" id="min_size_' + ps_n + '" type="text" value="' + minSize + '" />' +
                                    '</div>' +
                                    '<label style="float:left; padding:7px 0 0 7px;">&nbsp; Min text size</label>' +
                                '</div>' +
                                '<div class="cl"><br /></div>' +
                                '<div class="td_spinner">' +
                                    '<div class="fl">' +
                                        '<input size="3" name="max_size" id="max_size_' + ps_n + '" type="text" value="' + maxSize + '" />' +
                                    '</div>' +
                                    '<label style="float:left; padding:7px 0 0 7px;">&nbsp; Max text size</label>' +
                                '</div>' +
                            '</div>' +
                            '<div class="fl_field" style="padding-top:37px;">' +
                                '<select style="width:180px;" name="field_verify" id="field_verify_' + ps_n + '">' +
                                    '<option value="">Choose verification</option>' +
                                    '<option value="custom[email]"' + customEmail + '>Email</option>' +
                                    '<option value="custom[url]"' + customUrl + '>URL</option>' +
                                    '<option value="custom[number]"' + customNumber + '>Number</option>' +
                                    '<option value="custom[onlyNumberSp]"' + customOnlyNumberSp + '>Only Numbers &amp; Spaces</option>' +
                                    '<option value="custom[onlyLetterSp]"' + customOnlyLetterSp + '>Only Letters &amp; Spaces</option>' +
                                '</select>' +
                            '</div>' +
                        '</td>' +
                    '</tr>' +
                '</table>' +
            '</li>';
            break;
        case 'email' :
            field_html += '<li>' +
                '<table class="form-table cmsmasters-options">' +
                    '<tr>' +
                        '<td class="sep">' +
                            '<input class="delete small_but" type="button" name="delete_field" value="" style="height:30px; float:right; margin-left:0;" />' +
                            '<input type="hidden" name="field_id" value="' + id + '" />' +
                            '<input type="hidden" name="field_order" value="' + number + '" />' +
                            '<input type="hidden" name="field_type" value="email" />' +
                            '<div class="fl_field">' +
                                '<span class="label">Email Field Label <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Email Field Label" href="?lightbox[width]=350&amp;lightbox[height]=150#field_label_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_label_' + ps_n + '_light">Enter your field label here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<input size="36" name="field_label" type="text" value="' + label + '" id="' + name + '" />' +
                                '<div class="cl"><br /></div>' +
                                '<div class="check_parent">' +
                                    '<input type="checkbox" name="field_required" id="field_required_' + ps_n + '" value="required"' + required + ' />' +
                                    '<label for="field_required_' + ps_n + '"><span class="labelon">Required</span></label>' +
                                '</div>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Email Field Description</span>' +
                                '<a class="helpbox" title="Email Field Description" href="?lightbox[width]=350&amp;lightbox[height]=150#field_descr_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_descr_' + ps_n + '_light">Enter your field description here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<textarea name="field_descr" cols="36" rows="5">' + descr + '</textarea>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Email Field Options</span>' +
                                '<a class="helpbox" title="Email Field Options" href="?lightbox[width]=350&amp;lightbox[height]=150#field_opts_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_opts_' + ps_n + '_light">Choose your email field verification here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<select style="width:180px;" name="field_verify" id="field_verify_' + ps_n + '">' +
                                    '<option value="">Choose verification</option>' +
                                    '<option value="custom[email]"' + customEmail + '>Email</option>' +
                                '</select>' +
                            '</div>' +
                        '</td>' +
                    '</tr>' +
                '</table>' +
            '</li>';
            break;
        case 'textarea' :
            field_html += '<li>' +
                '<table class="form-table cmsmasters-options">' +
                    '<tr>' +
                        '<td class="sep">' +
                            '<input class="delete small_but" type="button" name="delete_field" value="" style="height:30px; float:right; margin-left:0;" />' +
                            '<input type="hidden" name="field_id" value="' + id + '" />' +
                            '<input type="hidden" name="field_order" value="' + number + '" />' +
                            '<input type="hidden" name="field_type" value="textarea" />' +
                            '<div class="fl_field">' +
                                '<span class="label">Text Area Field Label <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Text Area Field Label" href="?lightbox[width]=350&amp;lightbox[height]=150#field_label_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_label_' + ps_n + '_light">Enter your field label here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<input size="36" name="field_label" type="text" value="' + label + '" id="' + name + '" />' +
                                '<div class="cl"><br /></div>' +
                                '<div class="check_parent">' +
                                    '<input type="checkbox" name="field_required" id="field_required_' + ps_n + '" value="required"' + required + ' />' +
                                    '<label for="field_required_' + ps_n + '"><span class="labelon">Required</span></label>' +
                                '</div>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Text Area Field Description</span>' +
                                '<a class="helpbox" title="Text Area Field Description" href="?lightbox[width]=350&amp;lightbox[height]=150#field_descr_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_descr_' + ps_n + '_light">Enter your field description here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<textarea name="field_descr" cols="36" rows="5">'+descr+'</textarea>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Text Area Field Options</span>' +
                                '<a class="helpbox" title="Text Area Field Options" href="?lightbox[width]=350&amp;lightbox[height]=150#field_opts_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_opts_' + ps_n + '_light">Choose your field options here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<div class="td_spinner">' +
                                    '<div class="fl">' +
                                        '<input size="3" name="min_size" id="min_size_' + ps_n + '" type="text" value="' + minSize + '" />' +
                                    '</div>' +
                                    '<label style="float:left; padding:7px 0 0 7px;">&nbsp; Min text size</label>' +
                                '</div>' +
                                '<div class="cl"><br /></div>' +
                                '<div class="td_spinner">' +
                                    '<div class="fl">' +
                                        '<input size="3" name="max_size" id="max_size_' + ps_n + '" type="text" value="' + maxSize + '" />' +
                                    '</div>' +
                                    '<label style="float:left; padding:7px 0 0 7px;">&nbsp; Max text size</label>' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                    '</tr>' +
                '</table>' +
            '</li>';
            break;
        case 'dropdown' :
            field_html += '<li>' +
                '<table class="form-table cmsmasters-options">' +
                    '<tr>' +
                        '<td class="sep">' +
                            '<input class="delete small_but" type="button" name="delete_field" value="" style="height:30px; float:right; margin-left:0;" />' +
                            '<input type="hidden" name="field_id" value="' + id + '" />' +
                            '<input type="hidden" name="field_order" value="' + number + '" />' +
                            '<input type="hidden" name="field_type" value="dropdown" />' +
                            '<div class="fl_field">' +
                                '<span class="label">Dropdown Field Label <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Dropdown Field Label" href="?lightbox[width]=350&amp;lightbox[height]=150#field_label_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_label_' + ps_n + '_light">Enter your field label here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<input size="36" name="field_label" type="text" value="' + label + '" id="' + name + '" />' +
                                '<div class="cl"><br /></div>' +
                                '<div class="check_parent">' +
                                    '<input type="checkbox" name="field_required" id="field_required_' + ps_n + '" value="required"' + required + ' />' +
                                    '<label for="field_required_' + ps_n + '"><span class="labelon">Required</span></label>' +
                                '</div>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Dropdown Field Description</span>' +
                                '<a class="helpbox" title="Dropdown Field Description" href="?lightbox[width]=350&amp;lightbox[height]=150#field_descr_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_descr_' + ps_n + '_light">Enter your field description here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<textarea name="field_descr" cols="36" rows="5">' + descr + '</textarea>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Dropdown Items <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Dropdown Items" href="?lightbox[width]=350&amp;lightbox[height]=150#field_opts_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_opts_' + ps_n + '_light">Add/Remove your dropdown items here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<div class="opt_cont">';

                                if (value.length > 1) {
                                    for (var v = 0, vlength = value.length; v < vlength; v += 1) {
                                    field_html += '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="' + value[v] + '" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>';
                                    }
                                } else {
                                    field_html += '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>' +
                                    '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>';
                                }

                                field_html += '<input class="add small_but" type="button" name="add_opt" value="" style="height:30px; float:right; margin-left:12px;" />' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                    '</tr>' +
                '</table>' +
            '</li>';
            break;
        case 'radiobutton' :
            field_html += '<li>' +
                '<table class="form-table cmsmasters-options">' +
                    '<tr>' +
                        '<td class="sep">' +
                            '<input class="delete small_but" type="button" name="delete_field" value="" style="height:30px; float:right; margin-left:0;" />' +
                            '<input type="hidden" name="field_id" value="' + id + '" />' +
                            '<input type="hidden" name="field_order" value="' + number + '" />' +
                            '<input type="hidden" name="field_type" value="radiobutton" />' +
                            '<div class="fl_field">' +
                                '<span class="label">Radiobutton Field Label <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Radiobutton Field Label" href="?lightbox[width]=350&amp;lightbox[height]=150#field_label_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_label_' + ps_n + '_light">Enter your field label here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<input size="36" name="field_label" type="text" value="' + label + '" id="' + name + '" />' +
                                '<div class="cl"><br /></div>' +
                                '<div class="check_parent">' +
                                    '<input type="checkbox" name="field_required" id="field_required_' + ps_n + '" value="required"' + required + ' />' +
                                    '<label for="field_required_' + ps_n + '"><span class="labelon">Required</span></label>' +
                                '</div>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Radiobutton Field Description</span>' +
                                '<a class="helpbox" title="Radiobutton Field Description" href="?lightbox[width]=350&amp;lightbox[height]=150#field_descr_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_descr_' + ps_n + '_light">Enter your field description here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<textarea name="field_descr" cols="36" rows="5">' + descr + '</textarea>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Radiobuttons <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Radiobuttons" href="?lightbox[width]=350&amp;lightbox[height]=150#field_opts_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_opts_' + ps_n + '_light">Add/Remove radiobuttons here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<div class="opt_cont">';
                                
                                if (value.length > 1) {
                                    for (var w = 0, wlength = value.length; w < wlength; w += 1) {
                                    field_html += '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="' + value[w] + '" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>';
                                    }
                                } else {
                                    field_html += '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>' +
                                    '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>';
                                }

                                field_html += '<input class="add small_but" type="button" name="add_opt" value="" style="height:30px; float:right; margin-left:12px;" />' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                    '</tr>' +
                '</table>' +
            '</li>';
            break;
        case 'checkbox' :
            field_html += '<li>' +
                '<table class="form-table cmsmasters-options">' +
                    '<tr>' +
                        '<td class="sep">' +
                            '<input class="delete small_but" type="button" name="delete_field" value="" style="height:30px; float:right; margin-left:0;" />' +
                            '<input type="hidden" name="field_id" value="' + id + '" />' +
                            '<input type="hidden" name="field_order" value="' + number + '" /> '+
                            '<input type="hidden" name="field_type" value="checkbox" />' +
                            '<div class="fl_field">' +
                                '<span class="label">Checkbox Field Label <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Checkbox Field Label" href="?lightbox[width]=350&amp;lightbox[height]=150#field_label_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_label_' + ps_n + '_light">Enter your field label here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<input size="36" name="field_label" type="text" value="' + label + '" id="' + name + '" />' +
                                '<div class="cl"><br /></div>' +
                                '<div class="check_parent">' +
                                    '<input type="checkbox" name="field_required" id="field_required_' + ps_n + '" value="required"' + required + ' />' +
                                    '<label for="field_required_' + ps_n + '"><span class="labelon">Required</span></label>' +
                                '</div>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Checkbox Field Description</span>' +
                                '<a class="helpbox" title="Checkbox Field Description" href="?lightbox[width]=350&amp;lightbox[height]=150#field_descr_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_descr_' + ps_n + '_light">Enter your field description here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<textarea name="field_descr" cols="36" rows="5">' + descr + '</textarea>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Checkbox Label <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Checkboxes" href="?lightbox[width]=350&amp;lightbox[height]=150#field_opts_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_opts_' + ps_n + '_light">Enter checkbox label here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<div class="opt_cont">' +
                                    '<div class="opt_item">' +
                                        '<input size="36" name="opt_label" type="text" value="' + value + '" />' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                    '</tr>' +
                '</table>' +
            '</li>';
            break;
        case 'checkboxes' :
            field_html += '<li>' +
                '<table class="form-table cmsmasters-options">' +
                    '<tr>' +
                        '<td class="sep">' +
                            '<input class="delete small_but" type="button" name="delete_field" value="" style="height:30px; float:right; margin-left:0;" />' +
                            '<input type="hidden" name="field_id" value="' + id + '" />' +
                            '<input type="hidden" name="field_order" value="' + number + '" />' +
                            '<input type="hidden" name="field_type" value="checkboxes" />' +
                            '<div class="fl_field">' +
                                '<span class="label">Checkboxes Field Label <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Checkboxes Field Label" href="?lightbox[width]=350&amp;lightbox[height]=150#field_label_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_label_' + ps_n + '_light">Enter your field label here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<input size="36" name="field_label" type="text" value="' + label + '" id="' + name + '" />' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Checkboxes Field Description</span>' +
                                '<a class="helpbox" title="Checkboxes Field Description" href="?lightbox[width]=350&amp;lightbox[height]=150#field_descr_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_descr_' + ps_n + '_light">Enter your field description here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<textarea name="field_descr" cols="36" rows="5">' + descr + '</textarea>' +
                            '</div>' +
                            '<div class="fl_field">' +
                                '<span class="label">Checkboxes <span style="color:#ff0000;">*</span></span>' +
                                '<a class="helpbox" title="Checkboxes" href="?lightbox[width]=350&amp;lightbox[height]=150#field_opts_' + ps_n + '_light"></a>' +
                                '<div class="dn" id="field_opts_' + ps_n + '_light">Add/Remove checkboxes here</div>' +
                                '<div class="cl"><br /></div>' +
                                '<div class="opt_cont">';
                                
                                if (value.length > 1) {
                                    for (var y = 0, ylength = value.length; y < ylength; y += 1) {
                                    field_html += '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="' + value[y] + '" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>';
                                    }
                                } else {
                                    field_html += '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>' +
                                    '<div class="opt_item" style="padding-bottom:10px;">' +
                                        '<input size="36" name="opt_label" type="text" value="" class="fl" />' +
                                        '<input class="delete small_but" type="button" name="delete_opt" value="" style="height:30px; float:left; margin-left:12px;" />' +
                                        '<div class="cl"></div>' +
                                    '</div>';
                                }
                                
                                field_html += '<input class="add small_but" type="button" name="add_opt" value="" style="height:30px; float:right; margin-left:12px;" />' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                    '</tr>' +
                '</table>' +
            '</li>';
            break;
        }
	
        return field_html;
    }
    
    
    // Add New Form
    jQuery('.rght .tabb input[name="add_form"]').click(function () {
        if (insaving) { 
            return false;
        }
	
        insaving = true;
	
        var formName = prompt('Enter form name.');
	
        if (!formName || formName === '' || formName === ' ') {
            alert('Form name is invalid.');
            
            insaving = false;
            
            return false;
        } else {
            var form_name = formName.toLowerCase().replace(/ /g, '_').replace(/[^a-zA-Z0-9_]/g, '');
            
            if (form_name == '' || form_name == '_') { 
                form_name = 'form_' + Math.random() * 1000000000000000000;
            }
            
            jQuery(this).hide();
            jQuery('.rght .tabb input[name="cancel_form"]').show();
            jQuery('#form_build_tab').empty();
            
            var formHTML = '';
            
            formHTML += '<table class="form-table cmsmasters-options">' +
                '<tr>' +
                    '<td style="padding-top:10px;">' +
                        '<input type="hidden" name="form_option" value="add" />' +
                        '<input type="hidden" name="form_id" value="" />' +
                        '<h2 class="fb_h2">Form Name <span style="color:#ff0000;">*</span></h2>' +
                        '<div>' +
                            '<input type="submit" name="save" value="Save Form" style="height:30px; float:right; margin-left:0;" />' +
                            '<div class="fr" style="margin:7px 10px 0 0;"><img class="submit_loader" style="display:none;" src="' + loaderImageUrl + '/theme/administrator/images/wpspin_light.gif" alt="Loading" /></div>' +
                        '</div>' +
                        '<input size="50" maxlength="100" name="form_name" id="' + form_name + '" type="text" value="' + formName + '" class="fl" />' +
                        '<a class="helpbox" title="Form Name" href="?lightbox[width]=350&amp;lightbox[height]=150#form_name_light" style="margin-top:4px;"></a>' +
                        '<div class="dn" id="form_name_light">Enter your form name here.<br /><strong>Important: Form Name must be unique and not longer than 100 characters!</strong></div>' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td style="padding-top:0;">' +
                        '<p class="fr" style="padding-top:33px; margin-bottom:0;">Drag and Drop to change fields order</p>' +
                        '<h3 style="padding-bottom:5px;">Add / Remove / Edit Fields</h3>' +
                    '</td>' +
                '</tr>' +
            '</table>' +
            '<ul id="fields-list">' +
            '</ul>' +
            '<table class="form-table cmsmasters-options">' +
                '<tr>' +
                    '<td class="sep" style="padding-bottom:10px;">' +
                        '<input class="add small_but" type="button" name="add_field" value="" style="height:30px; float:right; margin-left:12px;" />' +
                        '<select style="width:150px; float:right;" id="field_choose">' +
                            '<option value="">Choose field type</option>' +
                            '<option value="text">Text Field</option>' +
                            '<option value="email">Email Field</option>' +
                            '<option value="textarea">Text Area</option>' +
                            '<option value="dropdown">Dropdown</option>' +
                            '<option value="radiobutton">Radiobuttons</option>' +
                            '<option value="checkbox">Checkbox</option>' +
                            '<option value="checkboxes">Checkboxes</option>' +
                        '</select>' +
                        '<a class="helpbox" title="Form Name" href="?lightbox[width]=350&amp;lightbox[height]=150#field_type_light" style="float:right; margin:4px 12px 0 0;"></a>' +
                        '<div class="dn" id="field_type_light">Choose your field type here</div>' +
                        '<div class="cl"></div>' +
                        '<h3 style="padding-bottom:0; margin-top:30px;">Message Composer</h3>' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>' +
                        '<div class="message_composer_buttons" style="margin-left:-7px;"></div>' +
                        '<div class="cl"></div>' +
                        '<textarea name="composer_message" cols="100" rows="15">Your message text...</textarea>' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>' +
                        '<h3>The Message Subgect</h3>' +
                        '<textarea name="composer_subject" cols="100" rows="1">Form Subject</textarea>' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td style="padding-top:0;">' +
                        '<h3>The Message About Succesful Sending Text</h3>' +
                        '<textarea name="composer_success" cols="100" rows="5">Thank You! <br />Your message has been sent successfully.</textarea>' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td class="sep">' +
                        '<div class="check_parent fl">' +
                            '<input type="checkbox" name="composer_use_captcha" id="composer_use_captcha" value="captcha" />' +
                            '<label for="composer_use_captcha"><span class="labelon">Use CAPTCHA</span></label>' +
                        '</div>' +
                        '<div class="check_parent fl">' +
                            '<input type="checkbox" name="composer_reset_button" id="composer_reset_button" value="reset" />' +
                            '<label for="composer_reset_button"><span class="labelon">Add Reset Button</span></label>' +
                        '</div>' +
                        '<div class="cl" style="padding-top:50px;">' +
                            '<input type="submit" name="save" value="Save Form" style="height:30px; float:left; margin-left:0;" />' +
                            '<div class="fl" style="margin:7px 0 0 10px;"><img class="submit_loader" style="display:none;" src="' + loaderImageUrl + '/theme/administrator/images/wpspin_light.gif" alt="Loading" /></div>' +
                        '</div>' +
                    '</td>' +
                '</tr>' +
            '</table>';
            
            jQuery('#form_build_tab').append(formHTML);
            jQuery('.slider .rght .tabb.bot').parent().slideDown('slow');
            
            insaving = false;
            
            // Enable Fields Sorting
            jQuery('#fields-list').sortable( {
                placeholder : 'ui-sortable-placeholder',
                forcePlaceholderSize : true,
                cursor : 'move',
                update : function (event, ui) {
                    jQuery('.message_composer_buttons').empty();
                    
                    for (var i = 0, ilength = jQuery('#fields-list li').length; i < ilength; i += 1) {
                        jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_order"]').val(i + 1);
			
                        var but_val = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_label"]').val();
			
                        if (but_val === '' || but_val === ' ') { 
                            but_val = 'Field';
                        }
			
                        jQuery('.message_composer_buttons').append('<input type="button" name="composer_add_button" value="' + but_val + '" style="height:30px; margin-left:7px;" />');
                    }
                }
            } );
            
            return false;
        }
    } );
    
    
    // Cancel
    jQuery('.rght .tabb input[name="cancel_form"]').click(function () {
        if (insaving) { 
            return false;
        }
	
        var ask = (jQuery('#form_build_tab').find('input[name="form_name"]').attr('name') !== undefined) ? confirm('All unsaved changes will be lost! Do you want to proceed?') : true;
	
        if (!ask) { 
            return false;
        }
	
        jQuery(this).hide();
        jQuery('.rght .tabb input[name="save_as_form"]').hide();
        jQuery('.rght .tabb input[name="add_form"]').show();
        jQuery('#form_build_tab').empty();
        jQuery('.slider .rght .tabb.bot').parent().slideUp('fast');
	
        return false;
    });
    
    
    // Delete Form
    jQuery('.rght .tabb input[name="delete_form"]').click(function () {
        if (insaving) { 
            return false;
        }
	
        var form_choose = jQuery('#form_choose').val();
	
        if (form_choose === '') {
            alert('Please choose form!');
            
            return false;
        }
	
        var form_choose_text = jQuery('#form_choose option:selected').text(), 
			ask = confirm('Are you sure you want to delete the form "' + form_choose_text + '" and all the fields it contains?');
	
        if (!ask) { 
            return false;
        }
	
        insaving = true;
	
        jQuery('#settings_error').hide();
        jQuery(this).parent().find('.submit_loader').addClass('active_submit_loader').fadeIn('fast');
	
        if (jQuery('#form_build_tab input[name="form_name"]').attr('id') === form_choose) {
            jQuery('.rght .tabb input[name="cancel_form"]').hide();
            jQuery('.rght .tabb input[name="save_as_form"]').hide();
            jQuery('.rght .tabb input[name="add_form"]').show();
            jQuery('#form_build_tab').empty();
            jQuery('.slider .rght .tabb.bot').parent().slideUp('fast');
        }
	
        jQuery.post(loaderImageUrl + '/theme/functions/form-builder-operator.php', {
            type : 'form', 
            option : 'delete', 
            data : form_choose
        } ).error(function () {
            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
            
            alert('Error on page! Please reload page and try again.');
            
            insaving = false;
            
            return false;
        } ).complete(function (data) {
            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('slow');
            
            if (data.responseText === 'error') {
                alert('Form deleting error was detected! It is no such form in your database.');
		
                insaving = false;
                
                return false;
            } else {
                jQuery('select#form_choose').find('option[value="' + form_choose + '"]').remove();
		
                jQuery('html, body').animate( {
                    scrollTop : 0
                }, 'slow');
                jQuery('#settings_error').slideDown('fast').delay(5000).slideUp('slow');
		
                insaving = false;
            }
        } );
	
        return false;
    } );
    
    
    // Edit Form
    jQuery('.rght .tabb input[name="edit_form"]').click(function () {
        if (insaving) { 
            return false;
        }
        
        var form_choose = jQuery('#form_choose').val();
        
        if (form_choose === '') {
            alert('Please choose form!');
            
            return false;
        }
	
        var ask = (jQuery('#form_build_tab').find('input[name="form_name"]').attr('name') !== undefined) ? confirm('All unsaved changes will be lost! Do you want to proceed?') : true;
	
        if (!ask) { 
            return false;
        }
	
        insaving = true;
	
        jQuery('#form_build_tab').empty();
        jQuery('.slider .rght .tabb.bot').parent().slideUp('fast');
	
        jQuery.post(loaderImageUrl + '/theme/functions/form-builder-operator.php', {
            type : 'form', 
            option : 'edit', 
            data : form_choose
        } ).error(function () {
            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
            
            alert('Error on page! Please reload page and try again.');
            
            insaving = false;
            
            return false;
        } ).complete(function (data) {
            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('slow');
            
            if (data.responseText === 'error') {
                alert('Error was detected! It is no such form in your database.');
		
                insaving = false;
                
                return false;
            } else {
                jQuery('.rght .tabb input[name="add_form"]').hide();
                jQuery('.rght .tabb input[name="cancel_form"]').show();
                jQuery('.rght .tabb input[name="save_as_form"]').show();
		
                var formHTML = '', 
					table_values = jQuery.parseJSON(data.responseText), 
					composer_value = '';
                
                jQuery.each(table_values, function (i, field_val) {
                    if (field_val.type !== 'form') { 
                        composer_value += '<input type="button" name="composer_add_button" value="' + field_val.label + '" style="height:30px; margin-left:7px;" />';
                    }
                } );
                
                jQuery.each(table_values, function (i, val) {
                    if (val.type === 'form'){ 
                        var form_vals = val.description, 
							captcha = (jQuery.inArray('captcha', val.parameters) != -1) ? ' checked="checked"' : '', 
							reset = (jQuery.inArray('reset', val.parameters) != -1) ? ' checked="checked"' : '';
                        
                        formHTML += '<table class="form-table cmsmasters-options">'+
                            '<tr>'+
                                '<td style="padding-top:10px;">'+
                                    '<input type="hidden" name="form_option" value="update" />'+
                                    '<input type="hidden" name="form_id" value="'+val.id+'" />'+
                                    '<h2 class="fb_h2">Form Name <span style="color:#ff0000;">*</span></h2>'+
                                    '<div>'+
                                        '<input type="submit" name="save" value="Save Form" style="height:30px; float:right; margin-left:0;" />'+
                                        '<div class="fr" style="margin:7px 10px 0 0;"><img class="submit_loader" style="display:none;" src="'+loaderImageUrl+'/theme/administrator/images/wpspin_light.gif" alt="Loading" /></div>'+
                                    '</div>'+
                                    '<input size="50" maxlength="100" name="form_name" id="'+val.parent_slug+'" type="text" value="'+val.label+'" class="fl" />'+
                                    '<a class="helpbox" title="Form Name" href="?lightbox[width]=350&amp;lightbox[height]=150#form_name_light" style="margin-top:4px;"></a>'+
                                    '<div class="dn" id="form_name_light">Enter your form name here.<br /><strong>Important: Form Name must be unique and not longer than 100 characters!</strong></div>'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td style="padding-top:0;">'+
                                    '<p class="fr" style="padding-top:33px; margin-bottom:0;">Drag and Drop to change fields order</p>'+
                                    '<h3 style="padding-bottom:5px;">Add / Remove / Edit Fields</h3>'+
                                '</td>'+
                            '</tr>'+
                        '</table>'+
                        '<ul id="fields-list">';
                        
                        jQuery.each(table_values, function (i, field_val) {
                            if (field_val.type !== 'form') { 
                                formHTML += fieldChoose(field_val.type, field_val);
                            }
                        });
                        
                        formHTML += '</ul>'+
                        '<table class="form-table cmsmasters-options">'+
                            '<tr>'+
                                '<td class="sep" style="padding-bottom:10px;">'+
                                    '<input class="add small_but" type="button" name="add_field" value="" style="height:30px; float:right; margin-left:12px;" />'+
                                    '<select style="width:150px; float:right;" id="field_choose">'+
                                        '<option value="">Choose field type</option>'+
                                        '<option value="text">Text Field</option>'+
                                        '<option value="email">Email Field</option>'+
                                        '<option value="textarea">Text Area</option>'+
                                        '<option value="dropdown">Dropdown</option>'+
                                        '<option value="radiobutton">Radiobuttons</option>'+
                                        '<option value="checkbox">Checkbox</option>'+
                                        '<option value="checkboxes">Checkboxes</option>'+
                                    '</select>'+
                                    '<a class="helpbox" title="Form Name" href="?lightbox[width]=350&amp;lightbox[height]=150#field_type_light" style="float:right; margin:4px 12px 0 0;"></a>'+
                                    '<div class="dn" id="field_type_light">Choose your field type here</div>'+
                                    '<div class="cl"></div>'+
                                    '<h3 style="padding-bottom:0; margin-top:30px;">Message Composer</h3>'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>'+
                                    '<div class="message_composer_buttons" style="margin-left:-7px;">'+composer_value+'</div>'+
                                    '<div class="cl"></div>'+
                                    '<textarea name="composer_message" cols="100" rows="15">'+val.value+'</textarea>'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>'+
                                    '<h3>The Message Subgect</h3>'+
                                    '<textarea name="composer_subject" cols="100" rows="1">'+form_vals[0]+'</textarea>'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td style="padding-top:0;">'+
                                    '<h3>The Message About Succesful Sending Text</h3>'+
                                    '<textarea name="composer_success" cols="100" rows="5">'+form_vals[1]+'</textarea>'+
                                '</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td class="sep">'+
                                    '<div class="check_parent fl">'+
                                        '<input type="checkbox" name="composer_use_captcha" id="composer_use_captcha" value="captcha"'+captcha+' />'+
                                        '<label for="composer_use_captcha"><span class="labelon">Use CAPTCHA</span></label>'+
                                    '</div>'+
                                    '<div class="check_parent fl">'+
                                        '<input type="checkbox" name="composer_reset_button" id="composer_reset_button" value="reset"'+reset+' />'+
                                        '<label for="composer_reset_button"><span class="labelon">Add Reset Button</span></label>'+
                                    '</div>'+
                                    '<div class="cl" style="padding-top:50px;">'+
                                        '<input type="submit" name="save" value="Save Form" style="height:30px; float:left; margin-left:0;" />'+
                                        '<div class="fl" style="margin:7px 0 0 10px;"><img class="submit_loader" style="display:none;" src="'+loaderImageUrl+'/theme/administrator/images/wpspin_light.gif" alt="Loading" /></div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>'+
                        '</table>';
                        
                        jQuery('#form_build_tab').append(formHTML);
                    }
                });
                
                jQuery('.slider .rght .tabb.bot').parent().slideDown('slow');
		
                insaving = false;
                
                // Enable Fields Sorting
                jQuery('#fields-list').sortable( {
                    placeholder : 'ui-sortable-placeholder',
                    forcePlaceholderSize : true,
                    cursor : 'move',
                    update : function(event, ui) {
                        jQuery('.message_composer_buttons').empty();
			
                        for (var i = 0, ilength = jQuery('#fields-list li').length; i < ilength; i += 1) {
                            jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_order"]').val(i + 1);
							
                            var but_val = jQuery('#fields-list li:eq(' + i + ')').find('input[name="field_label"]').val();
							
                            if (but_val === '' || but_val === ' ') { 
                                but_val = 'Field';
                            }
                            
                            jQuery('.message_composer_buttons').append('<input type="button" name="composer_add_button" value="' + but_val + '" style="height:30px; margin-left:7px;" />');
                        }
                    }
                } );
                
                // Enable Min/Max Size Spinner
                jQuery('input[name="min_size"], input[name="max_size"]').spinner( {
                    min : 0,
                    max : 999,
                    step : 1,
                    allowNull : true
                } );
            }
        } );
	
        return false;
    } );
    
    
    // Save As Form
    jQuery('.rght .tabb input[name="save_as_form"]').click(function () {
        if (insaving) { 
            return false;
        }
	
        insaving = true;
	
        jQuery('#settings_save').hide();
        jQuery(this).parent().find('.submit_loader').addClass('active_submit_loader').fadeIn('fast');
	
        var formName = prompt('Enter form name.');
	
        if (formName && formName !== '' && formName !== ' ') {
            saveAction('add', formName);
        } else {
            alert('Form not saved! Form name is invalid.');
            
            jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
        }
	
        insaving = false;
	
        return false;
    } );
    
    
    // Save Form
    jQuery('.rght .tabb').delegate('input[name="save"]', 'click', function () {
        if (insaving) { 
            return false;
        }
	
        insaving = true;
	
        jQuery('#settings_save').hide();
        jQuery(this).parent().find('.submit_loader').addClass('active_submit_loader').fadeIn('fast');
	
        var saveOption = jQuery('input[name="form_option"]').val();
	
        saveAction(saveOption);
	
        insaving = false;
	
        return false;
    } );
    
    
    // Add New Field
    jQuery('.rght .tabb').delegate('input[name="add_field"]', 'click', function () {
        if (insaving) { 
            return false;
        }
	
        var field_type = jQuery('#field_choose').val();
	
        if (field_type === ''){
            alert('Please choose field type!');
            
            return false;
        }
	
        jQuery('#fields-list').append(fieldChoose(field_type));
	
        jQuery('.message_composer_buttons').append('<input type="button" name="composer_add_button" value="Field" style="height:30px; margin-left:7px;" />');
	
        // Enable Min/Max Size Spinner
        jQuery('input[name="min_size"], input[name="max_size"]').spinner( {
            min : 0,
            max : 999,
            step : 1,
            allowNull : true
        } );
	
        return false;
    } );
    
    
    // Delete Field
    jQuery('.rght .tabb').delegate('input[name="delete_field"]', 'click', function () {
        if (insaving) { 
            return false;
        }
	
        var field = jQuery(this).parent().parent().parent().parent().parent();
	
        if (jQuery(field).is('li')) {
            var ask = confirm('Are you sure you want to delete this field?');
            
            if (!ask) { 
                return false;
            }
            
            if (jQuery('input[name="form_option"]').val() === 'update') {
                var field_choose = field.find('input[name="field_id"]').val();
		
                if (field_choose === '') {
                    alert('Error on page! Please reload page and try again.');
                    
                    return false;
                }
		
                jQuery.post(loaderImageUrl + '/theme/functions/form-builder-operator.php', {
                    type : 'fields', 
                    option : 'delete', 
                    data : field_choose
                } ).error(function () {
                    alert('Error on page! Please reload page and try again.');
                    
                    return false;
                } ).complete(function (data) {
                    if (data.responseText === 'error') {
                        alert('Field deleting error was detected! It is no such field in your database.');
			
                        field.slideUp('fast', function () {
                            jQuery(this).remove();
                        } );
			
                        jQuery('.message_composer_buttons').find('input[name="composer_add_button"]:eq(' + field.index() + ')').remove();
			
                        return false;
                    } else {
                        field.slideUp('fast', function () {
                            jQuery(this).remove();
                        } );
			
                        jQuery('.message_composer_buttons').find('input[name="composer_add_button"]:eq(' + field.index() + ')').remove();
			
                        return false;
                    }
                } );
            } else if (jQuery('input[name="form_option"]').val() === 'add') {
                field.slideUp('fast', function () {
                    jQuery(this).remove();
                } );
		
                jQuery('.message_composer_buttons').find('input[name="composer_add_button"]:eq(' + field.index() + ')').remove();
		
                return false;
            }
        } else {
            alert('Error on page! Please reload page and try again.');
            
            return false;
        }
    } );
    
    
    // Add Option
    jQuery('.rght .tabb').delegate('input[name="add_opt"]', 'click', function () {
        if (insaving) { 
            return false;
        }
	
        var opt = '<div class="opt_item" style="padding-bottom:10px;">' +
            '<input class="fl" type="text" value="" name="opt_label" size="36">' +
            '<input class="delete small_but" type="button" style="height:30px; float:left; margin-left:12px;" value="" name="delete_opt">' +
            '<div class="cl"></div>' +
        '</div>';
	
        jQuery(this).before(opt);
	
        return false;
    } );
    
    
    // Delete Option
    jQuery('.rght .tabb').delegate('input[name="delete_opt"]', 'click', function () {
        if (insaving) { 
            return false;
        }
	
        if (jQuery(this).parent().parent().find('.opt_item').length > 2) {
            var ask = confirm('Are you sure you want to delete this option?');
            
            if (!ask) { 
                return false;
            }
            
            jQuery(this).parent().fadeOut('fast', function () {
                jQuery(this).remove();
            } );
        } else {
            alert("Here can't be less than 2 options!");
        }
	
        return false;
    } );
    
    
    // Composer Add/Edit Buttons On Blur
    jQuery('.rght .tabb').delegate('input[name="field_label"]', 'blur', function () {
        if (insaving) { 
            return false;
        }
	
        var element = jQuery(this).parent().parent().parent().parent().parent().parent().index(), 
			vl = jQuery(this).val();
	
        if (vl === '' || vl === ' ') { 
            vl = 'Field';
        }
	
        jQuery('.message_composer_buttons').find('input[name="composer_add_button"]:eq(' + element + ')').val(vl);
	
        return false;
    } );
    
    
    // Composer Add/Edit Buttons On Change
    jQuery('.rght .tabb').delegate('input[name="field_label"]', 'change', function () {
        if (insaving) { 
            return false;
        }
	
        var element = jQuery(this).parent().parent().parent().parent().parent().parent().index(), 
			vl = jQuery(this).val();
		
        if (vl === '' || vl === ' ') { 
            vl = 'Field';
        }
	
        jQuery('.message_composer_buttons').find('input[name="composer_add_button"]:eq(' + element + ')').val(vl);
	
        return false;
    } );
    
    
    // Composer Button Click
    jQuery('.rght .tabb').delegate('input[name="composer_add_button"]', 'click', function () {
        if (insaving) { 
            return false;
        }
        
        var newVal = jQuery(this).val(), 
			oldVal = jQuery('textarea[name="composer_message"]').val();
	
        jQuery('textarea[name="composer_message"]').val(oldVal + '[%' + newVal + '%]').focus();
	
        return false;
    } );
} );
