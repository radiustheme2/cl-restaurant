<?php
/**
 * Agent Single
 *
 * @author     RadiusTheme
 * @package    rtcl-agent/templates
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions as RtclFunctions;

get_header('agent'); ?>

<div class="container">
	<div class="row agent-archive-wrap">
		<div class="col-lg-12">
			<?php
				/**
				 * rtcl_before_main_content hook.
				 *
				 * @hooked rtcl_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked rtcl_breadcrumb - 20
				 */
				do_action('rtcl_before_main_content');
			?>
			<?php while (have_posts()) : ?>
				<?php the_post(); ?>
				<?php RtclFunctions::get_template_part('content', 'single-agent'); ?>
			<?php endwhile; // end of the loop. ?>
			<?php
				/**
				 * rtcl_after_main_content hook.
				 *
				 * @hooked rtcl_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action('rtcl_after_main_content');
			?>
		</div>
	</div>
</div>

<?php
get_footer('agent');
