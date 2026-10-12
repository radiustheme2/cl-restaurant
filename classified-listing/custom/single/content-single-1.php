<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RadiusTheme\CLRestaurant\Options;
use RadiusTheme\CLRestaurant\Helper;

global $listing;

?>

<!-- listing Details --> 
<section class="listing-details listing-details--layout1">
  <div class="listingDetails-main">

    <?php Helper::get_custom_listing_template( 'single/listing-single-main',  ); ?>

    <?php if ( Options::$options['show_related_listing'] ) : ?>
      <?php $listing->the_related_listings(); ?>
    <?php endif; ?>
  </div>
</section>
<!-- listing Details End -->