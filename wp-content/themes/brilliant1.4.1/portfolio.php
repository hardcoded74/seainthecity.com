<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Template Name: Portfolio
 * Created by CMSMasters
 * 
 */


get_header();

$page_layout = get_post_meta(get_the_ID(), 'page_layout', true);

if (!$page_layout) { 
    $page_layout = 'nobg'; 
}

$portfolio_categ = get_post_meta(get_the_ID(), 'portfolio_categ', true);
$selected_perpage = get_post_meta(get_the_ID(), 'selected_perpage', true);
$selected_order = get_post_meta(get_the_ID(), 'selected_order', true);
$selected_order_type = get_post_meta(get_the_ID(), 'selected_order_type', true);
$selected_numbercolumns_sidebar = get_post_meta(get_the_ID(), 'selected_numbercolumns_sidebar', true);

if (!$selected_numbercolumns_sidebar) { 
    $selected_numbercolumns_sidebar = 'three_blocks'; 
}

$selected_numbercolumns_full = get_post_meta(get_the_ID(), 'selected_numbercolumns_full', true);

if (!$selected_numbercolumns_full) { 
    $selected_numbercolumns_full = 'four_blocks'; 
}

if ($page_layout != 'nobg') {
    $selected_numbercolumns = $selected_numbercolumns_sidebar;
} else {
    $selected_numbercolumns = $selected_numbercolumns_full;
}

?>
<!--_________________________ Start Content _________________________ -->
<?php 
	if ($page_layout == 'sidebar_bg') {
		echo '<section id="content">';
	} elseif ($page_layout == 'sidebar_bg sidebar_left') {
		echo '<section id="content" class="fr">';
	} else {
		echo '<section id="middle_content">';
	}
	
	if (have_posts()) : the_post();
		echo '<div class="entry">';
		
		if (has_post_thumbnail()) {
			if ($page_layout == 'sidebar_bg' || $page_layout == 'sidebar_bg sidebar_left') {
				echo '<div class="cmsms_media">';
				
				cmsms_thumb(get_the_ID(), 'post-thumbnail', false, 'prettyPhoto', true, false, true, true, false);
				
				echo '</div>';
			} else {
				echo '<div class="cmsms_media">';
				
				cmsms_thumb(get_the_ID(), 'full-thumb', false, 'prettyPhoto', true, false, true, true, false);
				
				echo '</div>';
			}
		}
		
		if (get_the_content() != '') {
			echo '<div class="entry-content">';
			
			the_content();
			
			echo '</div>';
			
			wp_link_pages('before=<div class="subpage_nav"><strong>' . __('Pages', 'cmsmasters') . ':</strong>&link_before= [ &link_after= ] &after=</div>');
		}
		
		if (has_post_thumbnail() || get_the_content() != '') {
			echo '<div class="divider"></div>' . 
			'<br />';
		}
		
		echo '</div>';
	endif;
	
	if (get_query_var('paged')) { 
		$paged = get_query_var('paged'); 
	} elseif (get_query_var('page')) { 
		$paged = get_query_var('page'); 
	} else { 
		$paged = 1; 
	}
	
	$temp = $wp_query;
	$wp_query= null;
	
	$wp_query = new WP_Query(array(
		'post_type' => 'portfolio', 
		'orderby' => $selected_order_type, 
		'order' => $selected_order, 
		'posts_per_page' => $selected_perpage, 
		'paged' => $paged, 
		'pt-categ' => $portfolio_categ
	));
	
	if ($wp_query->have_posts()) : 
		echo '<div class="entry-summary">' . 
			'<section class="portfolio_container ' . $selected_numbercolumns . '">';
		
		while ($wp_query->have_posts()) : $wp_query->the_post();
			$project_format = get_post_meta(get_the_ID(), 'pt_format', true);
			
			if (!$project_format) { 
				$project_format = 'album'; 
			}
			
			if ($page_layout == 'nobg') {
				get_template_part('theme/postTypes/portfolio/page/fullwidth/' . $project_format);
			} else { 
				get_template_part('theme/postTypes/portfolio/page/sidebar/' . $project_format);
			}
		endwhile;
		
		echo '</section>';
		
		if (function_exists('wp_pagenavi')) {
			wp_pagenavi();
		} 
		
		echo '</div>';
	endif;
	
	$wp_query = null;
	$wp_query = $temp;
	
	wp_reset_query();
	
	if (comments_open()) {
		echo '<br />' . 
		'<div class="divider"></div>';
		
		comments_template();
	}
	
	echo '</section>';
?>
<!-- _________________________ Finish Content _________________________ -->


<!-- _________________________ Start Sidebar _________________________ -->
<?php 
    if ($page_layout == 'sidebar_bg') {
        echo '<section id="sidebar">';

        get_sidebar();

        echo '</section>';
    } elseif ($page_layout == 'sidebar_bg sidebar_left') {
        echo '<section id="sidebar" class="fl">';

        get_sidebar();

        echo '</section>';
    }
?>
<!-- _________________________ Finish Sidebar _________________________ -->


<?php get_footer(); ?>