<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 *
 * Default Page Template
 * Created by CMSMasters
 *
 */


get_header();
?>
<style>
	.content_wrap {
		background-color: #000;
	}
	#middle_content {
		background-color: #000;
		color:#fff;
	}
	h1 {
		color: #fff;
	}
	h2 {
		color: #fff;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li {
		margin-right: 10px;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
		background: #ac1c58;
	}

	li.description_tab {
		margin-left: -12px !important;
	}
	.wc-tabs-wrapper {
		border-bottom: solid .5px;
		margin-top: 25px;
		margin-left: 0px;
	}

	.woocommerce div.product form.cart .button {
		background-color: #ac1c58;
	}
	.woocommerce div.product .product_title {
		visibility: hidden;
		height: 0px;
	}
	.woocommerce div.product p.price, .woocommerce div.product span.price {
		color: dodgerblue;
		font-size: 3.25em;
	}

	.woocommerce div.product .stock {
		color: dodgerblue;
	}
	.woocommerce div.product p.stock {
		font-size: 1.10em;
		padding-left: 15px;
		margin-bottom: 15px;
	}
	.woocommerce .quantity .qty {
		color: #fff;
		font-size: 16px;
	}
	input {
		height:30px !important;
		background-color: darkgray;
	}
	div.product_meta {
		font-size: 13px;
		line-height: 26px;
	}
	.woocommerce ul.products li.product .price {
		color: #fff;

	}
	.term-products .page-head h1 {
		display: none !IMPORTANT;
	}
	h3 {
		color: #fff;
		font-size: 16px !important;
	}
	mark {
	visibility: hidden;
	}
	.woocommerce div.product div.images, .woocommerce div.product div.summary {
		margin-bottom: 5em;
	}
	.woocommerce #reviews #comments h2 {
		clear: none;
		font-size: 12px;
	}
	h1, a.logo span.title {
		visibility: hidden;
		line-height: 5px;
	}
.content_wrap {
   background-color: #000; 
   background-image: none; 
}
</style>
<div style="text-align:right; padding:10px; color: #eeeeee;"><a class="cart-contents fa-shopping-cart" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
</div>
<div style="color:#ac1c58; padding:10px; font-weight:bold; font-size:x-large;">Free Shipping when you purchase $250.00 or more!</div>
<div id="woo_content" class="woo_wrap">
<?php $page_layout = get_post_meta(get_the_ID(), 'page_layout', true);

if (!$page_layout) {
    $page_layout = 'woo_sidebar_bg';
}

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


?>

<?php woocommerce_content(); ?>

<!-- _________________________ Finish Content _________________________ -->


<!--- where side bar would go normally --->
</div>
<?php get_footer(); ?>
