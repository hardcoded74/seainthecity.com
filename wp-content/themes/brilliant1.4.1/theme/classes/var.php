<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Get All Theme Options From Database
 * Created by CMSMasters
 * 
 */


global $options, $shortname;

$get_options = get_option($shortname.'_general_settings');

foreach ($options as $value) {
	if (!$get_options && isset($value['std']) && $get_options[$value['id']] == false) {
		$$value['id'] = $value['std'];
	} elseif ($get_options && isset($value['id']) && isset($get_options[$value['id']]) && $get_options[$value['id']] != false) {
		$$value['id'] = $get_options[$value['id']];
	} elseif ($get_options && isset($value['id'])) {
		$$value['id'] = '';
	}
}

?>