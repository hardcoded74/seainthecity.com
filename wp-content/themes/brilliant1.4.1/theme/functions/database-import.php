<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Import to Wordpress Database
 * Created by CMSMasters
 * 
 */


global $wpdb, $shortname;


if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . $shortname . '_bgs"') != $wpdb->prefix . $shortname . '_bgs') {
	$table = $wpdb->prefix . $shortname . '_bgs';
	
	$create_query = "CREATE TABLE $table (
		id INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
		bg_type VARCHAR(10) NOT NULL,
		bg_url VARCHAR(255) NOT NULL,
		bg_thumb_url VARCHAR(255) NOT NULL,
		bg_position_y VARCHAR(10) NOT NULL,
		bg_position_x VARCHAR(10) NOT NULL,
		bg_repeat VARCHAR(10) NOT NULL,
		bg_attachment VARCHAR(10) NOT NULL,
		bg_property_desc VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
	) DEFAULT CHARSET = utf8;";
	
	$wpdb->query($create_query);
	
	$objDOM = new DOMDocument();
	$objDOM->load(TEMPLATEPATH . '/theme/import/bgs.xml');
	$bgs = $objDOM->getElementsByTagName('bg');
	
	foreach ($bgs as $bg){
		$bg_type = $bg->getAttribute('type');
		$bg_url = $bg->getElementsByTagName('bg_url');
		$bg_url = $bg_url->item(0)->nodeValue;
		$bg_thumb_url = $bg->getElementsByTagName('bg_thumb_url');
		$bg_thumb_url = $bg_thumb_url->item(0)->nodeValue;
		$bg_position_y = $bg->getElementsByTagName('bg_position_y');
		$bg_position_y = $bg_position_y->item(0)->nodeValue;
		$bg_position_x = $bg->getElementsByTagName('bg_position_x');
		$bg_position_x = $bg_position_x->item(0)->nodeValue;
		$bg_repeat = $bg->getElementsByTagName('bg_repeat');
		$bg_repeat = $bg_repeat->item(0)->nodeValue;
		$bg_attachment = $bg->getElementsByTagName('bg_attachment');
		$bg_attachment = $bg_attachment->item(0)->nodeValue;
		$bg_property_desc = $bg->getElementsByTagName('bg_property_desc');
		$bg_property_desc = $bg_property_desc->item(0)->nodeValue;
		
		$wpdb->query($wpdb->prepare("INSERT INTO $table (bg_type, bg_url, bg_thumb_url, bg_position_y, bg_position_x, bg_repeat, bg_attachment, bg_property_desc) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", array($bg_type, $bg_url, $bg_thumb_url, $bg_position_y, $bg_position_x, $bg_repeat, $bg_attachment, $bg_property_desc))); 
	}
}


if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . $shortname . '_fonts"') != $wpdb->prefix . $shortname . '_fonts') {
	$table = $wpdb->prefix . $shortname . '_fonts';
	
	$create_query = "CREATE TABLE $table (
		id INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
		font_type VARCHAR(10) NOT NULL,
		font_name VARCHAR(100) NOT NULL,
		font_parameter VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
	) DEFAULT CHARSET = utf8;";
	
	$wpdb->query($create_query);
	
	$objDOM = new DOMDocument();
	$objDOM->load(TEMPLATEPATH . '/theme/import/fonts.xml');
	$fonts = $objDOM->getElementsByTagName('font');
	
	foreach ($fonts as $font) {
		$font_type = $font->getAttribute('type');
		$font_name = $font->getElementsByTagName('font_name');
		$font_name = $font_name->item(0)->nodeValue;
		$font_parameter = $font->getElementsByTagName('font_parameter');
		$font_parameter = $font_parameter->item(0)->nodeValue;
		
		$wpdb->query($wpdb->prepare("INSERT INTO $table (font_type, font_name, font_parameter) VALUES (%s, %s, %s)", array($font_type, $font_name, $font_parameter)));
	}
}


