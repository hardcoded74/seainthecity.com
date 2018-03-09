<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Blog Post with Sidebar Video Post Format Template
 * Created by CMSMasters
 * 
 */


global $blog_post_title, 
	$blog_post_tags;

$post_video_link = explode(',', str_replace(' ', '', get_post_meta(get_the_ID(), 'post_video_link', true)));

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
		if ($post_video_link[0] != '') {
			$try_link = explode(':', $post_video_link[0], 2);
			
			if ($try_link[0] != 'http') {
				foreach ($post_video_link as $post_video) {
					$link = explode(':', $post_video, 2);

					if ($link[0] != 'http') {
						$video_link[$link[0]] = $link[1];
					}
				}
				
				if (has_post_thumbnail()) {
					$poster = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'post-thumbnail');
					
					$video_link['poster'] = $poster[0];
				}
				
				echo '<div class="cmsms_media">' . 
					cmsmastersSingleVideoPlayer($video_link) . 
				'</div>';
			} else {
				echo '<div class="cmsms_media">' . 
					'<div class="resizable_block">' . 
						get_video_iframe($post_video_link[0]) . 
					'</div>' . 
				'</div>';
			}
		}
	?>
	<div class="entry-content">
    <?php 
		the_content();
		
		wp_link_pages('before=<div class="subpage_nav"><strong>' . __('Pages', 'cmsmasters') . ':</strong>&link_before= [ &link_after= ] &after=</div>');
	?>
	</div>
	<?php 
	if ($blog_post_tags && get_the_tags()) {
		cmsms_tags(get_the_ID(), 'post', 'post');
	}
	?>
</article>