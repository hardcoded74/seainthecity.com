<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Blog Page with Sidebar Link Post Format Template
 * Created by CMSMasters
 * 
 */


$post_link_text = get_post_meta(get_the_ID(), 'post_link_text', true);
$post_link_link = get_post_meta(get_the_ID(), 'post_link_link', true);

if ($post_link_text == '') {
    $post_link_text = __('Enter link text', 'cmsmasters');
}

if ($post_link_link == '') {
    $post_link_link = '#';
}

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
	<div class="entry_link_content">
		<h3>
			<a href="<?php echo $post_link_link; ?>" target="_blank"><?php echo $post_link_text; ?></a>
		</h3>
		<h6>- <?php echo $post_link_link; ?> -</h6>
		<?php cmsms_exc_cont(); 
			
			cmsms_tags(get_the_ID(), 'post', 'page');
		?>
	</div>
</article>