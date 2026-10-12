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

use RadiusTheme\CLRestaurant\Customizer\Controls\Heading;
use RadiusTheme\CLRestaurant\Customizer\Customizer;
use WP_Customize_Color_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Colors extends Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_general_controls' ) );
	}

    public function register_general_controls( $wp_customize ) {


        /**
        * Site Primary Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'primary_color',
            array(
                'default' => $this->defaults['primary_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'primary_color',
            array(
                'label' => esc_html__( 'Primary Color', 'clrestaurant' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Site Body Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'body_color',
            array(
                'default' => $this->defaults['body_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'body_color',
            array(
                'label' => esc_html__( 'Body Color', 'clrestaurant' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Site Heading Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'heading_color',
            array(
                'default' => $this->defaults['heading_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'heading_color',
            array(
                'label' => esc_html__( 'Heading Color', 'clrestaurant' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Normal Menu BG Color Controls
        * =================================================================*/
        $wp_customize->add_setting('menu_color_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'menu_color_heading', array(
            'label' => esc_html__( 'Menu Color', 'clrestaurant' ),
            'section' => 'menu_color_section',
        )));

        // Menu BG Color
        $wp_customize->add_setting( 'menu_bg_color',
            array(
                'default' => $this->defaults['menu_bg_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'menu_bg_color',
            array(
                'label' => esc_html__( 'Menu Background Color', 'clrestaurant' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#ffffff',
            )
        );

        // Menu Text Color
        $wp_customize->add_setting( 'menu_text_color',
            array(
                'default' => $this->defaults['menu_text_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'menu_text_color',
            array(
                'label' => esc_html__( 'Normal Color', 'clrestaurant' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#111111',
            )
        );
        // Menu Text Hover Color
        $wp_customize->add_setting( 'menu_text_hover_color',
            array(
                'default' => $this->defaults['menu_text_hover_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'menu_text_hover_color',
            array(
                'label' => esc_html__( 'Hover Color', 'clrestaurant' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#ff3c48',
            )
        );

        /**
        * Sub Menu Color Controls
        * ======================================================================*/
        $wp_customize->add_setting('dropdown_menu_color_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'dropdown_menu_color_heading', array(
            'label' => esc_html__( 'Sub Menu Color', 'clrestaurant' ),
            'section' => 'menu_color_section',
        )));

        // Submenu BG Color
        $wp_customize->add_setting( 'submenu_bg_color',
            array(
                'default' => $this->defaults['submenu_bg_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'clrestaurant' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#ffffff',
            )
        );

        // Submenu Text Color
        $wp_customize->add_setting( 'submenu_text_color',
            array(
                'default' => $this->defaults['submenu_text_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_text_color',
            array(
                'label' => esc_html__( 'Text Color', 'clrestaurant' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#646464',
            )
        );

         // Submenu Hover Text Color
        $wp_customize->add_setting( 'submenu_htext_color',
            array(
                'default' => $this->defaults['submenu_htext_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_htext_color',
            array(
                'label' => esc_html__( 'Hover Text Color', 'clrestaurant' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#ff3c48',
            )
        );

        // /**
        // * Transparent Menu Color Controls 
        // * =================================================================*/
        // $wp_customize->add_setting('menu2_color_heading', array(
        //     'default' => '',
        //     'sanitize_callback' => 'esc_html',
        // ));
        // $wp_customize->add_control(new Heading($wp_customize, 'menu2_color_heading', array(
        //     'label' => esc_html__( 'Menu Color', 'clrestaurant' ),
        //     'section' => 'menu2_color_section',
        // )));

        // // Menu Text Color
        // $wp_customize->add_setting( 'menu2_text_color',
        //     array(
        //         'default' => $this->defaults['menu2_text_color'],
        //         'transport' => 'refresh',
        //         'sanitize_callback' => 'rttheme_text_sanitization',
        //     )
        // );
        // $wp_customize->add_control( 'menu2_text_color',
        //     array(
        //         'label' => esc_html__( 'Normal Color', 'clrestaurant' ),
        //         'section' => 'menu2_color_section',
        //         'type' => 'color',
        //         'default' => '#ffffff',
        //     )
        // );
        // // Menu Text Hover Color
        // $wp_customize->add_setting( 'menu2_text_hover_color',
        //     array(
        //         'default' => $this->defaults['menu2_text_hover_color'],
        //         'transport' => 'refresh',
        //         'sanitize_callback' => 'rttheme_text_sanitization',
        //     )
        // );
        // $wp_customize->add_control( 'menu2_text_hover_color',
        //     array(
        //         'label' => esc_html__( 'Hover Color', 'clrestaurant' ),
        //         'section' => 'menu2_color_section',
        //         'type' => 'color',
        //         'default' => '#ff3c48',
        //     )
        // );

        // /**
        // * Sub Menu Color Controls
        // * ======================================================================*/
        // $wp_customize->add_setting('dropdown_menu2_color_heading', array(
        //     'default' => '',
        //     'sanitize_callback' => 'esc_html',
        // ));
        // $wp_customize->add_control(new Heading($wp_customize, 'dropdown_menu2_color_heading', array(
        //     'label' => esc_html__( 'Sub Menu Color', 'clrestaurant' ),
        //     'section' => 'menu2_color_section',
        // )));

        // // Submenu BG Color
        // $wp_customize->add_setting( 'submenu2_bg_color',
        //     array(
        //         'default' => $this->defaults['submenu2_bg_color'],
        //         'transport' => 'refresh',
        //         'sanitize_callback' => 'rttheme_text_sanitization',
        //     )
        // );
        // $wp_customize->add_control( 'submenu2_bg_color',
        //     array(
        //         'label' => esc_html__( 'Background Color', 'clrestaurant' ),
        //         'section' => 'menu2_color_section',
        //         'type' => 'color',
        //         'default' => '#ffffff',
        //     )
        // );

        // // Submenu Text Color
        // $wp_customize->add_setting( 'submenu2_text_color',
        //     array(
        //         'default' => $this->defaults['submenu2_text_color'],
        //         'transport' => 'refresh',
        //         'sanitize_callback' => 'rttheme_text_sanitization',
        //     )
        // );
        // $wp_customize->add_control( 'submenu2_text_color',
        //     array(
        //         'label' => esc_html__( 'Text Color', 'clrestaurant' ),
        //         'section' => 'menu2_color_section',
        //         'type' => 'color',
        //         'default' => '#646464',
        //     )
        // );

        //  // Submenu Hover Text Color
        // $wp_customize->add_setting( 'submenu2_htext_color',
        //     array(
        //         'default' => $this->defaults['submenu2_htext_color'],
        //         'transport' => 'refresh',
        //         'sanitize_callback' => 'rttheme_text_sanitization',
        //     )
        // );
        // $wp_customize->add_control( 'submenu2_htext_color',
        //     array(
        //         'label' => esc_html__( 'Hover Text Color', 'clrestaurant' ),
        //         'section' => 'menu2_color_section',
        //         'type' => 'color',
        //         'default' => '#ff3c48',
        //     )
        // );

        // /**
        // * Preloader Color Controls
        // * ================================================================*/
        // $wp_customize->add_setting('scrollup_color_heading', array(
        //     'default' => '',
        //     'sanitize_callback' => 'esc_html',
        // ));
        // $wp_customize->add_control(new Heading($wp_customize, 'scrollup_color_heading', array(
        //     'label' => esc_html__( 'Scroll Up Color', 'clrestaurant' ),
        //     'section' => 'others_color_section',
        // )));
        // $wp_customize->add_setting( 'scroll_color',
        //     array(
        //         'default' => $this->defaults['preloader_circle_color'],
        //         'transport' => 'refresh',
        //         'sanitize_callback' => 'rttheme_text_sanitization',
        //     )
        // );
        // $wp_customize->add_control( 'scroll_color',
        //     array(
        //         'label' => esc_html__( 'Icon Color', 'clrestaurant' ),
        //         'section' => 'others_color_section',
        //         'type' => 'color',
        //     )
        // );


        // /**
        // * Preloader Color Controls
        // * ================================================================*/
        // $wp_customize->add_setting('preloader_color_heading', array(
        //     'default' => '',
        //     'sanitize_callback' => 'esc_html',
        // ));
        // $wp_customize->add_control(new Heading($wp_customize, 'preloader_color_heading', array(
        //     'label' => esc_html__( 'Preloader Color', 'clrestaurant' ),
        //     'section' => 'others_color_section',
        // )));
        // // Menu Text Color
        // $wp_customize->add_setting( 'preloader_bg_color',
        //     array(
        //         'default' => $this->defaults['preloader_bg_color'],
        //         'transport' => 'refresh',
        //         'sanitize_callback' => 'rttheme_text_sanitization',
        //     )
        // );
        // $wp_customize->add_control( 'preloader_bg_color',
        //     array(
        //         'label' => esc_html__( 'Background Color', 'clrestaurant' ),
        //         'section' => 'others_color_section',
        //         'type' => 'color',
        //     )
        // );
        // // Menu Text Hover Color
        // $wp_customize->add_setting( 'preloader_circle_color',
        //     array(
        //         'default' => $this->defaults['preloader_circle_color'],
        //         'transport' => 'refresh',
        //         'sanitize_callback' => 'rttheme_text_sanitization',
        //     )
        // );
        // $wp_customize->add_control( 'preloader_circle_color',
        //     array(
        //         'label' => esc_html__( 'Circle Color', 'clrestaurant' ),
        //         'section' => 'others_color_section',
        //         'type' => 'color',
        //     )
        // );

    }

}