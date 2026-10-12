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
use RadiusTheme\CLRestaurant\Customizer\Controls\Image_Radio;
use RadiusTheme\CLRestaurant\Customizer\Controls\Switcher;
use RadiusTheme\CLRestaurant\Customizer\Customizer;
use RadiusTheme\CLRestaurant\Helper;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Header extends Customizer {

	public function __construct() {
		parent::instance();
		$this->populated_default_data();
		// Add Controls
		add_action( 'customize_register', [ $this, 'register_header_controls' ] );
	}

	public function register_header_controls( $wp_customize ) {
		// Header top bar
		$wp_customize->add_setting( 'header_top',
			[
				'default'           => $this->defaults['header_top'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'header_top',
			[
				'label'   => esc_html__( 'Top Bar', 'clrestaurant' ),
				'section' => 'header_all_section',
			]
		) );
        // Header variation
        $wp_customize->add_setting( 'header_top_variation',
			[
                'default' => $this->defaults['header_top_variation'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            ]
        );
        $wp_customize->add_control( 'header_top_variation',
			[
                'label' => esc_html__( 'Header Top Variation', 'clrestaurant' ),
                'section' => 'header_all_section',
                'description' => esc_html__( 'Header top part variation', 'clrestaurant' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( '1 Column', 'clrestaurant' ),
                    '2' => esc_html__( '2 Columns', 'clrestaurant' ),
                ),
            ]
        );

		// Header area		
		$wp_customize->add_setting( 'header_area',
            [
                'default' => $this->defaults['header_area'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            ]
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_area',
			[
                'label' => __( 'Header On/Off', 'clrestaurant' ),
                'section' => 'header_all_section',
            ]
        ) );
		// Header Style
		$wp_customize->add_setting( 'header_style',
			[
				'default'           => $this->defaults['header_style'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_radio_sanitization',
			]
		);
		$wp_customize->add_control( new Image_Radio( $wp_customize, 'header_style',
			[
				'label'       => esc_html__( 'Header Layout', 'clrestaurant' ),
				'description' => esc_html__( 'Select the header style', 'clrestaurant' ),
				'section'     => 'header_all_section',
				'choices'     => Helper::get_hf_list( 'header' ),
			]
		) );

		/* - Header login button
        ============================================================= */
        $wp_customize->add_setting( 'header_login',
            array(
                'default' => $this->defaults['header_login'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_login',
            array(
                'label' => esc_html__( 'Login Button', 'clrestaurant' ),
                'section' => 'header_all_section',
            )
        ) );
        // Header login button text
        $wp_customize->add_setting( 'header_login_text',
			[
				'default'           => $this->defaults['header_login_text'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'header_login_text',
			[
				'label'   => __( 'Login Button Text', 'clrestaurant' ),
				'section' => 'header_all_section',
				'type'    => 'text',
			]
		);
        // Header login button link
        $wp_customize->add_setting( 'login_btn_link',
			[
				'default'           => $this->defaults['login_btn_link'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'login_btn_link',
			[
				'label'   => __( 'Login Button Url', 'clrestaurant' ),
				'section' => 'header_all_section',
				'type'    => 'text',
			]
		);

        /* - Header Listing Form button
        ============================================================= */
        $wp_customize->add_setting( 'header_listing',
            array(
                'default' => $this->defaults['header_listing'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_listing',
            array(
                'label' => esc_html__( 'Listing Button', 'clrestaurant' ),
                'section' => 'header_all_section',
            )
        ) );
        // Header listing button text
        $wp_customize->add_setting( 'listing_btn_text',
			[
				'default'           => $this->defaults['listing_btn_text'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'listing_btn_text',
			[
				'label'   => __( 'Listing Form Button Text', 'clrestaurant' ),
				'section' => 'header_all_section',
				'type'    => 'text',
			]
		);
        // Header login button link
        $wp_customize->add_setting( 'listing_btn_link',
			[
				'default'           => $this->defaults['listing_btn_link'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'listing_btn_link',
			[
				'label'   => __( 'Listing Form Url', 'clrestaurant' ),
				'section' => 'header_all_section',
				'type'    => 'text',
			]
		);

        /* - Transparent Header
        ============================================================= */
		$wp_customize->add_setting( 'tr_header',
			[
				'default'           => $this->defaults['tr_header'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'tr_header',
			[
				'label'       => esc_html__( 'Transparent Header', 'clrestaurant' ),
				'description' => esc_html__( 'You have to enable Banner or Slider in page to make it work properly', 'clrestaurant' ),
				'section'     => 'header_all_section',
			]
		) );

        /* - Sticky Header Control
        ============================================================= */
		$wp_customize->add_setting( 'sticky_header',
			[
				'default'           => $this->defaults['sticky_header'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'sticky_header',
			[
				'label'       => esc_html__( 'Sticky Header', 'clrestaurant' ),
				'description' => esc_html__( 'Show header at the top when scrolling down', 'clrestaurant' ),
				'section'     => 'header_all_section',
			]
		) );

		/**
         * Mobile Devices Menu Heading
        * ===================================================================================================*/
        $wp_customize->add_setting('mobile_header_switching', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'mobile_header_switching', array(
            'label' => esc_html__( 'Mobile Menu Control', 'clrestaurant' ),
            'section' => 'header_mobile_section',
        )));

        // Mobile Devices Search
        $wp_customize->add_setting( 'header_mobile_login',
            array(
                'default' => $this->defaults['header_mobile_login'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_mobile_login',
            array(
                'label' => esc_html__( 'Login Button', 'clrestaurant' ),
                'section' => 'header_mobile_section',
            )
        ) );
        // Mobile Devices Button
        $wp_customize->add_setting( 'header_mobile_listing',
            array(
                'default' => $this->defaults['header_mobile_listing'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_mobile_listing',
            array(
                'label' => esc_html__( 'Listing Button', 'clrestaurant' ),
                'section' => 'header_mobile_section',
            )
        ) );
        // Mobile Devices Toggle
        $wp_customize->add_setting( 'header_mobile_toggle',
            array(
                'default' => $this->defaults['header_mobile_toggle'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_mobile_toggle',
            array(
                'label' => esc_html__( 'Toggle Button', 'clrestaurant' ),
                'section' => 'header_mobile_section',
            )
        ) );
        
        $wp_customize->add_setting('mobile_header_top_switching', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'mobile_header_top_switching', array(
            'label' => esc_html__( 'Mobile Header Top', 'clrestaurant' ),
            'section' => 'header_mobile_section',
        )));
        // Mobile Devices Phone
        $wp_customize->add_setting( 'header_mobile_topbar',
            array(
                'default' => $this->defaults['header_mobile_topbar'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_mobile_topbar',
            array(
                'label' => esc_html__( 'Top Bar', 'clrestaurant' ),
                'section' => 'header_mobile_section',
            )
        ) );
        // Mobile Devices Top Bar Phone
        $wp_customize->add_setting( 'header_mobile_topbar_phone',
            array(
                'default' => $this->defaults['header_mobile_topbar_phone'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_mobile_topbar_phone',
            array(
                'label' => esc_html__( 'Top Bar Phone', 'clrestaurant' ),
                'section' => 'header_mobile_section',
            )
        ) );
        // Mobile Devices Top Bar Email
        $wp_customize->add_setting( 'header_mobile_topbar_email',
            array(
                'default' => $this->defaults['header_mobile_topbar_email'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_mobile_topbar_email',
            array(
                'label' => esc_html__( 'Top Bar Email', 'clrestaurant' ),
                'section' => 'header_mobile_section',
            )
        ) );
        // Mobile Devices Top Bar Socias
        $wp_customize->add_setting( 'header_mobile_topbar_social',
            array(
                'default' => $this->defaults['header_mobile_topbar_social'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'header_mobile_topbar_social',
            array(
                'label' => esc_html__( 'Top Bar Social', 'clrestaurant' ),
                'section' => 'header_mobile_section',
            )
        ) );

	}
}