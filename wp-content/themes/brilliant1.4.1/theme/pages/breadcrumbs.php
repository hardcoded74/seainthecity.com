<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Custom Breadcrumbs Template
 * Created by CMSMasters
 * 
 */
?>


<!-- _________________________ Start Breadcrumbs _________________________ -->
<?php 
	$breadcrumbs_active = get_post_meta(get_the_ID(), 'selected_breadcrumbs_active', true);
	$breadcrumbs = get_post_meta(get_the_ID(), 'selected_breadcrumbs', true);
	$breadcrumbs_links = get_post_meta(get_the_ID(), 'selected_breadcrumbs_links', true);
	
	if ($breadcrumbs_active == 'true' && $breadcrumbs != '') {
		echo '<div class="cont_nav"><a href="' . home_url() . '/" class="cms_home">' . __('Home', 'cmsmasters') . '</a>&nbsp; /&nbsp; ';
		
		$breadcrbs = explode(';', $breadcrumbs);
		$breadcrbls = explode(';', $breadcrumbs_links);
		$brcrmb = 0;
		
		foreach ($breadcrbs as $breadcrb) {
			echo '<a href="' . $breadcrbls[$brcrmb] . '">' . $breadcrb . '</a>&nbsp; /&nbsp; ';
			
			$brcrmb = $brcrmb + 1;
		}
		
		echo get_the_title() . '</div>' . 
		'<div class="double_divider"></div>';
	} elseif ($breadcrumbs_active == 'false') {
		if (class_exists('simple_breadcrumb')) { 
			$bc = new simple_breadcrumb; 
		}
		
		echo '<div class="double_divider"></div>';
	}
?>
<!-- _________________________ Finish Breadcrumbs _________________________ -->

