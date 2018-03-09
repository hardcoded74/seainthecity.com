<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Single Post Template
 * Created by CMSMasters
 * 
 */


get_header();

global $blog_post_nav, 
	$blog_post_related_number;

$page_layout = get_post_meta(get_the_ID(), 'page_layout', true);

if (!$page_layout) { 
    $page_layout = 'sidebar_bg'; 
}

$sharing_box = get_post_meta(get_the_ID(), 'sharing_box_active', true);
$author_box = get_post_meta(get_the_ID(), 'author_box_active', true);
$related_box = get_post_meta(get_the_ID(), 'posts_box_related_active', true);
$popular_box = get_post_meta(get_the_ID(), 'posts_box_popular_active', true);
$recent_box = get_post_meta(get_the_ID(), 'posts_box_recent_active', true);

$related_box = ($related_box == 'true') ? true : false;
$popular_box = ($popular_box == 'true') ? true : false;
$recent_box = ($recent_box == 'true') ? true : false;

?>
<!-- _________________________ Start Content _________________________ -->
<?php 
	if ($page_layout == 'sidebar_bg') {
		echo '<section id="content">';
	} elseif ($page_layout == 'sidebar_bg sidebar_left') {
		echo '<section id="content" class="fr">';
	} else {
		echo '<section id="middle_content">';
	}
	
	if (have_posts()) : the_post();
?>
	<div class="entry">
		<section class="blog opened-article">
		<?php 
		if ($page_layout == 'nobg') {
			if (get_post_format() != '') {
				get_template_part('theme/postTypes/blog/post/fullwidth/' . get_post_format());
			} else {
				get_template_part('theme/postTypes/blog/post/fullwidth/standard');
			}
		} else {
			if (get_post_format() != ''){
				get_template_part('theme/postTypes/blog/post/sidebar/' . get_post_format());
			} else {
				get_template_part('theme/postTypes/blog/post/sidebar/standard');   
			}
		}
		
		if ($blog_post_nav) {
			echo '<div class="divider"></div>';
			echo '<aside class="project_navi">';
			
			next_post_link('<span class="fr">%link</span>', '%title &rarr;'); 
			previous_post_link('<span class="fl">%link</span>', '&larr; %title'); 
			
			echo '</aside>';
			echo '<div class="divider"></div>';
		}
		
		if ($sharing_box == 'true') {
			echo '<aside class="share_posts">' . 
				'<h3>' . __('Like this post?', 'cmsmasters') . '</h3>';
			
			cmsmsLike();
		?>
			<div class="fl">
				<div class="g-plusone" data-size="medium"></div>
				<script type="text/javascript">
					(function () { 
						var po = document.createElement('script'), 
							s = document.getElementsByTagName('script')[0];
						
						po.type = 'text/javascript';
						po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						
						s.parentNode.insertBefore(po, s);
					} )();
				</script>
			</div>
			<div class="fl">
				<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
				<script type="text/javascript">
					!function (d, s, id) { 
						var js = undefined, 
							fjs = d.getElementsByTagName(s)[0];
						
						if (!d.getElementById(id)) { 
							js = d.createElement(s);
							js.id = id;
							js.src = '//platform.twitter.com/widgets.js';
							
							fjs.parentNode.insertBefore(js, fjs);
						}
					} (document, 'script', 'twitter-wjs');
				</script>
			</div>
			<div class="fl">
				<div class="fb-like" data-send="false" data-layout="button_count" data-width="200" data-show-faces="false" data-font="arial"></div>
				<script type="text/javascript">
					(function (d, s, id) { 
						var js = undefined, 
							fjs = d.getElementsByTagName(s)[0];
						
						if (d.getElementById(id)) { 
							return;
						}
						
						js = d.createElement(s);
						js.id = id;
						js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';
						
						fjs.parentNode.insertBefore(js, fjs);
					} (document, 'script', 'facebook-jssdk'));
				</script>
			</div>
			<div class="cl"></div>
			<a class="cmsms_share button" href="#"><span><?php _e('More sharing options', 'cmsmasters'); ?></span></a>
			<div class="cmsms_social cl"></div>
		<?php 
			
			echo '</aside>' . 
			'<div class="divider"></div>';
		}
		
		if ($author_box == 'true') {
			$user_email = get_the_author_meta('user_email') ? get_the_author_meta('user_email') : false;
			$user_nicename = get_the_author_meta('user_nicename') ? get_the_author_meta('user_nicename') : false;
			$user_first_name = get_the_author_meta('first_name') ? get_the_author_meta('first_name') : false;
			$user_last_name = get_the_author_meta('last_name') ? get_the_author_meta('last_name') : false;
			$user_description = get_the_author_meta('description') ? get_the_author_meta('description') : false;
			
			echo '<aside class="about_author">';
			
			$out = '';
			
			if ($user_first_name) { 
				$out .= $user_first_name;
			}
			
			if ($user_first_name && $user_last_name) {
				$out .= ' ' . $user_last_name;
			} elseif ($user_last_name) {
				$out .= $user_last_name;
			}
			
			if (get_the_author() && ($user_first_name || $user_last_name)) {
				$out .= ' (';
			}
			
			if (get_the_author()) {
				$out .= get_the_author();
			}
			
			if (get_the_author() && ($user_first_name || $user_last_name)) {
				$out .= ')';
			}
			
			echo '<h3>' . __('About the author', 'cmsmasters') . '</h3>';
			
			echo '<figure class="fl" style="margin:0 20px 20px 0;">' . 
				get_avatar($user_email, 100, $default='<path_to_url>', $user_nicename) . 
			'</figure>';
			
			if ($out != '') {
				echo '<h5>' . $out . '</h5>';
			}
			
			if ($user_description) {
				echo '<p>' . $user_description . '</p>';
			}
			
			echo '<div class="cl"></div>' . 
			'</aside>' . 
			'<div class="divider"></div>';
		}
		
		if (get_the_tags()) {
			$tgsarray = array();
			
			foreach (get_the_tags() as $tagone) {
				$tgsarray[] = $tagone->term_id;
			}  
		} else {
			$tgsarray = null;
		}
		
		cmsms_related($related_box, $tgsarray, $popular_box, $recent_box, $blog_post_related_number);
		
		comments_template(); 
		?>
		</section>
	</div>
	<?php endif; ?>
</section>
<!-- _________________________ Finish Content _________________________ -->


<!-- _________________________ Start Sidebar _________________________ -->
<?php 
    if ($page_layout == 'sidebar_bg') {
        echo '<section id="sidebar">';

        get_sidebar();

        echo '</section>';
    } elseif ($page_layout == 'sidebar_bg sidebar_left') {
        echo '<section id="sidebar" class="fl">';

        get_sidebar();

        echo '</section>';
    }
?>
<!-- _________________________ Finish Sidebar _________________________ -->


<?php get_footer(); ?>