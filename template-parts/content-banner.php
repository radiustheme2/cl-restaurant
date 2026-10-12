<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLRestaurant\Options;

if ( is_404() ) {
	$rdtheme_title = Options::$options['error_page_title'];
	$rdtheme_title = $rdtheme_title . get_search_query();
}
elseif ( is_search() ) {
	$rdtheme_title = esc_html__( 'Search Results for : ', 'clrestaurant' ) . get_search_query();
}
elseif ( is_home() ) {
	if (!empty(Options::$options['blog_breadcrumb_title'])) {
		$rdtheme_title = Options::$options['blog_breadcrumb_title'];
	} elseif ( get_option( 'page_for_posts' ) ) {
		$rdtheme_title = get_the_title( get_option( 'page_for_posts' ) );
	}
	else {
		$rdtheme_title = apply_filters( "clrestaurant_blog_title", esc_html__( 'All Posts', 'clrestaurant' ) );
	}
}
elseif ( is_archive() ) {
	if ( is_post_type_archive( "rtcl_listing" ) ) {
		$rdtheme_title = esc_html__( 'Listing Archive', 'clrestaurant' );
	}
	else {
		$rdtheme_title = get_the_archive_title();
	}
} elseif (is_singular( 'rtcl_listing' )) {
	$rdtheme_title  = esc_html__( 'Listing Details', 'clrestaurant' );
} elseif (is_single()) {
	$rdtheme_title  = get_the_title();
} else {
	$rdtheme_title = get_the_title();	
}

$bgimg = Options::$bgimg;

?>

<section class="breadcrumbs-banner">
    <div class="container">
        <div class="breadcrumbs-area">
			<?php 
				if( function_exists( 'bcn_display') ){
					get_template_part( 'template-parts/content', 'breadcrumb' );
				} else {
					echo '<h1 class="heading-title">'.wp_kses_post( $rdtheme_title ).'</h1>';
				}
			?>
        </div>
    </div>
</section>

<!--=====================================-->
<!--=         Inner Banner Start    	=-->
<!--=====================================-->