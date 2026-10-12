<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.0.1
 */

namespace RadiusTheme\CLRestaurant\Customizer;

class Default_Data {

	// Customizer Default Data

	public static function default_values() {
		$customizer_defaults = [

			/* = General
            =======================================================*/
			'logo_one'                  => '',
			'logo_two'                  => '',
			'mobile_logo'               => '',
			'logo_width'                => '200px',
			'logo_m_size'               => '120px',
			'banner_image'              => '',
			'preloader'                 => '',
			'back_to_top'               => 1,
			'remove_admin_bar'          => 0,
			'site_body_layout'       	=> 'container',

			/* = Contact & Social Area = */
            'contact_phone_label'    => '',
            'contact_phone'   => '',
            'contact_email_label'     => '',
            'contact_email'    => '',
            'social_label'   => '',
            'rt_facebook'    => '',
            'rt_twitter'     => '',
            'rt_linkedin'    => '',
            'rt_instagram'   => '',
            'rt_pinterest'   => '',
            'rt_youtube'     => '',
 
			/* = Header
            =======================================================*/
			'header_top'           => 1,
			'header_top_variation' => '1',
			'header_area'          => '',
			'header_style'         => 1,
			'header_login'         => '',
            'header_login_text'    => 'Login/ Sign up',
            'login_btn_link'       => '',
            'header_listing'       => '',
            'listing_btn_text'     => 'Add Listing',
            'listing_btn_link'     => '',
			'tr_header'            => '',
			'sticky_header'        => '',

			//Mobile Control
            'header_mobile_login'   => '',
            'header_mobile_listing' => '',
            'header_mobile_toggle'  => '',           
            'header_mobile_topbar'  => '', 
            //TopBar
            'header_mobile_topbar_phone'  => '', 
            'header_mobile_topbar_email'  => '', 
            'header_mobile_topbar_social' => '',

            /* = Pages Area
            =======================================================*/
            'page_layout'        => 'full-width',
            'page_padding_top'    => '',
            'page_padding_bottom' => '',
            'page_banner' => 1,
            'page_breadcrumb' => 1,
            'page_bgcolor' => '#111111',
            'page_bgopacity' => '1',
            'page_bgimg' => '',
            'page_page_bgimg' => '',
            'page_page_bgcolor' => '',

			/* = Blog Archive
            =======================================================*/
            // Layout
            'blog_layout' => 'right-sidebar',
            'blog_padding_top'    => '',
            'blog_padding_bottom' => '',
            'blog_banner' => 1,
            'blog_breadcrumb' => 1, 
            'blog_bgcolor' => '#111111',
            'blog_bgopacity' => '1',
            'blog_bgimg' => '',
            'blog_page_bgimg' => '',
            'blog_page_bgcolor' => '',
            //Options
            'blog_style'         => 1,
            'post_meta_admin'    => 1, 
            'post_meta_comnts'   => '', 
            'post_meta_date'     => 1,
            'excerpt_length'     => 36,
            'blog_grid'          => 1,
			'blog_medium_grid'   => 1,
            'blog_button'   	 => 1,
			
			/* = Blog Single
            =======================================================*/
            //Layout
            'single_post_layout' => 'right-sidebar',
            'single_post_padding_top'    => '',
            'single_post_padding_bottom' => '',
            'single_post_banner' => 1,
            'single_post_breadcrumb' => 1,
            'single_post_bgcolor' => '#111111',
            'single_post_bgopacity' => '1',
            'single_post_bgimg' => '',
            'single_post_page_bgimg' => '',
            'single_post_page_bgcolor' => '',
            //Options
            'post_feature_img'  => 1,
            'post_admin'        => 1,
            'post_date'         => 1,
            'post_comnts'       => 1,
            'post_cats'         => 1,
            'post_tags'         => 1,
            'post_share'        => '',
            'blog_related_post' => '',

            /* = Search Layout 
            =======================================================*/
            //Layout 
            'search_layout' => 'right-sidebar',
            'search_padding_top'    => '',
            'search_padding_bottom' => '',
            'search_banner' => 1,
            'search_breadcrumb' => 1,
            'search_bgcolor' => '#111111',
            'search_bgopacity' => '1',
            'search_bgimg' => '',
            'search_page_bgimg' => '',
            'search_page_bgcolor' => '',
            'search_excerpt_length' => 40,

            // 'listing_search_items' => '',

			/* = Error Layout 
            =======================================================*/
            //Layout 
            'error_padding_top'    => '',
            'error_padding_bottom' => '',
            'error_banner' => 1,
            'error_breadcrumb' => 1,
            'error_bgcolor' => '#111111',
            'error_bgopacity' => '1',
            'error_bgimg' => '',
            'error_page_bgimg' => '',
            'error_page_bgcolor' => '',
            //Options
            'error_bg_img' => '',
            'error_page_title' => 'Oops... Page Not Found!',
            'error_page_desc' => 'Sorry We Can not Find That Page!',
            'error_buttontext' => 'Take Me Home',

			/* = Listing Archive
            =======================================================*/
            // Layout
            'listing_archive_box_layout' => 'container',
            'listing_layout' => 'left-sidebar',
            'listing_padding_top'    => '',
            'listing_padding_bottom' => '',
            'listing_banner' => 1,
            'listing_breadcrumb' => 1, 
            'listing_bgcolor' => '#111111',
            'listing_bgopacity' => '1',
            'listing_bgimg' => '',
            'listing_page_bgimg' => '',
            'listing_page_bgcolor' => '',
            //Options
            'listing_archive_breadcrumb'   => 1,
            'listing_archive_style'   => 1,
            'listing_grid_cols'       => 2,
            'show_custom_fields_label' => '',
            'show_listing_custom_fields' => '',
            'cl_restaurant_listing_excerpt' => '13',
            
            /* = Single Listing
            =======================================================*/
            // Layout
            'listing_post_banner' => '',
            'listing_post_padding_top'    => '',
            'listing_post_padding_bottom' => '',
            'listing_post_breadcrumb' => 1,
            'listing_post_bgimg' => '',
            'listing_post_bgcolor' => '#111111',
            'listing_post_bgopacity' => '1',
            'listing_post_page_bgimg' => '',
            'listing_post_page_bgcolor' => '',
            //Options
            'single_listing_header_banner' => 'image',
            'single_listing_style'         => 1,
            'listing_single_breadcrumb'    => 1,
            'listing_desc_title'           => 'Restaurant Overview',
            'listing_map_title'            => 'Location',
            'listing_video_title'          => 'Special Food Video',
            'listing_rating_title'         => 'Rating',
            'custom_fields_group_types'    => ['166'],
            'custom_fields_list_types'     => [],
            'show_related_listing'         => 1,
            'related_post_title'           => 'Related Restaurant',
            'related_post_slider_cols'     => 3,

            // Listing Search Form
            // Baneer
            'listing_banner_search_items'  => ['category', 'location', 'keyword'],
            'listing_banner_search_style'  => ['popup'],
            // Map
            'listing_map_search_items'    => ['keyword', 'location', 'category', 'price', 'radius'],
			'custom_fields_search_items'   => '',
            'listing_widget_min_price'    => '0',
			'listing_widget_max_price'    => '20000',
			'listing_price_search_type'   => 'input',

            //Sidebar
            'listing_list_information'    => 1,
            'listing_list_timing'         => 1,
            'listing_list_socials'        => 1,
            'listing_list_map_location'   => 1,

            // Listing Event Fields
            'custom_events_fields_types'  => [],
            // Listing Doctor Fields
            'custom_doctor_fields_types'  => [],

            /* = Footer Area 
            =======================================================*/
            //Footer
            'footer_area'    => 1,
            'footer_style'   => 1,
            'copyright_text' => gmdate( 'Y' ) . ' © CL Restaurant by <a href="https://www.radiustheme.com">RadiusTheme</a>.',

            //Footer 1
            'footer1_bg_color' => '#001e56',
            'footer1_bg_opacity' => '',
            'f1_widgets_area' => '4',
            'f1_area1_column' => '3',
            'f1_area2_column' => '3',
            'f1_area3_column' => '3',
            'f1_area4_column' => '3',

            //Apps
            'footer_newsletter'    => '',
            'newsletter_title'     => '',
            'newsletter_desc'      => '',
            'newsletter_shortcode' => '',

			/* = Body Typo Area
            =======================================================*/
            'typo_body' => json_encode(
                array(
                    'font' => 'Roboto',
                    'regularweight' => 'normal',
                )
            ),
            'typo_body_size' => '15px',
            'typo_body_height'=> '1.8',

            /* = Menu Typo Area
            =======================================================*/
            //Menu Typography
            'typo_menu' => json_encode(
                array(
                    'font' => 'Work Sans',
                    'regularweight' => '500',
                )
            ),
            'typo_menu_size' => '15px',
            'typo_menu_height'=> '1.6',

            //Sub Menu Typography
            'typo_submenu_size' => '14px',
            'typo_submenu_height'=> '1.6',

            /* = Heading Typo Area
            =======================================================*/
            //Heading Typography
            'typo_heading' => json_encode(
                array(
                    'font' => 'Work Sans',
                    'regularweight' => '600',
                )
            ),

            //Heading Typography
            'typo_sub_heading' => json_encode(
                array(
                    'font' => 'Taprom',
                    'regularweight' => '400',
                )
            ),

            //H1
            'typo_h1' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '600',
                )
            ),
            'typo_h1_size' => '42px',
            'typo_h1_height' => '1.3',

