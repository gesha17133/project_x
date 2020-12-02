<?php 

remove_action( 'woocommerce_before_add_to_cart_button', 'action_woocommerce_before_add_to_cart_button', 10, 0 ); 

remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_title', 5 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );

add_action( 'woocommerce_before_single_product','woocommerce_template_single_title', 5 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

remove_action("woocommerce_after_shop_loop_item_title", "woocommerce_template_loop_price");

remove_action("woocommerce_after_shop_loop_item", "woocommerce_template_loop_add_to_cart");

remove_action( 'woocommerce_after_add_to_cart_quantity', 'action_woocommerce_after_add_to_cart_quantity', 10, 0 ); 
