<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Default Main Page Template
 * Created by CMSMastersjlsxx
 *
 * 
 */


get_header();

?>

<!-- _________________________ Start Content _________________________ -->
<section id="content">
	<div class="entry-summary">
		<section class="blog">
	<?php
		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		
		if (have_posts()) :
			while (have_posts()) : the_post();
				if (get_post_type() == 'post') {
					if (get_post_format() != '') {
						get_template_part('theme/postTypes/blog/page/sidebar/' . get_post_format());
					} else {
						get_template_part('theme/postTypes/blog/page/sidebar/standard');
					}
				}
			endwhile;
			
			if (function_exists('wp_pagenavi')) {
				wp_pagenavi();
			} 
		endif; 
	?>
		</section>
	</div>
</section>
<!-- _________________________ Finish Content _________________________ -->


<!-- _________________________ Start Sidebar _________________________ -->
<section id="sidebar">
	<?php get_sidebar(); ?>
</section>
<!-- _________________________ Finish Sidebar _________________________ -->


<?php get_footer(); ?>