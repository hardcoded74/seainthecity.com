<?php
/*
Template Name: Authorize.net Checkout Template
*/
global $in_authnet_checkout_template;
$in_authnet_checkout_template = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo (get_option('authnet_checkout_title')); ?></title>
<link href="<?php echo $link_to_css; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $link_to_js; ?>"></script>
</head>

<body>
<div id="authnet_container"><!--CONTAINER START-->
	<div id="authnet_wrapper"><!--WRAPPER START-->
		<div class="authnet_header_part">
			<div class="authnet_logo_area">
				<?php if (get_option('authnet_checkout_header_brand') == 'logo') { ?>
				<img src="<?php echo get_option('authnet_checkout_logo'); ?>" />
				<?php } else if (get_option('authnet_checkout_header_brand') == 'text') { ?>
				<h1><?php echo get_option('authnet_checkout_text'); ?></h1>
				<?php } else { ?>
				Checkout
				<?php } ?>
			</div>
			<div class="authnet_menu">
				<?php echo (get_option('authnet_checkout_headerhtml')); ?>
			</div>
		</div>
		<!--CONTAIN START-->
		<div class="authnet_precontain_area">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
<?php endwhile; // end of the loop. ?>

		</div>
		<!--CONTAIN END-->
	</div><!--WRAPPER END-->
</div><!--CONTAINER END-->

<div id="authnet_footer_area"><!--FOOTER START-->
	<div class="authnet_footer_wrapper">
		<div class="authnet_footer_list_area">			
			<div><?php echo (get_option('authnet_checkout_copyright')); ?></div>
			<span><?php echo (get_option('authnet_checkout_footerhtml')); ?></span>
		</div>		
	</div>
</div><!--FOOTER END-->

</body>
</html>
