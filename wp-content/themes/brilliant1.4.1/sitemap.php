<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Template Name: Sitemap
 * Created by CMSMasters
 * 
 */


get_header();

global $sitemap_pages_show, 
	$sitemap_categories_show, 
	$sitemap_archives_show;

$page_layout = get_post_meta(get_the_ID(), 'page_layout', true);

if (!$page_layout) { 
    $page_layout = 'nobg'; 
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
			
			echo '<br />';
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
	
	if ($sitemap_pages_show) { 
		echo '<h2 style="margin-bottom:30px;">' .  __('Pages', 'cmsmasters') . '</h2>';
		
		wp_nav_menu(array(
			'theme_location' => 'primary', 
			'container' => '', 
			'sort_column' => 'menu_order', 
			'menu_class' => 'sitemap navigation_menu',
			'before' => '<span>',
			'after' => '</span>'
		));
		
		echo '<div class="cl"></div>' . 
		'<br />';
	}
	
	if ($sitemap_categories_show) {
	?>
		<br />
		<h2><?php _e('Categories', 'cmsmasters'); ?></h2>
		<ul class="sitemap_category">
		<?php 
			wp_list_categories(array(
				'title_li' => '', 
				'orderby' => 'name', 
				'order' => 'ASC' 
			)); 
		?>
		</ul>
		<div class="cl"></div>
		<br />
	<?php 
	}
	
	if ($sitemap_archives_show) {
	?>
		<h2><?php _e('Archives', 'cmsmasters'); ?></h2>
		<ul class="cms_archive">
		<?php 
			wp_get_archives(array('show_post_count' => true, 
				'format' => 'custom', 
				'before' => '<li>', 
				'after' => '</li>' 
			)); 
		?>
		</ul>
		<div class="cl"></div>
		<br />
	<?php 
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