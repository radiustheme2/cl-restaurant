<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLRestaurant;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Scripts { 

    public $version;
    protected static $instance = null;

    public function __construct() {
        $this->version = Constants::$theme_version;
        add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 12 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 99 );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_conditional_scripts' ), 1 );
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'rt_custom_animations' ], 99 );
    }

    public static function instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function fonts_url() {
        $fonts_url = '';
        $subsets = 'latin';
        $bodyFont = 'Roboto';
        $bodyFW = '400';
        $menuFont = 'Work Sans';
        $menuFontW = '500';
        $offmenuFont = 'Work Sans';
        $offmenuFontW = '400';
        $shFont = 'Taprom';
        $shFontW = '400';
        $hFont = 'Work Sans';
        $hFontW = '600';
        $h1Font = '';
        $h2Font = '';
        $h3Font = '';
        $h4Font = '';
        $h5Font = '';
        $h6Font = '';

        // Body Font
        $body_font  = json_decode( Options::$options['typo_body'], true );
        if ($body_font['font'] == 'Inherit') {
            $bodyFont = 'Roboto';
        } else {
            $bodyFont = $body_font['font'];
        }
        $bodyFontW = $body_font['regularweight'];

        // Menu Font
        $menu_font  = json_decode( Options::$options['typo_menu'], true );
        if ($menu_font['font'] == 'Inherit') {
            $menuFont = 'Work Sans';
        } else {
            $menuFont = $menu_font['font'];
        }
        $menuFontW = $menu_font['regularweight'];

        // Sub Heading Font
        $sh_font  = json_decode( Options::$options['typo_sub_heading'], true );
        if ($sh_font['font'] == 'Inherit') {
            $shFont = 'Taprom';
        } else {
            $shFont = $sh_font['font'];
        }
        $shFontW = $sh_font['regularweight'];

        // Heading Font Settings
        $h_font  = json_decode( Options::$options['typo_heading'], true );
        if ($h_font['font'] == 'Inherit') {
            $hFont = 'Work Sans';
        } else {
            $hFont = $h_font['font'];
        }
        $hFontW = $h_font['regularweight'];
        $h1_font  = json_decode( Options::$options['typo_h1'], true );
        $h2_font  = json_decode( Options::$options['typo_h2'], true );
        $h3_font  = json_decode( Options::$options['typo_h3'], true );
        $h4_font  = json_decode( Options::$options['typo_h4'], true );
        $h5_font  = json_decode( Options::$options['typo_h5'], true );
        $h6_font  = json_decode( Options::$options['typo_h6'], true );

        if ( 'off' !== _x( 'on', 'Google font: on or off', 'clrestaurant' ) ) {

            if (!empty($h1_font['font'])) {
                if ($h1_font['font'] == 'Inherit') {
                    $h1Font = $hFont;
                    $h1FontW = $hFontW;
                } else {
                    $h1Font = $h2_font['font'];
                    $h1FontW = $h1_font['regularweight'];
                }
            } if (!empty($h2_font['font'])) {
                if ($h2_font['font'] == 'Inherit') {
                    $h2Font = $hFont;
                    $h2FontW = $hFontW;
                } else {
                    $h2Font = $h2_font['font'];
                    $h2FontW = $h2_font['regularweight'];
                }
            } if (!empty($h3_font['font'])) {
                if ($h3_font['font'] == 'Inherit') {
                    $h3Font = $hFont;
                    $h3FontW = $hFontW;
                } else {
                    $h3Font = $h3_font['font'];
                    $h3FontW = $h3_font['regularweight'];
                }
            } if (!empty($h4_font['font'])) {
                if ($h4_font['font'] == 'Inherit') {
                    $h4Font = $hFont;
                    $h4FontW = $hFontW;
                } else {
                    $h4Font = $h4_font['font'];
                    $h4FontW = $h4_font['regularweight'];
                }
            } if (!empty($h5_font['font'])) {
                if ($h5_font['font'] == 'Inherit') {
                    $h5Font = $hFont;
                    $h5FontW = $hFontW;
                } else {
                    $h5Font = $h5_font['font'];
                    $h5FontW = $h5_font['regularweight'];
                }
            } if (!empty($h6_font['font'])) {
                if ($h6_font['font'] == 'Inherit') {
                    $h6Font = $hFont;
                    $h6FontW = $hFontW;
                } else {
                    $h6Font = $h6_font['font'];
                    $h6FontW = $h6_font['regularweight'];
                }
            }

            $check_families = array();
            $font_families = array();

            // Body Font
            if ( 'off' !== $bodyFont )
                $font_families[] = $bodyFont.':300,'.$bodyFW.',500,600,700';
                $check_families[] = $bodyFont;

            // Menu Font
            if ( 'off' !== $menuFont )
                if ( !in_array( $menuFont, $check_families ) ) {
                    $font_families[] = $menuFont.':'.$menuFontW.',600,700';
                    $check_families[] = $menuFont;
                }

            // Sub Heading Font
            if ( 'off' !== $shFont )
                if ( !in_array( $shFont, $check_families ) ) {
                    $font_families[] = $shFont.':'.$shFontW;
                    $check_families[] = $shFont;
                } 
                
            // Heading Font
            if ( 'off' !== $hFont )
                if (!in_array( $hFont, $check_families )) {
                    $font_families[] = $hFont.':'.$hFontW;
                    $check_families[] = $hFont;
                }

            // Heading 1 Font
            if (!empty($h1_font['font'])) {
                if ( 'off' !== $h1Font )
                    if (!in_array( $h1Font, $check_families )) {
                        $font_families[] = $h1Font.':'.$h1FontW;
                        $check_families[] = $h1Font;
                    }
            }
            // Heading 2 Font
            if (!empty($h2_font['font'])) {
                if ( 'off' !== $h2Font )
                    if (!in_array( $h2Font, $check_families )) {
                        $font_families[] = $h2Font.':'.$h2FontW;
                        $check_families[] = $h2Font;
                    }
            }
            // Heading 3 Font
            if (!empty($h3_font['font'])) {
                if ( 'off' !== $h3Font )
                    if (!in_array( $h3Font, $check_families )) {
                        $font_families[] = $h3Font.':'.$h3FontW;
                        $check_families[] = $h3Font;
                    }
            }
            // Heading 4 Font
            if (!empty($h4_font['font'])) {
                if ( 'off' !== $h4Font )
                    if (!in_array( $h4Font, $check_families )) {
                        $font_families[] = $h4Font.':'.$h4FontW;
                        $check_families[] = $h4Font;
                    }
            }

            // Heading 5 Font
            if (!empty($h5_font['font'])) {
                if ( 'off' !== $h5Font )
                    if (!in_array( $h5Font, $check_families )) {
                        $font_families[] = $h5Font.':'.$h5FontW;
                        $check_families[] = $h5Font;
                    }
            }
            // Heading 6 Font
            if (!empty($h6_font['font'])) {
                if ( 'off' !== $h6Font )
                    if (!in_array( $h6Font, $check_families )) {
                        $font_families[] = $h6Font.':'.$h6FontW;
                        $check_families[] = $h6Font;
                    }
            }
            $final_fonts = array_unique( $font_families );
            $query_args = array(
                'family' => urlencode( implode( '|', $final_fonts ) ),
                'display' => urlencode( 'fallback' ),
            );

            $fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
        }
        
        return esc_url_raw( $fonts_url );
    }   

    public function rt_custom_animations() {
        wp_register_style( 'rt-animation', Helper::get_css( 'rt-animation' ), [], $this->version );
        wp_enqueue_style( 'rt-animation' );
    }

    public function register_scripts(){

        /* = CSS
        ===========================================================*/
        // Bootstrap css
        wp_register_style( 'bootstrap',        Helper::get_vendor_css( 'bootstrap/bootstrap.min' ), array(), $this->version );
        wp_register_style( 'select2',          Helper::get_vendor_css( 'select2/select2.min' ), array(), $this->version );
        // FontAwesome css
        wp_register_style( 'font-awesome-all', Helper::get_css( 'font-awesome-all.min' ), array(), $this->version );
        // Custom Icon Fonts css
        wp_register_style( 'fontello',         Helper::get_css( 'fontello' ), array(), $this->version );
        // Rangle Slider
        wp_register_style( 'rangeSlider',      Helper::get_vendor_css( 'rangeSlider/ion.rangeSlider.min' ), [], $this->version );
        // Animate css
        wp_register_style( 'animate',          Helper::get_css( 'animate' ), array(), $this->version );
        // Main Theme Style
        wp_register_style( 'clrestaurant-style',    Helper::get_css( 'main' ), array(), $this->version );
        // Main Theme Style
        wp_register_style( 'clrestaurant-rtl',      Helper::get_rtl_css( 'clrestaurant-rtl' ), [], $this->version );
        
        /* = JS 
        ======================================================================*/
        // Bootstrap    
        wp_register_script( 'popper',    Helper::get_vendor_js( 'bootstrap/popper.min' ), array( 'jquery' ), $this->version, true );
        wp_register_script( 'bootstrap', Helper::get_vendor_js( 'bootstrap/bootstrap.min' ), array( 'jquery' ), $this->version, true );
        wp_register_script( 'select2',   Helper::get_vendor_js( 'select2/select2.min' ), array(), $this->version );
        
        // WoW Animation js
        wp_register_script( 'wow',       Helper::get_js( 'wow.min' ), array( 'jquery' ), $this->version, true );
        // PhotoSwipe js
        wp_register_script( 'photoswipe', Helper::get_vendor_js( 'photoswipe/photoswipe.min' ), [ 'jquery' ], $this->version, true );
        wp_register_script( 'photoswipe-ui-default', Helper::get_vendor_js( 'photoswipe/photoswipe-ui-default.min' ), [ 'jquery' ], $this->version, true );
        wp_register_script( 'rangeSlider', Helper::get_vendor_js( 'rangeSlider/ion.rangeSlider.min' ), [ 'jquery' ], $this->version, true );

        // Food Menu js
        wp_register_script( 'rt-food-menu', Helper::get_js( 'food-menu' ), [ 'jquery' ], $this->version, true );
        // Main js
        wp_register_script( 'cl-restaurant-main', Helper::get_js( 'main' ), array( 'jquery' ), $this->version, true );
    }  
    
    public function enqueue_scripts() {
        /*CSS*/
        wp_enqueue_style( 'clrestaurant-gfonts', $this->fonts_url(), array(), $this->version );
        wp_enqueue_style( 'bootstrap' );
        wp_enqueue_style( 'font-awesome-all' );
        wp_enqueue_style( 'fontello' );
        wp_enqueue_style( 'select2' );
        wp_enqueue_style( 'animate' );
        wp_enqueue_style( 'photoswipe' );
        wp_enqueue_style( 'photoswipe-default-skin' );

        $this->conditional_scripts();

        wp_enqueue_style( 'clrestaurant-style' );
        if ( is_rtl() ) {
            wp_enqueue_style( 'clrestaurant-rtl' );
        }
        $this->dynamic_style();
        /*JS*/
        wp_enqueue_script( 'popper' );
        wp_enqueue_script( 'bootstrap' );
        wp_enqueue_script( 'select2' );
        wp_enqueue_script( 'wow' );
        wp_enqueue_script( 'photoswipe' );
        wp_enqueue_script( 'photoswipe-ui-default' );
        $this->localized_scripts();
        wp_enqueue_script( 'rt-food-menu' );
        wp_enqueue_script( 'cl-restaurant-main' );

        $this->elementor_scripts();
    }

    public function elementor_scripts() {
        if ( !did_action( 'elementor/loaded' ) ) {
            return;
        }
        wp_enqueue_style( 'select2' );
        wp_enqueue_script( 'select2' );
    }

    private function conditional_scripts(){
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        if (is_post_type_archive('rtcl_listing') || is_singular('rtcl_listing') || is_author() || is_tax( 'rtcl_category' ) ) {
            wp_enqueue_style( 'rangeSlider' );
            wp_enqueue_script( 'rangeSlider' );
        }
    }
    
    public function admin_conditional_scripts(){
        //Css
        wp_enqueue_style( 'fontello',             Helper::get_css( 'fontello' ), array(), $this->version );  
        wp_enqueue_style( 'clrestaurant-gfonts',  $this->fonts_url(), array(), $this->version );
        wp_enqueue_style( 'font-awesome-all',     Helper::get_css( 'font-awesome-all.min' ), array(), $this->version );
        wp_enqueue_style( 'customizer-controls',  Helper::get_css( 'customizer' ), array(), $this->version );
        wp_enqueue_style( 'select2',              Helper::get_vendor_css( 'select2/select2.min' ), array(), $this->version );
        // Js
        wp_enqueue_script( 'select2',             Helper::get_vendor_js( 'select2/select2.min' ), array(), $this->version );
        wp_enqueue_script( 'clrestaurant-admin',  Helper::get_js( 'clrestaurant-admin' ), array( 'jquery' ), $this->version, true );
    }

    private function localized_scripts(){
        $adminajax     = esc_url( admin_url('admin-ajax.php') );
        $localize_data = array(
            'ajaxurl'     => $adminajax,
        );
        wp_localize_script( 'cl-restaurant-main', 'ClRestaurantObj', $localize_data );
    }

    private function dynamic_style() {
        $dynamic_css = $this->template_style();
        ob_start();
        Helper::requires( 'dynamic-style.php', 'dynamic-styles' );
        $dynamic_css .= ob_get_clean();
        $dynamic_css = $this->optimized_css( $dynamic_css );
        wp_register_style( 'cl-restaurant-dynamic', false );
        wp_enqueue_style( 'cl-restaurant-dynamic' );
        wp_add_inline_style( 'cl-restaurant-dynamic', $dynamic_css );
    }

    private function optimized_css( $css ) {
        $css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
        $css = str_replace( [ "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ], ' ', $css );

        return $css;
    }

    private function template_style(){
        $style = '';
        if ( is_single() ) {
            if ( !empty(Options::$bgimg ) ) {
                $opacity = Options::$opacity/100;
                $style .= '.single .breadcrumbs-banner { background-image: url(' . Options::$bgimg . ')}';
                $style .= '.single .breadcrumbs-banner:before { background-color: ' . Options::$bgcolor . '}';
                $style .= '.single .breadcrumbs-banner:before { opacity: ' . $opacity . '}';
            }
            else {
                $opacity = Options::$opacity/100;
                $style .= '.single .breadcrumbs-banner:before { background-color: ' . Options::$bgcolor . '}';
                $style .= '.breadcrumbs-banner:before { opacity: ' . $opacity . '}';
            }
        } else {
            if ( !empty( Options::$bgimg ) ) {
                $opacity = Options::$opacity/100;
                $style .= '.breadcrumbs-banner { background-image: url(' . Options::$bgimg . ')}';
                $style .= '.breadcrumbs-banner:before { background-color: ' . Options::$bgcolor . '}';
                $style .= '.breadcrumbs-banner:before { opacity: ' . $opacity . '}';
            }
            else {
                $opacity = Options::$opacity/100;
                $style .= '.breadcrumbs-banner:before { background-color: ' . Options::$bgcolor . '}';
                $style .= '.breadcrumbs-banner:before { opacity: ' . $opacity . '}';
            }
        }

        if ( Options::$padding_top) {
            $style .= '.breadcrumbs-banner { padding-top:'. Options::$padding_top . 'px;}';
        }
        if ( Options::$padding_bottom) {
            $style .= '.breadcrumbs-banner { padding-bottom:'. Options::$padding_bottom . 'px;}';
        }
        
        if ( !empty(Options::$pagebgimg ) ) {
            $style .= 'body { background-image: url(' . Options::$pagebgimg[0] . ') !important}';
        }
        if ( !empty(Options::$pagebgcolor ) ) {
            $style .= 'body { background-color: ' . Options::$pagebgcolor . ' !important}';
        }

        /* = Page bg
        =======================================================*/
        if ( has_post_thumbnail()) {
            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
            $style .= '.full-page-background { background-image: url(' . $large_image_url[0] . ')}';
        }
        
        return $style;
    }   
    
}