<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLRestaurant\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;

trait StoreTrait {

  	protected static $instance = null;

  	public static function instance() {
		if ( null == self::$instance ) {
		self::$instance = new self();
		}
		return self::$instance;
  	}

	public function rtcl_store_filter_hook() {

		// Change Store Category label
		add_filter( 'rtcl_store_myaccount_store_title',
			function ( $store_label ) {
				$store_label = esc_html__( 'Agency', 'clrestaurant' );
				return $store_label;
			} 
		);
	}

	public function store_category_name_change( $label ) {
		$label['labels']['name']      = esc_html_x( 'Agency Categories', 'Agency Category Name', 'clrestaurant' );
		$label['labels']['menu_name'] = esc_html_x( 'Agency Categories', 'Agency Category Name', 'clrestaurant' );
		return $label;
	} 

	public function modify_store_post_breadcrumb_args( $args ) {
		$labels = [
			'name'               => _x( 'Agencies', 'Post Type General Name', 'clrestaurant' ),
			'singular_name'      => _x( 'Agency', 'Post Type Singular Name', 'clrestaurant' ),
			'menu_name'          => esc_html__( 'Agency', 'clrestaurant' ),
			'name_admin_bar'     => esc_html__( 'Agency', 'clrestaurant' ),
			'all_items'          => esc_html__( 'Agencies', 'clrestaurant' ),
			'add_new_item'       => esc_html__( 'Add New Agency', 'clrestaurant' ),
			'add_new'            => esc_html__( 'Add New', 'clrestaurant' ),
			'new_item'           => esc_html__( 'New Agency', 'clrestaurant' ),
			'edit_item'          => esc_html__( 'Edit Agency', 'clrestaurant' ),
			'update_item'        => esc_html__( 'Update Agency', 'clrestaurant' ),
			'view_item'          => esc_html__( 'View Agency', 'clrestaurant' ),
			'search_items'       => esc_html__( 'Search Agency', 'clrestaurant' ),
			'not_found'          => esc_html__( 'No stores found', 'clrestaurant' ),
			'not_found_in_trash' => esc_html__( 'No stores found in Trash', 'clrestaurant' ),
		];

		$args['label']       = esc_html__( 'Agency', 'clrestaurant' );
		$args['description'] = esc_html__( 'Agency Description', 'clrestaurant' );
		$args['labels']      = $labels;

		return $args;
	}

	// Change Store Category label
	public function store_category_label( $label ) {
		return __( "Agency Categories", "clrestaurant" );
	}

	public function agents_grid_columns_class($classes){
		$classes = 'columns-3';
		return $classes;
	}

	public function agency_grid_columns_class($columns){
		$columns = 'columns-2';
		return $columns;
	}

	public function store_top_content_start() {
		?>
        <div class="top-content">
		<?php
	}

	public function loop_item_store_title() {
		global $store;
		?>
        <h3 class="rtcl-store-title">
            <a href="<?php esc_url( $store->the_permalink() ); ?>"><?php esc_html( $store->the_title() ); ?></a>
        </h3>
		<?php
	}

	public static function rt_get_post_view_count( $storeID ) {
		//Get store View Count 
		$rt_store_views_key = 'rt_post_views_count';
		$store_view_count   = get_post_meta( $storeID, $rt_store_views_key, true );

		return $store_view_count;
	}

	public function store_meta() {
		global $store;
		?>
		<?php if ( $store->get_address() || $store->get_website() || $store->get_phone() ): ?>
            <ul class="entry-meta">
				<?php if ( $store->get_address() ): ?>
                    <li><i class="fas fa-map-marker-alt"></i><?php echo esc_html( $store->get_address() ); ?></li>
				<?php endif; ?>

				<?php if ( $stor_view_count = self::rt_get_post_view_count( $store->get_id() ) ) : ?>
					<?php if ( $stor_view_count > 999 ): ?>
                        <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( sprintf( __( 'Total Views: %d', 'clrestaurant' ), $stor_view_count ) )
 ?>">
				
					<?php else : ?>
                        <li>
					<?php endif; ?>
                    <i class="fas fa-eye"></i>
					<?php
					$label = $stor_view_count < 10 ? esc_html__( 'View: ', 'clrestaurant' ) : esc_html__( 'Views: ', 'clrestaurant' );
					printf(
						"<span class='count-label'>%s</span><span class='count-number'>%s</span>",
						esc_html( $label ),
						esc_html( Helper::rt_number_shorten( $stor_view_count, 1 ) )
					);
					?>
                    </li>
				<?php endif; ?>

				<?php if ( $store->is_rating_enable() && $store->get_review_counts() ): ?>
                    <li>
                        <div class="store-rating">
							<?php echo wp_kses_post( Functions::get_rating_html( $store->get_average_rating(), $store->get_review_counts() ) ); ?>
                            <span class="reviews-rating-count">(<?php echo absint( $store->get_review_counts() ); ?>)</span>
                        </div>
                    </li>
				<?php endif; ?>
            </ul>
		<?php endif; ?>
		<?php
	}

	public function store_top_content_end() {
		?>
        </div>
		<?php
	}

	public function store_bottom_content() {
		global $store;
		?>
        <div class="bottom-content">
            <div class="listing-view-btn">
                <a href="<?php esc_url( $store->the_permalink() ); ?>"
                   class="item-btn"><?php esc_html_e( 'View Details', 'clrestaurant' ) ?></a>
            </div>

            <div class="store-social-info">
                <ul>
					<?php if ( $store->get_phone() ): ?>
                        <li>
                            <a class="item-btn" data-toggle="tooltip" data-placement="top"
                               href="tel:<?php echo esc_html( $store->get_phone() ); ?>"
                               title="<?php echo esc_html( $store->get_phone() ); ?>"
                               data-original-title="<?php echo esc_attr( $store->get_email() ); ?>">
                                <i class="fas fa-phone-alt"></i>
                            </a>
                        </li>
					<?php endif; ?>

					<?php if ( $store->get_email() ): ?>
                        <li>
                            <a class="item-btn" data-toggle="tooltip" data-placement="top"
                               title="<?php echo esc_attr( $store->get_email() ); ?>"
                               href="mailto:<?php echo esc_attr( $store->get_email() ); ?>"
                               data-original-title="<?php echo esc_attr( $store->get_email() ); ?>">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </li>
					<?php endif; ?>

					<?php if ( $store->get_website() ): ?>
                        <li>
                            <a class="item-btn" data-toggle="tooltip" data-placement="top"
                               title="<?php echo esc_url( $store->get_website() ); ?>"
                               href="<?php echo esc_url( $store->get_website() ); ?>"
                               data-original-title="<?php echo esc_url( $store->get_website() ); ?>">
                                <i class="fas fa-globe"></i>
                            </a>
                        </li>
					<?php endif; ?>
                </ul>
            </div>

        </div>
		<?php
	}


	// Override Store Ad count
	public function store_ad_count_html($content, $obj, $count){
		$count_string = $count <= 0
			? apply_filters( 'cl_hotel_store_no_ad_text', __( "No Hotel", "clrestaurant" ), $this, $count )
			: sprintf(
				_n( "%s Hotel", "%s Hotels", $count, 'clrestaurant' ),
				number_format_i18n( $count )
			);
		$content      = sprintf( '<span class="ads-count">%s</span>', $count_string );

		return $content;
	}
	
}

