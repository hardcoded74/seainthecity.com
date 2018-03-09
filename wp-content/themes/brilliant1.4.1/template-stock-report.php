<?php
/*
Template Name: Stock Report :)
*/
if (!is_user_logged_in() || !current_user_can('manage_options')) wp_die('This page is private.');
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php _e('Stock Report'); ?></title>
	<style>
		body { background:white; color:black; width: 95%; margin: 0 auto; }
		table { border: 1px solid #000; width: 100%; }
		table td, table th { border: 1px solid #000; padding: 6px; }
	</style>
</head>
<body>
	<header>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		    <h1 class="title"><?php the_title(); ?></h1>
		
			<?php the_content(); ?>
			
		<?php endwhile; endif; ?>
	</header>
	<section>
	<?php 

	global $woocommerce;
	?>
<table cellspacing="0" cellpadding="2">
		<thead>
			<tr>	
				<th scope="col" style="text-align:left;"><?php _e('Product', 'woothemes'); ?></th>
				<th scope="col" style="text-align:left;"><?php _e('Image', 'woothemes'); ?></th>
				<th scope="col" style="text-align:left;"><?php _e('Price', 'woothemes'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php

		$args = array(
			'post_type'			=> 'product',
			'post_status' 		=> 'publish',
	        'posts_per_page' 	=> -1,
	        'orderby'			=> 'title',
	        'order'				=> 'ASC',
			'meta_query' 		=> array(
	            array(
	                'key' 	=> '_manage_stock',
	                'value' => 'yes'
	            )
	        ),
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'product_type',
					'field' 	=> 'slug',
					'terms' 	=> array('simple'),
					'operator' 	=> 'IN'
				)
			)
		);
		
		$loop = new WP_Query( $args );
	
		while ( $loop->have_posts() ) : $loop->the_post();
		
                        global $product;
			?>
			<tr>
				<td><?php echo $product->get_title(); ?> - <a onclick="return confirm('Mark post sold? You can restore it later.');" href="<?php echo get_delete_post_link($postid); ?>">Mark Sold</a> (Think Twice)</td>
				<td><center><img src="<?php $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); echo $thumb_url[0]; ?>" width="100px" ?></center></td>
				<td><?php echo $product->price; ?></td>
			</tr>
			<?php
		endwhile; 
		
		?>
		</tbody>
	</table>
	
	<h2>&nbsp;</h2>
</body>
</html>