if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . $shortname . '_forms"') != $wpdb->prefix . $shortname . '_forms') {
	$table = $wpdb->prefix . $shortname . '_forms';
	
	$create_query = "CREATE TABLE $table (
		id INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
		number INT(4) NOT NULL,
		slug VARCHAR(255) NOT NULL,
		parent_slug VARCHAR(255) NOT NULL,
		type VARCHAR(20) NOT NULL,
		label VARCHAR(255) NOT NULL,
		value TEXT NULL,
		description TEXT NULL,
		parameters VARCHAR(255) NULL,
		UNIQUE KEY id (id)
	) DEFAULT CHARSET = utf8;";
	
	$wpdb->query($create_query);
	
	$objDOM = new DOMDocument();
	$objDOM->load(TEMPLATEPATH . '/theme/import/forms.xml');
	$forms = $objDOM->getElementsByTagName('form');
	
	foreach ($forms as $form) {
		$field_type = $form->getAttribute('type');
		$field_number = $form->getElementsByTagName('field_number');
		$field_number = $field_number->item(0)->nodeValue;
		$field_slug = $form->getElementsByTagName('field_slug');
		$field_slug = $field_slug->item(0)->nodeValue;
		$field_p_slug = $form->getElementsByTagName('field_p_slug');
		$field_p_slug = $field_p_slug->item(0)->nodeValue;
		$field_label = $form->getElementsByTagName('field_label');
		$field_label = $field_label->item(0)->nodeValue;
		$field_value = $form->getElementsByTagName('field_value');
		$field_value = $field_value->item(0)->nodeValue;
		$field_descr = $form->getElementsByTagName('field_descr');
		$field_descr = $field_descr->item(0)->nodeValue;
		$field_params = $form->getElementsByTagName('field_params');
		$field_params = $field_params->item(0)->nodeValue;
		
		$wpdb->query($wpdb->prepare("INSERT INTO $table (number, slug, parent_slug, type, label, value, description, parameters) VALUES (%d, %s, %s, %s, %s, %s, %s, %s)", array($field_number, $field_slug, $field_p_slug, $field_type, $field_label, $field_value, $field_descr, $field_params)));
	}
}


if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . $shortname . '_icons"') != $wpdb->prefix . $shortname . '_icons') {
	$table = $wpdb->prefix . $shortname . '_icons';
	$create_query = "CREATE TABLE $table (
		id INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
		icon_name VARCHAR(50) NOT NULL,
		icon_file VARCHAR(100) NOT NULL,
		icon_tooltip VARCHAR(255) NOT NULL,
		icon_link VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
	) DEFAULT CHARSET = utf8;";
	
	$wpdb->query($create_query);
	
	$objDOM = new DOMDocument();
	$objDOM->load(TEMPLATEPATH . '/theme/import/icons.xml');
	$icons = $objDOM->getElementsByTagName('icon');
	
	foreach ($icons as $icon) {
		$icon_name = $icon->getAttribute('name');
		$icon_file = $icon->getElementsByTagName('icon_file');
		$icon_file = $icon_file->item(0)->nodeValue;
		$icon_tooltip = $icon->getElementsByTagName('icon_tooltip');
		$icon_tooltip = $icon_tooltip->item(0)->nodeValue;
		$icon_link = $icon->getElementsByTagName('icon_link');
		$icon_link = $icon_link->item(0)->nodeValue;
		
		$wpdb->query($wpdb->prepare("INSERT INTO $table (icon_name, icon_file, icon_tooltip, icon_link) VALUES (%s, %s, %s, %s)", array($icon_name, $icon_file, $icon_tooltip, $icon_link)));
	}
}


if ($wpdb->get_var( 'SHOW TABLES LIKE "' . $wpdb->prefix . $shortname . '_sliders"' ) != $wpdb->prefix . $shortname . '_sliders') {
	$table = $wpdb->prefix . $shortname . '_sliders';
	$create_query = "CREATE TABLE $table (
		slider_id INT(11) UNSIGNED NOT NULL,
		slide_id INT(11) UNSIGNED NOT NULL,
		option_name VARCHAR(255) NOT NULL,
		option_value VARCHAR(255) NOT NULL,
		INDEX (slider_id, slide_id, option_name)
	) DEFAULT CHARSET = utf8;";
	
	$wpdb->query($create_query);
}


if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . $shortname . '_likes"') != $wpdb->prefix . $shortname . '_likes') {
	$table = $wpdb->prefix . $shortname . '_likes';
	
	$create_query = "CREATE TABLE $table (
		id INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
		time TIMESTAMP NOT NULL,
		post_id int(9) NOT NULL,
		ip VARCHAR(15) NOT NULL,
		UNIQUE KEY id (id)
	) DEFAULT CHARSET = utf8;";
	
	$wpdb->query($create_query);
}


wp_redirect(admin_url('admin.php?page=' . $page_handle . '&upgraded=true'));

