<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Portfolio Page with Sidebar Album Project Format Template
 * Created by CMSMasters
 * 
 */


global $selected_numbercolumns_sidebar;

$project_cover = get_post_meta(get_the_ID(), 'project_cover', true);

$attachments =& get_children(array(
	'post_type' => 'attachment', 
	'post_mime_type' => 'image', 
	'post_parent' => get_the_ID(), 
	'orderby' => 'menu_order', 
	'order' => 'ASC', 
	'exclude' => get_post_thumbnail_id(get_the_ID()) 
));

if (!$selected_numbercolumns_sidebar) {
    $selected_numbercolumns_sidebar = 'three_blocks';
}

if ($selected_numbercolumns_sidebar == 'three_blocks' || $selected_numbercolumns_sidebar == 'two_blocks') {
    $project_thumb = 'project-thumb';
} elseif ($selected_numbercolumns_sidebar == 'one_block') {
    $project_thumb = 'post-thumbnail';
}

$pt_sort_categs = get_the_terms(0, 'pt-sort-categ');

if ($pt_sort_categs != '') {
	$pt_categs = '';
	
	foreach ($pt_sort_categs as $pt_sort_categ) {
		$pt_categs .= ' ' . $pt_sort_categ->slug;
	}
	
	$pt_categs = ltrim($pt_categs, ' ');
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('format-album' . (($project_cover == 'true' && has_post_thumbnail()) ? ' format-cover' : '')); ?> data-category="<?php echo $pt_categs; ?>">
	<div class="portfolio_inner">
	<?php 
		
		if ($project_cover == 'true' && has_post_thumbnail()) {
			cmsms_thumb(get_the_ID(), $project_thumb, true, false, true, false, true, true, false);
		} elseif (has_post_thumbnail()) {
			cmsms_thumb(get_the_ID(), $project_thumb, false, 'prettyPhoto[' . get_the_ID() . ']', true, false, true, true, false, 'full');
		} elseif (sizeof($attachments) > 1) {
			foreach ($attachments as $attachment) {
				if (!isset($counter) && $counter = true) {
					cmsms_thumb(get_the_ID(), $project_thumb, false, 'prettyPhoto[' . get_the_ID() . ']', true, false, true, true, $attachment->ID, 'full');
				}
			}
		}
		
		if ( 
			($project_cover != 'true' && sizeof($attachments) > 1) || 
			($project_cover != 'true' && has_post_thumbnail() && sizeof($attachments) == 1) 
		) {
			echo '<div style="display:none;">';
			
			foreach ($attachments as $attachment) {
				if (!isset($counter)) {
					echo '<a href="' . $attachment->guid . '" rel="prettyPhoto[' . get_the_ID() . ']" title="' . $attachment->post_title . '">' . 
						wp_get_attachment_image($attachment->ID, 'full', false, array( 
							'class' => 'fullwidth', 
							'alt' => $attachment->post_title, 
							'title' => $attachment->post_title 
						)) . 
					'</a>';
				} else {
					unset($counter);
				}
			}
			
			echo '</div>';
		}
		
		cmsms_heading(get_the_ID(), 'project', 'sidebar');
		
		cmsms_meta('project', 'page', get_the_ID(), 'pt-sort-categ', 'sidebar');
		
		cmsms_exc_cont('project', 'sidebar');
		
		cmsms_more(get_the_ID(), 'project', 'sidebar');
	?>
		<div class="cl"></div>
	</div>
</article>