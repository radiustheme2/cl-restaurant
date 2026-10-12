<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLRestaurant;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class General {

	protected static $instance = null;

	public function __construct() {
		add_action( 'after_setup_theme',	array( $this, 'theme_setup' ) );
		add_action( 'widgets_init',			array( $this, 'register_sidebars' ) );
		add_filter( 'body_class',			array( $this, 'body_classes' ) );
		add_action( 'wp_head',				array( $this, 'noscript_hide_preloader' ), 1 );
		add_action( 'wp_head',				array( $this, 'pingback' ) );
		add_filter( 'upload_mimes',			array( $this, 'cc_mime_types' ));
		add_action( 'site_prealoader',      array( $this, 'cl_restaurant_preloader' ) );
		// add_action( 'wp_body_open',        array( $this, 'preloader' ) );
		// add_action( 'wp_footer',           array( $this, 'scroll_to_top_html' ), 1 );
		add_filter( 'get_search_form',		array( $this, 'search_form' ) );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function theme_setup() {
		// Theme supports
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_theme_support( 'wp-block-styles' );
		remove_theme_support( 'widgets-block-editor' );

		// Image sizes
		$sizes = array(
			'cl-restaurant-size1' => array( 415, 270, true ), // Listing Grid
			//'rdtheme-size2' => array( 270, 240, true ), // Listing Thumbnail Size
			//'rdtheme-size3' => array( 870, 500, true ), // When sidebar present
		);

		$sizes = apply_filters( 'clrestaurant_image_size', $sizes );

		foreach ( $sizes as $size => $value ) {
			add_image_size( $size, $value[0], $value[1], $value[2] );
		}

		// Register menus
		register_nav_menus( array(
			'primary'  => esc_html__( 'Primary', 'clrestaurant' ),
		) );
	}

	public function register_sidebars() {
		$footer_widget_titles1 = array(
			'1' => esc_html__( 'Footer (Style 1) 1', 'clrestaurant' ),
			'2' => esc_html__( 'Footer (Style 1) 2', 'clrestaurant' ),
			'3' => esc_html__( 'Footer (Style 1) 3', 'clrestaurant' ),
			'4' => esc_html__( 'Footer (Style 1) 4', 'clrestaurant' ),
		);	
		$footer_widget_titles2 = array(
			'1' => esc_html__( 'Footer (Style 2) 1', 'clrestaurant' ),
			'2' => esc_html__( 'Footer (Style 2) 2', 'clrestaurant' ),
			'3' => esc_html__( 'Footer (Style 2) 3', 'clrestaurant' ),
			'4' => esc_html__( 'Footer (Style 2) 4', 'clrestaurant' ),
		);
		$widgets_items1 = Options::$options['f1_widgets_area']; 
		$widgets_items2 = Options::$options['f1_widgets_area'];

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar Widgets', 'clrestaurant' ),
			'id'            => 'sidebar',
			'description'   => esc_html__('Sidebar widgets area', 'clrestaurant'),
			'before_widget' => '<div id="%1$s" class="widget %2$s sidebar-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		for ( $i = 1; $i <= $widgets_items1; $i++ ) {
			register_sidebar( array(
				'name'          => $footer_widget_titles1[$i],
				'id'            => 'footer-widget-1-'. $i,
				'before_widget' => '<div id="%1$s" class="widget footer-widgets'. Options::$footer_style .' %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}
		if( class_exists( 'CLRestaurant_Core' ) ){
			for ( $i = 1; $i <= $widgets_items2; $i++ ) {
				register_sidebar( array(
					'name'          => $footer_widget_titles2[$i],
					'id'            => 'footer-widget-2-'. $i,
					'before_widget' => '<div id="%1$s" class="widget footer-widgets'. Options::$footer_style .' %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );
			}
		}
	}

	public function body_classes( $classes ) {

		if ( Options::$tr_header == '1' || Options::$tr_header === "on" ) {
			$classes[] = 'trheader';
		}
		if ( Options::$header_top == '1' || Options::$header_top === "on" ) {
			$classes[] = 'top-bar-enable';
		}
		// $sticky = Options::$options['sticky_header'] ? 1: 0;
		// if ($sticky) {
		// 	$classes[] = 'site-header';
		// }

		if ( Options::$options['sticky_header'] == 1 ) {
			$classes[] = 'sticky-header';
		}

		if (is_front_page() && !is_home()) {
			$classes[] = 'front-page';
		}

		if (!is_front_page() || is_home()) {
			$classes[] = 'bg-aash';
		}

		return $classes;
	}

	public function noscript_hide_preloader(){
		// Hide preloader if js is disabled
		echo '<noscript><style>#preloader{display:none;}</style></noscript>';
	}

	public function pingback() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

	public function cc_mime_types( $mimes ){
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	public function cl_restaurant_preloader() {
		$loading_text = esc_html__( 'Loading...', 'clrestaurant' );
        echo '<div id="pageoverlay" class="pageoverlay"><div id="pageLoader" class="pageLoader">' . esc_html( $loading_text ) . '</div></div>';
	}

	public function search_form(){
		$output =  '
		<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
            <div class="custom-search-input widget-box">
                <div class="input-group stylish-input-group">
                    <input type="text" class="form-control" placeholder="' . esc_attr__( 'Search here ...', 'clrestaurant' ) . '" value="' . get_search_query() . '" name="s" />
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="clr-icon-rt18-search"></span>
                        </button>
                    </span>
                </div>
            </div>
		</form>
		';
		return $output;
	}
}

// General::instance();