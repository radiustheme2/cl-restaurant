<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
 
namespace RadiusTheme\CLRestaurant\Customizer;

use RadiusTheme\CLRestaurant\Customizer\Settings\General;
use RadiusTheme\CLRestaurant\Customizer\Settings\Contact_Info;
use RadiusTheme\CLRestaurant\Customizer\Settings\Header;
use RadiusTheme\CLRestaurant\Customizer\Settings\Newsletter;
use RadiusTheme\CLRestaurant\Customizer\Settings\Footer;
use RadiusTheme\CLRestaurant\Customizer\Settings\Blog;
use RadiusTheme\CLRestaurant\Customizer\Settings\Post;
use RadiusTheme\CLRestaurant\Customizer\Settings\Colors;
use RadiusTheme\CLRestaurant\Customizer\Typography\Typography;
use RadiusTheme\CLRestaurant\Customizer\Settings\Error;
/* = Layouts = */
use RadiusTheme\CLRestaurant\Customizer\Settings\Page_Layout;
use RadiusTheme\CLRestaurant\Customizer\Settings\Blog_Layout;
use RadiusTheme\CLRestaurant\Customizer\Settings\Blog_Single_Layout;
use RadiusTheme\CLRestaurant\Customizer\Settings\Error_Layout;
use RadiusTheme\CLRestaurant\Customizer\Settings\Search_Layout;
/* = Listing = */
use RadiusTheme\CLRestaurant\Customizer\Settings\Listing_Archive;
use RadiusTheme\CLRestaurant\Customizer\Settings\Listing_Single;
use RadiusTheme\CLRestaurant\Customizer\Settings\Listing_Search;
use RadiusTheme\CLRestaurant\Customizer\Settings\Listing_Archive_Layout;
use RadiusTheme\CLRestaurant\Customizer\Settings\Listing_Single_Layout;



class Init {
	protected static $instance = null;

	/**
	 * Create an inaccessible constructor.
	 */
	private function __construct() {
		$this->includes();
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function includes() {
		new General();
		new Contact_Info();
		new Header();
		new Footer();
		new Newsletter();
		new Blog();
		new Post();
		new Colors();
		new Typography();
		new Error();
		// Layout
		new Page_Layout();
		new Blog_Layout();
		new Blog_Single_Layout();
		new Search_Layout();
		new Error_Layout();
		
		// Listings
		if ( class_exists( 'Rtcl' ) ) {
			new Listing_Archive();
			new Listing_Single();
			new Listing_Search();
			new Listing_Archive_Layout();
			new Listing_Single_Layout();
		}
	}
}