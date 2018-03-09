<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Images Page Template
 * Created by CMSMasters
 * 
 */


get_header();

?>
<!-- _________________________ Start Content _________________________ -->
<section id="content">
	<div class="entry">
		<?php 
		if (have_posts()) : 
			while (have_posts()) : the_post(); 
		?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="entry">
					<p class="attachment" style="text-align:center;"><a href="<?php echo wp_get_attachment_url(get_the_ID()); ?>" rel="prettyPhoto" title="<?php the_title(); ?>"><?php echo wp_get_attachment_image(get_the_ID(), 'medium'); ?></a></p>
					<div class="caption"><?php 
						if (has_excerpt()) { 
							the_excerpt(); 
						} 
					?></div>
					<?php the_content(); ?>
					<br />
					<div class="navigation">
						<div class="fl"><?php previous_image_link(); ?></div>
						<div class="fr"><?php next_image_link(); ?></div>
					</div>
					<br class="cl" />
					<br />
					<p class="postmetadata alt">
					<?php 
						echo __('This entry was posted on', 'cmsmasters') . ' ' . get_the_time('l, F jS, Y') . ' ' . __('at', 'cmsmasters') . ' ' . get_the_time() . ' ' . __('and is filed under', 'cmsmasters') . ' '; 
						
						the_category(', '); 
						
						echo '.';
						
						the_taxonomies();
						
						echo ' ' . __('You can follow any responses to this entry through the', 'cmsmasters') . ' '; 
						
						post_comments_feed_link(__('RSS 2.0', 'cmsmasters')); 
						
						echo ' ' . __('feed', 'cmsmasters') . '.';
						
						if (comments_open() && pings_open()) {
							echo __('You can', 'cmsmasters') . ' <a href="#respond">' . __('leave a response', 'cmsmasters') . '</a>, ' . __('or', 'cmsmasters') . ' <a href="';
							
							trackback_url();
							echo '" rel="trackback">' . __('trackback', 'cmsmasters') . '</a> ' . __('from your own site', 'cmsmasters') . '.';
						} elseif (!comments_open() && pings_open()) {
							echo __('Responses are currently closed, but you can', 'cmsmasters') . ' <a href="';
							
							trackback_url();
							
							echo '" rel="trackback">' . __('trackback', 'cmsmasters') . '</a> ' . __('from your own site', 'cmsmasters') . '.';
						} elseif (comments_open() && !pings_open()) {
							_e('You can skip to the end and leave a response. Pinging is currently not allowed.', 'cmsmasters');
						} elseif (!comments_open() && !pings_open()) {
							_e('Both comments and pings are currently closed.', 'cmsmasters');
						}
						
						edit_post_link(__('Edit this media', 'cmsmasters'), '<div class="cl"></div><span class="link_arrow fr">', '</span><div class="cl"></div>'); 
					?>
					</p>
				</div>
			</div>
		<?php 
			endwhile; 
		endif; 
		?>
	</div>
</section>
<!-- _________________________ Finish Content _________________________ -->


<!-- _________________________ Start Sidebar _________________________ -->
<section id="sidebar">
	<?php get_sidebar(); ?>
</section>
<!-- _________________________ Finish Sidebar _________________________ -->


<?php get_footer(); ?>