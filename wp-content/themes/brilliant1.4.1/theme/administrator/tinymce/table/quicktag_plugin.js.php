<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Table Quick Tag Script
 * Created by CMSMasters
 * 
 */


require_once('../../../../../../../wp-load.php');
require_once('../../../../../../../wp-admin/includes/admin.php');

do_action('admin_init');

if (!is_user_logged_in()) {
	die(__('You must be logged in to access this script', 'cmsmasters') . '.');
}

?>
edButtons[edButtons.length] = new edButton(
    'cmsms_table', 
    'table', 
    "<table class=\"table\">\n<thead>\n<tr>\n<th><?php echo __('Header', 'cmsmasters') . ' 1'; ?></th>\n<th><?php echo __('Header', 'cmsmasters') . ' 2'; ?></th>\n<th><?php echo __('Header', 'cmsmasters') . ' 3'; ?></th>\n</tr>\n</thead>\n<tbody>\n<tr>\n<td><?php echo __('Division', 'cmsmasters') . ' 1'; ?></td>\n<td><?php echo __('Division', 'cmsmasters') . ' 2'; ?></td>\n<td><?php echo __('Division', 'cmsmasters') . ' 3'; ?></td>\n</tr>\n<tr>\n<td><?php echo __('Division', 'cmsmasters') . ' 1'; ?></td>\n<td><?php echo __('Division', 'cmsmasters') . ' 2'; ?></td>\n<td><?php echo __('Division', 'cmsmasters') . ' 3'; ?></td>\n</tr>\n</tbody>\n</table>" 
);
