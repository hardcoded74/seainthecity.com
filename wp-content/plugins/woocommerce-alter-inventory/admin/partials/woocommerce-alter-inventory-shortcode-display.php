<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.altertech.it/
 * @since    1.2.4
 *
 * @package    Woocommerce_Alter_Inventory
 * @subpackage Woocommerce_Alter_Inventory/admin/partials
 */

?>
        <section class="alter_inventory_page" id="alter_inventory_page">
            <div class="alter_inventory_header">
                <script type="text/javascript">
                //Remove parameter after page load
                jQuery(document).one('ready',function(){
                    if (location.href.indexOf("?") > -1 || window.location.href.indexOf("=") > -1 || window.location.href.indexOf("&") > -1 ) {
                                    location.href = location.protocol + "//" + 
                                    location.host + 
                                    location.pathname + 
                                    location.hash.split('?')[0];
                        } 
                    });
                </script>
                <?php 
                if (sizeof(WC()->cart->get_cart()) != 0) {
                if (sizeof(WC()->cart->get_cart()) > 1) {
                    $head_sell = __('SELLING PRODUCTS', 'woocommerce-alter-inventory');
                } else {
                    $head_sell = __('SELLING PRODUCT', 'woocommerce-alter-inventory');
                }
                echo '<h2>' . $head_sell . '</h2>';
                //include_once( 'woocommerce-alter-inventory-custom-cart.php' );
                echo do_shortcode('[woocommerce_cart]', 'alterinventory');
                echo do_shortcode('[woocommerce_checkout]', 'woocommerce-alter-inventory');
                } //End Custom Cart
                ?>
            </div>
            <div class="alter_inventory_container">
                <div class="tabs_at">
                    <h2 class="product_at_tab active"><?php echo __('Products', 'woocommerce-alter-inventory'); ?></h2>    
                    <h2 class="variants_at_tab"><?php echo __('Variants', 'woocommerce-alter-inventory'); ?></h2>
                </div>            
            <div id="variants_table_wrap">
                <table class="pagination_at" width="100%"  cellspacing="0" cellpadding="2"  >
                    <thead >
                        <tr>
                            <th scope="col" ><?php _e('IMAGE', 'woothemes'); ?></th>
                            <th scope="col" ><?php _e('VARIANT', 'woocommerce-alter-inventory'); ?></th>
                            <th scope="col" ><?php _e('SKU', 'woocommerce-alter-inventory'); ?></th>
                            <th scope="col" ><?php _e('PRICE', 'woocommerce-alter-inventory'); ?></th>
                            <th scope="col" ><?php _e('SELL PRICE', 'woocommerce-alter-inventory'); ?></th>
                            <th scope="col" ><?php _e('ATTRIBUTE', 'woocommerce-alter-inventory'); ?></th>
                            <th scope="col" ><?php _e('STOCK', 'woocommerce-alter-inventory'); ?></th>                       
                            <th class="order-number" scope="col" ><?php _e('BUY', 'woothemes'); ?></th>
                        </tr>
                    </thead>
        <tbody>
                <?php
        $args = array(
                    'post_type' => 'product_variation',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC'           
                );
                //	Loop Product Variation 
                $loop = new WP_Query($args);
                while ($loop->have_posts()) : $loop->the_post();
                    $product = new WC_Product_Variation($loop->post->ID);
                    $attrs = array();
                    if ($product->variation_data != "") {
                        $terms = wc_get_attribute_taxonomies();

                        foreach ($terms as $term) {
                            $termMap['attribute_pa_' . $term->attribute_name] = $term->attribute_label;
                        }

                        foreach ($product->variation_data as $attributeKey => $value) {
                            if (isset($termMap[$attributeKey])) {
                                $attrs[] = $termMap[$attributeKey] . " : " . $value;
                            } else {
                                $attrs[] = $value;
                            }
                        }
                    }
                    if ($product->stock == 1){
                    $piece = "peace";    
                    } else {
                    $piece = "peaces";                            
                    }
                    $out_of_stock = __('Out of stock', 'woocommerce-alter-inventory');
                ?>
                        <tr class="order">
                            <td scope="col"  class="thumb column-thumb"><?php echo $product->get_image($size = 'shop_thumbnail'); ?></td>
                            <td scope="col" class="order-number"><?php echo $product->get_title(); ?></td>
                            <td scope="col" class="order-number"><?php echo $product->sku; ?> </td>
                            <td scope="col" class="order-number"><?php echo $product->regular_price; ?> <strong>€</strong></td>
                            <td scope="col" class="order-number"><?php echo $product->sale_price; ?></td>				                
                            <td scope="col" class="order-number prod_attrs"><?php echo join("</br>", $attrs); ?></td>
                            <td scope="col" class="order-number"><?php echo $product->stock ." <strong>".__($piece, 'woocommerce-alter-inventory')."</strong>"; ?></td>
                            <td scope="col" class="order-number button_add">
                            <?php
                            if ($product->stock_status == 'instock') {
                            echo apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button btn-default alt %s product_type_%s">%s</a>', esc_url($product->add_to_cart_url($current_url)), esc_attr($product->id), esc_attr($product->get_sku()), $product->is_purchasable() ? 'add_to_cart_button' : '', esc_attr($product->product_type), esc_html($product->add_to_cart_text())), $product);                                
                            } else {
                            echo '<a href="#" style="background:#ccc;background-color:#ccc;" class="button btn-default alt add_to_cart_button product_type_variation">'.$out_of_stock.'</a>';    
                            }
                            ?> 
                            </td>
                        </tr>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
                    </tbody>
                </table>

            </div>
                <div class="clearfix"></div>
            <div id="products_table_wrap_at">
                <table class="pagination_at" width="100%" cellspacing="0" cellpadding="2" >
                <thead>
                    <tr>
                        <th scope="col" ><?php _e('IMAGE', 'woocommerce-alter-inventory'); ?></th>
                        <th scope="col" ><?php _e('PRODUCT', 'woocommerce-alter-inventory'); ?></th>
                        <th scope="col" ><?php _e('SKU', 'woocommerce-alter-inventory'); ?></th>
                        <th scope="col" ><?php _e('PRICE', 'woocommerce-alter-inventory'); ?></th>
                        <th scope="col" ><?php _e('SELL PRICE', 'woocommerce-alter-inventory'); ?></th>
                        <th scope="col" ><?php _e('STOCK', 'woocommerce-alter-inventory'); ?></th>
                        <th class="order-number" scope="col" ><?php _e('BUY', 'woocommerce-alter-inventory'); ?></th>
                    </tr>
                </thead>
                <tbody>
        <?php
        $args2 = array(
            'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'orderby' => 'sku',
                    'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => array('simple'),
                    'operator' => 'IN'
                )
            )
        );
                    $loop = new WP_Query($args2);
                    while ($loop->have_posts()) : $loop->the_post();
                    global $product;
                    if ($product->stock == 1){
                    $piece = "peace";    
                    } else {
                    $piece = "peaces";                            
                    }            
        ?>
                    <tr class="order">
                        <td scope="col"  class="thumb column-thumb" ><?php echo $product->get_image($size = 'shop_thumbnail'); ?></td>
                        <td scope="col" class="order-number prod_title"><?php echo $product->get_title(); ?></td>
                        <td scope="col" class="order-number prod_sku"><?php echo $product->sku; ?></td>											
                        <td scope="col" class="order-number prod_price"><?php echo $product->price; ?></td>
                        <td scope="col" class="order-number prod_sale"><?php echo $product->sale_price; ?></td>	
                        <td scope="col" class="order-number prod_stock"><?php echo $product->stock." <strong>".__($piece, 'woocommerce-alter-inventory')."</strong>"; ?></td>
                        <td scope="col" class="order-number button_add"  />
                        <?php
                        if ($product->stock_status == 'instock') {
                            echo apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button btn-default alt %s product_type_%s">%s</a>', esc_url($product->add_to_cart_url($current_url)), esc_attr($product->id), esc_attr($product->get_sku()), $product->is_purchasable() ? 'add_to_cart_button' : '', esc_attr($product->product_type), esc_html($product->add_to_cart_text())), $product);                                
                        } else {
                        echo '<a href="#" style="background:#ccc;background-color:#ccc;" class="button %s product_type_%s">'.$out_of_stock.'</a>';    
                        }
                        ?>                        
                        </td>
                    </tr>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
            </tbody>
        </table>

            </div>
            </div>
        </section>