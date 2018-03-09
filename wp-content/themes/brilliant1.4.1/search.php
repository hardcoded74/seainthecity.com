<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Search Page Template
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
			echo '<div class="error_block">' . 
				'<h2>' . 
					__('Nothing found. Try another search?', 'cmsmasters') . 
				'</h2>';
			
			get_search_form();
			
			echo '</div>';
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
				} elseif (get_post_type() == 'page') { 
				?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
						<?php 
							cmsms_heading(get_the_ID());
						?>
						</header>
						<?php 
							if (has_post_thumbnail()) { 
								echo '<div class="cmsms_media">';
								
								cmsms_thumb(get_the_ID(), $image_width, $image_height, true, false, true, true);
								
								echo '</div>';
							}
						?>
						<div class="entry-content">
							<h6><?php _e('This page contains your query', 'cmsmasters'); ?></h6>
						</div>
						<footer class="entry-meta">
							<?php cmsms_more(get_the_ID()); ?>
						</footer>
					</article>
				<?php 
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