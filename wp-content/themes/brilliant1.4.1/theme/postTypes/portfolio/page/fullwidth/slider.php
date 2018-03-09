<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Portfolio Page Full Width Slider Project Format Template
 * Created by CMSMasters
 * 
 */


global $selected_numbercolumns_full;

$project_cover = get_post_meta(get_the_ID(), 'project_cover', true);

$attachments =& get_children(array(
	'post_type' => 'attachment', 
	'post_mime_type' => 'image', 
	'post_parent' => get_the_ID(), 
	'orderby' => 'menu_order', 
	'order' => 'ASC', 
	'exclude' => get_post_thumbnail_id(get_the_ID()) 
));

if (!$selected_numbercolumns_full) {
    $selected_numbercolumns_full = 'four_blocks';
}

if ($selected_numbercolumns_full == 'four_blocks' || $selected_numbercolumns_full == 'three_blocks') {
    $project_thumb = 'project-thumb';
} elseif ($selected_numbercolumns_full == 'two_blocks') {
    $project_thumb = 'post-thumbnail';
} elseif ($selected_numbercolumns_full == 'one_block') {
    $project_thumb = 'full-thumb';
}

$pt_sort_categs = get_the_terms(0, 'pt-sort-categ');

if ($pt_sort_categs != '') {
	$pt_categs = '';
	
	foreach ($pt_sort_categs as $pt_sort_categ) {
		$pt_categs .= ' ' . $pt_sort_categ->slug;
	}
	
	$pt_categs = ltrim($pt_categs, ' ');
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('format-slider'); ?> data-category="<?php echo $pt_categs; ?>">
	<div class="portfolio_inner">
	<?php 
		
		if ($project_cover == 'true' && has_post_thumbnail()) {
			cmsms_thumb(get_the_ID(), $project_thumb, true, false, true, false, true, true, false);
		} elseif (sizeof($attachments) > 1 || (sizeof($attachments) == 1 && has_post_thumbnail())) {
		?>
		<div class="shortcode_slideshow" id="slideshow_<?php the_ID(); ?>">
			<div class="shortcode_slideshow_body">
				<script type="text/javascript">
					jQuery(window).load(function () { 
						jQuery('#slideshow_<?php the_ID(); ?> .shortcode_slideshow_slides').cmsmsResponsiveContentSlider( { 
							sliderWidth : '100%', 
							sliderHeight : 'auto', 
							animationSpeed : 500, 
							animationEffect : 'slide', 
							animationEasing : 'easeInOutExpo', 
							pauseTime : 0, 
							activeSlide : 1, 
							touchControls : true, 
							pauseOnHover : false, 
							arrowNavigation : false, 
							slidesNavigation : true 
						} ); 
					} );
				</script>
				<div class="shortcode_slideshow_container">
					<ul class="shortcode_slideshow_slides responsiveContentSlider">
					<?php 
					if (has_post_thumbnail()) {
						echo '<li>' . 
							'<figure>' . 
								wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), $project_thumb, false, array( 
									'class' => 'fullwidth', 
									'alt' => cmsms_title(get_the_ID(), false), 
									'title' => cmsms_title(get_the_ID(), false), 
									'style' => 'width:100%; height:auto;' 
								)) . 
							'</figure>' . 
						'</li>';
					}
					
					foreach ($attachments as $attachment) {
						echo '<li>' . 
							'<figure>' . 
								wp_get_attachment_image($attachment->ID, $project_thumb, false, array( 
									'class' => 'fullwidth', 
									'alt' => $attachment->post_title, 
									'title' => $attachment->post_title, 
									'style' => 'width:100%; height:auto;' 
								)) . 
							'</figure>' . 
						'</li>';
					}
					?>
					</ul>
				</div>
			</div>
		</div>
		<?php 
		} else if (sizeof($attachments) == 1 && !has_post_thumbnail()) {
			foreach ($attachments as $attachment) {
				cmsms_thumb(get_the_ID(), $project_thumb, false, 'prettyPhoto', true, true, true, true, $attachment->ID, 'full');
			}
		} else if (has_post_thumbnail()) {
			cmsms_thumb(get_the_ID(), $project_thumb, false, 'prettyPhoto', true, true, true, true, false, 'full');
		}
		
		cmsms_heading(get_the_ID(), 'project', 'fullwidth');
		
		cmsms_meta('project', 'page', get_the_ID(), 'pt-sort-categ', 'fullwidth');
		
		cmsms_exc_cont('project', 'fullwidth');
		
		cmsms_more(get_the_ID(), 'project', 'fullwidth');
	?>
		<div class="cl"></div>
	</div>
</article>