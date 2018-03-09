<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Data Base Operator for Backgrounds, Fonts & Icons
 * Created by CMSMasters
 * 
 */


require('../../../../../wp-load.php');
global $wpdb, $shortname;

if ($_POST['type'] == 'bg') {
	if ($_POST['option'] == 'add' && $_POST['bgurl'] && $_POST['bgthumb'] && $_POST['bgvpos'] && $_POST['bghpos'] && $_POST['bgrep'] && $_POST['bgatt'] && $_POST['bgtype']) {
		$bgurl = $_POST['bgurl'];
		$bgthumb = $_POST['bgthumb'];
		$bgvpos = $_POST['bgvpos'];
		$bghpos = $_POST['bghpos'];
		$bgrep = $_POST['bgrep'];
		$bgatt = $_POST['bgatt'];
		$bgtype = $_POST['bgtype'];
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_bgs WHERE bg_url = '" . $bgurl . "'") == '') { 
			$wpdb->query($wpdb->insert($wpdb->prefix . $shortname . '_bgs', array('bg_url' => $bgurl, 'bg_thumb_url' => $bgthumb, 'bg_position_y' => $bgvpos, 'bg_position_x' => $bghpos, 'bg_repeat' => $bgrep, 'bg_attachment' => $bgatt, 'bg_type' => $bgtype, 'bg_property_desc' => 'pageBg'), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')));
		} else { 
			echo 'warning';
		}
	} elseif ($_POST['option'] == 'delete' && $_POST['bgurl']) {
		$deletebg = $_POST['bgurl'];
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_bgs WHERE bg_url = '" . $deletebg . "'") != '') { 
			$wpdb->query("DELETE FROM " . $wpdb->prefix . $shortname . "_bgs WHERE bg_url = '" . $deletebg . "'");
		} else { 
			echo 'warning';
		}
	} elseif ($_POST['option'] == 'update' && $_POST['bgurl'] && $_POST['newbgurl'] && $_POST['bgthumb'] && $_POST['bgvpos'] && $_POST['bghpos'] && $_POST['bgrep'] && $_POST['bgatt'] && $_POST['bgtype']){
		$updatebg = $_POST['bgurl'];
		$bgurl = $_POST['newbgurl'];
		$bgthumb = $_POST['bgthumb'];
		$bgvpos = $_POST['bgvpos'];
		$bghpos = $_POST['bghpos'];
		$bgrep = $_POST['bgrep'];
		$bgatt = $_POST['bgatt'];	
		$bgtype = $_POST['bgtype'];
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_bgs WHERE bg_url = '" . $updatebg . "'") != '') { 
			$wpdb->query($wpdb->update($wpdb->prefix . $shortname . '_bgs', array('bg_url' => $bgurl, 'bg_thumb_url' => $bgthumb, 'bg_position_y' => $bgvpos, 'bg_position_x' => $bghpos, 'bg_repeat' => $bgrep, 'bg_attachment' => $bgatt, 'bg_type' => $bgtype), array('bg_url' => $updatebg), array('%s', '%s', '%s', '%s', '%s', '%s', '%s'), array('%s')));
		} else { 
			echo 'warning';
		}
	} else {
		echo 'error';
	}
} elseif ($_POST['type'] == 'font') {
	if ($_POST['option'] == 'add' && $_POST['fontname'] && $_POST['fontparameter'] && $_POST['fonttype']) {
		$fontname = $_POST['fontname'];
		$fontparameter = $_POST['fontparameter'];
		$fonttype = $_POST['fonttype'];	
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_fonts WHERE font_name = '" . $fontname . "'") == '') { 
			$wpdb->query($wpdb->insert($wpdb->prefix . $shortname . '_fonts', array('font_name' => $fontname, 'font_parameter' => $fontparameter, 'font_type' => $fonttype), array('%s', '%s', '%s')));
		} else { 
			echo 'warning';
		}
	} elseif ($_POST['option'] == 'delete' && $_POST['fontname']) {
		$fontname = $_POST['fontname'];
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_fonts WHERE font_name = '" . $fontname . "'") != '') { 
			$wpdb->query("DELETE FROM " . $wpdb->prefix . $shortname . "_fonts WHERE font_name = '" . $fontname . "'");
		} else { 
			echo 'warning';
		}
	} elseif ($_POST['option'] == 'update' && $_POST['fontname'] && $_POST['newfontname'] && $_POST['fontparameter'] && $_POST['fonttype']) {
		$fontname = $_POST['fontname'];
		$newfontname = $_POST['newfontname'];
		$fontparameter = $_POST['fontparameter'];
		$fonttype = $_POST['fonttype'];
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_fonts WHERE font_name = '" . $fontname . "'") != '') { 
			$wpdb->query($wpdb->update($wpdb->prefix . $shortname . '_fonts', array('font_name' => $newfontname, 'font_parameter' => $fontparameter, 'font_type' => $fonttype), array('font_name' => $fontname), array('%s', '%s', '%s'), array('%s')));
		} else { 
			echo 'warning';
		}
	} else {
		echo 'error';
	}
} elseif ($_POST['type'] == 'icon') {
	if ($_POST['option'] == 'add' && $_POST['icon'] && $_POST['iconfile'] && $_POST['icontooltip'] && $_POST['iconlink']) {
		$addicon = $_POST['icon'];
		$iconfile = $_POST['iconfile'];
		$icontooltip = $_POST['icontooltip'];
		$iconlink = $_POST['iconlink'];
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_icons WHERE icon_name = '" . $addicon . "'") == '') { 
			$wpdb->query($wpdb->insert($wpdb->prefix . $shortname . '_icons', array('icon_name' => $addicon, 'icon_file' => $iconfile, 'icon_tooltip' => $icontooltip, 'icon_link' => $iconlink), array('%s', '%s', '%s', '%s')));
		} else { 
			echo 'warning';
		}
	} elseif ($_POST['option'] == 'delete' && $_POST['iconname']) {
		$deleteicon = $_POST['iconname'];
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_icons WHERE icon_name = '" . $deleteicon . "'") != '') { 
			$wpdb->query("DELETE FROM " . $wpdb->prefix . $shortname . "_icons WHERE icon_name = '" . $deleteicon . "'");
		} else { 
			echo 'warning';
		}
	} elseif ($_POST['option'] == 'update' && $_POST['icon'] && $_POST['iconlink']) {
		$updateicon = $_POST['icon'];
		$iconlink = $_POST['iconlink'];
		
		if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_icons WHERE icon_name = '" . $updateicon . "'") != '') { 
			$wpdb->query($wpdb->update($wpdb->prefix . $shortname . '_icons', array('icon_link' => $iconlink), array('icon_name' => $updateicon), array('%s'), array('%s')));
		} else { 
			echo 'warning';
		}
	} else {
		echo 'error';
	}
}

?>