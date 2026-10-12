<?php
/**
 * @package ClassifiedListing/Templates
 * @version 1.5.4
 */

if (!class_exists( 'RtclPro' )) return;

use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use RadiusTheme\CLRestaurant\Helper;
use RadiusTheme\CLRestaurant\Options;

defined('ABSPATH') || exit;


$bodyLayout = Options::$options['listing_archive_box_layout'] ? Options::$options['listing_archive_box_layout'] : 'container';

?>
<?php get_header(); ?>
<section class="listing-archvie-page">

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

   <div class="<?php echo esc_attr( $bodyLayout ); ?>">
      <?php
         /**
          * Hook: rtcl_before_main_content.
          *
          * @hooked rtcl_output_content_wrapper - 10 (outputs opening divs for the content)
          */
         do_action( 'rtcl_before_main_content' );
      ?>
      <div class="row">
         <div class="<?php Helper::listing_layout_class(); ?>">
            <?php if ( rtcl()->wp_query()->have_posts() ) { ?>
            <div class="listing-box-grid">
               <?php
                  /**
                 * Hook: rtcl_before_listing_loop.
                 *
                 * @hooked TemplateHooks::output_all_notices() - 10
                 * @hooked TemplateHooks::listings_actions - 20
                 *
                 */
                  do_action( 'rtcl_before_listing_loop' );

                  Functions::listing_loop_start();

                  /**
                  * Top listings
                  */
                  if ( Fns::is_enable_top_listings() ) {
                     do_action( 'rtcl_listing_loop_prepend_data' );
                  }

                  while ( rtcl()->wp_query()->have_posts() ) : rtcl()->wp_query()->the_post();

                  /**
                  * Hook: rtcl_listing_loop.
                  */
                  do_action( 'rtcl_listing_loop' );

                  Functions::get_template_part( 'content', 'listing' );

                  endwhile;
                  
                  Functions::listing_loop_end();
               ?>
            </div>
            <?php 
            /**
              * Hook: rtcl_after_listing_loop.
              *
              * @hooked TemplateHook::pagination() - 10
              */
               do_action( 'rtcl_after_listing_loop' );
            
               } else {

               /**
               * Prepend listings
               */
               ob_start();
               do_action('rtcl_listing_loop_prepend_data');
               $listing_loop_prepend_data = ob_get_clean();
               if ($listing_loop_prepend_data) {
                  Functions::listing_loop_start();
                  echo wp_kses_post($listing_loop_prepend_data);
                  Functions::listing_loop_end();
               }
               /**
                * Hook: rtl_no_listings_found.
                *
                * @hooked no_listings_found - 10
                */
               do_action('rtcl_no_listings_found');
            }
         ?>
         </div>
         <?php Helper::listing_sidebar(); ?>
      </div>
      <?php
         /**
          * Hook: rtcl_after_main_content.
          *
          * @hooked rtcl_output_content_wrapper_end - 10 (outputs closing divs for the content)
          */
         do_action( 'rtcl_after_main_content' );
      ?>
   </div>
</section>

<?php get_footer(); ?>