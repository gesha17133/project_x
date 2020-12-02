<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package flower-staff
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function woo_flower_store_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 150,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'woo_flower_store_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function woo_flower_store_woocommerce_scripts() {
	wp_enqueue_style( 'woo_flower_store-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'woo_flower_store-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'woo_flower_store_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function woo_flower_store_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'woo_flower_store_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function woo_flower_store_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'woo_flower_store_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'woo_flower_store_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function woo_flower_store_woocommerce_wrapper_before() {
		?>
			<div id="primary" class="left_content">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'woo_flower_store_woocommerce_wrapper_before' );

if ( ! function_exists( 'woo_flower_store_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function woo_flower_store_woocommerce_wrapper_after() {
		?>
		<div class="clear"></div>
		</div><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'woo_flower_store_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'woo_flower_store_woocommerce_header_cart' ) ) {
			woo_flower_store_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'woo_flower_store_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function woo_flower_store_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		woo_flower_store_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_flower_store_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'woo_flower_store_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */

	function woo_flower_store_woocommerce_cart_link() {
		?>
			<?php
			
			$item_count_text = sprintf(
				
				/* translators: number of items in the mini cart. */
				_n( '%d x item', '%d x items', WC()->cart->get_cart_contents_count(), 'woo_flower_store' ),
				WC()->cart->get_cart_contents_count()
				
			);

			?>
			<div class="fix_card_wrap">
				<div class="img_cart">
					<img src="<?php echo get_template_directory_uri(); ?>/images/cart.gif" alt="penis">
				</div>

				<div class="home_cart_content">
					<span class="count"> <?php echo esc_html( $item_count_text ); ?> |</span>
					<span class="amount"><?php esc_html_e('TOTAL')?>: <?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?> </span> 
				</div>
				
				<a class="cart-content custom_sidebar_cart"
				href="<?php echo esc_url( wc_get_cart_url() ); ?>"
				title="<?php esc_attr_e( 'View your shopping cart', 'woo_flower_store' ); ?>">
					<?php _e('view cart') ?>
				</a>
				<div class="clear"></div>
			</div>
		<?php
	}
}

if ( ! function_exists( 'woo_flower_store_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function woo_flower_store_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php woo_flower_store_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar' );
add_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

function woocommerce_get_sidebar(){
	wc_get_template( 'sidebar.php' );
} 



/*
* Tabs rename & remove
*/
function woo_rename_tabs( $tabs ) {

	global $product;
	
	if( $product->has_attributes() || $product->has_dimensions() || $product->has_weight() ) { 
		$tabs['description']['title'] = __( 'More Details' );	
	}
 
	return $tabs;
 
} 

//removes tabs
function woo_remove_product_tabs( $tabs ) {
     			
    unset( $tabs['additional_information'] );

    return $tabs;
}

//new tabs
function woo_new_product_tab( $tabs ) {
    
	$tabs['related_products'] = array(
		'title'    => __( 'Related products', 'woocommerce' ),
		'priority'    => 50,
		'callback'    => 'woo_new_product_tab_content',
	);
	   
	return $tabs;
}

//related tab
function woo_new_product_tab_content(){

	woocommerce_output_related_products();

}


add_filter( 'woocommerce_breadcrumb_defaults', 'breadcrumbs_customization' );

function breadcrumbs_customization( $defaults ) {

	$defaults['delimiter'] = '>>';

	return $defaults;

}

add_filter( 'woocommerce_pagination_args', 'custom_woo_pagination' );
function custom_woo_pagination( $args ) {
	$args['prev_text'] = '<<'; 
	$args['next_text'] = '>>';	
	return $args;
}

require get_template_directory()."/woocommerce/removment.php";


/*woocommerce filtering*/
/* 
$sale_price = get_post_meta( $product->get_id(), '_price', true);

$regular_price = get_post_meta( $product->get_id(), '_regular_price', true);

$sale = ceil(( ($regular_price - $sale_price) / $regular_price ) * 100); */