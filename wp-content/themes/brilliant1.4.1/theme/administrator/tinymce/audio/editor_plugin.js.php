<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Audio Shortcodes Script
 * Created by CMSMasters
 * 
 */


require_once('../../../../../../../wp-load.php');
require_once('../../../../../../../wp-admin/includes/admin.php');

do_action('admin_init');

if (!is_user_logged_in()) {
	die(__('You must be logged in to access this script', 'cmsmasters') . '.');
}

if (!isset($cmsmasters_shortcode_audio)) {
	$cmsmasters_shortcode_audio = new CMSMastersAudio();
}

?>
(function () {
	tinymce.create('tinymce.plugins.<?php echo $cmsmasters_shortcode_audio->buttonName; ?>', {
        init : function (c, url) {
        <?php 
        foreach ($cmsmasters_shortcode_audio->buttonArray as $val) { 
            echo "c.addCommand('" . $val[1] . "_command', function () { " . 
                "tb_show('" . __('CMSMasters', 'cmsmasters') . " " . $val[0] . " " . __('Shortcode', 'cmsmasters') . "', '#TB_inline'); " . 
                "jQuery('#TB_ajaxContent').load('" . CMSMASTERS_ADMIN_TINYMCE . "/" . $cmsmasters_shortcode_audio->buttonName . "/editor_plugin_popup.php?type=" . $val[1] . "&content=' + tinyMCE.activeEditor.selection.getContent( { format : 'html' } ).replace(/ /g, '+'));" . 
                "jQuery('#TB_ajaxContent').css( { " . 
                    "width : jQuery('#TB_ajaxContent').parent().width() - 30, " . 
                    "height : jQuery('#TB_ajaxContent').parent().height() - 47 " . 
                '} );' . 
            '} );';
        }
        ?>
        } ,
		createControl : function (n, c) {
			if (n === '<?php echo $cmsmasters_shortcode_audio->buttonName; ?>') {
                var b = c.createSplitButton('<?php echo $cmsmasters_shortcode_audio->buttonName; ?>List', {
                    title : '<?php echo $cmsmasters_shortcode_audio->buttonTitle; ?>',
					onclick : function () {
						if (b.isActive) {
							b.showMenu(1);
						} else {
							b.hideMenu(1);
						}
					}
                } );
				
				b.onRenderMenu.add(function (c, m) {
					m.add( { 
						title : '<?php echo $cmsmasters_shortcode_audio->buttonTitle; ?>', 
						'class' : 'mceMenuItemTitle' 
					} ).setDisabled(1);
					
                    <?php 
                    foreach ($cmsmasters_shortcode_audio->buttonArray as $val) { 
                        echo 'm.add( { ' . 
                            "title : '" . $val[0] . "', " . 
                            "cmd : '" . $val[1] . "_command'" . 
                        '} ); ';
                    } 
                    ?>
				} );
				
                return b;
            }
            
            return null;
		} , 
		getInfo : function () {
			return {
				longname : '<?php echo $cmsmasters_shortcode_audio->buttonTitle . ' ' . __('Shortcode Selector', 'cmsmasters'); ?>',
				author : '<?php _e('CMSMasters', 'cmsmasters'); ?>',
				authorurl : 'http://cmsmasters.net',
				infourl : 'http://cmsmasters.net',
				version : '1.0'
			};
		}
	} );
	
	tinymce.PluginManager.add('<?php echo $cmsmasters_shortcode_audio->buttonName; ?>', tinymce.plugins.<?php echo $cmsmasters_shortcode_audio->buttonName; ?>);
} )();
