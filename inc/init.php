<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLRestaurant\Customizer\Controls\Conditions;
use RadiusTheme\CLRestaurant\Constants;
use RadiusTheme\CLRestaurant\TGM_Config;
use RadiusTheme\CLRestaurant\General;
use RadiusTheme\CLRestaurant\Scripts;
use RadiusTheme\CLRestaurant\Layouts;
use RadiusTheme\CLRestaurant\Options;
use RadiusTheme\CLRestaurant\Listing_Functions;
use RadiusTheme\CLRestaurant\Shortcode;
use RadiusTheme\CLRestaurant\Customizer\Init;

if ( file_exists( dirname( __FILE__ ) . '/../vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/../vendor/autoload.php';
endif;

final class Includes {
	private $suffix;
	private $version;
	private static $singleton = false;

	/**
	 * Create an inaccessible constructor.
	 */
	private function __construct() {
		$this->suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		// $this->version = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : Constants::theme_version;

		$this->init();
	}

	/**
	 * Fetch an instance of the class.
	 */
	final public static function getInstance() {
		if ( self::$singleton === false ) {
			self::$singleton = new self();
		}

		return self::$singleton;
	}

	/**
	 * Classified Listing Constructor.
	 */
	protected function init() {
		new Constants();
		new TGM_Config();
		Options::instance();
		General::instance();
		Scripts::instance();
		Layouts::instance();
		if ( class_exists( 'WP_Customize_Control' ) ) {
			Init::instance();
		}
		if (class_exists('Rtcl')) {
			Listing_Functions::instance();
			Shortcode::instance();
		}
	}
}

/**
 * @return bool|Includes
 */
function Includes() {
	return Includes::getInstance();
}

Includes();
