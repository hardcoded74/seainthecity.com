<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Blog Post with Sidebar Image Post Format Template
 * Created by CMSMasters
 * 
 */


global $blog_post_title, 
	$blog_post_tags;

$attachments =& get_children(array(
	'post_type' => 'attachment', 
	'post_mime_type' => 'image', 
	'post_parent' => get_the_ID(), 
	'orderby' => 'menu_order', 
	'order' => 'ASC'
));

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-article'); ?>>
	<header class="entry-header">
	<?php 
		if ($blog_post_title) { 
			cmsms_heading_nolink(get_the_ID());
		}
	?>
	</header>
	<footer class="entry-meta">
		<div class="cmsms_info">
			<?php cmsms_meta('post', 'post'); ?>
		</div>
	</footer>
	<div class="divider"></div>
    <?php 
		if (has_post_thumbnail()) { 
			echo '<div class="cmsms_media">';
			
			cmsms_thumb(get_the_ID(), 'slider-thumb', false, 'prettyPhoto', true, true, true, true, false);
			
			echo '</div>';
		} elseif (!has_post_thumbnail() && sizeof($attachments) > 0) {
			foreach ($attachments as $attachment) { 
				if (!isset($counter) && $counter = true) { 
					echo '<div class="cmsms_media">';
					
					cmsms_thumb(get_the_ID(), 'slider-thumb', false, 'prettyPhoto', true, true, true, true, $attachment->ID);
					
					echo '</div>';
				}
			}
		}
	?>
	<div class="entry-content">
    <?php 
		the_content();
	?>
	</div>
	<?php 
	wp_link_pages('before=<div class="subpage_nav"><strong>' . __('Pages', 'cmsmasters') . ':</strong>&link_before= [ &link_after= ] &after=</div>');
	
	if ($blog_post_tags && get_the_tags()) {
		cmsms_tags(get_the_ID(), 'post', 'post');
	}
	?>
</article>