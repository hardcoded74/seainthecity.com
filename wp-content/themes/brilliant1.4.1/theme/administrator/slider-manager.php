<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.3
 * 
 * Slider Manager
 * Created by CMSMasters
 * 
 */


$slider_handle = 'slider-manager';

function cmsmasters_slider_manager() {
    global $wpdb, $shortname;
	
    $sliderManager = new cmsmsSliderManager();
?>
    <!--[if lt IE 9]>
    <style type="text/css">
		.slider .rght .check_parent input[type="checkbox"], 
		.slider .rght .check_parent input[type="radio"] {
			position:relative;
			top:auto;
			left:auto;
			opacity:1;
		}
		
		.slider .rght .check_parent input[type="checkbox"] + label {
			background:none;
			padding:2px 0 0 25px;
		}
		
		.slider .rght .check_parent input[type="checkbox"] + label span.labelon, 
		.slider .rght .check_parent input[type="checkbox"] + label span.labeloff {font-weight:normal;}
		
		.slider .rght input[type="radio"] + label {
			background:none;
			padding-left:5px;
		}
    </style>
    <![endif]-->
    <!--[if IE 7]>
    <style type="text/css">
		body.wp-admin .slider .rght input[type="button"], 
		body.wp-admin .slider .rght input[type="button"].fl, 
		body.wp-admin .slider .rght input[type="submit"] {
			height:30px;
			padding:0;
		}
		
		body.wp-admin .slider .rght input[type="text"] {height:18px;}
		
		body.wp-admin .slider .rght input[type="button"].button.fl {height:30px;}
		
		body.wp-admin .slider .rght .spinner-wrpr input[type="text"] {width:35px;}
		
		.slider .rght .check_parent input[type="checkbox"] + label {padding-left:5px;}
    </style>
    <![endif]-->
<?php if (version_compare(get_bloginfo('version'), '3.5') < 0) { ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/js/jquery-ui-1.8.12.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/js/spinner.js"></script>
<?php } else { ?>
	<style type="text/css">
		.slider .rght .ui-spinner {
			display:inline-block;
			position:relative;
			top:auto;
			left:auto;
		}
		
		.slider .rght .ui-spinner .ui-spinner-input {
			border-left:0;
			border-right:0;
			text-align:center;
			margin:0 30px;
			-webkit-border-radius:0;
			-moz-border-radius:0;
			border-radius:0;
		}
		
		.slider .rght .ui-spinner-button {padding:0;}
		
		.slider .rght .ui-spinner-button.ui-corner-tr {right:0;}
		
		.slider .rght .ui-spinner-button.ui-corner-br {left:0;}
		
		.slider .rght .ui-spinner-button .ui-icon-triangle-1-n, 
		.slider .rght .ui-spinner-button .ui-icon-triangle-1-s {color:transparent;}
	</style>
<?php } ?>
    <div class="wrap" style="position:relative; overflow:hidden; padding-left:5px; padding-bottom:10px;">
        <?php screen_icon('themes'); ?>
        <h2 style="padding-top:12px;"><?php _e('Slider Manager', 'cmsmasters'); ?></h2>
    </div>
    <div id="settings_save" class="updated fade below-h2 myadminpanel" style="display:none;"><p><strong><?php _e('Slider settings succesfully saved', 'cmsmasters'); ?>.</strong></p></div>
    <div id="settings_error" class="error fade below-h2 myadminpanel" style="display:none;"><p><strong><?php _e('Slider succesfully deleted', 'cmsmasters'); ?>.</strong></p></div>
    <div class="slider wrap" style="padding-left:15px;">
        <div class="bot">
            <div class="logo slider_manager_logo"></div>
            <div class="rght form_builder_mp">
                <form method="post" action="" id="adminoptions_form">
                    <div id="slider_choose_tab" class="tabb top">
                        <table class="form-table cmsmasters-options">
                            <tr>
                                <td>
                                    <input id="slider_id" class="slider_id" type="hidden" value="" />
                                    <input id="slides_counter" class="slides_counter" type="hidden" value="0" />
                                    <input type="hidden" id="actionUri" value="<?php echo get_template_directory_uri(); ?>" />
                                    <input class="add" type="button" name="addSlider" id="addSlider" value="<?php _e('Add New', 'cmsmasters'); ?>" style="height:30px; float:right;" />
									<input type="button" id="cancel_slider" name="cancel_slider" value="<?php _e('Cancel', 'cmsmasters'); ?>" style="display:none; height:30px; float:right; margin-left:0;" />
                                    <select style="height:30px; width:140px; float:right; margin-left:0; display: none;" >
                                        <option value="responsive"><?php _e('Responsive Slider', 'cmsmasters'); ?></option>
                                        <option value="motion"><?php _e('Motion Slider', 'cmsmasters'); ?></option>
                                    </select>
                                    <select style="width:180px;" id="sliderChoose" class="fl">
										<option value=""><?php _e('Select your slider here', 'cmsmasters'); ?></option>
										<?php
										$sliders = $sliderManager->getSliders();
										
										if (!empty($sliders)) {
											foreach ($sliders as $slider) {
												echo '<option value="' . $slider[slider_id] . '">' . $slider[option_value] . '</option>';
											}
										}
										?>
									</select>
                                    <input class="fl edit" type="button" name="editSlider" id="editSlider" value="<?php _e('Edit', 'cmsmasters'); ?>" style="height:30px; margin-left:12px;" />
                                    <div class="fl">
                                        <input class="delete fl" type="button" name="deleteSlider" id="deleteSlider" value="<?php _e('Delete', 'cmsmasters'); ?>" style="height:30px; margin-left:12px;" />
                                        <div class="fl" style="margin:7px 0 0;"><img class="submit_loader" style="display:none; margin:0 0 0 10px;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" /></div>
                                    </div>
                                    <div class="fl">
                                        <input type="button" name="saveAsSlider" id="saveAsSlider" value="<?php _e('Save As...', 'cmsmasters'); ?>" style="display:none; height:30px; margin-left:12px;" />
                                        <div class="fl" style="margin:7px 0 0;"><img class="submit_loader" style="display:none; margin:0 0 0 10px;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" /></div>
                                    </div>
                                </td>
                            </tr>
                            <tr><td style="padding:0; margin:0;"></td></tr>
                        </table>
                    </div>

                    <div class="clsep" style="display:none;">
                        <div id="slider_manager_tab" class="tabb bot"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}

function cmsmasters_enable_slider_manager() {
    global $shortname, $slider_handle;
	
    add_submenu_page($shortname . '-options', __('Slider Manager', 'cmsmasters'), __('Slider Manager', 'cmsmasters'), 'edit_themes', $slider_handle, 'cmsmasters_slider_manager');
}

add_action('admin_menu', 'cmsmasters_enable_slider_manager');

?>