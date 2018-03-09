<?php 
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Custom Comments Template
 * Created by CMSMasters
 * 
 */


function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<figure class="alignleft">
				<?php echo get_avatar($comment, $size = '100', $default = '<path_to_url>'); ?>
			</figure>
            <div class="comment-authorinfo">
				<?php 
					comment_reply_link(array_merge($args, array( 
						'depth' => $depth, 
						'max_depth' => $args['max_depth'], 
						'reply_text' => '<span>' . __('Reply', 'cmsmasters') . '</span>' 
					)));
					
					echo '<abbr class="published fr" title="' . get_comment_time('F d, Y') . ' ' . __('at', 'cmsmasters') . ' ' . get_comment_time('g:i a') . '">' . 
						get_comment_time('F d, Y') . ' ' . __('at', 'cmsmasters') . ' ' . get_comment_time('g:i a') . 
					'</abbr>';
				?>
				<h6 class="name"><?php echo get_comment_author_link(); ?></h6>
			</div>	
			<div class="comment-content">
				<?php 
					comment_text();
					
					if ($comment->comment_approved == '0') {
						echo '<p><em>' . __('Your comment is awaiting moderation.', 'cmsmasters') . '</em></p>';
					}
				?>
				<div class="cl"></div>
			</div>	
			<?php edit_comment_link(__('Edit', 'cmsmasters')); ?>
			<div class="cl"></div>
        </div>
    <?php 
}

?>