<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Blog Page Full Width Quote Post Format Template
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
	<blockquote>
		<?php 
			if (has_excerpt()) {
				the_excerpt();
			} else {
				echo '<p>' . __('Enter post excerpt', 'cmsmasters') . '</p>';
			}
		?>
	</blockquote>
	<div class="entry-content">
		<?php 
			if (get_the_content('') != '') { 
				global $more;
				
				$more = 0;
				
				the_content('');
			}
		?>
	</div>
	<?php 
		cmsms_tags(get_the_ID(), 'post', 'page');
	?>
</article>