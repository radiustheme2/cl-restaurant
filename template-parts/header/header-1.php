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
$menu_layout_settings = get_post_meta( get_the_id(), 'cl_restaurant_layout_settings', true );
$menu_layout = ( empty( $menu_layout_settings['cl_restaurant_header_menu'] ) || $menu_layout_settings['cl_restaurant_header_menu'] == 'default' ) ? Options::$options['site_body_layout'] : $menu_layout_settings['cl_restaurant_header_menu'];


?>
<div class="header-menu mobile-menu container-custom" id="header-menu">
    <div class="<?php echo esc_attr( $menu_layout ); ?>">
        <div class="menu-full-wrap">
            <div class="site-branding">
                <?php get_template_part( 'template-parts/header/logo', 1 ); ?>
                <?php get_template_part( 'template-parts/header/logo', 2 ); ?>
            </div>
            <?php 
                get_template_part( 'template-parts/header/menu', 1 );
                get_template_part( 'template-parts/header/menu', 'elements' );
            ?>
        </div>
    </div>
</div>