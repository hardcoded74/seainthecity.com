<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Comments Template
 * Created by CMSMasters
 * 
 */


if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
    die(__('Please do not load this page directly. Thanks!', 'cmsmasters'));
}

if (post_password_required()) { 
	echo '<p class="nocomments">' . __('This post is password protected. Enter the password to view comments.', 'cmsmasters') . '</p>';
	
    return;
}

if (have_comments()) : 
?>
<div class="divider"></div>
<aside id="comments">
	<h3><?php comments_number(__('No Comments', 'cmsmasters'), __('Comment', 'cmsmasters') . ' (1)', __('Comments', 'cmsmasters') . ' (%)'); ?></h3>
	<?php if (get_previous_comments_link() || get_next_comments_link()) { ?>
	<aside class="project_navi">
		<span class="fl"><?php previous_comments_link(__('Older Comments', 'cmsmasters')); ?></span>
		<span class="fr"><?php next_comments_link(__('Newer Comments', 'cmsmasters')); ?></span>
		<div class="divider" style="padding-bottom:20px; margin-top:40px;"></div>
	</aside>
	<?php } ?>
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
	</ol>
	<?php if (get_previous_comments_link() || get_next_comments_link()) { ?>
	<aside class="project_navi">
		<span class="fl"><?php previous_comments_link(__('Older Comments', 'cmsmasters')); ?></span>
		<span class="fr"><?php next_comments_link(__('Newer Comments', 'cmsmasters')); ?></span>
		<div class="cl"></div>
	</aside>
</aside>
<?php 
	}
endif; 

if (comments_open()) : 
?>
<div class="divider"></div>
<aside id="respond">
	<div class="cancel-comment-reply fr" style="margin:10px 10px 0 0;"><?php cancel_comment_reply_link(__('Cancel Reply', 'cmsmasters')); ?></div>
	<h3><?php comment_form_title(__('Leave a Reply', 'cmsmasters'), __('Leave your comment to', 'cmsmasters').' %s'); ?></h3>
<?php 
	echo '<p>' . __('Your email address will not be published. Required fields are marked', 'cmsmasters') . '</p>';
	
	if (get_option('comment_registration') && !is_user_logged_in()) : 
		echo '<p>' . __('You must be', 'cmsmasters') . ' <a href="' . wp_login_url(get_permalink()) . '">' . __('logged in', 'cmsmasters') . '</a> ' . __('to post a comment', 'cmsmasters') . '.</p>';
	else : 
		echo '<form action="' . get_option('siteurl') . '/wp-comments-post.php" method="post" id="commentform">';
		
		if (is_user_logged_in()) : 
			echo '<p>' . __('Logged in as', 'cmsmasters') . ' <a href="' . get_option('siteurl') . '/wp-admin/profile.php">' . $user_identity . '</a>. <a class="all" href="' . wp_logout_url(get_permalink()) . '" title="' . __('Log out of this account', 'cmsmasters') . '">' . __('Log out', 'cmsmasters') . '</a></p>' . 
			'<div class ="cl"></div>';
		else : 
	?>
			<p>
				<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
				<label><?php _e('Name', 'cmsmasters'); ?> <span class="color_3">*</span></label>
			</p>
			<div class="cl"></div>
			<p>
				<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
				<label><?php _e('Email', 'cmsmasters'); ?> <span class="color_3">*</span></label>
			</p>
			<div class="cl"></div>
			<p>
				<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
				<label><?php _e('Website', 'cmsmasters'); ?></label>
			</p>
			<div class="cl"></div>
   <?php endif; ?>
		<textarea name="comment" id="comment" cols="28" rows="6" tabindex="4"></textarea>
		<div>
		<?php 
			comment_id_fields();
			
			do_action('comment_form', get_the_ID()); 
		?>
		</div>
	</form>
	<div class="cl"></div>
	<br />
	<a class="button" id="submittedContact" href="javascript: submitform();"><span><?php _e('Submit Comment', 'cmsmasters'); ?></span></a>
	<div class="cl"></div>
	<?php endif; ?>	
	<br />
</aside>
<?php endif; ?>