<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use RadiusTheme\CLRestaurant\Options;

$has_newsletter = Options::$has_newsletter;

$footer_style = Options::$footer_style ? Options::$footer_style : 1;

?>

<?php 
    if ( Options::$has_newsletter == '1' || Options::$has_newsletter === "on" ) {
        get_template_part( 'template-parts/footer/newsletter'); 
    }
    get_template_part( 'template-parts/footer/footer', $footer_style ); 

    if ( class_exists( 'RtclPro' ) && is_singular('rtcl_listing') ) {
        get_template_part( 'template-parts/footer/photoswipe'); 
    }
    if ( class_exists( 'Rtcl' ) && class_exists( 'RtclPro' ) ) {
        if (Functions::is_enable_favourite()){ 
		}
	}
?>

<?php wp_footer(); ?>

</div> 
</body>
</html>