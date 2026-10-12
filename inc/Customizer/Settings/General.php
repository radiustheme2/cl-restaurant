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

use RadiusTheme\CLRestaurant\Customizer\Controls\Separator;
use RadiusTheme\CLRestaurant\Customizer\Controls\Switcher;
use RadiusTheme\CLRestaurant\Customizer\Controls\Heading;
use RadiusTheme\CLRestaurant\Customizer\Customizer;
use RadiusTheme\CLRestaurant\Helper;
use WP_Customize_Media_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class General extends Customizer {

	public function __construct() {
		parent::instance();
		$this->populated_default_data();
		// Add Controls
		add_action( 'customize_register', [ $this, 'register_general_controls' ] );
	}

	public function register_general_controls( $wp_customize ) {
		// Main Logo
		$wp_customize->add_setting( 'logo_one',
			[
				'default'           => $this->defaults['logo_one'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			]
		);
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'logo_one',
			[
				'label'         => esc_html__( 'Logo Dark', 'clrestaurant' ),
				'description'   => esc_html__( 'Add site main logo', 'clrestaurant' ),
				'section'       => 'general_logo',
				'mime_type'     => 'image',
				'button_labels' => [
					'select'       => esc_html__( 'Select Logo', 'clrestaurant' ),
					'change'       => esc_html__( 'Change Logo', 'clrestaurant' ),
					'default'      => esc_html__( 'Default', 'clrestaurant' ),
					'remove'       => esc_html__( 'Remove', 'clrestaurant' ),
					'placeholder'  => esc_html__( 'No file selected', 'clrestaurant' ),
					'frame_title'  => esc_html__( 'Select File', 'clrestaurant' ),
					'frame_button' => esc_html__( 'Choose File', 'clrestaurant' ),
				],
			]
		) );

		$wp_customize->selective_refresh->add_partial( 'logo_one', [
			'selector'        => '.site-logo',
			'render_callback' => '__return_false',
		] );

		// White logo
		$wp_customize->add_setting( 'logo_two',
			[
				'default'           => $this->defaults['logo_two'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			]
		);
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'logo_two',
			[
				'label'         => esc_html__( 'Logo Light', 'clrestaurant' ),
				'description'   => esc_html__( 'Add logo for transparent header', 'clrestaurant' ),
				'section'       => 'general_logo',
				'mime_type'     => 'image',
				'button_labels' => [
					'select'       => esc_html__( 'Select Logo', 'clrestaurant' ),
					'change'       => esc_html__( 'Change Logo', 'clrestaurant' ),
					'default'      => esc_html__( 'Default', 'clrestaurant' ),
					'remove'       => esc_html__( 'Remove', 'clrestaurant' ),
					'placeholder'  => esc_html__( 'No file selected', 'clrestaurant' ),
					'frame_title'  => esc_html__( 'Select File', 'clrestaurant' ),
					'frame_button' => esc_html__( 'Choose File', 'clrestaurant' ),
				],
			]
		) );

		// Logo Width
		$wp_customize->add_setting( 'logo_width',
			[
				'default'           => $this->defaults['logo_width'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_text_sanitization',
			]
		);
		$wp_customize->add_control( 'logo_width',
			[
				'label'           => esc_html__( 'Logo max width', 'clrestaurant' ),
				'section'         => 'general_logo',
				'type'            => 'text',
				'description'     => esc_html__( 'Enter logo width. Eg: 200px', 'clrestaurant' ),
				'input_attrs'     => [
					'placeholder' => esc_html__( '200px', 'clrestaurant' ),
				],
			]
		);
		// Logo Mobile Width
		$wp_customize->add_setting( 'logo_m_size',
			[
				'default'           => $this->defaults['logo_m_size'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_text_sanitization',
			]
		);
		$wp_customize->add_control( 'logo_m_size',
			[
				'label'           => esc_html__( 'Logo max width', 'clrestaurant' ),
				'section'         => 'general_logo',
				'type'            => 'text',
				'description'     => esc_html__( 'Enter logo mobile width. Eg: 120px', 'clrestaurant' ),
				'input_attrs'     => [
					'placeholder' => esc_html__( '120px', 'clrestaurant' ),
				],
			]
		);

		// Separator
		$wp_customize->add_setting( 'separator_general1', [
			'default'           => '',
			'sanitize_callback' => 'esc_html',
		] );
		$wp_customize->add_control( new Separator( $wp_customize, 'separator_general1', [
			'settings' => 'separator_general1',
			'section'  => 'general_section',
		] ) );

		// Banner Image
		$wp_customize->add_setting( 'banner_image',
			[
				'default'           => $this->defaults['banner_image'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			]
		);
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'banner_image',
			[
				'label'         => esc_html__( 'Banner Image', 'clrestaurant' ),
				'description'   => esc_html__( 'Add banner image to change default image', 'clrestaurant' ),
				'section'       => 'general_section',
				'mime_type'     => 'image',
				'button_labels' => [
					'select'       => esc_html__( 'Select Image', 'clrestaurant' ),
					'change'       => esc_html__( 'Change Image', 'clrestaurant' ),
					'default'      => esc_html__( 'Default', 'clrestaurant' ),
					'remove'       => esc_html__( 'Remove', 'clrestaurant' ),
					'placeholder'  => esc_html__( 'No file selected', 'clrestaurant' ),
					'frame_title'  => esc_html__( 'Select File', 'clrestaurant' ),
					'frame_button' => esc_html__( 'Choose File', 'clrestaurant' ),
				],
			]
		) );

		/**
         * Heading
         */
        $wp_customize->add_setting('site_switching', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'site_switching', array(
            'label' => esc_html__( 'Site Switch Control', 'clrestaurant' ),
            'section' => 'general_switcher',
        )));
		// Back to top
		$wp_customize->add_setting( 'preloader',
			[
				'default'           => $this->defaults['preloader'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'preloader',
			[
				'label'   => esc_html__( 'Preloader', 'clrestaurant' ),
				'section' => 'general_switcher',
			]
		) );

		// Back to top
		$wp_customize->add_setting( 'back_to_top',
			[
				'default'           => $this->defaults['back_to_top'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'back_to_top',
			[
				'label'   => esc_html__( 'Back to Top', 'clrestaurant' ),
				'section' => 'general_switcher',
			]
		) );
		
		// Switch for custom cursor
        $wp_customize->add_setting( 'sticky_header',
            [
                'default' => $this->defaults['sticky_header'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            ]
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'sticky_header',
            [
                'label' => esc_html__( 'Sticky Header', 'clrestaurant' ),
                'section' => 'general_switcher',
			]
        ) );

		// Hide admin bar
		$wp_customize->add_setting( 'remove_admin_bar',
			[
				'default'           => $this->defaults['remove_admin_bar'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'remove_admin_bar',
			[
				'label'       => esc_html__( 'Remove Admin Bar', 'clrestaurant' ),
				'section'     => 'general_switcher',
				'description' => esc_html__( 'This option not work for administrator users.', 'clrestaurant' ),
			]
		) );

	}

}
