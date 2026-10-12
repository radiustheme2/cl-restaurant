<?php
/**
 * @author        RadiusTheme
 * @package       clrestaurant/templates
 * @version       1.0.0
 *
 * @var WP_Query $rtcl_related_query
 * @var array    $slider_options
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RadiusTheme\CLRestaurant\Helper;
use RadiusTheme\CLRestaurant\Options;

if (!$rtcl_related_query->have_posts()) {
    return;
}
global $listing;

$related_count = $rtcl_related_query->post_count;
$posts_per_page = $rtcl_related_query->get( 'posts_per_page' );
if ( $posts_per_page <= $related_count ) {
	$slider_options['loop'] = true;
}

$slider_options['breakpoints'] = [
	0   => [
		"slidesPerView" => 1,
	],
	576 => [
		"slidesPerView" => 2,
	],
	768 => [
		"slidesPerView" => 3,
	],
	1200 => [
		"slidesPerView" => 4,
	],
];

?>
<div class="container">
    <div class="row">
        <div class="col-12 related-listing-main-wrap">
            
            <div class="related-listing-header">
                <div class="rtcl-related-title">
                    <h4 class="subheading"><?php echo esc_html( Options::$options['related_post_title'] ); ?></h4>
                    <h2><?php echo esc_html( Options::$options['related_post_title'] ); ?></h2>
                </div>
            </div>

            <div class="rtcl rtcl-related-listing rtcl-listings">
                <div class="rtcl-related-listings">
                    <div class="rtcl-related-slider-wrap">
                        <div class="rtcl-related-slider rtcl-carousel-slider rtcl-grid-view" id="rtcl-related-slider" data-options="<?php echo esc_attr( wp_json_encode($slider_options) ); ?>">
                            <div class="swiper-wrapper">
                                <?php
                                global $post;
                                while ($rtcl_related_query->have_posts()):
                                    $rtcl_related_query->the_post();
                                    $listing = rtcl()->factory->get_listing(get_the_ID());
                                    ?>
                                    <div class="swiper-slide rtcl-related-slider-item listing-item rtcl-listing-item">
                                        <div class="related-item-inner grid-item">
                                            <?php Helper::get_custom_listing_template( 'archive/grid/grid-1'); ?>
                                        </div>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>