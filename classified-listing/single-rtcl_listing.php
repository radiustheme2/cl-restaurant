<?php
/**
 *
 * @author     RadiusTheme
 * @package    classified-listing/templates
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use RadiusTheme\CLRestaurant\Options;
use Rtcl\Services\FormBuilder\FBHelper;

get_header( 'listing' );

$bodyLayout = Options::$options['listing_archive_box_layout'] ?? 'container';

?>

<div class="listing-details-page">
	<?php if (Options::$options['listing_banner'] || Options::$options['listing_breadcrumb']) { ?>
		<div class="listing-breadcrumb listing-archive-page">
			<?php 
				if (Options::$options['listing_banner']) {
					get_template_part( 'template-parts/content', 'banner' );
				} elseif ( Options::$options['listing_breadcrumb']) { ?>
			<div class="<?php echo esc_attr( $bodyLayout ); ?>">
				<?php get_template_part( 'template-parts/content', 'breadcrumb' ); ?>
			</div>
			<?php } else { ?>
			<div class="<?php echo esc_attr( $bodyLayout ); ?>">
				<?php get_template_part( 'template-parts/content', 'breadcrumb' ); ?>
			</div>
			<?php }
				?>
		</div>
	<?php } ?>
	<?php 
		/**
		 * rtcl_before_main_content hook.
		 *
		 * @hooked rtcl_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked rtcl_breadcrumb - 20
		 */
		do_action( 'rtcl_before_main_content' );
        global $listing;
        $clrestaurant_enableBuilder = FBHelper::isEnableSingleBuilder( $listing );
		while ( have_posts() ) :
			the_post();
			if ( $clrestaurant_enableBuilder ) {
				$form = $listing->getForm();
                ?>
                <div class="container">
                    <?php Functions::get_template( 'single-layout/builder', [ 'form' => $form ] ); ?>
                </div>
                <?php
			} else {
				Functions::get_template_part( 'content', 'single-rtcl_listing' );
			}
		endwhile; // end of the loop.

		/**
		 * rtcl_after_main_content hook.
		 *
		 * @hooked rtcl_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'rtcl_after_main_content' );
	?>
</div>

<?php 

get_footer( 'listing' );
