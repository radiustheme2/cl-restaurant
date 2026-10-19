<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use RadiusTheme\CLRestaurant\Helper;
use Rtcl\Controllers\BusinessHoursController;
use RadiusTheme\CLRestaurant\Listing_Functions;

global $listing;

if (!class_exists('RtclPro')) return;


$mod_settings = Functions::get_option( 'rtcl_archive_listing_settings' );

$show_discount = ! empty( $mod_settings['display_options'] ) && in_array( 'discount', $mod_settings['display_options'] );

$discount = get_post_meta( $listing->get_id(), 'listing_discount', true );

if ( $listing->can_show_user() ) {
    $userShow = 'user-show';
} else {
    $userShow = 'user-not-show';
}

?>

<div class="item-img <?php echo esc_attr( $userShow ); ?>">
    <?php if ( Functions::is_enable_business_hours() && ! empty( BusinessHoursController::get_business_hours( $listing->get_id() ) ) ){ ?>
    <div class="open-close-location-status">
        <?php Listing_Functions::business_open_close_status( $listing, true ); ?>
    </div>
    <?php } ?>
    <ul class="meta-tags ul-ol">
        <?php if ( Functions::is_enable_favourite() ) { ?>
            <li class="tooltip-item meta-favourite">
                <?php echo wp_kses_post( Listing_Functions::get_favourites_link( $listing->get_id() ) ); ?>
            </li>
        <?php } ?>

        <?php if ( Fns::is_enable_quick_view() ) { ?>
            <li class="meta-quick-view">
                <div class="rtcl-quick-view rtcl-btn" data-listing_id="<?php echo absint($listing->get_id()) ?>"><i class="rtcl-icon clr-icon-d-eye"></i></div>
            </li>
        <?php } ?>
    </ul>
    <div class="listing-thumb">
        <a href="<?php the_permalink(); ?>" class="rtcl-media grid-view-img">
            <?php echo wp_kses_post( $listing->get_the_thumbnail( 'cl-restaurant-size1' ) ); ?>
        </a>
        <a href="<?php the_permalink(); ?>" class="rtcl-media list-view-img">
            <?php echo wp_kses_post( $listing->get_the_thumbnail( 'rtcl-thumbnail' ) ); ?>
        </a>
	</div>
    
    <?php 
        if ( $listing->can_show_user() ) {
            Helper::get_listing_author_image( $listing ); 
        }
    ?>

    <?php if ( !empty( $discount && $show_discount )) { ?>
    <div class="listing-discount">
        <?php echo esc_html( $discount ); ?>
    </div>
    <?php } ?>
</div>
