<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLRestaurant\Options;

/*-------------------------------------
#. Evacon Body Color Settings
---------------------------------------*/
// Body Color
$body_color = Options::$options['body_color'];

if (!empty($body_color)) {
?>
body {
    color: <?php echo esc_attr( $body_color ); ?>;
}
<?php } ?>