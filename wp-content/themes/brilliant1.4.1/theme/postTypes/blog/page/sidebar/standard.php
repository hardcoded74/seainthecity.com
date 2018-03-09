<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Blog Page with Sidebar Standard Post Format Template
 * Created by CMSMasters
 * 
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php cmsms_heading(get_the_ID()); ?>
	</header>
	<footer class="entry-meta">
		<div class="cmsms_info">
			<?php cmsms_meta(); 
			
				cmsms_comments();
			?>
		</div>
	</footer>
	<div class="divider"></div>
	<?php 
		if (has_post_thumbnail()) { 
			echo '<div class="blog_media">';
			
			cmsms_thumb(get_the_ID(), 'post-thumbnail', true, false, true, false, true, true, false);
			
			echo '</div>';
		}
	?>
    <?php 
		cmsms_exc_cont();
		
		cmsms_tags(get_the_ID(), 'post', 'page');
		
		cmsms_more(get_the_ID());
	?>
</article>