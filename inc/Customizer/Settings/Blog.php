<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.0.0
 */

namespace RadiusTheme\CLRestaurant\Customizer\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLRestaurant\Customizer\Controls\Image_Radio;
use RadiusTheme\CLRestaurant\Customizer\Controls\Switcher;
use RadiusTheme\CLRestaurant\Customizer\Customizer;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Blog extends Customizer {

	public function __construct() {
		parent::instance();
		$this->populated_default_data();
		// Add Controls
		add_action( 'customize_register', [ $this, 'register_blog_archive_controls' ] );
	}

	/**
	 * Blog Archive Controls
	 */
	public function register_blog_archive_controls( $wp_customize ) {
		// Blog Post Style
        $wp_customize->add_setting( 'blog_style',
            [
                'default' => $this->defaults['blog_style'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            ]
        );

        $wp_customize->add_control( new Image_Radio( $wp_customize, 'blog_style',
			[
                'label' => esc_html__( 'Post Layout', 'clrestaurant' ),
                'description' => esc_html__( 'Blog Post layout variation you can selecr and use.', 'clrestaurant' ),
                'section' => 'blog_archive_section',
                'choices' => array(
                    '1' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/list.png',
                        'name' => esc_html__( 'List Layout', 'clrestaurant' )
                    ),
                    '2' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/grid.png',
                        'name' => esc_html__( 'Grid Layout 1', 'clrestaurant' )
                    )
                )
            ]
        ) );

		// Blog grid area
        $wp_customize->add_setting( 'blog_grid',
			[
                'default' => $this->defaults['blog_grid'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            ]
        );
        $wp_customize->add_control( 'blog_grid',
			[
                'label' => esc_html__( 'Grid layput Columns', 'clrestaurant' ),
                'section' => 'blog_archive_section',
                'description' => esc_html__( 'This grid system work only for large devices', 'clrestaurant' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( '1 Column', 'clrestaurant' ),
                    '2' => esc_html__( '2 Columns', 'clrestaurant' ),
                    '3' => esc_html__( '3 Columns', 'clrestaurant' ),
                    '4' => esc_html__( '4 Columns', 'clrestaurant' ),
                    '5' => esc_html__( '5 Columns', 'clrestaurant' ),
                    '6' => esc_html__( '6 Columns', 'clrestaurant' ),
                ),
				'active_callback' => 'rt_blog_style_2',
            ]
        );
		// Blog grid medium devices
        $wp_customize->add_setting( 'blog_medium_grid',
			[
                'default' => $this->defaults['blog_medium_grid'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            ]
        );
        $wp_customize->add_control( 'blog_medium_grid',
			[
                'label' => esc_html__( 'Medium Devices Columns', 'clrestaurant' ),
                'section' => 'blog_archive_section',
                'description' => esc_html__( 'This grid system work only for medium devices', 'clrestaurant' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( '1 Column', 'clrestaurant' ),
                    '2' => esc_html__( '2 Columns', 'clrestaurant' ),
                    '3' => esc_html__( '3 Columns', 'clrestaurant' ),
                    '4' => esc_html__( '4 Columns', 'clrestaurant' ),
                    '5' => esc_html__( '5 Columns', 'clrestaurant' ),
                    '6' => esc_html__( '6 Columns', 'clrestaurant' ),
                ),
				'active_callback' => 'rt_blog_style_2',
            ]
        );

		$wp_customize->add_setting( 'post_meta_admin',
			[
				'default'           => $this->defaults['post_meta_admin'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'post_meta_admin',
			[
				'label'   => esc_html__( 'Meta Admin', 'clrestaurant' ),
				'section' => 'blog_archive_section',
			]
		) );

		$wp_customize->add_setting( 'post_meta_comnts',
			[
				'default'           => $this->defaults['post_meta_comnts'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'post_meta_comnts',
			[
				'label'   => esc_html__( 'Meta Comments', 'clrestaurant' ),
				'section' => 'blog_archive_section',
			]
		) );

		// Blog Cat Visibility
		$wp_customize->add_setting( 'post_meta_date',
			[
				'default'           => $this->defaults['post_meta_date'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'post_meta_date',
			[
				'label'   => esc_html__( 'Meta Date', 'clrestaurant' ),
				'section' => 'blog_archive_section',
			]
		) );

		// Blog Button
		$wp_customize->add_setting( 'blog_button',
			[
				'default'           => $this->defaults['blog_button'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'blog_button',
			[
				'label'   => esc_html__( 'Display Button', 'clrestaurant' ),
				'section' => 'blog_archive_section',
			]
		) );

		$wp_customize->add_setting( 'excerpt_length',
			[
				'default'           => $this->defaults['excerpt_length'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_sanitize_integer',
			]
		);
		$wp_customize->add_control( 'excerpt_length',
			[
				'label'   => esc_html__( 'Excerpt Length', 'clrestaurant' ),
				'section' => 'blog_archive_section',
				'type'    => 'number',
			]
		);
	}
}