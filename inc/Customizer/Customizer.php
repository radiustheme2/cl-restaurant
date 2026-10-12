<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.0.0
 */

namespace RadiusTheme\CLRestaurant\Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Customizer {

	// Get our default values
	protected $defaults;
	protected static $instance = null;

	public function __construct() {
		// Register Panels
		add_action( 'customize_register', [ $this, 'add_customizer_panels' ] );
		// Register sections
		add_action( 'customize_register', [ $this, 'add_customizer_sections' ] );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function populated_default_data(){
		$this->defaults = Default_Data::default_values();
	}

	/**
	 * Customizer Panels
	 */
	public function add_customizer_panels( $wp_customize ) {
		// Add General Panel
        $wp_customize->add_panel( 'rttheme_general_settings',
            [
                'title' => esc_html__( 'General', 'clrestaurant' ),
                'description' => esc_html__( 'Headers.', 'clrestaurant' ),
                'priority' => 1,
            ]
        );

		// Add Header Panel
        $wp_customize->add_panel( 'rttheme_header_settings',
            [
                'title' => esc_html__( 'Header', 'clrestaurant' ),
                'description' => esc_html__( 'Headers.', 'clrestaurant' ),
                'priority' => 2,
            ]
        );

        // Add Footer Panel
        $wp_customize->add_panel( 'rttheme_footer_settings',
			[
                'title' => esc_html__( 'Footer', 'clrestaurant' ),
                'description' => esc_html__( 'Footers', 'clrestaurant' ),
                'priority' => 3,
            ]
        );
		// Color Panel
		$wp_customize->add_panel( 'rttheme_color_panel',
			[
				'title'       => esc_html__( 'Color', 'clrestaurant' ),
				'description' => esc_html__( 'Change site color', 'clrestaurant' ),
				'priority'    => 4,
			]
		);
		// Blog Panel
		$wp_customize->add_panel( 'rttheme_blog_panel',
			[
				'title'       => esc_html__( 'Blog', 'clrestaurant' ),
				'description' => esc_html__( 'Blog Settings', 'clrestaurant' ),
				'priority'    => 6,
			]
		);
		// Listing Panel
		$wp_customize->add_panel( 'rttheme_listing_panel',
			[
				'title'       => esc_html__( 'Listing', 'clrestaurant' ),
				'description' => esc_html__( 'Listing & Listing Details Settings', 'clrestaurant' ),
				'priority'    => 7,
			]
		);
		// Layout Panel
		$wp_customize->add_panel( 'rttheme_layouts_defaults',
			[
				'title'       => esc_html__( 'Layout Settings', 'clrestaurant' ),
				'description' => esc_html__( 'Adjust the overall layout for your site.', 'clrestaurant' ),
				'priority'    => 8,
			]
		);
		// Pages Panel
		$wp_customize->add_panel( 'rttheme_pages_defaults',
			[
				'title'       => esc_html__( 'Pages Settings', 'clrestaurant' ),
				'description' => esc_html__( 'Default pages settings here.', 'clrestaurant' ),
				'priority'    => 8,
			]
		);
	}

	/**
	 * Customizer sections
	 */
	public function add_customizer_sections( $wp_customize ) {
		// Rename the default Colors section
		$wp_customize->get_section( 'colors' )->title = 'Background';
		// Move the default Colors section to our new Colors Panel
		$wp_customize->get_section( 'colors' )->panel = 'colors_panel';
		// Change the Priority of the default Colors section so it's at the top of our Panel
		$wp_customize->get_section( 'colors' )->priority = 10;

		/* = General Panel
		===================================================================*/
		// Add General Section Logo
		$wp_customize->add_section( 'general_logo',
			[
				'title'    => esc_html__( 'Logo', 'clrestaurant' ),
				'priority' => 1,
				'panel'    => 'rttheme_general_settings',
			]
		);
		// General Section Logo
		$wp_customize->add_section( 'general_switcher',
			[
				'title'    => esc_html__( 'Switcher', 'clrestaurant' ),
				'priority' => 2,
				'panel'    => 'rttheme_general_settings',
			]
		);
		// General Section Contact Info
		$wp_customize->add_section( 'contact_info_section',
			[
				'title'    => esc_html__( 'Contact & Social', 'clrestaurant' ),
				'priority' => 3,
				'panel'    => 'rttheme_general_settings',
			]
		);


		/* = Header Panel
		===================================================================*/
		// Add Header Main Section
		$wp_customize->add_section( 'header_all_section',
			[
				'title'    => esc_html__( 'All Header', 'clrestaurant' ),
				'priority' => 1,
				'panel'    => 'rttheme_header_settings',
			]
		);
		// Add Header Mobile Section
		$wp_customize->add_section( 'header_mobile_section',
			[
				'title'    => esc_html__( 'Mobile', 'clrestaurant' ),
				'priority' => 3,
				'panel'    => 'rttheme_header_settings',
			]
		);

		/* = Footer Panel
		===================================================================*/
		// Add Footer Section
		$wp_customize->add_section( 'footer_all_section',
			[
				'title'    => esc_html__( 'All Footer', 'clrestaurant' ),
				'panel'    => 'rttheme_footer_settings',
				'priority' => 1,
			]
		);
		$wp_customize->add_section( 'footer_1',
			[
				'title'    => esc_html__( 'Footer Columns', 'clrestaurant' ),
				'panel'    => 'rttheme_footer_settings',
				'priority' => 2,
			]
		);
		$wp_customize->add_section( 'footer_2',
			[
				'title'    => esc_html__( 'Footer 2', 'clrestaurant' ),
				'panel'    => 'rttheme_footer_settings',
				'priority' => 3,
			]
		);
		$wp_customize->add_section( 'footer_newsletter',
			[
				'title'    => esc_html__( 'Newsletter Section', 'clrestaurant' ),
				'panel'    => 'rttheme_footer_settings',
				'priority' => 4,
			]
		);


		/* = Colors Panel
		===================================================================*/
		// Add Color Section
		$wp_customize->add_section( 'site_color_section',
			[
				'title'    => esc_html__( 'Site Color', 'clrestaurant' ),
				'panel'    => 'rttheme_color_panel',
				'priority' => 1,
			]
		);
		$wp_customize->add_section( 'menu_color_section',
			[
				'title'    => esc_html__( 'Menu Color', 'clrestaurant' ),
				'panel'    => 'rttheme_color_panel',
				'priority' => 2,
			]
		);
		$wp_customize->add_section( 'breadcrumb_color_section',
			[
				'title'    => esc_html__( 'Breadcrumb Color', 'clrestaurant' ),
				'panel'    => 'rttheme_color_panel',
				'priority' => 3,
			]
		);
		$wp_customize->add_section( 'footer_color_section',
			[
				'title'    => esc_html__( 'Footer Color', 'clrestaurant' ),
				'panel'    => 'rttheme_color_panel',
				'priority' => 4,
			]
		);


		/* = Layout Panel
		===================================================================*/
		// Add Blog Layout Section
		$wp_customize->add_section( 'blog_layout_section',
			[
				'title'    => esc_html__( 'Blog Layout', 'clrestaurant' ),
				'priority' => 1,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Single Post Layout Section
		$wp_customize->add_section( 'blog_single_layout_section',
			[
				'title'    => esc_html__( 'Blog Single Layout', 'clrestaurant' ),
				'priority' => 2,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Pages Layout Section
		$wp_customize->add_section( 'page_layout_section',
			[
				'title'    => esc_html__( 'Pages Layout', 'clrestaurant' ),
				'priority' => 3,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Search Layout Section
		$wp_customize->add_section( 'search_layout_section',
			[
				'title'    => esc_html__( 'Search Layout', 'clrestaurant' ),
				'priority' => 4,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Error Layout Section
		$wp_customize->add_section( 'error_layout_section',
			[
				'title'    => esc_html__( 'Error Layout', 'clrestaurant' ),
				'priority' => 4,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Listing Layout Section
		$wp_customize->add_section( 'listing_archive_layout_section',
			[
				'title'    => esc_html__( 'Listing Archive Layout', 'clrestaurant' ),
				'priority' => 5,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Listing Single Layout Section
		$wp_customize->add_section( 'listing_single_layout_section',
			[
				'title'    => esc_html__( 'Listing Single Layout', 'clrestaurant' ),
				'priority' => 6,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);


		/* = Blog Panel
		===================================================================*/
		// Add Blog Archive Section
		$wp_customize->add_section( 'blog_archive_section',
			[
				'title'    => esc_html__( 'Blog Archive', 'clrestaurant' ),
				'priority' => 1,
				'panel'    => 'rttheme_blog_panel',
			]
		);
		// Add Single Post Section 
		$wp_customize->add_section( 'single_post_section',
			[
				'title'    => esc_html__( 'Blog Post Details', 'clrestaurant' ),
				'priority' => 2,
				'panel'    => 'rttheme_blog_panel',
			]
		);

		/* = Listing Panel
		===================================================================*/
		// Add Listing Section
        $wp_customize->add_section( 'listing_archive_section',
            array(
                'title' => esc_html__( 'Listing Archive', 'clrestaurant' ),
                'priority' => 1,
                'panel' => 'rttheme_listing_panel',
            )
        );
        // Add Listing Section
        $wp_customize->add_section( 'listing_details_section',
            array(
                'title' => esc_html__( 'Listing Details', 'clrestaurant' ),
                'priority' => 2,
                'panel' => 'rttheme_listing_panel',
            )
        );
        // Add Listing Search Section
        $wp_customize->add_section( 'listing_search_section',
            array(
                'title' => esc_html__( 'Listing Search', 'clrestaurant' ),
                'priority' => 3,
                'panel' => 'rttheme_listing_panel',
            )
        );

		// Add Error Page Section
		$wp_customize->add_section( 'error_section',
			[
				'title'    => esc_html__( 'Error Page', 'clrestaurant' ),
				'priority' => 1,
			]
		);

		/* = Pages Panel
		===================================================================*/
		// 404 Page
        $wp_customize->add_section( 'error_section',
            array(
                'title' => esc_html__( '404 Error', 'clrestaurant' ),
                'priority' => 1,
                'panel' => 'rttheme_pages_defaults',
            )
        );
	}

}
