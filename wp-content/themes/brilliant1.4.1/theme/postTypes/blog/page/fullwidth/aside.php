<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Blog Page Full Width Aside Post Format Template
 * Created by CMSMasters
 * 
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h3 class="entry-title"></h3>
	</header>
	<footer class="entry-meta">
		<div class="cmsms_info">
			<?php cmsms_meta(); 
			
				cmsms_comments();
			?>
		</div>
	</footer>
	<div class="divider"></div>
	<?php echo '<div class="entry-content">' . theme_excerpt(55, false) . '</div>'; ?>
	<?php 
		cmsms_tags(get_the_ID(), 'post', 'page');
	?>
</article>