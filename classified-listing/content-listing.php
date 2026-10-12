<?php
/**
 * @package ClassifiedListing/Templates
 * @version 1.5.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use RadiusTheme\CLRestaurant\Helper;

global $listing;

// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only view preference, no nonce needed
if ( isset( $_GET['view'] ) && in_array( sanitize_text_field( wp_unslash( $_GET['view'] ) ), [ 'grid', 'list' ], true ) ) {
	$view = sanitize_text_field( wp_unslash( $_GET['view'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
} else {
	$view = Functions::get_option_item( 'rtcl_archive_listing_settings', 'default_view', 'list' );
}

?>

<div <?php Functions::listing_class(); ?> <?php Functions::listing_data_attr_options(); ?>>

	<?php
	if ( $view == 'grid' ) {
		Helper::get_custom_listing_template( 'archive/grid/grid-1');
	} else {
		Helper::get_custom_listing_template( 'archive/list/list-1');
	}
	?>
</div>
