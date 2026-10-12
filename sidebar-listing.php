<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RadiusTheme\CLRestaurant\Helper;

?>

<div class="<?php Helper::listing_sidebar_class(); ?>">
	<div class="listing-sidenar-widgets">
		<?php dynamic_sidebar( 'rtcl-archive-sidebar' ); ?>
    </div>
</div>
