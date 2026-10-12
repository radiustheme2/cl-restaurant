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

/* = Body Typo Area
=======================================================*/
$typo_body = json_decode( Options::$options['typo_body'], true );
if ($typo_body['font'] == 'Inherit') {
	$typo_body['font'] = 'Roboto';
} else {
	$typo_body['font'] = $typo_body['font'];
}

/* = Heading Typo Area
=======================================================*/
$typo_heading = json_decode( Options::$options['typo_heading'], true );
if ($typo_heading['font'] == 'Inherit') {
	$typo_heading['font'] = 'Work Sans';
} else {
	$typo_heading['font'] = $typo_heading['font'];
}

/* = Sub Heading Typo Area
=======================================================*/
$typo_sub_heading = json_decode( Options::$options['typo_sub_heading'], true );
if ($typo_sub_heading['font'] == 'Inherit') {
	$typo_sub_heading['font'] = 'Taprom';
} else {
	$typo_sub_heading['font'] = $typo_sub_heading['font'];
}

/* = Colors
=======================================================*/
$colorPrimary = Options::$options['primary_color'];
$colorBody = Options::$options['body_color'];
$colorHeading = Options::$options['heading_color'];

?>

:root {
	--body-font: <?php echo esc_html( $typo_body['font'] ? $typo_body['font'] : 'Roboto' ); ?>;
	--heading-font: <?php echo esc_html( $typo_heading['font'] ? $typo_heading['font'] : 'Work Sans' ); ?>;
	--sub-heading-font: <?php echo esc_html( $typo_sub_heading['font'] ? $typo_sub_heading['font'] : 'Taprom' ); ?>;
    --color-primary: <?php echo esc_html( $colorPrimary ? $colorPrimary : '#F22929' ); ?>;
    --color-body: <?php echo esc_html( $colorBody ? $colorBody : '#6A6A6A' ); ?>;
    --color-heading: <?php echo esc_html( $colorHeading ? $colorHeading : '#222222' ); ?>;
}

<?php 
//Typography Settings
get_template_part( 'dynamic-styles/typography');
//Primary Color
get_template_part( 'dynamic-styles/primary-color');
//Body Color
// get_template_part( 'dynamic-styles/body-color');
//Others Color
// Helper::requires( 'views/other-color.php' );
//Menu Color
// Helper::requires( 'views/menu-color.php' );

?>

<?php 
	$logo_width = Options::$options['logo_width'];
	$logo_m_size = Options::$options['logo_m_size'];
?>
.header-logo a {
    width: <?php echo esc_html( $logo_width ); ?>px;
}

@media only screen and (max-width: 767px) {
	.header-logo a {
		width: <?php echo esc_html( $logo_m_size ); ?>px;
	}
}