            //H2
            'typo_h2' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '600',
                )
            ),
            'typo_h2_size' => '36px',
            'typo_h2_height'=> '1.3',

            //H3
            'typo_h3' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '600',
                )
            ),
            'typo_h3_size' => '28px',
            'typo_h3_height'=> '1.3',

            //H4
            'typo_h4' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '600',
                )
            ),
            'typo_h4_size' => '22px',
            'typo_h4_height'=> '1.3',

            //H5
            'typo_h5' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '600',
                )
            ),
            'typo_h5_size' => '18px',
            'typo_h5_height'=> '1.3',

            //H6
            'typo_h6' => json_encode(
                array(
                    'font' => '',
                    'regularweight' => '600',
                )
            ),
            'typo_h6_size' => '14px',
            'typo_h6_height'=> '1.2',

            /* = Site Color Area
            =======================================================*/
            // Base Color
            'primary_color' => '',
            'body_color' => '',
            'heading_color' => '',

            /* = Menu Color
            =======================================*/
            // Normal Menu
            'menu_bg_color' => '',
            'menu_text_color' => '',
            'menu_text_hover_color' => '',
            // Submenu
            'submenu_bg_color' => '',
            'submenu_text_color' => '',
            'submenu_htext_color' => '',

            // Transparent Menu
            'menu2_text_color' => '',
            'menu2_text_hover_color' => '',
            // Submenu
            'submenu2_bg_color' => '',
            'submenu2_text_color' => '',
            'submenu2_htext_color' => '',

            // Others light
            'scroll_color'    => '',
            'preloader_bg_color' => '',
            'preloader_circle_color' => '',

		];

		return apply_filters( 'rttheme_customizer_defaults', $customizer_defaults );
	}
}