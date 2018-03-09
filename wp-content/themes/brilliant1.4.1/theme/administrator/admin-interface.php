<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.3
 * 
 * Theme Admin Panel Interface
 * Created by CMSMasters
 * 
 */


function cmsmasters_admin_options() {
    global $themename, 
		$shortname, 
		$options, 
		$cmsmasters_categories;
	
    require(CMSMASTERS_CLASSES . '/var.php');
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
		
		.slider .rght input.button.fl[type="button"], 
		.slider .rght input[type="submit"], 
		.slider .rght input[type="button"] {height:auto;}
	</style>
<?php } ?>
    <script type="text/javascript">
        jQuery(document).ready(function () { 
            jQuery('input[type="color"]').mColorPicker( { 
				imageFolder : '<?php echo get_template_directory_uri(); ?>/theme/administrator/images/mColorPicker/' 
			} ); 
        } );
    </script>
    <script type="text/javascript">
        jQuery(function () {
            if (!jQuery.browser.msie) {
                jQuery('.rght .tabb input[name="save"]').click(function () {
                    jQuery('#settings_save').hide();
                    jQuery(this).parent().find('.submit_loader').addClass('active_submit_loader').fadeIn('fast');
                    
                    jQuery.post(jQuery('#adminoptions_form').attr('action'), jQuery('#adminoptions_form').serialize() + '&action=save').error(function () {
                        jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('fast');
                        jQuery('html, body').animate( { scrollTop : 0 } , 'slow');
                        jQuery('#settings_error').slideDown('fast').delay(5000).slideUp('slow');
                        
                        alert('<?php _e('Error on page! Please reload page and try again.', 'cmsmasters'); ?>');
                    } ).complete(function () {
                        jQuery('.submit_loader.active_submit_loader').removeClass('active_submit_loader').fadeOut('slow');
                        jQuery('html, body').animate( { scrollTop : 0 } , 'slow');
                        jQuery('#settings_save').slideDown('fast').delay(5000).slideUp('slow');
                    } );
                    
                    return false;
                } );
            }
            
            jQuery('.slider .tabs li a').click(function () {
                if (jQuery(this).parent().hasClass('select') || jQuery(this).next().find('li:first').hasClass('select')){
                    
                } else { 
                    if (jQuery(this).parent().parent().hasClass('tabs')) {
                        var href;
                        
                        if (jQuery(this).parent().hasClass('sel')) {
                            jQuery('.slider .tabs li.select').removeClass('select');
                            jQuery('.slider .tabs li.sel').removeClass('sel');
                        } else {
                            jQuery('.slider .tabs li.select').removeClass('select').find('ul').slideUp(500);
                            jQuery('.slider .tabs li.sel').removeClass('sel').find('ul').slideUp(500);
                        }
                        
                        if (jQuery(this).next().find('li').length === 0) { 
                            href = jQuery(this).attr('href');
                            
                            jQuery(this).parent().addClass('select');
                        } else {
                            href = jQuery(this).next().find('a:first').attr('href');
                            
                            jQuery(this).next().find('li:first').addClass('select');
                            jQuery(this).parent().addClass('sel');
                        }
                        
                        jQuery(this).parent().find('ul').slideDown(500);
                        jQuery('.slider .rght .tabb.select').slideUp(250).removeClass('select');
                        jQuery('.slider .rght').find(href).slideDown(250).addClass('select');
                    } else {
                        href = jQuery(this).attr('href');
                        
                        jQuery('.slider .tabs li.select').removeClass('select');
                        jQuery('.slider .tabs li.sel').removeClass('sel');
                        jQuery(this).parent().addClass('select');
                        jQuery(this).parent().parent().parent().addClass('sel');
                        jQuery('.slider .rght .tabb.select').slideUp(250).removeClass('select');
                        jQuery('.slider .rght').find(href).slideDown(250).addClass('select');
                    }
                }
                
                return false;
            } );
            
            jQuery('.slider .rght .tabb').css( { minHeight : '500px' } );
            jQuery('.slider .rght #dashboard').addClass('select');
        } );
    </script>
    <div class="wrap" style="position:relative; overflow:hidden; padding-left:5px; padding-bottom:10px;">
        <?php screen_icon('options-general'); ?>
        <h2 style="padding-top:10px;"><?php echo $themename . ' ' . __('Theme Settings', 'cmsmasters'); ?></h2>
    </div>
    <div id="settings_save" class="updated fade below-h2 myadminpanel" style="display:none;">
		<p><strong><?php echo $themename . ' ' . __('settings saved', 'cmsmasters'); ?>.</strong></p>
	</div>
    <div id="settings_reset" class="updated fade below-h2 myadminpanel" style="display:none;">
		<p><strong><?php echo $themename . ' ' . __('settings reset', 'cmsmasters'); ?>.</strong></p>
	</div>
    <div id="settings_error" class="error fade below-h2 myadminpanel" style="display:none;">
		<p><strong><?php echo __('Error on page!', 'cmsmasters') . ' ' . $themename . ' ' . __('settings not saved', 'cmsmasters'); ?> <?php echo $themename; ?>.</strong></p>
	</div>
    <div id="settings_import" class="updated fade below-h2 myadminpanel" style="display:none;">
		<p><strong><?php echo $themename . ' ' . __('theme demo content now added to your website database', 'cmsmasters'); ?>.</strong></p>
	</div>
    <?php if (isset($_GET['upgraded'])) { ?>
	<div id="settings_active" class="updated fade below-h2 myadminpanel">
		<p><strong><?php echo $themename . ' ' . __('is now activated', 'cmsmasters') . '. ' . __('To get the most out of everything', 'cmsmasters') . ' ' . $themename . ' ' . __('has to offer please refer to the documentation that was include in the download', 'cmsmasters') . '. ' . __('Should you require further assistance you can contact us thru our ThemeForest profile page', 'cmsmasters'); ?> <a target="_blank" href="http://themeforest.net/user/cmsmasters"><?php _e('here', 'cmsmasters'); ?></a>.</strong></p>
	</div>
    <?php 
	}
	
    if (isset($_GET['saved'])) {
	?>
	<div id="settings_save_ie" class="updated fade below-h2 myadminpanel">
		<p><strong><?php echo $themename . ' ' . __('settings saved', 'cmsmasters'); ?>.</strong></p>
	</div>
    <?php } ?>
    <div class="slider wrap">
        <div class="bot">
            <div class="logo"></div>
            <ul class="tabs">
                <li class="select">
					<a href="#dashboard" title="<?php _e('Dashboard', 'cmsmasters'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/icon_dashboard.png" alt="<?php _e('Dashboard', 'cmsmasters'); ?>" />
						<?php _e('Dashboard', 'cmsmasters'); ?>
					</a>
				</li>
                <li>
					<a href="#logo_options" title="<?php _e('Styling Options', 'cmsmasters'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/icon_styling.png" alt="<?php _e('Styling Options', 'cmsmasters'); ?>" />
						<?php _e('Styling Options', 'cmsmasters'); ?>
					</a>
                    <ul>
                        <li>
							<a href="#logo_options" title="<?php _e('Header, Logo & Favicon', 'cmsmasters'); ?>"><?php _e('Header, Logo & Favicon', 'cmsmasters'); ?></a>
						</li>
						<li>
							<a href="#background_options" title="<?php _e('Background Options', 'cmsmasters'); ?>"><?php _e('Background Options', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#font_family" title="<?php _e('Font Name Options', 'cmsmasters'); ?>"><?php _e('Font Name Options', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#font_size" title="<?php _e('Font Size Options', 'cmsmasters'); ?>"><?php _e('Font Size Options', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#line_height" title="<?php _e('Line Height Options', 'cmsmasters'); ?>"><?php _e('Line Height Options', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#font_color" title="<?php _e('Font Color Options', 'cmsmasters'); ?>"><?php _e('Font Color Options', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#footer_options" title="<?php _e('Footer Options', 'cmsmasters'); ?>"><?php _e('Footer Options', 'cmsmasters'); ?></a>
						</li>
                    </ul>
                </li>
                <li>
					<a href="#general_options" title="<?php _e('General Options', 'cmsmasters'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/icon_general.png" alt="<?php _e('General Options', 'cmsmasters'); ?>" />
						<?php _e('General Options', 'cmsmasters'); ?>
					</a>
                    <ul>
                        <li>
							<a href="#general_options" title="<?php _e('Theme Options', 'cmsmasters'); ?>"><?php _e('Theme Options', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#sidebar_options" title="<?php _e('Sidebars', 'cmsmasters'); ?>"><?php _e('Sidebars', 'cmsmasters'); ?></a>
						</li>
						<li>
							<a href="#theme_bgs" title="<?php _e('Backgrounds Manager', 'cmsmasters'); ?>"><?php _e('Backgrounds Manager', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#social_icons" title="<?php _e('Social Icons Manager', 'cmsmasters'); ?>"><?php _e('Social Icons Manager', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#theme_icons" title="<?php _e('Theme Icons Manager', 'cmsmasters'); ?>"><?php _e('Theme Icons Manager', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#theme_fonts" title="<?php _e('Theme Fonts Manager', 'cmsmasters'); ?>"><?php _e('Theme Fonts Manager', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#sharing_options" title="<?php _e('Sharing Options', 'cmsmasters'); ?>"><?php _e('Sharing Options', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#seo_options" title="<?php _e('SEO Tools', 'cmsmasters'); ?>"><?php _e('SEO Tools', 'cmsmasters'); ?></a>
						</li>
                    </ul>
                </li>
                <li>
					<a href="#blog_options_sb" title="<?php _e('Blog Options', 'cmsmasters'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/icon_blog.png" alt="<?php _e('Blog Options', 'cmsmasters'); ?>" />
						<?php _e('Blog Options', 'cmsmasters'); ?>
					</a>
                    <ul>
                        <li>
							<a href="#blog_options_pg" title="<?php _e('Blog Page', 'cmsmasters'); ?>"><?php _e('Blog Page', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#blog_options_pt" title="<?php _e('Blog Posts', 'cmsmasters'); ?>"><?php _e('Blog Posts', 'cmsmasters'); ?></a>
						</li>
                    </ul>
                </li>
                <li>
					<a href="#portfolio_options_fw" title="<?php _e('Portfolio Page', 'cmsmasters'); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/icon_portfolio.png" alt="<?php _e('Portfolio Page', 'cmsmasters'); ?>" />
						<?php _e('Portfolio Page', 'cmsmasters'); ?>
					</a>
                    <ul>
                        <li>
							<a href="#portfolio_options_fw" title="<?php _e('Full Width Portfolio', 'cmsmasters'); ?>"><?php _e('Full Width Portfolio', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#portfolio_options_sb" title="<?php _e('Portfolio With Sidebar', 'cmsmasters'); ?>"><?php _e('Portfolio With Sidebar', 'cmsmasters'); ?></a>
						</li>
                        <li>
							<a href="#portfolio_options_pj" title="<?php _e('Portfolio Projects', 'cmsmasters'); ?>"><?php _e('Portfolio Projects', 'cmsmasters'); ?></a>
						</li>
                    </ul>
                </li>
            </ul>
            <div class="rght">
                <input type="hidden" name="loader_image_url" value="<?php echo get_template_directory_uri(); ?>" />
                <div class="lnk">
                    <a target="_blank" href="http://themeforest.net/user/cmsmasters" title="<?php _e('ThemeForest Profile', 'cmsmasters'); ?>"><?php _e('ThemeForest Profile', 'cmsmasters'); ?></a>
                    <a target="_blank" href="http://forums.cmsmasters.net/" title="<?php _e('Support Forum', 'cmsmasters'); ?>"><?php _e('Support Forum', 'cmsmasters'); ?></a>
                    <a target="_blank" href="http://cmsmasters.net/" title="<?php _e('Website', 'cmsmasters'); ?>"><?php _e('Website', 'cmsmasters'); ?></a>
                    <a target="_blank" href="http://twitter.com/cmsmasters/" title="<?php _e('Twitter', 'cmsmasters'); ?>"><?php _e('Twitter', 'cmsmasters'); ?></a>
                    <a target="_blank" href="http://brilliant-docs.cmsmasters.net/" title="<?php _e('Documentation', 'cmsmasters'); ?>"><?php _e('Documentation', 'cmsmasters'); ?></a>
                </div>
                <form method="post" action="<?php echo admin_url(); ?>admin.php?page=<?php echo $shortname; ?>-options&amp;saved=true" id="adminoptions_form">
                <?php
                $get_options = get_option($shortname . '_general_settings');
                
                foreach ($options as $value) {
                    if (isset($value['id'])) {
                        $id = $value['id'];
                    } else {
                        $id = '';
                    }
                    
                    $selector = (isset($value['selector'])) ? ' class="selector"' : '';
                    
                    switch ($value['type']) {
                    case 'opentab':
                    ?>
                        <div id="<?php echo $value['id']; ?>" class="tabb">
                            <div class="submit cmsmasters-submit" style="float:right; padding-top:2px;">
                                <input type="submit" name="save" value="<?php _e('Save Changes', 'cmsmasters'); ?>" />
                                <div class="fl" style="margin:7px 10px 0 0;">
                                    <img class="submit_loader" style="display:none;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                </div>
                            </div>
                            <h2><?php echo $value['name']; ?></h2>
                            <?php
                        break;
                    case 'opentab_nobutton':
                    ?>
                        <div id="<?php echo $value['id']; ?>" class="tabb">
                            <h2><?php echo $value['name']; ?></h2>
                            <?php
                        break;
                    case 'closetab':
                    ?>
                        </div>
                        <?php
                        break;
                    case 'title_h2':
                    ?>
                        <table class="form-table cmsmasters-options">
                        <?php
                        break;
                    case 'title_h3':
                    ?>
                        <div class="submit cmsmasters-submit" style="float:right; padding:27px 0 8px;"><input type="submit" name="save" value="<?php _e('Save Changes', 'cmsmasters'); ?>" /><div class="fl" style="margin:7px 10px 0 0;"><img class="submit_loader" style="display:none;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" /></div></div>
                            <h3 <?php 
                            if (isset($value['id'])) {
                                echo 'id="head_' . $value['id'] . '"';
                            } 
                            ?>><?php echo $value['name']; ?></h3>
                            <table <?php if (isset($value['id'])) {
                                echo 'id="table_' . $value['id'] . '"';
                            } ?> class="form-table cmsmasters-options">
                            <?php
                        break;
                    case 'title_h3_nobutton':
                    ?>
                        <h3 <?php 
                        if (isset($value['id'])) {
                            echo 'id="head_' . $value['id'] . '"';
                        } 
                        ?>><?php echo $value['name']; ?></h3>
                        <table <?php 
                        if (isset($value['id'])) {
                            echo 'id="table_' . $value['id'] . '"';
                        } 
                        ?> class="form-table cmsmasters-options">
                        <?php
                        break;
                    case 'title_nobutton':
                    ?>
                        <table <?php 
                        if (isset($value['id'])) {
                            echo 'id="table_' . $value['id'] . '"';
                        } 
                        ?> class="form-table cmsmasters-options">
                        <?php
                        break;
                    case 'title_p_nobutton':
                    ?>
                        <p class="newline" <?php 
                        if (isset($value['id'])) {
                            echo 'id="head_' . $value['id'] . '"';
                        } 
                        ?>><?php echo $value['name']; ?></p>
                        <table <?php 
                        if (isset($value['id'])) {
                            echo 'id="table_' . $value['id'] . '"';
                        } 
                        ?> class="form-table cmsmasters-options">
                        <?php
                        break;
                    case 'close':
                    ?>
                            <tr><td style="padding:0; margin:0;"></td></tr>
                        </table>
                        <?php
                    break;
                    case 'update':
                        update_notifier_cmsms();
                        break;
                    case 'text':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input size="<?php echo $value['size']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo stripslashes(htmlspecialchars($get_options[$id])); ?>" />
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'text_show':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input size="<?php echo $value['size']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo stripslashes(htmlspecialchars($get_options[$id]));
                                } else {
                                    if (isset($value['std'])) {
                                        echo $value['std'];
                                    }
                                } 
                                ?>" />
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'password':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input size="<?php echo $value['size']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo stripslashes(htmlspecialchars($get_options[$id])); ?>" />
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'slider':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td valign="top">
                                <input size="10" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" style="text-align:center;" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo stripslashes(htmlspecialchars($get_options[$id]));
                                } else {
                                    echo $value['std'];
                                } 
                                ?>" class="fl" />
                                <div class="fl" style="padding:11px 0 0 20px;">
                                    <div id="<?php echo $value['id']; ?>_slider" style='width:160px'></div>
                                </div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        jQuery('#<?php echo $value['id']; ?>_slider').slider( {
                                            min : <?php echo $value['min']; ?>,
                                            max : <?php echo $value['max']; ?>,
                                            step : <?php echo $value['step']; ?>,
                                            <?php
                                            if ($get_options[$id] != '') {
                                                echo 'value : ' . stripslashes(htmlspecialchars($get_options[$id])) . ',';
                                            } else {
                                                echo 'value : ' . $value['std'] . ',';
                                            }
                                            ?>
                                            slide : function(event, ui) {
                                                jQuery('#<?php echo $value['id']; ?>').val(ui.value);
                                            }
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>').change(function (event) {
                                            var data = jQuery('#<?php echo $value['id']; ?>').val();
                                            
                                            if (data.length > <?php echo $value['min']; ?>) {
                                                if (parseInt(data) >= <?php echo $value['min']; ?> && parseInt(data) <= <?php echo $value['max']; ?>) {
                                                    jQuery('#<?php echo $value['id']; ?>_slider').slider('option', 'value', data);
                                                } else {
                                                    if (parseInt(data) < <?php echo $value['min']; ?>) {
                                                        jQuery('#<?php echo $value['id']; ?>').val('<?php echo $value['min']; ?>');
                                                        jQuery('#<?php echo $value['id']; ?>_slider').slider('option', 'value', '<?php echo $value['min']; ?>');
                                                    }
                                                    
                                                    if (parseInt(data) > <?php echo $value['max']; ?>) {
                                                        jQuery('#<?php echo $value['id']; ?>').val('<?php echo $value['max']; ?>');
                                                        jQuery('#<?php echo $value['id']; ?>_slider').slider('option', 'value', '<?php echo $value['max']; ?>');
                                                    }
                                                }
                                            } else { 
                                                jQuery('#<?php echo $value['id']; ?>_slider').slider('option', 'value', '<?php echo $value['min']; ?>');
                                            }
                                        } );
                                    } );
                                </script>
                            </td>
                        </tr>
                        <?php
                    break;
                    case 'spinner':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td valign="top">
                                <input size="5" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo $get_options[$id];
                                } else {
                                    echo $value['std'];
                                } 
                                ?>" />
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        jQuery('#<?php echo $value['id']; ?>').spinner( {
                                            min : <?php echo $value['min']; ?>, 
                                            max : <?php echo $value['max']; ?>, 
                                            step : <?php echo $value['step']; ?>
                                        } );
                                    } );
                                </script>
                            </td>
                        </tr>
                       <?php
                        break;
                    case 'td_open':
                    ?>
                        <tr valign="top">
                            <th align="left" id="<?php echo $value['id']; ?>">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td valign="top">
                        <?php
                        break;
                    case 'td_close':
                    ?>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'td_spinner':
                    ?>
                        <div class="td_spinner">
                            <div style="padding:0 0 3px 5px;"><?php echo $value['name']; ?></div>
                            <div>
                                <input size="5" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo $get_options[$id];
                                } else {
                                    echo $value['std'];
                                } 
                                ?>" />
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        jQuery('#<?php echo $value['id']; ?>').spinner( {
                                            min:<?php echo $value['min']; ?>, 
                                            max:<?php echo $value['max']; ?>, 
                                            step:<?php echo $value['step']; ?>
                                        } );
                                    } );
                                </script>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'color':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td valign="top" style="padding-top:26px;">
                                <input size="10" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="color" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo $get_options[$id];
                                } else {
                                    echo $value['std'];
                                } 
                                ?>" class="data_hex_color" style="background-position:repeat; float:left; margin-top:-6px;" data-hex="true" />
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'color_choose':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td valign="top">
                                <div class="colrs" id="<?php echo $value['id']; ?>_colrs">
                                <?php
                                foreach ($value['options'] as $option) {
                                    if ($get_options[$id] != '') {
                                        if (strstr($get_options[$id], $option) != false) {
                                            $selected = ' class="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                    } else {
                                        if ($value['std'] == $option) {
                                            $selected = ' class="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                    }

                                    if ($option != '') {
                                        echo "<a$selected href='" . $option . "' style='background-color:" . $option . ";'>&nbsp;</a>";
                                    }
                                }
                                ?>
                                </div>
                                <input size="10" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="color" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo $get_options[$id];
                                } else {
                                    echo $value['std'];
                                } 
                                ?>" class="data_hex_color" style="background-position:repeat; float:left; margin-top:-6px;" data-hex="true" />
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'textarea':
                    ?>
                        <tr valign="top">
                            <th>
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <textarea id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" cols="55" rows="5"><?php 
                                if ($get_options[$id] != "") {
                                    echo stripslashes($get_options[$id]);
                                } else {
                                    if (isset($value['std'])) {
                                        echo $value['std'];
                                    }
                                } 
                                ?></textarea>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'background':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td valign="top" style="padding-bottom:0;">
                                <div class="select_bgs" id="<?php echo $value['id']; ?>_patterns_bgs">
                                    <span class="fl" style="display:block; width:140px; padding:5px 0 0;"><?php _e('Patterns', 'cmsmasters'); ?></span>
                                    <?php
                                    foreach ($value['options'] as $option) {
                                        if ($option->bg_type == 'bg_t') {
                                            if ($get_options[$id] != '') {
                                                $opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $get_options[$id]);
                                                
                                                if (strstr($opt_id, $option->bg_url) != false) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            } else {
                                                if (str_replace(get_template_directory_uri() . '/images/bgs/', '', $value['std']) == $option->bg_url) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            }
                                            
                                            if ($option->bg_url != '') {
                                                echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");'>&nbsp;</a>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="select_bgs" id="<?php echo $value['id']; ?>_transparents_bgs">
                                    <span class="fl" style="display:block; width:140px; padding:5px 0 0;"><?php _e('Transparent Images', 'cmsmasters'); ?></span>
                                    <?php
                                    foreach ($value['options'] as $option) {
                                        if ($option->bg_type == 'bg_t_i') {
                                            if ($get_options[$id] != '') {
                                                $opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $get_options[$id]);
                                                
                                                if (strstr($opt_id, $option->bg_url) != false) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            } else {
                                                if (str_replace(get_template_directory_uri() . '/images/bgs/', '', $value['std']) == $option->bg_url) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            }
                                            
                                            if ($option->bg_url != '') {
                                                echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");'>&nbsp;</a>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="select_bgs" id="<?php echo $value['id']; ?>_images_bgs">
                                    <span class="fl" style="display:block; width:140px; padding:5px 0 0;"><?php _e('Background Images', 'cmsmasters'); ?></span>
                                    <?php
                                    foreach ($value['options'] as $option) {
                                        if ($option->bg_type == 'bg_i') {
                                            if ($get_options[$id] != '') {
                                                $opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $get_options[$id]);
                                                
                                                if (strstr($opt_id, $option->bg_url) != false) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            } else {
                                                if (str_replace(get_template_directory_uri() . '/images/bgs/', '', $value['std']) == $option->bg_url) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            }
                                            
                                            if ($option->bg_url != '') {
                                                echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");'>&nbsp;</a>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <input type="hidden" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo stripslashes($get_options[$id]);
                                } else {
                                    echo $value['std'];
                                } ?>" />
                                <br /><br />
                            </td>
                        </tr>
                        <?php
                        break;
                        case 'upload':
                        ?>
                            <tr valign="top">
                                <th align="left">
                                    <span class="label"><?php echo $value['name']; ?></span>
                                    <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                    <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                </th>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <input size="<?php echo $value['size']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php 
                                    if (isset($get_options[$id]) && $get_options[$id] != '') {
                                        echo stripslashes(htmlspecialchars($get_options[$id]));
                                    } else {
                                        if (isset($value['std'])) {
                                            echo $value['std'];
                                        }
                                    } 
                                    ?>" class="fl" />
                                    <input type="button" name="imageupload" value="<?php _e('Upload', 'cmsmasters'); ?>" id="<?php echo $value['id']; ?>_upload" class="fl" />
                                    <div style="margin:8px 0 0 8px; float:left; display:none;">
                                        <img id="<?php echo $value['id']; ?>_loading" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div id="<?php echo $value['id']; ?>_image">
                                        <?php 
                                        if ($get_options[$id] != '') {
                                            echo '<img src="' . stripslashes(htmlspecialchars($get_options[$id])) . '" style="max-width:400px; margin:10px 0 0 3px;" alt="" />';
                                        } 
                                        ?>
                                        <div<?php if ($get_options[$id] == '') { 
                                            ?> style="display:none;"<?php 
                                        } ?>>
                                            <br />
                                            <a href="#" id="<?php echo $value['id']; ?>_clear"><?php _e('Reset', 'cmsmasters'); ?> [X]</a>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            var btnUpload = jQuery('#<?php echo $value['id']; ?>_upload');
                                            var status = jQuery('#<?php echo $value['id']; ?>_loading');
                                            
                                            new AjaxUpload(btnUpload, {
                                                action : '<?php echo get_template_directory_uri(); ?>/theme/functions/upload.php',
                                                name : 'uploadfile',
                                                data : { url : '../../images/theme_icons/' },
                                                onSubmit : function (file, ext) {
                                                    if (!(ext && /^(jpg|png|jpeg|ico|gif)$/.test(ext))) { 
                                                        alert('<?php _e('Only JPG, PNG, ICO or GIF files are allowed', 'cmsmasters'); ?>');
                                                        
                                                        return false;
                                                    }
                                                    
                                                    status.parent().fadeIn();
                                                },
                                                onComplete : function (file, response) {
                                                    status.parent().fadeOut();
                                                    
                                                    if ( response !== 'error') {
                                                        jQuery('#<?php echo $value['id']; ?>').val('<?php echo get_template_directory_uri(); ?>/images/theme_icons/' + response);
                                                        
                                                        if (jQuery('#<?php echo $value['id']; ?>_image').find('img').length > 0) {
                                                            jQuery('#<?php echo $value['id']; ?>_image img').attr( { src : '<?php echo get_template_directory_uri(); ?>/images/theme_icons/' + response } );
                                                        } else {
                                                            jQuery('#<?php echo $value['id']; ?>_image').prepend('<img src="<?php echo get_template_directory_uri(); ?>/images/theme_icons/' + response + '" alt="" />');
                                                        }
                                                        
                                                        jQuery('#<?php echo $value['id']; ?>_image img').css('margin', '10px 0 0 3px');
                                                        jQuery('#<?php echo $value['id']; ?>_image img').fadeIn();
                                                        jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeIn();
                                                    } else {
                                                        alert('<?php _e('File', 'cmsmasters'); ?> ' + file + ' <?php _e('do not load...', 'cmsmasters'); ?> ');
                                                    }
                                                }
                                            } );
                                            
                                            jQuery('#<?php echo $value['id']; ?>_clear').click(function () {
                                                jQuery('#<?php echo $value['id']; ?>').val('');
                                                jQuery('#<?php echo $value['id']; ?>_image img').fadeOut();
                                                jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeOut();
                                                jQuery('#<?php echo $value['id']; ?>_image img').css('margin', '0');
                                                
                                                return false;
                                            } );
                                        } );
                                    </script>
                                </td>
                            </tr>
                            <?php
                            break;
                        case 'upload_background':
                        ?>
                            <tr valign="top">
                                <th align="left">
                                    <span class="label"><?php echo $value['name']; ?></span>
                                    <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                    <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                </th>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <input size="<?php echo $value['size']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php 
                                    if ($get_options[$id] != "") {
                                        echo stripslashes(htmlspecialchars($get_options[$id]));
                                    } else {
                                        echo $value['std'];
                                    } 
                                    ?>" class="fl" />
                                    <input type="button" name="imageupload" value="<?php _e('Upload', 'cmsmasters'); ?>" id="<?php echo $value['id']; ?>_upload" class="fl" />
                                    <div style="margin:8px 0 0 8px; float:left; display:none;">
                                        <img id="<?php echo $value['id']; ?>_loading" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div id="<?php echo $value['id']; ?>_image"<?php if ($get_options[$id] != '') { 
                                        ?> style="width:400px; height:250px; <?php 
                                        if ($get_options[$id] != '') { 
                                            ?> margin:10px 0;<?php 
                                        } ?> background:url(<?php echo stripslashes(htmlspecialchars($get_options[$id])); ?>) top center no-repeat;"<?php 
                                    } ?>></div>
                                    <div<?php if ($get_options[$id] == '') { 
                                        ?> style="display:none;"<?php 
                                    } ?>>
                                        <a href="#" id="<?php echo $value['id']; ?>_clear" style="padding-top:15px;"><?php _e('Reset', 'cmsmasters'); ?> [X]</a>
                                    </div>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            var btnUpload = jQuery('#<?php echo $value['id']; ?>_upload');
                                            var status = jQuery('#<?php echo $value['id']; ?>_loading');
                                            
                                            new AjaxUpload(btnUpload, {
                                                action : '<?php echo get_template_directory_uri(); ?>/theme/functions/upload.php',
                                                name : 'uploadfile',
                                                data : { url : '../../images/bgs/' },
                                                onSubmit : function(file, ext){
                                                    if (!(ext && /^(jpg|png|jpeg|ico|gif)$/.test(ext))) {
                                                        alert('<?php _e('Only JPG, PNG, ICO or GIF files are allowed', 'cmsmasters'); ?>');
                                                        
                                                        return false;
                                                    }
                                                    
                                                    status.parent().fadeIn();
                                                },
                                                onComplete : function (file, response) {
                                                    status.parent().fadeOut();
                                                    
                                                    if (response !== 'error') {
                                                        jQuery('#<?php echo $value['id']; ?>').val('<?php echo get_template_directory_uri(); ?>/images/bgs/' + response);
                                                        jQuery('#<?php echo $value['id']; ?>_image').css( { 
															background : 'url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + response + ') top center no-repeat', 
															width : '400px', 
															height : '250px', 
															margin : '10px 0' 
														} );
                                                        
                                                        if (jQuery('input#custom_background_show:checked').attr('id') === 'custom_background_show') {
                                                            jQuery('#<?php echo $value['id']; ?>_image').fadeIn();
                                                        }
                                                        
                                                        jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeIn();
                                                    } else {
                                                        alert('<?php _e('File', 'cmsmasters'); ?> ' + file + ' <?php _e('do not load...', 'cmsmasters'); ?> ')
                                                    }
                                                }
                                            } );
                                            
                                            jQuery('#<?php echo $value['id']; ?>_clear').click(function () {
                                                jQuery('#<?php echo $value['id']; ?>').val('');
                                                jQuery('#<?php echo $value['id']; ?>_image').fadeOut();
                                                jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeOut();
                                                jQuery('#<?php echo $value['id']; ?>_image').css('margin', '0');
                                                
                                                return false;
                                            } );
                                        } );
                                    </script>
                                </td>
                            </tr>
                            <?php
                            break;
                        case 'checkbox':
                        ?>
                            <tr>
                                <th align="left">
                                    <span class="label"><?php echo $value['name']; ?></span>
                                    <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                    <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                </th>
                            </tr>
                            <tr>
                                <td valign="top" class="check_parent">
									<div class="cl">
										<?php 
										if ((!$get_options && isset($value['std']) && $value['std'] == 'true') || ($get_options && $get_options[$id] && $get_options[$id] == 'true')) {
											$checked = ' checked="checked"';
										} else {
											$checked = '';
										} 
										?>
										<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true"<?php echo $checked; ?> />
										<label for="<?php echo $value['id']; ?>">
											<span class="labelon"><?php echo $value['labelon']; ?></span>
											<span class="fl">&nbsp;/&nbsp;</span>
											<span class="labeloff"><?php echo $value['labeloff']; ?></span>
										</label>
									</div>
                                </td>
                            </tr>
                            <?php
                            break;
                        case 'buttons':
                        ?>
                            <tr>
                                <th valign="top">
                                    <input type="button" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php echo $value['name']; ?>" style="display:block; float:left; height:30px; margin:0 10px 0 0;" title="<?php echo $value['value']; ?>" onClick="self.location.href=this.title;" />
                                    <input type="button" name="<?php echo $value['id']; ?>_2" id="<?php echo $value['id']; ?>_2" value="<?php echo $value['name2']; ?>" style="display:block; float:left; height:30px; margin:0 10px 0 0;" title="<?php echo $value['value2']; ?>" onClick="self.location.href=this.title;" />
                                    <input type="button" name="<?php echo $value['id']; ?>_3" id="<?php echo $value['id']; ?>_3" value="<?php echo $value['name3']; ?>" style="display:block; float:left; height:30px; margin:0 10px 0 0;" title="<?php echo $value['value3']; ?>" onClick="self.location.href=this.title;" />
                                </th>
                            </tr>
                            <?php
                            break;
                        case 'button':
                        ?>
                            <tr>
                                <th valign="top">
                                    <input type="button" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php echo $value['name']; ?>" style="<?php 
                                    if ($value['width']) {
                                        echo ' width:' . $value['width'] . 'px;';
                                    } else {
                                        echo ' width:auto;';
                                    } 
                                    ?> float:left; height:30px; margin-left:0;" title="<?php echo $value['value']; ?>" onClick="self.location.href=this.title;" />
                                    <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light" style="margin:5px 0 0 10px;"></a>
                                    <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                    <?php if (isset($value['margin']) && $value['margin'] == 'true') {
                                        echo '<br /><br /><br />';
                                    } ?>
                                </th>
                            </tr>
                            <?php
                            break;
                        case 'button_normal':
                        ?>
                            <tr>
                                <th align="left">
                                    <span class="label"><?php echo $value['name']; ?></span>
                                    <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                    <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                </th>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <input type="button" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php echo $value['value']; ?>" style="height:30px; margin-left:0;" />
                                </td>
                            </tr>
                            <?php
                            break;
                        case 'button_import':
                        ?>
                            <tr>
                                <th valign="top">
                                    <input type="button" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php echo $value['name']; ?>" style="<?php 
                                    if ($value['width']) {
                                        echo ' width:' . $value['width'] . 'px;';
                                    } else {
                                        echo ' width:auto;';
                                    } 
                                    ?> float:left; height:30px; margin-left:0;" title="<?php echo $value['value']; ?>" />
                                    <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light" style="margin:5px 0 0 10px;"></a>
                                    <div style="margin:7px 0 0 15px; float:left; display:none;">
                                        <img id="<?php echo $value['id']; ?>_loading" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                    </div>
                                    <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                    <?php if ($value['margin'] == 'true') {
                                        echo '<br /><br /><br />';
                                    } ?>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            jQuery('input#<?php echo $value['id']; ?>').click(function () {
                                                jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeIn('fast');
                                                
                                                jQuery.post('<?php echo get_template_directory_uri() . '/theme/functions/import.php'; ?>', { active : 'true' }
                                                ).error(function () {
                                                    alert('<?php _e('Error! Demo content not import.', 'cmsmasters'); ?>');
                                                } ).complete(function () {
                                                    jQuery('html, body').animate( { scrollTop : 0 }, 'slow');
                                                    jQuery('#settings_import').slideDown('fast').delay(5000).slideUp('slow');
                                                    jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeOut('fast');
                                                    
                                                    return false; 
                                                } );
                                                
                                                return false;
                                            } );
                                        } );
                                    </script>
                                    <p style="color:#dd0000;"><?php _e('Warning: By importing Demo Content you make changes in your Database!', 'cmsmasters'); ?></p>
                                </th>
                            </tr>
                            <?php
                            break;
                        case 'select':
                        ?>
                            <tr>
                                <th align="left">
                                    <span class="label"><?php echo $value['name']; ?></span>
                                    <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                    <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <select style="width:270px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                                        <?php
                                        foreach ($value['options'] as $option) {
                                            if ($get_options[$id] == $option) {
                                                $selected = ' selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                            
                                            $optionval = str_replace(' ', '_', strtolower($option));
                                            
                                            echo "<option$selected value='" . $optionval . "'>" . $option . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <?php
                            break;
                    case 'select_font':
                    ?>
                        <tr>
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <select style="width:270px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                                <?php
                                $contentout = $googleout = $allout = '';
                                
                                foreach ($value['options'] as $option) {
                                    if ($option->font_type == 'content') {
                                        if (stripslashes($get_options[$id]) == $option->font_parameter) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                            
                                            if ($value['std'] == $option->font_parameter && !$get_options[$id]) {
                                                $selected = ' selected="selected"';
                                            }
                                        }
                                        
                                        $contentout .= '<option' . $selected . ' value="' . $option->font_parameter . '">' . $option->font_name . '</option>';
                                    }
                                }
                                
                                $allout = '<optgroup label="' . __('Content Fonts', 'cmsmasters') . '">' . $contentout . '</optgroup>';
                                
                                foreach ($value['options'] as $option) {
                                    if ($option->font_type == 'heading') {
                                        if (stripslashes($get_options[$id]) == $option->font_parameter) {
                                            $selected = ' selected="selected"';
                                        } else {
                                            $selected = '';
                                            
                                            if ($value['std'] == $option->font_parameter && !$get_options[$id]) {
                                                $selected = ' selected="selected"';
                                            }
                                        }
                                        
                                        $googleout .= '<option ' . $selected . ' value="' . $option->font_parameter . '">' . $option->font_name . '</option>';
                                    }
                                }
                                
                                echo $allout . '<optgroup label="' . __('Google Fonts', 'cmsmasters') . '">' . $googleout . '</optgroup>';
                                ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'radio':
                    ?>
                        <tr>
                            <th valign="top">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['help']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td class="check_parent" style="padding-bottom:10px;">
                                <div>
                                    <div class="cl">
                                        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="<?php echo $value['value']; ?>"<?php
                                        echo $selector;
                                        
                                        if ($get_options[$id] == $value['value'] || $get_options[$id] == '') {
                                            echo ' checked="checked"';
                                        }
                                        ?> />
                                        <label for="<?php echo $value['id']; ?>"> <?php echo $value['desc']; ?></label>
                                    </div>
                                    <div class="cl">
                                        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>_2" type="radio" value="<?php echo $value['value2']; ?>"<?php 
                                        echo $selector;
                                        
                                        if ($get_options[$id] == $value['value2']) {
                                            echo ' checked="checked"';
                                        } 
                                        ?> />
                                        <label for="<?php echo $value['id']; ?>_2"> <?php echo $value['desc2']; ?></label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'radio_multiple':
                    ?>
                        <tr>
                            <th valign="top">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['help']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td class="check_parent" style="padding-bottom:10px;">
                                <div>
                                <?php
                                $i = 0;
                                
                                foreach ($value['options'] as $option) {
                                    if ($get_options[$id] != '') {
                                        if ($get_options[$id] == $option) {
                                            $checked = ' checked="checked"';
                                        } else {
                                            $checked = '';
                                        }
                                    } else {
                                        if ($value['std'] == $option) {
                                            $checked = ' checked="checked"';
                                        } else {
                                            $checked = '';
                                        }
                                    }
                                    
                                    $label = $value['labels'][$i];
                                    
                                    echo '<div class="cl">' . 
                                        '<input name="' . $value['id'] . '" id="' . $value['id'] . '_' . $i . '" type="radio" value="' . $option . '"' . $checked . ' />' . 
                                        '<label for="' . $value['id'] . '_' . $i . '"> ' . $label . '</label>' . 
                                    '</div>';
                                    
                                    $i++;
                                }
                                ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'include_type':
                    ?>
                        <tr>
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <ul class="check_container" id="list_<?php echo $value['id']; ?>">
                                <?php
                                foreach ($value['options'] as $option) {
                                    if ($get_options[$id] != '') {
                                        if (strstr($get_options[$id], $option) != false) {
                                            $selected = ' class="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                    } else {
                                        $selected = ' class="selected"';
                                    }
                                    
                                    if ($option != '') {
                                        echo "<li$selected>" . 
											"<a href='" . $option . "'>" . 
												"<img src='" . get_template_directory_uri() . "/images/share_icons/" . $option . ".png' alt='" . $option . "' />" . 
												$option . 
											"</a>" . 
										"</li>";
                                    }
                                }
                                ?>
                                </ul>
                                <input type="hidden" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo $get_options[$id];
                                } else {
                                    echo $value['std'];
                                } 
                                ?>" />
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'include_type_add':
                    ?>
                            <tr>
                                <th align="left">
                                    <span class="label"><?php echo $value['name']; ?></span>
                                    <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                    <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                </th>
                            </tr>
                            <tr>
                                <td style="padding-bottom:0;">
                                    <ul class="include_container" id="list_<?php echo $value['id']; ?>">
                                    <?php
                                    foreach ($value['options'] as $option) {
                                        if ($get_options[$id] != '') {
                                            if (strstr($get_options[$id], $option->icon_name) != false) {
                                                $selected = ' class="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                        } else {
                                            if (strstr($value['std'], $option->icon_name) != false) {
                                                $selected = ' class="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                        }

                                        if ($option->icon_name != '') {
                                            echo "<li$selected>" . 
												"<span class='include'>" . 
													"<a href='" . $option->icon_name . "'>" . 
														"<img src='" . get_template_directory_uri() . "/images/social_icons/" . $option->icon_file . "' alt='" . $option->icon_name . "' />" . 
														$option->icon_tooltip . 
													"</a>" . 
												"</span>" . 
												"<span class='sharedel'>" . 
													"<a href='#'>" . __('Delete', 'cmsmasters') . "</a>" . 
												"</span>" . 
											"</li>";
                                        }
                                    }
                                    ?>
                                    </ul>
                                    <input type="hidden" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php 
                                    if ($get_options[$id] != '') {
                                        echo $get_options[$id];
                                    } else {
                                        echo $value['std'];
                                    } 
                                    ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0; margin:0;"></td>
                            </tr>
                        </table>
                        <div class="submit cmsmasters-submit" style="float:right; padding-top:27px;">
                            <input type="submit" name="save" value="<?php _e('Save Changes', 'cmsmasters'); ?>" />
                            <div class="fl" style="margin:7px 10px 0 0;">
                                <img class="submit_loader" style="display:none;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                            </div>
                        </div>
                        <h3><?php _e('Add New Social Icon', 'cmsmasters'); ?></h3>
                        <table class="form-table cmsmasters-options">
                            <tr>
                                <th align="left">
                                    <span class="label"><?php _e('Upload Icon', 'cmsmasters'); ?></span>
                                </th>
                            </tr>
                            <tr>
                                <td valign="top" style="padding-bottom:0;">
                                    <input size="36" name="<?php echo $value['id']; ?>_file" id="<?php echo $value['id']; ?>_file" type="text" value="" class="fl" />
                                    <input type="button" name="imageupload" value="<?php _e('Upload', 'cmsmasters'); ?>" id="<?php echo $value['id']; ?>_upload" class="fl" />
                                    <div style="margin:8px 0 0 8px; float:left; display:none;">
                                        <img id="<?php echo $value['id']; ?>_loading" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                    </div>
                                    <div style="clear:both;"></div>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            var btnUpload = jQuery('#<?php echo $value['id']; ?>_upload'), 
												status = jQuery('#<?php echo $value['id']; ?>_loading');
                                            
                                            new AjaxUpload(btnUpload, {
                                                action : '<?php echo get_template_directory_uri(); ?>/theme/functions/upload.php',
                                                name : 'uploadfile',
                                                data : { url : '../../images/social_icons/' },
                                                onSubmit : function (file, ext) {
                                                    if (!(ext && /^(jpg|png|jpeg|ico|gif)$/.test(ext))) { 
                                                        alert('<?php _e('Only JPG, PNG, ICO or GIF files are allowed', 'cmsmasters'); ?>');
                                                        
                                                        return false;
                                                    }
                                                    
                                                    status.parent().fadeOut('fast', function () {
                                                        status.attr( { src : '<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif' } );
                                                    });
                                                    
                                                    status.parent().fadeIn();
                                                },
                                                onComplete : function (file, response) {
                                                    if (response !== 'error') {
                                                        jQuery('#<?php echo $value['id']; ?>_file').val('<?php echo get_template_directory_uri(); ?>/images/social_icons/' + response);
                                                        jQuery('#<?php echo $value['id']; ?>_file').attr( { title : response } );
                                                        
                                                        status.parent().fadeOut('fast', function () {
                                                            status.attr( { src : '<?php echo get_template_directory_uri(); ?>/images/social_icons/' + response } );
                                                        } );
                                                        
                                                        status.parent().fadeIn();
                                                    } else {
                                                        alert('<?php _e('File', 'cmsmasters'); ?> ' + file + ' <?php _e('do not load...', 'cmsmasters'); ?> ');
                                                    }
                                                }
                                            } );
                                            
                                            jQuery('#list_<?php echo $value['id']; ?> .sharedel a').live('click', function () {
                                                if (jQuery(this).parent().parent().is('.selected')) {
                                                    alert('You need unselect icon before deleting.');
                                                } else {
                                                    jQuery(this).addClass('activedel');
                                                    
                                                    if (confirm('<?php _e('Do you realy want to delete this icon from social icons list?', 'cmsmasters'); ?>')) {
                                                        jQuery.ajax( {
                                                            type : 'post',
                                                            url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php',
                                                            data : ( { type : 'icon', option : 'delete', iconname : jQuery(this).parent().parent().find('span.include').find('a').attr('href') } ),
                                                            complete : function (data) {
                                                                if (data.responseText !== 'error'){
                                                                    jQuery('#list_<?php echo $value['id']; ?> a.activedel').parent().parent().fadeOut('slow', function () {
                                                                        jQuery(this).remove();
                                                                    } );
                                                                } else {
                                                                    jQuery('#list_<?php echo $value['id']; ?> a.activedel').removeClass('activedel');
                                                                    
                                                                    alert('<?php _e('Icon was not removed', 'cmsmasters'); ?>...');
                                                                }
                                                            }
                                                        } );
                                                    } else {
                                                        jQuery(this).removeClass('activedel');
                                                    }
                                                }
                                                
                                                return false;
                                            } );
                                            
                                            jQuery('#<?php echo $value['id']; ?>_addicon').click(function () {
                                                if (jQuery('#<?php echo $value['id']; ?>_file').val() !== '' && jQuery('#<?php echo $value['id']; ?>_tooltip').val() !== '') {
                                                    if (jQuery('#<?php echo $value['id']; ?>_link').val() === ''){
                                                        jQuery('#<?php echo $value['id']; ?>_link').val('#');
                                                    }
                                                    
                                                    var newiconname = jQuery('#<?php echo $value['id']; ?>_tooltip').val();
                                                    var newiconlink = jQuery('#<?php echo $value['id']; ?>_link').val();
                                                    var newiconfile = jQuery('#<?php echo $value['id']; ?>_file').val().replace('<?php echo get_template_directory_uri(); ?>/images/social_icons/', '');
                                                    var newicon = newiconfile.replace('.png', '');
                                                    
                                                    newicon = newicon.replace('.jpg', '');
                                                    newicon = newicon.replace('.jpeg', '');
                                                    newicon = newicon.replace('.gif', '');
                                                    
                                                    jQuery.ajax( { 
                                                        type : 'post', 
                                                        url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php', 
                                                        data : ( { 
															type : 'icon', 
															option : 'add', 
															icon : newicon, 
															iconfile : newiconfile, 
															icontooltip : newiconname, 
															iconlink : newiconlink 
														} ), 
                                                        complete : function (data) { 
                                                            if (data.responseText !== 'error' && data.responseText !== 'warning') { 
                                                                jQuery('#list_<?php echo $value['id']; ?>').append('<li class="iconadded" style="display:none;">' + 
																	'<span class="include">' + 
																		'<a href="' + newicon + '">' + 
																			'<img src="<?php echo get_template_directory_uri(); ?>/images/social_icons/' + newiconfile + '" alt="' + newicon + '" />' + 
																			newiconname + 
																		'</a>' + 
																	'</span>' + 
																	'<span class="sharedel">' + 
																		'<a href="#"><?php _e('Delete', 'cmsmasters'); ?></a>' + 
																	'</span>' + 
																'</li>');
                                                                jQuery('.include_links_container').append('<div class="include_links">' + 
																	'<input type="text" id="iconlink_' + newicon + '" name="iconlink_' + newicon + '" value="' + newiconlink + '" size="50" style="padding-right:30px;" />' + 
																	'<a href="#">&nbsp;</a>' + 
																	'<span>' + newiconname + '</span>' + 
																'</div>');
                                                                jQuery('#<?php echo $value['id']; ?>_tooltip').val('');
                                                                jQuery('#<?php echo $value['id']; ?>_link').val('');
                                                                jQuery('#<?php echo $value['id']; ?>_file').val('');
                                                                
                                                                jQuery('#list_<?php echo $value['id']; ?> .iconadded').fadeIn('slow', function () {
                                                                    jQuery(this).removeClass('iconadded');
                                                                });
                                                            } else if (data.responseText === 'warning'){
                                                                alert('<?php _e('This icon already exists', 'cmsmasters'); ?>...');
                                                            } else {
                                                                alert('<?php _e('Icon was not added', 'cmsmasters'); ?>...');
                                                            }
                                                        }
                                                    } );
                                                } else {
                                                    alert('<?php _e('Upload icon file and enter tooltip!', 'cmsmasters'); ?>');
                                                }
                                                
                                                return false;
                                            } );
                                            
                                            jQuery('.include_links a').live('click', function () {
                                                var newicon = jQuery(this).parent().find('input').attr('name').replace('iconlink_', ''), 
													newiconlink = jQuery(this).parent().find('input').val();
                                                
                                                jQuery(this).fadeOut('fast', function () {
                                                    jQuery(this).css( { background : 'url(<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif) 2px 2px no-repeat'}).fadeIn('fast', function () {
                                                        jQuery.ajax( {
                                                            type : 'post',
                                                            url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php',
                                                            data : ( { type : 'icon', option : 'update', icon : newicon, iconlink : newiconlink } ),
                                                            complete : function (data) {
                                                                if (data.responseText !== 'error' && data.responseText !== 'warning') {
                                                                    jQuery('#iconlink_' + newicon).parent().find('a').fadeOut('fast', function () {
                                                                        jQuery(this).css( { background : '' } ).fadeIn('fast');
                                                                    } );
                                                                } else if (data.responseText === 'warning'){
                                                                    alert('<?php _e('There is no such icon!', 'cmsmasters'); ?>');
                                                                    
                                                                    jQuery('#iconlink_' + newicon).parent().find('a').fadeOut('fast', function () {
                                                                        jQuery(this).css( { background : '' } ).fadeIn('fast');
                                                                    } );
                                                                } else {
                                                                    alert('<?php _e('Link was not updated', 'cmsmasters'); ?>...');
                                                                    
                                                                    jQuery('#iconlink_' + newicon).parent().find('a').fadeOut('fast', function () {
                                                                        jQuery(this).css( { background : '' } ).fadeIn('fast');
                                                                    } );
                                                                }
                                                            }
                                                        } );
                                                    } )
                                                } );
                                                
                                                return false;
                                            } );
                                        } );
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <th align="left"><span class="label"><?php _e('Enter Tooltip Text', 'cmsmasters'); ?></span></th>
                            </tr>
                            <tr>
                                <td style="padding-bottom:0;">
                                    <input size="50" name="<?php echo $value['id']; ?>_tooltip" id="<?php echo $value['id']; ?>_tooltip" type="text" value="" />
                                </td>
                            </tr>
                            <tr>
                                <th align="left">
                                    <span class="label"><?php _e('Enter Icon Link', 'cmsmasters'); ?></span>
                                </th>
                            </tr>
                            <tr>
                                <td style="padding-bottom:0;">
                                    <input size="50" name="<?php echo $value['id']; ?>_link" id="<?php echo $value['id']; ?>_link" type="text" value="" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input name="<?php echo $value['id']; ?>_addicon" id="<?php echo $value['id']; ?>_addicon" type="button" value="<?php _e('Add Icon', 'cmsmasters'); ?>" style="height:30px; margin-left:0;" />
                                </td>
                            </tr>
                            <?php if ($get_options[$id] != '' || $value['std'] != '') { ?>
                                <tr>
                                    <td style="padding:0; margin:0;"></td>
                                </tr>
                            </table>
                            <div class="submit cmsmasters-submit" style="float:right; padding-top:27px;">
                                <input type="submit" name="save" value="<?php _e('Save Changes', 'cmsmasters'); ?>" />
                                <div class="fl" style="margin:7px 10px 0 0;">
                                    <img class="submit_loader" style="display:none;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                </div>
                            </div>
                            <h3><?php _e('Social Icons Links', 'cmsmasters'); ?></h3>
                            <table class="form-table cmsmasters-options">
                                <tr>
                                    <td class="include_links_container" style="padding-bottom:0;">
                                    <?php
                                    foreach ($value['options'] as $option) {
                                        if ($get_options[$id] != '') {
                                            if (strstr($get_options[$id], $option->icon_name) != false) {
                                                $selected = ' selected';
                                            } else {
                                                $selected = '';
                                            }
                                        } else {
                                            if (strstr($value['std'], $option->icon_name) != false) {
                                                $selected = ' selected';
                                            } else {
                                                $selected = '';
                                            }
                                        }
                                        
                                        if ($option->icon_name != '') {
                                            echo "<div class='include_links$selected'>" . 
												"<input type='text' size='50' name='iconlink_" . $option->icon_name . "' value='" . $option->icon_link . "' id='iconlink_" . $option->icon_name . "' style='padding-right:30px;' />" . 
												"<a href='#'>&nbsp;</a>" . 
												"<span>" . $option->icon_tooltip . "</span>" . 
											"</div>";
                                        }
                                    }
                                    ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        break;
                    case 'font_add':
                    ?>
                        <tr>
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                                <a id="<?php echo $value['id']; ?>_cancelfont" href="#" style="display:none; float:left; margin:2px 0 0 40px;"><?php _e('Cancel', 'cmsmasters'); ?></a>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <select style="width:270px;" name="<?php echo $value['id']; ?>_selectfont" id="<?php echo $value['id']; ?>_selectfont">
                                    <option value="" style="font-style:italic; font-weight:bold;"><?php _e('Select Font For Editing', 'cmsmasters'); ?></option>
                                    <?php
                                    $contentout = $googleout = $allout = '';
                                    
                                    foreach ($value['options'] as $option) {
                                        if ($option->font_type == 'content') {
                                            if (stripslashes($get_options[$id]) == $option->font_parameter) {
                                                $selected = ' selected="selected"';
                                            } else {
                                                $selected = '';
                                                
                                                if ($value['std'] == $option->font_parameter && !$get_options[$id]) {
                                                    $selected = ' selected="selected"';
                                                }
                                            }
                                            
                                            $contentout .= '<option' . $selected . ' value="' . $option->font_parameter . '">' . $option->font_name . '</option>';
                                        }
                                    }
                                    
                                    $allout = '<optgroup label="' . __('Google Fonts', 'cmsmasters') . '">' . $contentout . '</optgroup>';
                                    
                                    foreach ($value['options'] as $option) {
                                        if ($option->font_type == 'heading') {
                                            if (stripslashes($get_options[$id]) == $option->font_parameter) {
                                                $selected = ' selected="selected"';
                                            } else {
                                                $selected = '';
                                                
                                                if ($value['std'] == $option->font_parameter && !$get_options[$id]) {
                                                    $selected = ' selected="selected"';
                                                }
                                            }
                                            
                                            $googleout .= '<option' . $selected . ' value="' . $option->font_parameter . '">' . $option->font_name . '</option>';
                                        }
                                    }
                                    
                                    echo $allout . '<optgroup label="' . __('Google Fonts', 'cmsmasters') . '">' . $googleout . '</optgroup>';
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">
                                <span class="label"><?php _e('Enter Google Font Name', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <input size="46" name="<?php echo $value['id']; ?>_name" id="<?php echo $value['id']; ?>_name" type="text" value="" />
                            </td>
                        </tr>
                        <tr>
                            <th align="left">
                                <span class="label"><?php _e('Enter Google Font API Parameter Name', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <input size="46" name="<?php echo $value['id']; ?>_parameter" id="<?php echo $value['id']; ?>_parameter" type="text" value="" />
                            </td>
                        </tr>
                        <tr>
                            <th align="left">
                                <span class="label"><?php _e('Choose Font Type (Advanced)', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <select name="<?php echo $value['id']; ?>_type" id="<?php echo $value['id']; ?>_type" style="width:270px;">
                                    <option value="heading"><?php _e('Heading', 'cmsmasters'); ?></option>
                                    <option value="content"><?php _e('Content', 'cmsmasters'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="position:relative;">
                                    <div style="display:none; position:absolute; top:7px; left:280px;">
                                        <img id="<?php echo $value['id']; ?>_loading" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                    </div>
                                    <input name="<?php echo $value['id']; ?>_addfont" id="<?php echo $value['id']; ?>_addfont" type="button" value="<?php _e('Add Font', 'cmsmasters'); ?>" style="float:left; height:30px; width:90px; margin-left:0;" />
                                    <input name="<?php echo $value['id']; ?>_updatefont" id="<?php echo $value['id']; ?>_updatefont" type="button" value="<?php _e('Update Font', 'cmsmasters'); ?>" style="display:none; float:left; height:30px; width:90px; margin-left:0;" />
                                    <input name="<?php echo $value['id']; ?>_deletefont" id="<?php echo $value['id']; ?>_deletefont" type="button" value="<?php _e('Delete Font', 'cmsmasters'); ?>" style="display:none; float:left; height:30px; width:90px; margin-left:90px;" />
                                </div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        function stripslashes(str) {
                                            str = str.replace(/\\'/g, '\'');
                                            str = str.replace(/\\"/g, '"');
                                            str = str.replace(/\\0/g, '\0');
                                            str = str.replace(/\\\\/g, '\\');
                                            
                                            return str;
                                        }
                                        
                                        jQuery('#<?php echo $value['id']; ?>_selectfont').change(function () {
                                            if (jQuery('#<?php echo $value['id']; ?>_selectfont option:selected').val() !== '') {
                                                var newfontname = jQuery('#<?php echo $value['id']; ?>_selectfont option:selected').text(), 
													newfontparameter = jQuery('#<?php echo $value['id']; ?>_selectfont option:selected').val();
                                                
                                                if (jQuery('#<?php echo $value['id']; ?>_selectfont option:selected').parent().attr('label') === '<?php _e('Content Fonts', 'cmsmasters'); ?>') {
                                                    var newfonttype = 'content';
                                                    
                                                    document.getElementById('<?php echo $value['id']; ?>_type').selectedIndex = '1';
                                                } else if (jQuery('#<?php echo $value['id']; ?>_selectfont option:selected').parent().attr('label') === '<?php _e('Google Fonts', 'cmsmasters'); ?>') {
                                                    var newfonttype = 'heading';
                                                    
                                                    document.getElementById('<?php echo $value['id']; ?>_type').selectedIndex = '0';
                                                }
                                                
                                                jQuery('#<?php echo $value['id']; ?>_name').val(newfontname);
                                                jQuery('#<?php echo $value['id']; ?>_parameter').val(stripslashes(newfontparameter));
                                                
                                                jQuery('#<?php echo $value['id']; ?>_addfont').hide();
                                                jQuery('#<?php echo $value['id']; ?>_updatefont').show();
                                                jQuery('#<?php echo $value['id']; ?>_deletefont').show();
                                                jQuery('#<?php echo $value['id']; ?>_cancelfont').show();
                                            } else {
                                                jQuery('#<?php echo $value['id']; ?>_name').val('');
                                                jQuery('#<?php echo $value['id']; ?>_parameter').val('');
                                                document.getElementById('<?php echo $value['id']; ?>_type').selectedIndex = '0';
                                                jQuery('#<?php echo $value['id']; ?>_addfont').show();
                                                jQuery('#<?php echo $value['id']; ?>_updatefont').hide();
                                                jQuery('#<?php echo $value['id']; ?>_deletefont').hide();
                                                jQuery('#<?php echo $value['id']; ?>_cancelfont').hide();
                                            }
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_addfont').click(function () {
                                            if (jQuery('#<?php echo $value['id']; ?>_name').val() !== '' && jQuery('#<?php echo $value['id']; ?>_parameter').val() !== '' && jQuery('#<?php echo $value['id']; ?>_type').val() !== ''){
                                                jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeIn('fast');
                                                
                                                var newfontname = jQuery('#<?php echo $value['id']; ?>_name').val(), 
													newfontparameter = jQuery('#<?php echo $value['id']; ?>_parameter').val(), 
													newfonttype = jQuery('#<?php echo $value['id']; ?>_type').val();
                                                
                                                jQuery.ajax( {
                                                    type : 'post',
                                                    url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php',
                                                    data : ( { type : 'font', option : 'add', fontname : newfontname, fontparameter : newfontparameter, fonttype : newfonttype } ),
                                                    complete : function (data) {
                                                        if (data.responseText !== 'error' && data.responseText !== 'warning') {
                                                            jQuery('#<?php echo $value['id']; ?>_name').val('');
                                                            jQuery('#<?php echo $value['id']; ?>_parameter').val('');
                                                            document.getElementById('<?php echo $value['id']; ?>_type').selectedIndex = '0';
                                                            
                                                            alert('<?php _e('Font successfully added.', 'cmsmasters'); ?>');
                                                        } else if (data.responseText === 'warning'){
                                                            alert('<?php _e('This font already exists!', 'cmsmasters'); ?>');
                                                        } else {
                                                            alert('<?php _e('Font was not added!!!', 'cmsmasters'); ?>');
                                                        }
                                                        
                                                        jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeOut('fast');
                                                    }
                                                } );
                                            } else {
                                                alert('<?php _e('Enter font name and description!', 'cmsmasters'); ?>');
                                            }
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_deletefont').click(function () {
                                            jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeIn('fast');
                                            
                                            var newfontname = jQuery('#<?php echo $value['id']; ?>_name').val();
                                            
                                            if (confirm('<?php _e('Do you realy want to delete this font from your fonts list?', 'cmsmasters'); ?>')) {
                                                jQuery.ajax( {
                                                    type : 'post',
                                                    url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php',
                                                    data : ( { type : 'font', option : 'delete', fontname : newfontname } ),
                                                    complete : function (data) {
                                                        if (data.responseText !== 'error' && data.responseText !== 'warning'){
                                                            document.getElementById('<?php echo $value['id']; ?>_selectfont').selectedIndex = '0';
                                                            jQuery('#<?php echo $value['id']; ?>_name').val('');
                                                            jQuery('#<?php echo $value['id']; ?>_parameter').val('');
                                                            document.getElementById('<?php echo $value['id']; ?>_type').selectedIndex = '0';
                                                            jQuery('#<?php echo $value['id']; ?>_addfont').show();
                                                            jQuery('#<?php echo $value['id']; ?>_updatefont').hide();
                                                            jQuery('#<?php echo $value['id']; ?>_deletefont').hide();
                                                            jQuery('#<?php echo $value['id']; ?>_cancelfont').hide();
                                                            
                                                            alert('<?php _e('Font successfully deleted.', 'cmsmasters'); ?>');
                                                        } else if (data.responseText === 'warning'){
                                                            alert('<?php _e('It is no font with this name! Refresh this page and try again.', 'cmsmasters'); ?>');
                                                        } else {
                                                            alert('<?php _e('Font was not deleted!!!', 'cmsmasters'); ?>');
                                                        }
                                                        
                                                        jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeOut('fast');
                                                    }
                                                } );
                                            } else {
                                                jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeOut('fast');
                                            }
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_updatefont').click(function () {
                                            jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeIn('fast');
                                            
                                            var oldfontname = jQuery('#<?php echo $value['id']; ?>_selectfont option:selected').text(), 
												newfontname = jQuery('#<?php echo $value['id']; ?>_name').val(), 
												newfontparameter = jQuery('#<?php echo $value['id']; ?>_parameter').val(), 
												newfonttype = jQuery('#<?php echo $value['id']; ?>_type').val();
                                            
                                            jQuery.ajax( { 
                                                type : 'post', 
                                                url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php', 
                                                data : ( { 
													type : 'font', 
													option : 'update', 
													fontname : oldfontname, 
													newfontname : newfontname, 
													fontparameter : newfontparameter, 
													fonttype : newfonttype 
												} ), 
                                                complete : function (data) { 
                                                    if (data.responseText !== 'error' && data.responseText !== 'warning') {
                                                        document.getElementById('<?php echo $value['id']; ?>_selectfont').selectedIndex = '0';
                                                        jQuery('#<?php echo $value['id']; ?>_name').val('');
                                                        jQuery('#<?php echo $value['id']; ?>_parameter').val('');
                                                        document.getElementById('<?php echo $value['id']; ?>_type').selectedIndex = '0';
                                                        jQuery('#<?php echo $value['id']; ?>_addfont').show();
                                                        jQuery('#<?php echo $value['id']; ?>_updatefont').hide();
                                                        jQuery('#<?php echo $value['id']; ?>_deletefont').hide();
                                                        jQuery('#<?php echo $value['id']; ?>_cancelfont').hide();
                                                        
                                                        alert('<?php _e('Font successfully updated.', 'cmsmasters'); ?>');
                                                    } else if (data.responseText === 'warning') { 
                                                        alert('<?php _e('It is no font with this name! Refresh this page and try again.', 'cmsmasters'); ?>');
                                                    } else { 
                                                        alert('<?php _e('Font was not updated!!!', 'cmsmasters'); ?>');
                                                    }
                                                    
                                                    jQuery('#<?php echo $value['id']; ?>_loading').parent().fadeOut('fast');
                                                } 
                                            } );
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_cancelfont').click(function () {
                                            document.getElementById('<?php echo $value['id']; ?>_selectfont').selectedIndex = '0';
                                            jQuery('#<?php echo $value['id']; ?>_name').val('');
                                            jQuery('#<?php echo $value['id']; ?>_parameter').val('');
                                            document.getElementById('<?php echo $value['id']; ?>_type').selectedIndex = '0';
                                            jQuery('#<?php echo $value['id']; ?>_addfont').show();
                                            jQuery('#<?php echo $value['id']; ?>_updatefont').hide();
                                            jQuery('#<?php echo $value['id']; ?>_deletefont').hide();
                                            jQuery('#<?php echo $value['id']; ?>_cancelfont').hide();
                                            
                                            return false;
                                        } );
                                    } );
                                </script>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'bg_add':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" title="<?php echo $value['name']; ?>" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td valign="top" style="padding-bottom:0;" class="theme_bg_add_block">
                                <div class="bgs" id="<?php echo $value['id']; ?>_patterns_bgs">
                                    <span class="fl" style="display:block; width:140px; padding:5px 0 0;"><?php _e('Patterns', 'cmsmasters'); ?></span>
                                    <?php
                                    foreach ($value['options'] as $option) {
                                        if ($option->bg_type == 'bg_t') {
                                            if ($get_options[$id] != '') {
                                                $opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $get_options[$id]);
                                                
                                                if (strstr($opt_id, $option->bg_url) != false) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            } else {
                                                if ($value['std'] == $option->bg_url) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            }
                                            
                                            if ($option->bg_url != '') {
                                                echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");' title='" . $option->bg_url . "," . $option->bg_thumb_url . "," . $option->bg_position_y . "," . $option->bg_position_x . "," . $option->bg_repeat . "," . $option->bg_attachment . "," . $option->bg_type . "'>&nbsp;</a>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="bgs" id="<?php echo $value['id']; ?>_transparents_bgs">
                                    <span class="fl" style="display:block; width:140px; padding:5px 0 0;"><?php _e('Transparent Images', 'cmsmasters'); ?></span>
                                    <?php
                                    foreach ($value['options'] as $option) {
                                        if ($option->bg_type == 'bg_t_i') {
                                            if ($get_options[$id] != '') {
                                                $opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $get_options[$id]);
                                                
                                                if (strstr($opt_id, $option->bg_url) != false) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            } else {
                                                if ($value['std'] == $option->bg_url) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            }
                                            
                                            if ($option->bg_url != '') {
                                                echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");' title='" . $option->bg_url . "," . $option->bg_thumb_url . "," . $option->bg_position_y . "," . $option->bg_position_x . "," . $option->bg_repeat . "," . $option->bg_attachment . "," . $option->bg_type . "'>&nbsp;</a>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="bgs" id="<?php echo $value['id']; ?>_images_bgs">
                                    <span class="fl" style="display:block; width:140px; padding:5px 0 0;"><?php _e('Background Images', 'cmsmasters'); ?></span>
                                    <?php
                                    foreach ($value['options'] as $option) {
                                        if ($option->bg_type == 'bg_i') {
                                            if ($get_options[$id] != '') {
                                                $opt_id = str_replace(get_template_directory_uri() . '/images/bgs/', '', $get_options[$id]);
                                                
                                                if (strstr($opt_id, $option->bg_url) != false) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            } else {
                                                if ($value['std'] == $option->bg_url) {
                                                    $selected = ' class="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            }
                                            
                                            if ($option->bg_url != '') {
                                                echo "<a$selected href='" . get_template_directory_uri() . "/images/bgs/" . $option->bg_url . "' style='background-image:url(" . get_template_directory_uri() . "/images/bgs/" . $option->bg_thumb_url . ");' title='" . $option->bg_url . "," . $option->bg_thumb_url . "," . $option->bg_position_y . "," . $option->bg_position_x . "," . $option->bg_repeat . "," . $option->bg_attachment . "," . $option->bg_type . "'>&nbsp;</a>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th align="left" style="padding-top:30px;">
                                <span class="label"><?php _e('Upload Your Background Image', 'cmsmasters'); ?></span> 
                                <a id="<?php echo $value['id']; ?>_cancelbg" href="#" style="display:none; float:left; margin:2px 0 0 75px;"><?php _e('Cancel', 'cmsmasters'); ?></a>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <input size="36" name="<?php echo $value['id']; ?>_selectbgimg" id="<?php echo $value['id']; ?>_selectbgimg" type="text" value="" class="fl" />
                                <input type="button" name="imageupload" value="<?php _e('Upload', 'cmsmasters'); ?>" id="<?php echo $value['id']; ?>_upload" class="fl" />
                                <input size="36" name="<?php echo $value['id']; ?>_selectbgthumb" id="<?php echo $value['id']; ?>_selectbgthumb" type="hidden" value="" />
                                <div style="margin:8px 0 0 8px; float:left; display:none;">
                                    <img id="<?php echo $value['id']; ?>_loading" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                </div>
                                <div style="clear:both;"></div>
                                <div id="<?php echo $value['id']; ?>_image"></div>
                                <div<?php 
                                if ($get_options[$id] == '') { 
                                    echo ' style="display:none;"';
                                }
                                ?>>
                                    <a href="#" id="<?php echo $value['id']; ?>_clear" style="padding-top:15px;"><?php _e('Reset', 'cmsmasters'); ?> [X]</a>
                                </div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        var btnUpload = jQuery('#<?php echo $value['id']; ?>_upload'), 
											status = jQuery('#<?php echo $value['id']; ?>_loading');
                                        
                                        new AjaxUpload(btnUpload, {
                                            action : '<?php echo get_template_directory_uri(); ?>/theme/functions/upload-bg.php',
                                            name : 'uploadfile',
                                            data : { url : '../../images/bgs/' },
                                            onSubmit : function (file, ext) {
                                                if (!(ext && /^(jpg|png|jpeg|ico|gif)$/.test(ext))) { 
                                                    alert('<?php _e('Only JPG, PNG, ICO or GIF files are allowed', 'cmsmasters'); ?>');
                                                    
                                                    return false;
                                                }
                                                
                                                status.parent().fadeIn();
                                            },
                                            onComplete : function(file, response) {
                                                status.parent().fadeOut();
                                                
                                                if (response !== 'error') {
                                                    jQuery('#<?php echo $value['id']; ?>_selectbgimg').val('<?php echo get_template_directory_uri(); ?>/images/bgs/' + response.split(',')[0]);
                                                    jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val('<?php echo get_template_directory_uri(); ?>/images/bgs/' + response.split(',')[1]);
                                                    jQuery('#<?php echo $value['id']; ?>_image').css( { 
														background : 'url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + response.split(',')[0] + ') top center no-repeat', 
														width : '400px', 
														height : '250px', 
														margin : '10px 0' 
													} );
                                                    jQuery('#<?php echo $value['id']; ?>_image').fadeIn();
                                                    jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeIn();
                                                } else {
                                                    alert('<?php _e('File', 'cmsmasters'); ?> ' + file + ' <?php _e('do not load...', 'cmsmasters'); ?>')
                                                }
                                            }
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_clear').click(function () {
                                            jQuery('#<?php echo $value['id']; ?>_selectbgimg').val('');
                                            jQuery('#<?php echo $value['id']; ?>_image').fadeOut();
                                            jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeOut();
                                            jQuery('#<?php echo $value['id']; ?>_image').css( { 
												border : '0', 
												margin : '0'
											} );
                                            
                                            return false;
                                        } );
                                    } );
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">
                                <span class="label"><?php _e('Select Background Image Vertical Position', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <select style="width:297px;" name="<?php echo $value['id']; ?>_selectvpos" id="<?php echo $value['id']; ?>_selectvpos">
                                    <option value="top"><?php _e('Top', 'cmsmasters'); ?></option>
                                    <option value="center"><?php _e('Center', 'cmsmasters'); ?></option>
                                    <option value="bottom"><?php _e('Bottom', 'cmsmasters'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">
                                <span class="label"><?php _e('Select Background Image Horizontal Position', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <select style="width:297px;" name="<?php echo $value['id']; ?>_selecthpos" id="<?php echo $value['id']; ?>_selecthpos">
                                    <option value="left"><?php _e('Left', 'cmsmasters'); ?></option>
                                    <option value="center"><?php _e('Center', 'cmsmasters'); ?></option>
                                    <option value="right"><?php _e('Right', 'cmsmasters'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">
                                <span class="label"><?php _e('Select Background Image Repeat', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <select style="width:297px;" name="<?php echo $value['id']; ?>_selectrep" id="<?php echo $value['id']; ?>_selectrep">
                                    <option value="no-repeat"><?php _e('No Repeat', 'cmsmasters'); ?></option>
                                    <option value="repeat-x"><?php _e('Repeat Horizontally', 'cmsmasters'); ?></option>
                                    <option value="repeat-y"><?php _e('Repeat Vertically', 'cmsmasters'); ?></option>
                                    <option value="repeat"><?php _e('Repeat', 'cmsmasters'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">
                                <span class="label"><?php _e('Select Background Image Attachment', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <select name="<?php echo $value['id']; ?>_selectatt" id="<?php echo $value['id']; ?>_selectatt" style="width:297px;">
                                    <option value="scroll"><?php _e('Scroll', 'cmsmasters'); ?></option>
                                    <option value="fixed"><?php _e('Fixed', 'cmsmasters'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">
                                <span class="label"><?php _e('Select Background Image Type', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <select style="width:297px;" name="<?php echo $value['id']; ?>_selectbgtype" id="<?php echo $value['id']; ?>_selectbgtype">
                                    <option value="bg_t"><?php _e('Patterns', 'cmsmasters'); ?></option>
                                    <option value="bg_t_i"><?php _e('Transparent Images', 'cmsmasters'); ?></option>
                                    <option value="bg_i"><?php _e('Background Images', 'cmsmasters'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="position:relative;">
                                    <div style="display:none; position:absolute; top:7px; left:307px;">
                                        <img id="<?php echo $value['id']; ?>_loadingbg" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                    </div>
                                    <input name="<?php echo $value['id']; ?>_addbg" id="<?php echo $value['id']; ?>_addbg" type="button" value="<?php _e('Add Background', 'cmsmasters'); ?>" style="float:left; height:30px; width:120px; margin-left:0;" />
                                    <input name="<?php echo $value['id']; ?>_updatebg" id="<?php echo $value['id']; ?>_updatebg" type="button" value="<?php _e('Update Background', 'cmsmasters'); ?>" style="display:none; float:left; height:30px; width:135px; margin-left:0;" />
                                    <input name="<?php echo $value['id']; ?>_deletebg" id="<?php echo $value['id']; ?>_deletebg" type="button" value="<?php _e('Delete Background', 'cmsmasters'); ?>" style="display:none; float:left; height:30px; width:135px; margin-left:27px;" />
                                </div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        function stripslashes(str) {
                                            return str.replace('/\0/g', '0').replace('/\(.)/g', '$1');
                                        }
                                        
                                        jQuery('.theme_bg_add_block a').live('click', function () {
                                            var params = jQuery(this).attr('title').split(',');
                                            
                                            jQuery('.theme_bg_add_block a').removeClass('selected');
                                            jQuery(this).addClass('selected');
                                            
                                            jQuery('#<?php echo $value['id']; ?>_selectbgimg').val('<?php echo get_template_directory_uri(); ?>/images/bgs/' + params[0]);
                                            jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val('<?php echo get_template_directory_uri(); ?>/images/bgs/' + params[1]);
                                            
                                            if (params[6] === 'bg_t'){
                                                jQuery('#<?php echo $value['id']; ?>_image').css( { background : '#ffffff url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + params[0] + ') ' + params[2] + ' ' + params[3] + ' ' + params[4], width : '398px', height : '248px', border : '1px solid #000000', margin : '10px 0' } );
                                            } else if (params[6] === 'bg_t_i'){
                                                jQuery('#<?php echo $value['id']; ?>_image').css( { 
													background : '#333333 url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + params[0] + ') ' + params[2] + ' ' + params[3] + ' ' + params[4], 
													width : '400px', 
													height : '250px', 
													border : '0', 
													margin : '10px 0' 
												} );
                                            } else if (params[6] === 'bg_i'){
                                                jQuery('#<?php echo $value['id']; ?>_image').css( { 
													background : 'url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + params[0] + ') ' + params[2] + ' ' + params[3] + ' ' + params[4], 
													width : '400px', 
													height : '250px', 
													border : '0', 
													margin : '10px 0' 
												} );
                                            }
                                            
                                            jQuery('#<?php echo $value['id']; ?>_image').fadeIn();
                                            jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeIn();
                                            
                                            if (params[2] === 'top') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectvpos').selectedIndex = '0';
                                            } else if (params[2] === 'center') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectvpos').selectedIndex = '1';
                                            } else if (params[2] === 'bottom') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectvpos').selectedIndex = '2';
                                            }
                                            
                                            if (params[3] === 'left') {
                                                document.getElementById('<?php echo $value['id']; ?>_selecthpos').selectedIndex = '0';
                                            } else if (params[3] === 'center') {
                                                document.getElementById('<?php echo $value['id']; ?>_selecthpos').selectedIndex = '1';
                                            } else if (params[3] === 'right') {
                                                document.getElementById('<?php echo $value['id']; ?>_selecthpos').selectedIndex = '2';
                                            }
                                            
                                            if (params[4] === 'no-repeat') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectrep').selectedIndex = '0';
                                            } else if (params[4] === 'repeat-x') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectrep').selectedIndex = '1';
                                            } else if (params[4] === 'repeat-y') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectrep').selectedIndex = '2';
                                            } else if (params[4] === 'repeat') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectrep').selectedIndex = '3';
                                            }
                                            
                                            if (params[5] === 'scroll') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectatt').selectedIndex = '0';
                                            } else if (params[5] === 'fixed') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectatt').selectedIndex = '1';
                                            }
                                            
                                            if (params[6] === 'bg_t') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectbgtype').selectedIndex = '0';
                                            } else if (params[6] === 'bg_t_i') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectbgtype').selectedIndex = '1';
                                            } else if (params[6] === 'bg_i') {
                                                document.getElementById('<?php echo $value['id']; ?>_selectbgtype').selectedIndex = '2';
                                            }
                                            
                                            jQuery('#<?php echo $value['id']; ?>_addbg').hide();
                                            jQuery('#<?php echo $value['id']; ?>_updatebg').show();
                                            jQuery('#<?php echo $value['id']; ?>_deletebg').show();
                                            jQuery('#<?php echo $value['id']; ?>_cancelbg').show();
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_addbg').click(function () {
                                            if (jQuery('#<?php echo $value['id']; ?>_selectbgimg').val() !== '' && jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val() !== '' && jQuery('#<?php echo $value['id']; ?>_selectvpos').val() !== '' && jQuery('#<?php echo $value['id']; ?>_selecthpos').val() !== '' && jQuery('#<?php echo $value['id']; ?>_selectrep').val() !== '' && jQuery('#<?php echo $value['id']; ?>_selectatt').val() !== '' && jQuery('#<?php echo $value['id']; ?>_selectbgtype').val() !== ''){
                                                jQuery('#<?php echo $value['id']; ?>_loadingbg').parent().fadeIn('fast');
                                                
                                                var newbgurl = jQuery('#<?php echo $value['id']; ?>_selectbgimg').val().replace('<?php echo get_template_directory_uri(); ?>/images/bgs/', ''), 
													newbgthumb = jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val().replace('<?php echo get_template_directory_uri(); ?>/images/bgs/', ''), 
													newbgvpos = jQuery('#<?php echo $value['id']; ?>_selectvpos').val(), 
													newbghpos = jQuery('#<?php echo $value['id']; ?>_selecthpos').val(), 
													newbgrep = jQuery('#<?php echo $value['id']; ?>_selectrep').val(), 
													newbgatt = jQuery('#<?php echo $value['id']; ?>_selectatt').val(), 
													newbgtype = jQuery('#<?php echo $value['id']; ?>_selectbgtype').val();
                                                
                                                jQuery.ajax( { 
                                                    type : 'post', 
                                                    url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php', 
                                                    data : ( { 
														type : 'bg', 
														option : 'add', 
														bgurl : newbgurl, 
														bgthumb : newbgthumb, 
														bgvpos : newbgvpos, 
														bghpos : newbghpos, 
														bgrep : newbgrep, 
														bgatt : newbgatt, 
														bgtype : newbgtype 
													} ), 
                                                    complete : function (data) { 
                                                        if (data.responseText !== 'error' && data.responseText !== 'warning') {
                                                            if (newbgtype === 'bg_t') { 
                                                                jQuery('#<?php echo $value['id']; ?>_patterns_bgs').append('<a href="<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgurl + '" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgthumb + ');" title="' + newbgurl + ',' + newbgthumb + ',' + newbgvpos + ',' + newbghpos + ',' + newbgrep + ',' + newbgatt + ',' + newbgtype + '" style="display:none;">&nbsp;</a>').fadeIn('slow');
                                                            } else if (newbgtype === 'bg_t_i') { 
                                                                jQuery('#<?php echo $value['id']; ?>_transparents_bgs').append('<a href="<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgurl + '" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgthumb + ');" title="' + newbgurl + ',' + newbgthumb + ',' + newbgvpos + ',' + newbghpos + ',' + newbgrep + ',' + newbgatt + ',' + newbgtype + '" style="display:none;">&nbsp;</a>').fadeIn('slow');
                                                            } else if (newbgtype === 'bg_i') { 
                                                                jQuery('#<?php echo $value['id']; ?>_images_bgs').append('<a href="<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgurl + '" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgthumb + ');" title="' + newbgurl + ',' + newbgthumb + ',' + newbgvpos + ',' + newbghpos + ',' + newbgrep + ',' + newbgatt + ',' + newbgtype + '" style="display:none;">&nbsp;</a>').fadeIn('slow');
                                                            }
                                                            
                                                            jQuery('#<?php echo $value['id']; ?>_selectbgimg').val('');
                                                            jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val('');
                                                            jQuery('#<?php echo $value['id']; ?>_image').fadeOut();
                                                            jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeOut();
                                                            jQuery('#<?php echo $value['id']; ?>_image').css( { border : '0', margin : '0' } );
                                                            document.getElementById('<?php echo $value['id']; ?>_selectvpos').selectedIndex = '0';
                                                            document.getElementById('<?php echo $value['id']; ?>_selecthpos').selectedIndex = '0';
                                                            document.getElementById('<?php echo $value['id']; ?>_selectrep').selectedIndex = '0';
                                                            document.getElementById('<?php echo $value['id']; ?>_selectatt').selectedIndex = '0';
                                                            document.getElementById('<?php echo $value['id']; ?>_selectbgtype').selectedIndex = '0';
                                                            
                                                            alert('<?php _e('Background image successfully added.', 'cmsmasters'); ?>');
                                                        } else if (data.responseText === 'warning') {
                                                            alert('<?php _e('This background image already exists!', 'cmsmasters'); ?>');
                                                        } else {
                                                            alert('<?php _e('Background image was not added!!!', 'cmsmasters'); ?>');
                                                        }
                                                        
                                                        jQuery('#<?php echo $value['id']; ?>_loadingbg').parent().fadeOut('fast');
                                                    }
                                                } );
                                            } else {
                                                alert('<?php _e('Choose background image file and parameters!', 'cmsmasters'); ?>');
                                            }
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_deletebg').live('click', function () {
                                            jQuery('#<?php echo $value['id']; ?>_loadingbg').parent().fadeIn('fast');
                                            
                                            var newbgurl = jQuery('#<?php echo $value['id']; ?>_selectbgimg').val().replace('<?php echo get_template_directory_uri(); ?>/images/bgs/', '');
                                            
                                            if (confirm('<?php _e('Do you realy want to delete this background image from your backgrounds list?', 'cmsmasters'); ?>')) {
                                                jQuery.ajax( {
                                                    type : 'post',
                                                    url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php',
                                                    data : ( { type : 'bg', option : 'delete', bgurl : newbgurl } ),
                                                    complete : function (data) {
                                                        if (data.responseText !== 'error' && data.responseText !== 'warning') {
                                                            jQuery('.theme_bg_add_block a.selected').fadeOut('fast').remove();
                                                            jQuery('#<?php echo $value['id']; ?>_selectbgimg').val('');
                                                            jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val('');
                                                            jQuery('#<?php echo $value['id']; ?>_image').fadeOut();
                                                            jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeOut();
                                                            jQuery('#<?php echo $value['id']; ?>_image').css( { border : '0', margin : '0' } );
                                                            document.getElementById('<?php echo $value['id']; ?>_selectvpos').selectedIndex = '0';
                                                            document.getElementById('<?php echo $value['id']; ?>_selecthpos').selectedIndex = '0';
                                                            document.getElementById('<?php echo $value['id']; ?>_selectrep').selectedIndex = '0';
                                                            document.getElementById('<?php echo $value['id']; ?>_selectatt').selectedIndex = '0';
                                                            document.getElementById('<?php echo $value['id']; ?>_selectbgtype').selectedIndex = '0';
                                                            jQuery('#<?php echo $value['id']; ?>_addbg').show();
                                                            jQuery('#<?php echo $value['id']; ?>_updatebg').hide();
                                                            jQuery('#<?php echo $value['id']; ?>_deletebg').hide();
                                                            jQuery('#<?php echo $value['id']; ?>_cancelbg').hide();
                                                            
                                                            alert('<?php _e('Background image successfully deleted.', 'cmsmasters'); ?>');
                                                        } else if (data.responseText === 'warning') {
                                                            alert('<?php _e('It is no background image with this name! Refresh this page and try again.', 'cmsmasters'); ?>');
                                                        } else {
                                                            alert('<?php _e('Background image was not deleted!!!', 'cmsmasters'); ?>');
                                                        }
                                                        
                                                        jQuery('#<?php echo $value['id']; ?>_loadingbg').parent().fadeOut('fast');
                                                    }
                                                } );
                                            } else {
                                                jQuery('#<?php echo $value['id']; ?>_loadingbg').parent().fadeOut('fast');
                                            }
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_updatebg').live('click', function () {
                                            jQuery('#<?php echo $value['id']; ?>_loadingbg').parent().fadeIn('fast');
                                            
                                            var oldbgurl = jQuery('.theme_bg_add_block a.selected').attr('href').replace('<?php echo get_template_directory_uri(); ?>/images/bgs/', ''), 
												newbgurl = jQuery('#<?php echo $value['id']; ?>_selectbgimg').val().replace('<?php echo get_template_directory_uri(); ?>/images/bgs/', ''), 
												newbgthumb = jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val().replace('<?php echo get_template_directory_uri(); ?>/images/bgs/', ''), 
												newbgvpos = jQuery('#<?php echo $value['id']; ?>_selectvpos').val(), 
												newbghpos = jQuery('#<?php echo $value['id']; ?>_selecthpos').val(), 
												newbgrep = jQuery('#<?php echo $value['id']; ?>_selectrep').val(), 
												newbgatt = jQuery('#<?php echo $value['id']; ?>_selectatt').val(), 
												newbgtype = jQuery('#<?php echo $value['id']; ?>_selectbgtype').val();
                                            
                                            jQuery.ajax( {
                                                type : 'post',
                                                url : '<?php echo get_template_directory_uri(); ?>/theme/functions/db-operator.php',
                                                data : ( { 
													type : 'bg', 
													option : 'update', 
													bgurl : oldbgurl, 
													newbgurl : newbgurl, 
													bgthumb : newbgthumb, 
													bgvpos : newbgvpos, 
													bghpos : newbghpos, 
													bgrep : newbgrep, 
													bgatt : newbgatt, 
													bgtype : newbgtype 
												} ),
                                                complete : function (data) {
                                                    if (data.responseText !== 'error' && data.responseText !== 'warning') {
                                                        jQuery('.theme_bg_add_block a.selected').fadeOut('fast').remove();
                                                        
                                                        if (newbgtype === 'bg_t') { 
                                                            jQuery('#<?php echo $value['id']; ?>_patterns_bgs').append('<a href="<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgurl + '" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgthumb + ');" title="' + newbgurl + ',' + newbgthumb + ',' + newbgvpos + ',' + newbghpos + ',' + newbgrep + ',' + newbgatt + ',' + newbgtype + '" style="display:none;">&nbsp;</a>').fadeIn('slow');
                                                        } else if (newbgtype === 'bg_t_i') { 
                                                            jQuery('#<?php echo $value['id']; ?>_transparents_bgs').append('<a href="<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgurl + '" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgthumb + ');" title="' + newbgurl + ',' + newbgthumb + ',' + newbgvpos + ',' + newbghpos + ',' + newbgrep + ',' + newbgatt + ',' + newbgtype + '" style="display:none;">&nbsp;</a>').fadeIn('slow');
                                                        } else if (newbgtype === 'bg_i') { 
                                                            jQuery('#<?php echo $value['id']; ?>_images_bgs').append('<a href="<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgurl + '" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/bgs/' + newbgthumb + ');" title="' + newbgurl + ',' + newbgthumb + ',' + newbgvpos + ',' + newbghpos + ',' + newbgrep + ',' + newbgatt + ',' + newbgtype + '" style="display:none;">&nbsp;</a>').fadeIn('slow');
                                                        }
                                                        
                                                        jQuery('#<?php echo $value['id']; ?>_selectbgimg').val('');
                                                        jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val('');
                                                        jQuery('#<?php echo $value['id']; ?>_image').fadeOut();
                                                        jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeOut();
                                                        jQuery('#<?php echo $value['id']; ?>_image').css( { border : '0', margin : '0' } );
                                                        document.getElementById('<?php echo $value['id']; ?>_selectvpos').selectedIndex = '0';
                                                        document.getElementById('<?php echo $value['id']; ?>_selecthpos').selectedIndex = '0';
                                                        document.getElementById('<?php echo $value['id']; ?>_selectrep').selectedIndex = '0';
                                                        document.getElementById('<?php echo $value['id']; ?>_selectatt').selectedIndex = '0';
                                                        document.getElementById('<?php echo $value['id']; ?>_selectbgtype').selectedIndex = '0';
                                                        jQuery('#<?php echo $value['id']; ?>_addbg').show();
                                                        jQuery('#<?php echo $value['id']; ?>_updatebg').hide();
                                                        jQuery('#<?php echo $value['id']; ?>_deletebg').hide();
                                                        jQuery('#<?php echo $value['id']; ?>_cancelbg').hide();
                                                        
                                                        alert('<?php _e('Background image successfully updated.', 'cmsmasters'); ?>');
                                                    } else if (data.responseText === 'warning') {
                                                        alert('<?php _e('It is no background image with this name! Refresh this page and try again.', 'cmsmasters'); ?>');
                                                    } else {
                                                        alert('<?php _e('Background image was not updated!!!', 'cmsmasters'); ?>');
                                                    }
                                                    
                                                    jQuery('#<?php echo $value['id']; ?>_loadingbg').parent().fadeOut('fast');
                                                }
                                            } );
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#<?php echo $value['id']; ?>_cancelbg').click(function () {
                                            jQuery('.theme_bg_add_block a').removeClass('selected');
                                            jQuery('#<?php echo $value['id']; ?>_selectbgimg').val('');
                                            jQuery('#<?php echo $value['id']; ?>_selectbgthumb').val('');
                                            jQuery('#<?php echo $value['id']; ?>_image').fadeOut();
                                            jQuery('#<?php echo $value['id']; ?>_clear').parent().fadeOut();
                                            jQuery('#<?php echo $value['id']; ?>_image').css( { border : '0', margin : '0' } );
                                            document.getElementById('<?php echo $value['id']; ?>_selectvpos').selectedIndex = '0';
                                            document.getElementById('<?php echo $value['id']; ?>_selecthpos').selectedIndex = '0';
                                            document.getElementById('<?php echo $value['id']; ?>_selectrep').selectedIndex = '0';
                                            document.getElementById('<?php echo $value['id']; ?>_selectatt').selectedIndex = '0';
                                            document.getElementById('<?php echo $value['id']; ?>_selectbgtype').selectedIndex = '0';
                                            jQuery('#<?php echo $value['id']; ?>_addbg').show();
                                            jQuery('#<?php echo $value['id']; ?>_updatebg').hide();
                                            jQuery('#<?php echo $value['id']; ?>_deletebg').hide();
                                            jQuery('#<?php echo $value['id']; ?>_cancelbg').hide();
                                            
                                            return false;
                                        } );
                                    } );
                                </script>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'icons_list':
                    ?>
                        <tr>
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['id']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['id']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <ul class="icons_container" id="list_<?php echo $value['id']; ?>">
                                <?php
                                foreach ($value['options'] as $option) {
                                    if ($option != '') {
                                        echo "<li>" . 
											"<img src='" . get_template_directory_uri() . "/images/theme_icons/" . $option . "' alt='" . $option . "' width='48' height='48' style='cursor:pointer;' />" . 
											"<br />" . 
											"<a href='#'>" . __('Delete', 'cmsmasters') . "</a>" . 
										"</li>";
                                    }
                                }
                                ?>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <span class="label"><?php _e('Icon Link', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input size="100" name="<?php echo $value['id']; ?>_iconlink" id="<?php echo $value['id']; ?>_iconlink" type="text" value="" />
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <span class="label"><?php _e('Add New Icon', 'cmsmasters'); ?></span>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input size="36" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="" class="fl" />
                                <input type="button" name="imageupload" value="<?php _e('Upload', 'cmsmasters'); ?>" id="<?php echo $value['id']; ?>_upload" class="fl" />
                                <div style="margin:8px 0 0 8px; float:left; display:none;">
                                    <img id="<?php echo $value['id']; ?>_loading" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                </div>
                                <div style="clear:both;"></div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        var btnUpload = jQuery('#<?php echo $value['id']; ?>_upload'), 
											status = jQuery('#<?php echo $value['id']; ?>_loading');
                                        
                                        new AjaxUpload(btnUpload, {
                                            action : '<?php echo get_template_directory_uri(); ?>/theme/functions/upload-icon.php',
                                            name : 'uploadfile',
                                            data : { url : '../../images/theme_icons/' },
                                            onSubmit : function (file, ext) {
                                                if (!(ext && /^(jpg|png|jpeg|ico|gif)$/.test(ext))) {
                                                    alert('<?php _e('Only JPG, PNG, ICO or GIF files are allowed', 'cmsmasters'); ?>');
                                                    
                                                    return false;
                                                } else {
                                                    jQuery('#<?php echo $value['id']; ?>').val(file);
                                                }
                                                
                                                status.parent().fadeIn();
                                            },
                                            onComplete : function (file, response) {
                                                status.parent().fadeOut();
                                                
                                                if (response !== 'error' && response !== 'warning') {
                                                    jQuery('#<?php echo $value['id']; ?>').val('<?php echo get_template_directory_uri(); ?>/images/theme_icons/' + response);
                                                    jQuery('#list_<?php echo $value['id']; ?>').append('<li class="added" style="display:none;"><img src="<?php echo get_template_directory_uri(); ?>/images/theme_icons/' + response + '" width="48" height="48" alt="' + response + '" /><br /><a href="#"><?php _e('Delete', 'cmsmasters'); ?></a></li>');
                                                    jQuery('#list_<?php echo $value['id']; ?>').find('li.added').removeClass('added').fadeIn('slow');
                                                } else if (response === 'warning') {
													alert('<?php _e('File', 'cmsmasters'); ?> ' + file + ' <?php _e('already exists!', 'cmsmasters'); ?>');
                                                } else {
													alert('<?php _e('File', 'cmsmasters'); ?> ' + file + ' <?php _e('do not load...', 'cmsmasters'); ?>');
                                                }
                                                
                                                jQuery('#<?php echo $value['id']; ?>').val('');
                                            }
                                        } );
                                        
                                        jQuery('#list_<?php echo $value['id']; ?> a').live('click', function () {
                                            jQuery(this).addClass('active');
                                            
                                            if (confirm('<?php _e('Do you realy want to delete this file from the server?', 'cmsmasters'); ?>')) {
                                                jQuery.post('<?php echo get_template_directory_uri(); ?>/theme/functions/delete.php', { file : jQuery(this).parent().find('img').attr('alt') }, 
                                                function (file, response) {
                                                    if (response !== 'error') {
                                                        jQuery('#list_<?php echo $value['id']; ?> a.active').parent().fadeOut('slow', function () {
                                                            jQuery(this).remove();
                                                        } );
                                                    } else {
                                                        alert('<?php _e('File', 'cmsmasters'); ?> ' + file + ' <?php _e('do not delete...', 'cmsmasters'); ?>');
                                                    }
                                                } );
                                            } else {
                                                jQuery(this).removeClass('active');
                                            }
                                            
                                            return false;
                                        } );
                                        
                                        jQuery('#list_<?php echo $value['id']; ?> img').live('click', function () {
                                            jQuery('#<?php echo $value['id']; ?>_iconlink').val(jQuery(this).attr('src'));
                                            
                                            return false;
                                        } );
                                    } );
                                </script>
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'sidebar':
                    ?>
                        <tr valign="top">
                            <th align="left">
                                <span class="label"><?php echo $value['name']; ?></span>
                                <a class="helpbox" href="?lightbox[width]=350&amp;lightbox[height]=150#<?php echo $value['htmlid']; ?>_light"></a>
                                <div class="dn" id="<?php echo $value['htmlid']; ?>_light"><?php echo $value['desc']; ?></div>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input size="36" name="<?php echo $value['htmlid']; ?>" id="<?php echo $value['htmlid']; ?>" type="text" value="<?php 
                                if ($get_options[$id] != '') {
                                    echo $get_options[$id];
                                } else {
                                    echo $value['std'];
                                } 
                                ?>" class="fl" />
                                <input type="button" name="sidebar_add" id="sidebar_add" class="button fl" value="<?php _e('Add', 'cmsmasters'); ?>" style="padding-left:20px; padding-right:20px; margin:0 0 0 5px;" />
                            </td>
                        </tr>
                        <?php
                        break;
                    case 'sidebar_delete':
                    ?>
                        <table class="form-table cmsmasters-options" id="side_del">
                        <?php
                        $get_sidebar_options = sidebar_generator_cmsmasters::get_sidebars();
                        
                        if ($get_sidebar_options != '') {
                            $i = 1;
                            
                            foreach ($get_sidebar_options as $sidebar_gen) {
                                if ($i == 1) { 
                                ?>
                                <tr valign="top">
                                    <td style="padding:0;">
                                        <h3 style="margin:10px 0 0; padding:25px 0 10px;"><?php echo $value['desc']; ?></h3>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr class="sidebar_table" id="sidebar_table_<?php echo $i; ?>">
                                    <td style="padding-bottom:0;">
                                        <div class="sidename fl" align="left" style="width:217px;"><?php echo $sidebar_gen; ?></div>
                                        <input type="button" name="sidebar_rm_<?php echo $i; ?>" id="sdbr_<?php echo $i; ?>" class="button fl" value="<?php _e('Delete', 'cmsmasters'); ?>" style="padding:5px 13px;" />
                                        <div class="fl" style="margin:7px 0 0 10px;">
                                            <img class="sidebar_rm_<?php echo $i; ?>" style="display:none;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                                        </div>
                                    </td>
                                    <td style="padding:0; margin:0;"><input id="<?php echo 'sidebar_generator_' . $i ?>" type="hidden" name="<?php echo 'sidebar_generator_' . $i ?>" value="<?php echo $sidebar_gen; ?>" /></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            <tr valign="top">
                                <td style="padding:0; margin:0;"></td>
                            </tr>
                        <?php
                        }
                        break;
                    case 'submit':
                    ?>
                        <div class="submit cmsmasters-submit">
                            <input type="submit" name="save" value="<?php _e('Save Changes', 'cmsmasters'); ?>" style="float:left;" />
                            <input type="hidden" name="action" value="save" />
                            <div class="fl" style="margin:7px 0 0 10px;">
                                <img class="submit_loader" style="display:none;" src="<?php echo get_template_directory_uri(); ?>/theme/administrator/images/wpspin_light.gif" alt="<?php _e('Loading', 'cmsmasters'); ?>" />
                            </div>
                        </div>
                        <?php
                        break;
                    }
                }
                ?>
                </form>
            </div>
        </div>
    </div>
<?php
}

function cmsmasters_add_admin_options() {
    global $themename, $shortname, $options, $page_handle;
    
    if (isset($_GET['page'])) {
        $send = $_GET['page'];
    }
    
    if (isset($_GET['page']) && $_GET['page'] == $page_handle) {
        if (isset($_REQUEST['action']) && 'save' == $_REQUEST['action']) {
            foreach ($options as $value) {
                if (isset($value['id']) && isset($_REQUEST[$value['id']]) && $value['id'] != 'sidebar_generator_0')
                    $options_array[$value['id']] = $_REQUEST[$value['id']];
            }
            
            update_option($shortname . '_general_settings', $options_array);
            $get_sidebar_options = sidebar_generator_cmsmasters::get_sidebars();
            $sidebar_name = str_replace(array("\n", "\r", "\t"), '', $_POST['sidebar_generator_0']);
            $sidebar_id = sidebar_generator_cmsmasters::name_to_class($sidebar_name);
            
            if ($sidebar_id == '') {
                $options_sidebar = $get_sidebar_options;
            } else {
                if (isset($get_sidebar_options[$sidebar_id])) {
                    header("Location: admin.php?page=$send&error=true");
                    
                    die;
                }
                
                if (is_array($get_sidebar_options)) {
                    $new_sidebar_gen[$sidebar_id] = $sidebar_id;
                    $options_sidebar = array_merge($get_sidebar_options, (array) $new_sidebar_gen);
                } else {
                    $options_sidebar[$sidebar_id] = $sidebar_id;
                }
            }
            
            update_option($shortname . '_sidebar_generator', $options_sidebar);
            header("Location: admin.php?page=$send&saved=true");
            
            die;
        } else if (isset($_REQUEST['action']) && 'reset' == $_REQUEST['action']) {
            foreach ($options as $value) {
                delete_option($value['id']);
            }
            
            header("Location: admin.php?page=$send&reset=true");
            
            die;
        }
    }
    
    add_menu_page($themename . ' ' . __('Options', 'cmsmasters'), $themename, 'edit_themes', $page_handle, 'cmsmasters_admin_options');
}

function ajax_update_widgets($sidebar_id) {
    $get_widgets = wp_get_sidebars_widgets();
    unset($get_widgets['array_version']);
    $before_delete = true;
    $i = 0;
    
    foreach ($get_widgets as $key => $value) {
        if (!preg_match('/cmsmasters_sidebar-([0-9]+)/', $key)) {
            $update_widgets[$key] = $value;
        }
        
        if (preg_match('/cmsmasters_sidebar-([0-9]+)/', $key)) {
            if ($key == "cmsmasters_sidebar-$sidebar_id") {
                $before_delete = false;
                $inactive_widgets = $value;
            }
            
            if ($key != "cmsmasters_sidebar-$sidebar_id" && $before_delete == true) {
                $update_widgets[$key] = $value;
            }
            
            if ($key != "cmsmasters_sidebar-$sidebar_id" && $before_delete == false) {
                $update_widgets['cmsmasters_sidebar-' . $i] = $value;
            }
            
            $i++;
        }
    }
    
    $update_widgets['wp_inactive_widgets'] = array_merge($inactive_widgets, (array) $update_widgets['wp_inactive_widgets']);
    wp_set_sidebars_widgets($update_widgets);
}

function ajax_sidebar_add() {
    global $shortname, $wpdb;
    
    $sidebar = $_POST['sidebar'];
    $sidebar_id = $_POST['sidebar_id'];
    $sidebar_name = $_POST['sidebar_name'];
    $pieces = explode(',', $sidebar);
    
    foreach ($pieces as $key => $value) {
        if ($value != '') {
            $options_sidebar_add[$value] = $value;
        }
    }
    
    update_option($shortname . '_sidebar_generator', $options_sidebar_add);
}

function ajax_sidebar_rm() {
    global $shortname, $wpdb;
    
    $sidebar = $_POST['sidebar'];
    $sidebar_id = $_POST['sidebar_id'];
    $sidebar_name = $_POST['sidebar_name'];
    $pieces = explode(',', $sidebar);
    
    foreach ($pieces as $key => $value) {
        if ($value != '') {
            $options_sidebar_rm[$value] = $value;
        }
    }
    
    update_option($shortname . '_sidebar_generator', $options_sidebar_rm);
    ajax_update_widgets($sidebar_id);
    $sidebar_meta = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '$sidebar_name'", ARRAY_A);
    
    if (is_array($sidebar_meta)) {
        foreach ($sidebar_meta as $key => $value) {
            delete_post_meta($value['post_id'], 'selected_sidebar');
        }
    }
}

add_action('wp_ajax_sidebar_add', 'ajax_sidebar_add');
add_action('wp_ajax_sidebar_rm', 'ajax_sidebar_rm');
add_action('admin_menu', 'cmsmasters_add_admin_options');

?>