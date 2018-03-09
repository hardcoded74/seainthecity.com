<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Divider Shortcodes Script
 * Created by CMSMasters
 * 
 */


require_once('../../../../../../../wp-load.php');
require_once('../../../../../../../wp-admin/includes/admin.php');

do_action('admin_init');

if (!is_user_logged_in()) {
	die(__('You must be logged in to access this script', 'cmsmasters') . '.');
}

if (!isset($cmsmasters_shortcode_divider)) {
	$cmsmasters_shortcode_divider = new CMSMastersDivider();
}

?>
(function () {
	tinymce.create('tinymce.plugins.<?php echo $cmsmasters_shortcode_divider->buttonName; ?>', {
        init : function (c, url) {
        <?php 
        foreach ($cmsmasters_shortcode_divider->buttonArray as $val) { 
			echo "c.addCommand('" . $val[1] . "_command', function () { " . 
                "if (tinyMCE.activeEditor.selection.getContent() !== '') { " . 
                    "tinyMCE.activeEditor.selection.setContent('[" . $val[1] . "]'); " . 
                '} else { ' . 
                    "tinyMCE.activeEditor.selection.setContent('[" . $val[1] . "]'); " . 
                '} ' . 
                "edInsertContent('', '[" . $val[1] . "]');" . 
            '} );';
        }
        ?>
        } , 
		createControl : function (n, c) {
			if (n === '<?php echo $cmsmasters_shortcode_divider->buttonName; ?>') {
                var b = c.createSplitButton('<?php echo $cmsmasters_shortcode_divider->buttonName; ?>List', {
                    title : '<?php echo $cmsmasters_shortcode_divider->buttonTitle; ?>',
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
						title : '<?php echo $cmsmasters_shortcode_divider->buttonTitle; ?>', 
						'class' : 'mceMenuItemTitle' 
					} ).setDisabled(1);
					
                    <?php 
                    foreach ($cmsmasters_shortcode_divider->buttonArray as $val) { 
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
				longname : '<?php echo $cmsmasters_shortcode_divider->buttonTitle . ' ' . __('Shortcode Selector', 'cmsmasters'); ?>',
				author : '<?php _e('CMSMasters', 'cmsmasters'); ?>',
				authorurl : 'http://cmsmasters.net',
				infourl : 'http://cmsmasters.net',
				version : '1.0'
			};
		}
	} );
	
	tinymce.PluginManager.add('<?php echo $cmsmasters_shortcode_divider->buttonName; ?>', tinymce.plugins.<?php echo $cmsmasters_shortcode_divider->buttonName; ?>);
} )();
