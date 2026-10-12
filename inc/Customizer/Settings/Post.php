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

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Post extends Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_blog_single_post_controls' ) );
	}

    /**
     * Blog Post Controls
     */
    public function register_blog_single_post_controls( $wp_customize ) {

        // Post Features
        $wp_customize->add_setting( 'post_feature_img',
            array(
                'default' => $this->defaults['post_feature_img'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'post_feature_img',
            array(
                'label' => esc_html__( 'Display Feature Images', 'clrestaurant' ),
                'section' => 'single_post_section',
            )
        ));

        // Post Admin
        $wp_customize->add_setting( 'post_admin',
            array(
                'default' => $this->defaults['post_admin'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'post_admin',
            array(
                'label' => esc_html__( 'Display Admin', 'clrestaurant' ),
                'section' => 'single_post_section',
            )
        ));

        // Post Date 
        $wp_customize->add_setting( 'post_date',
            array(
                'default' => $this->defaults['post_date'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'post_date',
            array(
                'label' => esc_html__( 'Display Date', 'clrestaurant' ),
                'section' => 'single_post_section',
            )
        ));

        // Post Comments 
        $wp_customize->add_setting( 'post_comnts',
            array(
                'default' => $this->defaults['post_comnts'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'post_comnts',
            array(
                'label' => esc_html__( 'Display Comments', 'clrestaurant' ),
                'section' => 'single_post_section',
            )
        ));

        // Post Category
        $wp_customize->add_setting( 'post_cats',
            array(
                'default' => $this->defaults['post_cats'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'post_cats',
            array(
                'label' => esc_html__( 'Display Category', 'clrestaurant' ),
                'section' => 'single_post_section',
            )
        ) );

        // Post Tags
        $wp_customize->add_setting( 'post_tags',
            array(
                'default' => $this->defaults['post_tags'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'post_tags',
            array(
                'label' => esc_html__( 'Display Tags', 'clrestaurant' ),
                'section' => 'single_post_section',
            )
        ) );

        // Post Share
        $wp_customize->add_setting( 'post_share',
            array(
                'default' => $this->defaults['post_share'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'post_share',
            array(
                'label' => esc_html__( 'Display Post Share', 'clrestaurant' ),
                'section' => 'single_post_section',
            )
        ) );
        // Related Post
        $wp_customize->add_setting( 'blog_related_post',
            array(
                'default' => $this->defaults['blog_related_post'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'blog_related_post',
            array(
                'label' => esc_html__( 'Display Related Posts', 'clrestaurant' ),
                'section' => 'single_post_section',
            )
        ) );

    }
}
