<?php
/**
 * Listing meta
 *
 * @author     RadiusTheme
 * @package    classified-listing/templates
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
global $listing;

if (!class_exists('RtclPro')) return;

$archive_settings = Functions::get_option( 'rtcl_archive_listing_settings' );
$show_phone = ! empty( $archive_settings['display_options'] ) && in_array( 'phone', $archive_settings['display_options'] );
$phone = get_post_meta( $listing->get_id(), 'phone', true );
$phone_url = str_replace( ' ', '', $phone );
?>

<ul class="meta-list ul-ol">
    <?php if ( $listing->has_location() && $listing->can_show_location() ){ ?>
        <li class="meta-address">
            <i class="clr-icon-rt18-marker"></i>
            <?php $listing->the_locations(); ?>
        </li>
	<?php } ?>

	<?php if ( $show_phone ) { ?>
        <li class="meta-phone">
            <a href="tel:<?php echo esc_url( $phone_url ); ?>">
            <i class="clr-icon-rt18-phone2"></i>
			<?php echo esc_html( $phone ); ?>
            </a>
        </li>
	<?php } ?>

    <?php if ( $listing->can_show_date() ) { ?>
        <li class="meta-time">
            <i class="clr-icon-calendar1-1"></i> 
            <?php $listing->the_time(); ?>
        </li>
    <?php } ?> 
    
    <?php if ( $listing->can_show_views() ) { ?>
    <li class="meta-view">
        <i class="clr-icon-d-eye"></i>
        <?php echo esc_html( sprintf( _n( "View: %s", "Views: %s", $listing->get_view_counts(), 'clrestaurant' ), number_format_i18n( $listing->get_view_counts() ) ) ); ?>
    </li>
    <?php } ?>

    <?php if ( $listing->can_show_price() ){ ?>
    <li class="meta-price">
        <?php echo wp_kses_post( $listing->get_price_html() ); ?>
    </li>
    <?php } ?>
</ul>