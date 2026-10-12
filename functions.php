<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 2.0.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_editor_style( 'style-editor.css' );

if ( ! isset( $content_width ) ) {
	$content_width = 1240;
}

class CLR_Restaurant_Main {
	public $theme = 'cl-restaurant';
	public $action = 'cl_restaurant_theme_init';

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'load_textdomain' ) );
		add_action( 'admin_notices', array( $this, 'plugin_update_notices' ) );
		$this->includes();
	}

	public function load_textdomain() {
		load_theme_textdomain( 'clrestaurant', get_template_directory() . '/languages' );
	}

	public function includes() {
		do_action( $this->action );

		if ( ! defined( 'RT_DEBUG' ) || ! RT_DEBUG ) {
			require_once get_template_directory() . '/lib/updater/theme-updater.php';
			require_once get_template_directory() . '/lib/updater/lc-utility.php';
			require_once get_template_directory() . '/lib/updater/lc-helper.php';
		}
		require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

		require_once get_template_directory() . '/inc/init.php';
		require_once get_template_directory() . '/inc/Customizer/Controls/Conditions.php';
		require_once get_template_directory() . '/inc/Customizer/sanitization.php';

		if ( class_exists( 'Rtcl' ) ) {
			require_once get_template_directory() . '/inc/data-migration.php';
		}
	}

	public function plugin_update_notices() {
		$plugins = array();

		if ( defined( 'CL_RESTAURANT_CORE' ) ) {
			if ( version_compare( CL_RESTAURANT_CORE, '2.2.0', '<' ) ) {
				$plugins[] = 'CL Restaurant Core';
			}
		}

		foreach ( $plugins as $plugin ) {
			$notice = '<div class="error"><p>' . sprintf( __( "Please update plugin <b><i>%s</b></i> to the latest version otherwise some functionalities will not work properly. You can update it from <a href='%s'>here</a>", 'clrestaurant' ), $plugin, menu_page_url( 'cl-restaurant-install-plugins', false ) ) . '</p></div>';
			echo wp_kses( $notice, 'alltext_allow' );
		}
	}
}

new CLR_Restaurant_Main;