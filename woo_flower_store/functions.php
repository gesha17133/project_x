<?php
/**
 * flower-staff functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package flower-staff
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'woo_flower_store_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function woo_flower_store_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on flower-staff, use a find and replace
		 * to change 'woo_flower_store' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'woo_flower_store', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu_header_primary' => esc_html__( 'Primary', 'woo_flower_store' ),
				'menu_footer_navigation' => esc_html__( 'Footer navigation', 'woo_flower_store' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'woo_flower_store_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		add_image_size( 'custom-size', 220, 180 ); 

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'woo_flower_store_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function woo_flower_store_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'woo_flower_store_content_width', 640 );
}
add_action( 'after_setup_theme', 'woo_flower_store_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function woo_flower_store_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'woo_flower_store' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'woo_flower_store' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar( array(
		'name'          => __('Commerce_sidebar'),
		'id'            => "sidebar_commerce",
		'description'   => 'fuck its fucking fuck',
		'class'         => 'right_content',
		'before_widget' => '',
		'after_widget'  => "",
		'before_title'  => '<div class = "title">',
		'after_title'   => '</div>',
	
	) );


}
add_action( 'widgets_init', 'woo_flower_store_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function woo_flower_store_scripts() {
	wp_enqueue_style( 'woo_flower_store-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'woo_flower_store-style', 'rtl', 'replace' );

	wp_enqueue_script( 'woo_flower_store-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'woo_flower_store_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/woocommerce/woocommerce.php';
}


/*
* Theme custom widgets for sidebar 
*/
// partners area
require get_template_directory() . '/widgets/parnters.php';

//product categories
require get_template_directory() . '/widgets/product_cats.php';

//product on sale
require get_template_directory() . '/widgets/sale-product.php';

//about us section
require get_template_directory() . '/widgets/short_description.php';
/*
* Carbon 
*/
require get_template_directory().'/carbon-fields.php';

/*
* CPT partners  
*/
add_action('init', 'register_partnership');

function register_partnership(){

	register_post_type('partner', array(
	
			'labels'             => array(
			'name'               => __('Partner'), 
			'singular_name'      => __('partnet'), 
			'add_new'            => __('Add Partner'),
			'add_new_item'       => __('Add pertner'),
			'edit_item'          => __('Edit Partner'),
			'new_item'           => __('New partner'),
			'view_item'          => __('See partner'),
			'search_items'       => __('Search Partner'),
			'not_found'          => __('Partners not found'),
			'not_found_in_trash' => __('Partners not found in bin'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Partners')

		  ),

		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor','author','thumbnail','excerpt','comments')
	) );
}


