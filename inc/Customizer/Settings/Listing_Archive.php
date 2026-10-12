<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
namespace RadiusTheme\CLRestaurant\Customizer\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLRestaurant\Customizer\Controls\Switcher;
use RadiusTheme\CLRestaurant\Customizer\Customizer;
use Rtcl\Helpers\Functions;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Listing_Archive extends Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_listing_post_controls' ) );
	}

    /**
     * Portfolio Post Controls
     */
    public function register_listing_post_controls( $wp_customize ) {
        $group_list = $this->custom_field_group_list();

        // Listing archive version
        $wp_customize->add_setting( 'listing_archive_style',
            array(
                'default' => $this->defaults['listing_archive_style'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'listing_archive_style',
            array(
                'label' => esc_html__( 'Archive Style', 'clrestaurant' ),
                'section' => 'listing_archive_section',
                'description' => esc_html__( 'Listing archive style.', 'clrestaurant' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( 'Layout Normal', 'clrestaurant' ),
                    '2' => esc_html__( 'Layout Map', 'clrestaurant' ),
                ),
            )
        );
        
        // Listing grid columns
        $wp_customize->add_setting( 'listing_grid_cols',
            array(
                'default' => $this->defaults['listing_grid_cols'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'listing_grid_cols',
            array(
                'label' => esc_html__( 'Grid Columns', 'clrestaurant' ),
                'section' => 'listing_archive_section',
                'description' => esc_html__( 'Width is defined by the number of columns.', 'clrestaurant' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( '1 Columns', 'clrestaurant' ),
                    '2' => esc_html__( '2 Columns', 'clrestaurant' ),
                    '3' => esc_html__( '3 Columns', 'clrestaurant' ),
                    '4' => esc_html__( '4 Columns', 'clrestaurant' ),
                ),
            )
        );
        $wp_customize->add_setting( 'show_listing_custom_fields',
            array(
                'default' => $this->defaults['show_listing_custom_fields'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'show_listing_custom_fields',
            array(
                'label' => __( 'Show Listing Custom Field', 'clrestaurant' ),
                'section' => 'listing_archive_section',
            )
        ) );

        $wp_customize->add_setting( 'show_custom_fields_label',
            array(
                'default' => $this->defaults['show_custom_fields_label'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'show_custom_fields_label',
            array(
                'label' => __( 'Show Custom Field Icon or Label', 'clrestaurant' ),
                'section' => 'listing_archive_section',
            )
        ) );

        // Listing content excerpt
        $wp_customize->add_setting( 'cl_restaurant_listing_excerpt',
            array(
                'default' => $this->defaults['cl_restaurant_listing_excerpt'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'cl_restaurant_listing_excerpt',
            array(
                'label' => esc_html__( 'Listing Content Excerpt', 'clrestaurant' ),
                'section' => 'listing_archive_section',
                'type' => 'number'
            )
        );

        $wp_customize->add_setting( 'listing_archive_box_layout',
            array(
                'default' => $this->defaults['listing_archive_box_layout'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization',
            )
        );
        $wp_customize->add_control( 'listing_archive_box_layout',
            array(
                'label' => esc_html__( 'Archive Page Layout', 'clrestaurant' ),
                'section' => 'listing_archive_section',
                'type' => 'select',
                'choices' => array(
                    'container' => esc_html__( 'Select Layout', 'clrestaurant' ),
                    'container' => esc_html__( 'Box layout', 'clrestaurant' ),
                    'container-fluid custom-padding' => esc_html__( 'Full width layout', 'clrestaurant' ),
                ),
            )
        );

    }

    public function custom_field_group_list() {
        $group_ids = Functions::get_cfg_ids();

        $list[0] = esc_html__( 'Skip Individual View', 'clrestaurant' );

        foreach ( $group_ids as $id ) {
            $list[ $id ] = get_the_title( $id );
        }

        return $list;
    }

}