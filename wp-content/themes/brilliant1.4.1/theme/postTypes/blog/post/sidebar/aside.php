<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Blog Post with Sidebar Aside Post Format Template
 * Created by CMSMasters
 * 
 */


global $blog_post_tags;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-article'); ?>>
	<header class="entry-header">
		<h3 class="entry-title"></h3>
	</header>
	<footer class="entry-meta">
		<div class="cmsms_info">
			<?php cmsms_meta('post', 'post'); ?>
		</div>
	</footer>
	<div class="divider"></div>
	<?php 
		if (get_the_content() != '') {
			echo '<div class="entry-content">' . get_the_content() . '</div>';
		} else {
			echo '<div class="entry-content">' . get_the_excerpt() . '</div>';
		}
		
		wp_link_pages('before=<div class="subpage_nav"><strong>' . __('Pages', 'cmsmasters') . ':</strong>&link_before= [ &link_after= ] &after=</div>');
		
		if ($blog_post_tags && get_the_tags()) { 
			cmsms_tags(get_the_ID(), 'post', 'post');
		}
	?>
</article>