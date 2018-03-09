<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.3
 * 
 * Form Builder
 * Created by CMSMasters
 * 
 */


$form_handle = 'form-builder';

function cmsmasters_form_builder() {
    global $wpdb, $shortname;
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
        
        .slider .rght .check_parent input[type="checkbox"] + label, 
        .slider .rght .check_parent input[type="radio"] + label {
            background:none;
            padding-left:5px;
        }
        
        .slider .rght .check_parent input[type="checkbox"] + label span.labelon, 
        .slider .rght .check_parent input[type="checkbox"] + label span.labeloff { font-weight:normal; }
        
        .slider .rght .spinner-wrpr input { display:block; }
    </style>
    <![endif]-->
    <!--[if IE 7]>
    <style type="text/css">
        .slider .rght input[type="button"], 
        .slider .rght input[type="button"].fl, 
        .slider .rght input[type="submit"] {
            height:30px;
            padding:0;
        }
        
        .slider .rght input[type="button"].edit, 
        .slider .rght input[type="button"].delete, 
        .slider .rght input[type="button"].add { padding-left:30px; }
        
        .slider .rght input[type="button"].small_but {
            width:auto;
            padding:4px 9px 6px 17px;
        }
        
        .slider .rght input[type="text"] { height:18px; }
        
        .slider .rght input[type="button"].button.fl { height:30px; }
        
        .slider .rght .spinner-wrpr { height:31px; }
        
        .slider .rght .spinner-wrpr input[type="text"] { width:35px; }
        
        .slider .rght .ui-spinner-button { top:1px; }
        
        .slider .rght .check_parent input[type="checkbox"] + label, 
        .slider .rght .check_parent input[type="radio"] + label { padding-top:2px; }
        
        .slider .rght .check_parent input[type="checkbox"] + label span { padding-bottom:5px; }
        
        .slider .rght select#form_choose, 
        .slider .rght select#field_choose { margin-top:5px; }
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
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/js/form-builder.js"></script>
    <div class="wrap" style="position:relative; overflow:hidden; padding-left:5px; padding-bottom:10px;">
        <?php screen_icon('themes'); ?>
        <h2 style="padding-top:12px;"><?php _e('Contact Form Builder', 'cmsmasters'); ?></h2>
    </div>
    <div id="settings_save" class="updated fade below-h2 myadminpanel" style="display:none;"><p><strong><?php _e('Form settings succesfully saved', 'cmsmasters'); ?>.</strong></p></div>
    <div id="settings_error" class="error fade below-h2 myadminpanel" style="display:none;"><p><strong><?php _e('Form succesfully deleted', 'cmsmasters'); ?>.</strong></p></div>
    <div class="slider wrap" style="padding-left:15px;">
        <div class="bot">
            <div class="logo form_builder_logo"></div>
            <div class="rght form_builder_mp">
                <form method="post" action="" id="adminoptions_form">
                    <div id="form_choose_tab" class="tabb top">
                        <table class="form-table cmsmasters-options">
                            <tr>
                                <td>
                                    <input type="hidden" name="loader_image_url" value="<?php echo get_template_directory_uri(); ?>" />
                                    <input class="add" type="button" name="add_form" value="<?php _e('Add New', 'cmsmasters'); ?>" style="height:30px; float:right; margin-left:0;" />
                                    <input type="button" name="cancel_form" value="<?php _e('Cancel', 'cmsmasters'); ?>" style="display:none; height:30px; float:right; margin-left:0;" />
                                    <select style="width:180px;" id="form_choose" class="fl">
                                        <option value=""><?php _e('Select your form here', 'cmsmasters'); ?></option>
                                        <?php
                                        $get_forms = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . $shortname . "_forms WHERE type='form'");

                                        foreach ($get_forms as $form) {
                                            $val = $form->slug;
                                            $name = $form->label;

                                            echo '<option value="' . $val . '">' . $name . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <input class="fl edit" type="button" name="edit_form" value="<?php _e('Edit', 'cmsmasters'); ?>" style="height:30px; margin-left:12px;" />
                                    <div class="fl">
                                        <input class="delete fl" type="button" name="delete_form" value="<?php _e('Delete', 'cmsmasters'); ?>" style="height:30px; margin-left:12px;" />
                                        <div class="fl" style="margin:7px 0 0;"><img class="submit_loader" style="display:none; margin:0 0 0 10px;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" /></div>
                                    </div>
                                    <div class="fl">
                                        <input type="button" name="save_as_form" value="<?php _e('Save As...', 'cmsmasters'); ?>" style="display:none; height:30px; float:left; margin-left:12px;" />
                                        <div class="fl" style="margin:7px 0 0;"><img class="submit_loader" style="display:none; margin:0 0 0 10px;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" /></div>
                                    </div>
                                </td>
                            </tr>
                            <tr><td style="padding:0; margin:0;"></td></tr>
                        </table>
                    </div>
                    <div class="clsep">
                        <div id="form_build_tab" class="tabb bot"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}

function cmsmasters_enable_form_builder() {
    global $shortname, $form_handle;

    add_submenu_page($shortname . '-options', __('Form Builder', 'cmsmasters'), __('Form Builder', 'cmsmasters'), 'edit_themes', $form_handle, 'cmsmasters_form_builder');
}

add_action('admin_menu', 'cmsmasters_enable_form_builder');

?>