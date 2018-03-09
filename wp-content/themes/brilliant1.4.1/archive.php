<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Archives Page Template
 * Created by CMSMasters
 * 
 */


get_header();

?>

<!-- _________________________ Start Content _________________________ -->
<section id="content">
	<div class="entry-summary">
		<section class="blog portfolio_container one_block">
	<?php
		if (get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		
		if (!have_posts()) : 
			echo '<h2>' . 
				__('No posts found', 'cmsmasters') . 
			'</h2>';
		else : 
			while (have_posts()) : the_post();
				if (get_post_type() == 'post') {
					if (get_post_format() != '') {
						get_template_part('theme/postTypes/blog/page/sidebar/' . get_post_format());
					} else {
						get_template_part('theme/postTypes/blog/page/sidebar/standard');   
					}
				} elseif (get_post_type() == 'portfolio') { 
					$project_format = get_post_meta(get_the_ID(), 'pt_format', true);
					
					if (!$project_format) { 
						$project_format = 'slider'; 
					}
					
					$selected_numbercolumns_sidebar = 'one_block';
					
					get_template_part('theme/postTypes/portfolio/page/sidebar/' . $project_format);
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