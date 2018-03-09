<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Script for Text with Icon Widget
 * Created by CMSMasters
 * 
 */


header('Content-type: text/javascript');
require('../../../../../../wp-load.php');

?>
jQuery(document).ready(function () { 
	jQuery('input[type="color"]').mColorPicker( { 
		imageFolder : '<?php echo get_template_directory_uri(); ?>/theme/administrator/images/mColorPicker/' 
	} ); 
} );

var icon = { 
	init : function () { 
        this._registerEvents();
    }, 
    _registerEvents : function () { 
        jQuery('.cmsmasters_icon_list img').live('click', function () { 
            jQuery(this).parent().parent().find('.current_icon').removeClass('current_icon').css( { 
				border : 0, 
				padding : '2px' 
			} );;
            jQuery(this).parent().addClass('current_icon').css( { 
				border : '2px solid #d54e21', 
				padding : 0 
			} );
            jQuery(this).parent().parent().parent().prev().find('input[type="hidden"]').val(jQuery(this).attr('src'));
        } );
    } 
};

jQuery(function () { 
	icon.init(); 
} );
