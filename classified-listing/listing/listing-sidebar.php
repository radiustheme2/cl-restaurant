<?php
/**
 * @author        RadiusTheme
 * @package       classified-listing/templates
 * @version       1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RadiusTheme\CLRestaurant\Options;
use Rtcl\Helpers\Functions;
global $listing;

$sidebar_position = Functions::get_option_item( 'rtcl_single_listing_settings', 'detail_page_sidebar_position', 'right' );
$sidebar_class = [
	'col-lg-3',
	'order-lg-2',
];
if ( $sidebar_position == "left" ) {
	$sidebar_class   = array_diff( $sidebar_class, [ 'order-lg-2' ] );
	$sidebar_class[] = 'order-lg-1';
} elseif ( $sidebar_position == "bottom" ) {
	$sidebar_class   = array_diff( $sidebar_class, [ 'col-lg-3' ] );
	$sidebar_class[] = 'rtcl-listing-bottom-sidebar';
}

$map_title = Options::$options['listing_map_title'];
$hide_listing_map = get_post_meta( get_the_ID(), 'hide_map', true );

?>

<!-- Seller / User Information -->
<div id="sticky_sidebar" class="<?php echo esc_attr( implode( ' ', $sidebar_class ) ); ?>">
    <div class="listing-sidebar">
		<?php 
			if (Options::$options['listing_list_information']) {
				$listing->the_user_info();
			} 
			if ( method_exists( 'Rtcl\Helpers\Functions', 'has_map' ) && Functions::has_map() && ! $hide_listing_map ){
		            if (Options::$options['listing_list_map_location']) {
                ?>

				<div class="sidebar-map">
					<div class="rtcl-listing-side-title">
						<h3><?php echo esc_html( $map_title ); ?></h3>
					</div>
					<?php do_action( 'rtcl_single_listing_content_end', $listing ); ?>
				</div>
			<?php } }
			if (Options::$options['listing_list_timing']) {
				do_action('rtcl_single_listing_business_hours');
			} 
		?>
		<?php if ( is_active_sidebar( 'listing-single-sidebar' ) ): ?>
            <aside class="sidebar-widget">
				<?php dynamic_sidebar( 'listing-single-sidebar' ); ?>
            </aside>
		<?php endif; ?>

    </div>
</div>
