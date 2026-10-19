<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use RadiusTheme\CLRestaurant\Helper;
use RadiusTheme\CLRestaurant\Listing_Functions;
use Rtcl\Controllers\BusinessHoursController;
use Rtcl\Controllers\BusinessHoursController as BHS;
use RtclClaimListing\Helpers\Functions as ClaimFunctions;

global $listing;
global $wp_locale;

$images = $listing->get_images();

$banner = Listing_Functions::listing_single_banner_option();

$business_hours = BHS::get_business_hours($listing->get_id());
if (BHS::openStatus($business_hours)) {
    $onoff = '<span class="onoff-status open"><i class="fas fa-check-circle"></i>'. esc_html__( 'Open Now', 'clrestaurant' ).'</span>';
} else {
    $onoff = '<span class="onoff-status close"><i class="fas fa-times-circle"></i>'. esc_html__( 'Close Now', 'clrestaurant' ).'</span>';
}

$generalSettings = Functions::get_option( 'rtcl_general_settings' );

$detailOption = Functions::get_option_item( 'rtcl_single_listing_settings', 'display_options_detail', [] );

$show_phone = ! empty( $mod_settings['display_options'] ) && in_array( 'phone', $mod_settings['display_options'] );

$address = get_post_meta( $listing->get_id(), 'address', true );
$phone = get_post_meta( $listing->get_id(), 'phone', true );
$phone_url = str_replace( ' ', '', $phone );

$abuse = Functions::get_option_item( 'rtcl_single_listing_settings', 'has_report_abuse', '', 'checkbox' ) ? true : false;

?>
<div class="listingDetails-header header-v1">
    <div class="row align-items-center">
        <div class="col-lg-9">
            <div class="listingDetails-header">
                <div class="listingDetails-header__fetures">
                    <ul class="ul-ol">
                        <?php if ( $listing->has_category() && $listing->can_show_category() ){ ?>
                            <li>
                                <?php echo wp_kses_post( Helper::CLR_listing_categories( $listing->get_id() ) ); ?>
                            </li> 
                        <?php }
                        if ( $listing && Fns::is_enable_mark_as_sold() && Fns::is_mark_as_sold( $listing->get_id() ) ) {
                            echo '<li class="rtcl-sold-out">' . wp_kses_post( apply_filters( 'rtcl_sold_out_header_text', esc_html__( "Sold Out", 'clrestaurant' ) ) ) . '</li>';
                        }
                        ?>
                        <li><?php $listing->the_badges(); ?></li>
                    </ul>
                </div>
                <h2 class="listingDetails-header__heading">
                    <?php the_title(); ?>
                </h2>
                <div class="listingDetails-header__fetures">
                    <ul class="info-list">
                        <?php
                            if ( current( $listing->user_contact_location_at_single() ) ){ ?>
                            <li class="meta-address">
                                <span class="listingDetails-header__info">
                                    <i class="clr-icon-rt18-marker"></i>
                                    <?php echo esc_html( implode( ', ', $listing->user_contact_location_at_single() ) ); ?>
                                </span>
                            </li>
                            <?php } if ( $listing->can_show_date() ) { ?>
                            <li class="meta-date"><i class="clr-icon-03-calendar-check"></i> <?php $listing->the_time(); ?></li>
                            <?php } if ( $listing->can_show_views() ){ ?>
                            <li class="meta-view">
                                <span>
                                    <i class="clr-icon-d-eye"></i>  
                                    <?php echo esc_html( sprintf( _n( "View: %s", "Views: %s", $listing->get_view_counts(), 'clrestaurant' ), 
                                        number_format_i18n( $listing->get_view_counts() ) ) ); ?>
                                </span>
                            </li>
                            <?php } ?>

                            <?php if ( Functions::is_enable_business_hours() && ! empty( BusinessHoursController::get_business_hours( $listing->get_id() ) ) ){ ?>
                                <li class="meta-status">
                                    <?php Listing_Functions::business_open_close_status( $listing, true ); ?>
                                </li>
                            <?php } ?>
                    </ul>
                </div>
                <?php if ( $listing->can_show_price() ): ?>
                    <div class="product-price"><?php echo wp_kses_post( $listing->get_price_html() ); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-3 text-lg-end">
            <div class="listing-actions">
                <ul>
                    <?php if ( Fns::is_enable_compare() ) { ?>
                        <li class="meta-compare">
                        <?php
                            $compare_ids = ! empty( $_SESSION['rtcl_compare_ids'] ) ? array_map( 'absint', (array) $_SESSION['rtcl_compare_ids'] ) : [];
                            $selected_class = '';
                            if ( is_array( $compare_ids ) && in_array( $listing->get_id(), $compare_ids ) ) {
                                $selected_class = ' selected';
                            }
                        ?>
                        <a class="rtcl-compare <?php echo esc_attr( $selected_class ); ?>" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Compare", "clrestaurant" ) ?>" data-listing_id="<?php echo absint( $listing->get_id() ) ?>">
                            <?php echo Helper::compare_icon(); ?>
                        </a>
                        </li>
                    <?php } if (Functions::is_enable_favourite()){ ?>
                    <li class="meta-favourite" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Favourite", "clrestaurant" ) ?>">
                        <?php echo wp_kses_post( Listing_Functions::get_favourites_link( $listing->get_id() ) ); ?>
                    </li>
                    <?php } if ( in_array('social_share', $detailOption)){ ?>
                    <li class="social-share-li" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Share", "clrestaurant" ) ?>"> 
                        <button class="listing-social-action" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                            <i class="clr-icon-rt18-share"></i>
                        </button>   
                    </li>
                    <?php } if ( $abuse ){ ?>
                        <li class="report-abuse-li" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Report", "clrestaurant" ) ?>">
                            <?php if ( is_user_logged_in() ): ?>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#rtcl-report-abuse-modal">
                                <?php echo Helper::warning_icon(); ?>
                            </a>
                            <?php else: ?>
                            <a href="javascript:void(0)" class="rtcl-require-login">
                                <?php echo Helper::warning_icon(); ?>
                            </a>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
	                <?php if ( function_exists( 'rtclClaimListing' ) && ClaimFunctions::claim_listing_enable() ){ ?>
                        <li class='report-abuse-li' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Claim", "clrestaurant" ) ?>">
			                <?php if ( is_user_logged_in() ): ?>
                                <span data-bs-toggle="tooltip" data-original-title="<?php echo esc_html( ClaimFunctions::get_claim_action_title() ); ?>">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#rtcl-claim-listing-modal">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </a>
                                        </span>
			                <?php else: ?>
                                <a href="javascript:void(0)" data-bs-toggle="tooltip" class="rtcl-require-login" data-original-title="<?php echo esc_html( ClaimFunctions::get_claim_action_title() ); ?>">
                                    <i class="fas fa-exclamation-circle"></i>
                                </a>
			                <?php endif; ?>
                        </li>
	                <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <?php 
        $feature_img = '';
        $images = $listing->get_images();
        if (empty($images)) {
            $feature_img = 'feature-img-not-set';
        }
        if (!empty($images)) {
    ?>
        <div class="page-header">
            <?php 
                if ( $banner == 'slider' ) {
                    Listing_Functions::listing_details_slider();
                } else {
                    Listing_Functions::listing_details_gallery();
                }
            ?>
        </div>
    <?php } ?>
</div>

<?php 
    if ( in_array('social_share', $detailOption)){
        Listing_Functions::get_share_link(); 
    }
?>

<?php do_action( 'rtcl_single_listing_after_action', $listing->get_id() ); ?>
