<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.0.0
 */

namespace RadiusTheme\CLRestaurant;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use Rtcl\Models\RtclCFGField;
use Rtcl\Controllers\Hooks\Filters;
use Rtcl\Services\FormBuilder\FBField;
use Rtcl\Services\FormBuilder\FBHelper;
use Rtcl\Controllers\Hooks\TemplateHooks;
use RadiusTheme\CLRestaurant\Traits\StoreTrait;
use Rtcl\Controllers\BusinessHoursController as BHS;
use RtclStore\Controllers\Hooks\TemplateHooks as StoreHooks;

class Listing_Functions {

	use StoreTrait;

	protected static $instance = null;

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'theme_support' ] );
		add_action( 'init', [ $this, 'rtcl_filter_hook' ] );
		add_action( 'init', [ $this, 'rtcl_action_hook' ] );
		add_filter( 'rtcl_get_icon_list', [ $this, 'rtcl_get_icon_list_modify' ] );
		add_filter( 'rtcl_get_icon_class_list', [ $this, 'rtcl_get_icon_list_modify' ] );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function theme_support() {
		add_theme_support( 'rtcl' );
	}

	public function rtcl_action_hook() {

		/* = Listing Archive & Single Hooks
		=====================================================================================================*/
		remove_action( 'rtcl_before_main_content', [ TemplateHooks::class, 'output_main_wrapper_start' ], 8 );
		remove_action( 'rtcl_sidebar', [ TemplateHooks::class, 'output_main_wrapper_end' ], 15 );

		/* = Listing Archive Hooks
		=====================================================================================================*/
		//Remove Action Hooks
		remove_action( 'rtcl_before_main_content', [ TemplateHooks::class, 'breadcrumb' ], 6 );
		remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'loop_item_listing_title' ], 20 );
		// remove_action( 'rtcl_listing_loop_item', [ ProTemplateHooks::class, 'loop_item_listable_fields' ], 40 );
		// remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'loop_item_meta' ], 50 );
		remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'loop_item_excerpt' ], 70 );
		remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'listing_price' ], 80 );
		// remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'loop_item_wrapper_end' ], 100 );

		//Add Action Hooks
		add_action( 'rtcl_listing_loop_item', [ $this, 'cl_restaurant_listing_title' ], 20 );
		add_action( 'rtcl_listing_loop_item', [ $this, 'cl_restaurant_listing_excerpt' ], 30 );
		add_action( 'rtcl_listing_loop_item', [ $this, 'listing_more_details_button' ], 90 );
		add_filter( 'rtcl_get_listing_display_options', [ $this, 'listing_archive_extra_options' ] );
		add_action( "rtcl_widget_filter_form", [ $this, 'widget_filter_custom_fields_item' ], 100 );

		// add_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'loop_item_meta' ], 40 );
		// add_action( 'rtcl_listing_loop_item', [ ProTemplateHooks::class, 'loop_item_listable_fields' ], 50 );

		/**
		 * Notice
		 */
		remove_action( 'rtcl_before_listing_loop', [ TemplateHooks::class, 'output_all_notices' ], 10 );
		add_action( 'rtcl_before_listing_loop', [ $this, 'cl_restaurant_output_all_notices' ], 10 );

		/* = Listing Details Hooks
		=====================================================================================================*/
		//Remove Action Hooks
		// remove_action( 'rtcl_single_listing_content_end', [ ProTemplateHooks::class, 'single_listing_map_content' ] );

		//Add Action Hooks
		add_action( 'rtcl_listing_form_after_save_or_update', [
			$this,
			'listing_form_save'
		], 12, 5 ); // save extra listing form fields
		add_action( 'wp_ajax_delete_food_attachment', [ $this, 'delete_food_attachment' ] );

		// Filter Hook
		add_filter( 'rtcl_single_listing_settings_options', [ $this, 'listing_details_fields_options' ] );


		/**Added Rtcl category color field meta meta */
		add_action( 'rtcl_category_add_form_fields', array($this,'cl_restaurant_colorpicker_field_add_new_category' ));
		add_action( 'rtcl_category_edit_form_fields', array($this,'cl_restaurant_colorpicker_field_edit_category') ); 

		add_action( 'created_rtcl_category', array($this,'cl_restaurant_save_termmeta'));
		add_action( 'edited_rtcl_category', array($this,'cl_restaurant_save_termmeta'));

		// Store
		// Store Archive Hooks
		if ( class_exists( 'RtclStore' ) ) {
			remove_action( 'rtcl_before_store_loop_item', [ StoreHooks::class, 'open_store_link' ], 10 );
			remove_action( 'rtcl_after_store_loop_item', [ StoreHooks::class, 'close_store_link' ], 5 );
			remove_action( 'rtcl_after_store_loop_item', [ StoreHooks::class, 'rtcl_after_store_loop_item' ], 5 );
			remove_action( 'rtcl_store_loop_item', [ StoreHooks::class, 'loop_item_store_title' ], 10 );
			remove_action( 'rtcl_store_loop_item', [ StoreHooks::class, 'store_meta' ], 20 );

			add_action( 'rtcl_store_loop_item', [ $this, 'store_top_content_start' ], 5 );
			add_action( 'rtcl_store_loop_item', [ $this, 'loop_item_store_title' ], 10 );
			add_action( 'rtcl_store_loop_item', [ $this, 'store_meta' ], 20 );
			add_action( 'rtcl_store_loop_item', [ $this, 'store_top_content_end' ], 25 );
			add_action( 'rtcl_store_loop_item', [ $this, 'store_bottom_content' ], 40 );
		}

	}

	public function rtcl_filter_hook() {
		// Change Grid Column for listing
		add_filter( 'rtcl_listings_grid_columns_class', function () {
			$per_row   = Functions::get_listings_per_row();
			$col_class = sprintf(
				'columns-%d tab-columns-%d mobile-columns-%d',
				intval( $per_row['desktop'] ?? 3 ),
				intval( $per_row['tablet'] ?? 2 ),
				intval( $per_row['mobile'] ?? 1 )
			);
			if ( is_page_template( 'templates/listing-map.php' ) ) {
				$columns = 'columns-' . Options::$options['listing_grid_cols'];
			} else {
				$columns = $col_class;
			}
			return $columns;
		} );

		// Change add to favorite text
		add_filter( 'rtcl_text_add_to_favourite', function ( $text ) {
			$text = esc_html__( 'Favourite', 'clrestaurant' );

			return $text;
		} );

		// Pagination
		add_filter( 'rtcl_pagination_args', function ( $args ) {
			$args['prev_text'] = '<i class="clr-icon-rt18-arrow-right" aria-hidden="true"></i>';
			$args['next_text'] = '<i class="clr-icon-rt18-arrow-left" aria-hidden="true"></i>';

			return $args;
		} );

		// Override Related Listing Item Number
		add_filter( 'rtcl_related_slider_options', function ( $options ) {
			$rpc                     = Options::$options['related_post_slider_cols'];
			$options['breakpoints']  = [
				0    => [
					"slidesPerView" => 1
				],
				576  => [
					"slidesPerView" => 2
				],
				992  => [
					"slidesPerView" => 3
				],
				1400 => [
					"slidesPerView" => $rpc
				]
			];
			$options['spaceBetween'] = 24;

			return $options;
		} );

		// Listing/Directory Settings
		add_filter( 'rtcl_single_listing_settings_options', [ $this, 'listing_custom_listing_options' ] );

		add_filter( 'rtcl_sv_verified_icon_class', function($user_id){
			return 'clr-icon-rt18-subtract-01';
		});
	}

	/**
	 * @param $items
	 *
	 * @return array
	 */
	public static function group_menu_items( $items ) {
		$grouped       = [];
		$current_group = - 1;

		foreach ( $items as $item ) {
			// New group start
			if ( isset( $item['enable_group_title'] ) && $item['enable_group_title'] === 'yes' ) {
				$current_group ++;
				$grouped[ $current_group ] = [
					'group_title' => $item['menu_name'],
					'items'       => []
				];
			} else {
				// Add menu item to current group
				if ( $current_group >= 0 ) {
					$grouped[ $current_group ]['items'][] = $item;
				}
			}
		}

		return $grouped;
	}

	public static function cl_restaurant_output_all_notices() {
		if (Functions::print_notices()) {
			echo '<div class="rtcl-notices-wrapper">';
			Functions::print_notices();
			echo '</div>';
		}
	}

	public static function cl_restaurant_listing_title() {
		global $listing;
		$archive_settings = Functions::get_option( 'rtcl_archive_listing_settings' );
		$show_rating = ! empty( $archive_settings['display_options'] ) && in_array( 'rating', $archive_settings['display_options'] );

        if ($show_rating) {
	        Helper::get_listing_rating( $listing );
        }
		echo '<h3 class="' . esc_attr( apply_filters( 'rtcl_listing_loop_title_classes', 'listing-title rtcl-listing-title' ) ) . '"><a href="' . esc_url( $listing->get_the_permalink() ) . '">' . esc_html( $listing->get_the_title() ) . '</a></h3>';
	}

	public function listing_custom_listing_options( $options ) {

		$options['cl_restaurant_listing_section']             = [
			'title' => esc_html__( 'Listing Settings', 'clrestaurant' ),
			'type'  => 'section',
		];
		$options['listing_food_list_section_label'] = [
			'title'   => esc_html__( 'Food List Section Label', 'clrestaurant' ),
			'type'    => 'text',
			'default' => 'Food Menu List',
		];

		return $options;
	}

	public function listing_archive_extra_options( $options ) {
		$options['discount'] = esc_html__( 'Discount', 'clrestaurant' );
		$options['phone'] = esc_html__( 'Phone', 'clrestaurant' );
		$options['rating'] = esc_html__( 'Rating', 'clrestaurant' );
		$options['readmore'] = esc_html__( 'Read More Button', 'clrestaurant' );

		return $options;
	}

	public function listing_details_fields_options( $options ) {
		$options['display_options_detail']['options']['video_url']    = esc_html__( 'Video', 'clrestaurant' );
		// $options['display_options_detail']['options']['phone_no'] = esc_html__( 'Phone Number', 'clrestaurant' );
		$options['display_options_detail']['options']['social_share'] = esc_html__( 'Social Share', 'clrestaurant' );
		
		return $options;
	}

	public static function listing_single_style() {
		$opt_layout = ! empty( Options::$options['single_listing_style'] ) ? Options::$options['single_listing_style'] : '1';

		return $opt_layout;
	}

	public static function listing_single_banner_option() {
		$opt_layout = ! empty( Options::$options['single_listing_header_banner'] ) ? Options::$options['single_listing_header_banner'] : '1';

		return $opt_layout;
	}

	public static function listing_selected_category( $category_id ){
		$to_get_slug = get_term(  $category_id, 'rtcl_category' );
		$parent_id = $to_get_slug->parent;

		if (!empty($parent_id)) {
			$to_get_slug = get_term( $parent_id, 'rtcl_category' );
		} else {
			$to_get_slug = get_term( $category_id, 'rtcl_category' );
		}
		$cat_slug = $to_get_slug->slug;
		return $cat_slug;
	}

	public static function get_favourites_link( $post_id ) {
		$has_favourites = get_option( 'rtcl_general_settings' );
		if ( isset( $has_favourites['has_favourites'] ) && 'yes' !== $has_favourites['has_favourites'] ) {
			return;
		}
		if ( is_user_logged_in() ) {
			if ( $post_id == 0 ) {
				global $post;
				$post_id = $post->ID;
			}

			$favourites = (array) get_user_meta( get_current_user_id(), 'rtcl_favourites', true );

			if ( in_array( $post_id, $favourites ) ) {
				return '<a href="javascript:void(0)" class="rtcl-favourites rtcl-btn rtcl-active" data-id="' . $post_id . '"><span class="rtcl-icon rtcl-icon-heart"></span><span class="favourite-label">'
					. \Rtcl\Helpers\Text::remove_from_favourite() . '</span></a>';
			} else {
				return '<a href="javascript:void(0)" class="rtcl-favourites rtcl-btn" data-id="' . $post_id . '"><i class="rtcl-icon rtcl-icon-heart-empty"></i><span class="favourite-label">'
					. \Rtcl\Helpers\Text::add_to_favourite() . '</span></a>';
			}
		} else {
			return '<a href="#" class="rtcl-btn"><i class="rtcl-icon rtcl-icon-heart-empty"></i><span class="favourite-label">' . \Rtcl\Helpers\Text::add_to_favourite()
				. '</span></a>';
		}
	}

	public static function get_share_link() {
		global $listing;
		?>
        <!-- Modal -->
        <div class="modal fade social-share" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e( 'Share This Link Via', 'clrestaurant' ); ?></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="clr-icon-rt18-cross"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="share-icon">
							<?php $listing->the_social_share(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	public static function listing_details_banner() {
		global $listing;
		$imgUrl = get_the_post_thumbnail_url( $listing->get_id(), 'full' );
		if ( empty( $imgUrl ) ) {
			$images = $listing->get_images();
			if ( ! empty( $images ) ) {
				$total_gallery_image = count( $images );
				$total_gallery_item  = $total_gallery_image;
				if ( $total_gallery_item ) {
					foreach ( $images as $index => $image ) {
						$img_url = wp_get_attachment_image_url( $image->ID, 'full' );
					}
				}
			} else {
				$img_url = '';
			}
		} elseif ( ! empty( $imgUrl ) ) {
			$img_url = $imgUrl;
		} else {
			$img_url = '';
		}

		//Inner Page Banner Area Start Here
		echo '<section class="inner-page-banner bg-common inner-page-top-margin" data-bg-image="' . esc_url( $img_url ) . '"></section>';
		
	}

	public static function listing_details_gallery() {
		global $listing;

		$detailOption = Functions::get_option_item( 'rtcl_single_listing_settings', 'display_options_detail', [] );

		$video_urls = [];
		if ( ! Functions::is_video_urls_disabled() ) {
			$video_urls = get_post_meta( $listing->get_id(), '_rtcl_video_urls', true );
			$video_urls = ! empty( $video_urls ) && is_array( $video_urls ) ? $video_urls : [];
		}
		// Image Gallery
		$images              = $listing->get_images();
		$total_gallery_image = count( $images );

		$number = $total_gallery_image - 5;

		if ( $total_gallery_image ) {

		?>

            <div class="photo-swip-gallery-wrap">
				<?php
					if ( !in_array( 'video_url', $detailOption ) ){
						if ( ! empty( $video_urls ) ) { ?>
						<div class="listing-gallery-item">
							<div class="video-info rtcl-slider-video-item ratio-16x9">
								<iframe class="rtcl-lightbox-iframe"
										src="<?php echo esc_url( Functions::get_sanitized_embed_url( $video_urls[0] ) ); ?>"
										style="height: 404px"
										frameborder="0" webkitAllowFullScreen
										mozallowfullscreen allowFullScreen></iframe>
							</div>
						</div>
					<?php }
					}
					$counter = 1;
					foreach ( $images as $image ) {
						++$counter;

						if ($total_gallery_image < 2) {
							$img_size = 'full';
						} else {
							$img_size = 'rtcl-thumbnail';
						}
												
						?>
						<div class="listing-gallery-item photoswip-item image-size-<?php echo esc_attr($img_size); ?>">
							<?php $img_url = wp_get_attachment_image_url( $image->ID, 'full' ); ?>
							<a class="listing-popup-btn" href="<?php echo esc_url( $img_url ); ?>" data-width="1170" data-height="550">
								<?php 
									if ( $counter <= 6 ) {
										echo wp_get_attachment_image( $image->ID, $img_size ); 
									}
									if($counter > 5 ){
										echo '<span>+'.esc_html($number).'</span>';
									}
								?>
							</a>
						</div>
					<?php
					}
				?>
            </div>
		<?php }
	}

	public static function listing_details_slider() { 
		global $listing;
		?>
            <div class="listingDetails-gallery-slider">
                <div class="productDetailsGallery">
                    <?php $listing->the_gallery(); ?>
                </div>
            </div>
	<?php }

	public function get_listing_attachment_id( $post_id, $file ) {
		if ( $file['error'] !== UPLOAD_ERR_OK ) {
			__return_false();
		}

		if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
			get_template_part( ABSPATH . "/wp-admin" . '/includes/image.php' );
			get_template_part( ABSPATH . "/wp-admin" . '/includes/file.php' );
			get_template_part( ABSPATH . "/wp-admin" . '/includes/media.php' );
		}

		Filters::beforeUpload();
		// you can use WP's wp_handle_upload() function:
		$status = wp_handle_upload(
			$file,
			[
				'test_form' => false,
			]
		);
		Filters::afterUpload();

		if ( $status && ! isset( $status['error'] ) ) {
			// $filename should be the path to a file in the upload directory.
			$filename = $status['file'];

			// Check the type of tile. We'll use this as the 'post_mime_type'.
			$filetype = wp_check_filetype( basename( $filename ), null );

			// Get the path to the upload directory.
			$wp_upload_dir = wp_upload_dir();

			// Prepare an array of post data for the attachment.
			$attachment = [
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			];
			// Insert the attachment.
			$attach_id = wp_insert_attachment( $attachment, $filename );
		}

		return isset( $attach_id ) ? $attach_id : 0;
	}

	public function listing_form_save( $post_id, $type, $cat_id, $new_listing_status, $data ) {

		// Listing Discount
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified by RTCL plugin before this hook fires
		if ( isset( $_POST['listing_discount'] ) ) {
			$listing_discount = sanitize_text_field( wp_unslash( $_POST['listing_discount'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
			if ( $listing_discount ) {
				update_post_meta( $post_id->get_id(), 'listing_discount', $listing_discount );
			}
		}

		// Listing Logo
		$files = $data['files'];

		// Food Menu
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce verified by RTCL plugin before this hook fires
		if ( isset( $_POST['listing_food_list'] ) ) {
			$raw_data = wp_unslash( $_POST['listing_food_list'] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- array is sanitized field-by-field below

			$sanitized_data = [];
			$count          = 0;

			$food_images = [];
			if ( ! empty( $files['listing_food_images'] ) ) {
				$attachmentData = $files['listing_food_images'];
				foreach ( $attachmentData as $file_key => $images ) {
					foreach ( $images as $key => $values ) {
						foreach ( $values as $food_list ) {
							foreach ( $food_list as $index => $name ) {
								$food_images[ $key ][ $index ][ $file_key ] = $name;
							}
						}
					}
				}
			}

			foreach ( $raw_data as $group_no => $foods_group ) {
				$foods_menu = [];

				foreach ( $foods_group as $key => $value ) {
					if ( $key === 'gtitle' ) {
						$foods_menu[ $key ] = sanitize_text_field( $foods_group['gtitle'] );
					}

					if ( $key === 'food_list' ) {
						foreach ( $foods_group['food_list'] as $index => $data ) {

							foreach ( $data as $data_key => $value ) {

								$attach_id = 0;

								if ( $data_key === 'title' || $data_key === 'foodprice' ) {
									$foods_menu[ $key ][ $index ][ $data_key ] = sanitize_text_field( $value );
								} elseif ( $data_key === 'description' ) {
									$foods_menu[ $key ][ $index ][ $data_key ] = sanitize_textarea_field( $value );
								} elseif( $data_key === 'attachment_id' ) {
									$attach_id = $value;
								}

								if ( ! empty( $food_images[ $group_no ][ $index ] ) && empty($attach_id) ) {
									$attach_id = $this->get_listing_attachment_id( $post_id->get_id(), $food_images[ $group_no ][ $index ] );
								}

								if ( ! empty( $attach_id ) ) {
									$foods_menu[ $key ][ $index ]['attachment_id'] = $attach_id;
								}
							}
						}
					}
				}

				if ( ! empty( $foods_menu ) ) {
					$sanitized_data[] = $foods_menu;
				}
			}

			if ( ! empty( $sanitized_data ) ) {
				update_post_meta( $post_id->get_id(), 'listing_food_list', $sanitized_data );
			}
		}

	}
	public function delete_food_attachment() {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- AJAX handler; nonce verified by RTCL
		$attachment_id = isset( $_POST['attachment_id'] ) ? absint( wp_unslash( $_POST['attachment_id'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$post_id       = isset( $_POST['post_id'] ) ? absint( wp_unslash( $_POST['post_id'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( $attachment_id && $post_id ) {
			delete_post_meta( $post_id, 'listing_food_list' );
			wp_delete_attachment( $attachment_id );
			echo 'success';
		} else {
			echo 'error';
		}
		wp_die();
	}

	public function cl_restaurant_listing_excerpt() {
		global $listing;
		$excerpt_length = Options::$options['cl_restaurant_listing_excerpt'];

		if ( $listing->can_show_excerpt() ) {
			?>
            <p><?php echo wp_kses_post( Helper::cl_restaurant_excerpt( $excerpt_length ) ); ?></p>
		<?php }
	}

	public static function listingHourStatus( $listing_id ) {
	}

	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- search form GET params, read-only, no nonce required
	public static function get_advanced_search_field_html( $field_id ) {
		$field      = new RtclCFGField( $field_id );
		$field_html = null;

		if ( $field_id && $field ) {
			$id = "rtcl_{$field->getType()}_{$field->getFieldId()}";

			switch ( $field->getType() ) {
				case 'text':
					$field_html = sprintf(
						'<input type="text" class="rtcl-text form-control rtcl-cf-field" id="%s" name="filters[_field_%d]" placeholder="%s" value="" />',
						$id,
						absint( $field->getFieldId() ),
						esc_attr( $field->getPlaceholder() )
					);
					break;
				case 'textarea':
					$field_html = sprintf(
						'<textarea class="rtcl-textarea form-control rtcl-cf-field" id="%s" name="filters[_field_%d]" rows="%d" placeholder="%s"></textarea>',
						$id,
						absint( $field->getFieldId() ),
						absint( $field->getRows() ),
						esc_attr( $field->getPlaceholder() )
					);
					break;
				case 'select':
					$options      = $field->getOptions();
					$choices      = ! empty( $options['choices'] ) && is_array( $options['choices'] ) ? $options['choices'] : [];
					$options_html = '<option value="">' . esc_html( $field->getLabel() ) . '</option>';

					if ( ! empty( $choices ) ) {
						foreach ( $choices as $key => $choice ) {
							$_attr = '';
							if ( isset( $_GET['filters'][ '_field_' . $field->getFieldId() ] ) && $_GET['filters'][ '_field_' . $field->getFieldId() ] == $choice ) {
								$_attr .= ' selected';
							}
							$options_html .= sprintf( '<option value="%s"%s>%s</option>', $key, $_attr, $choice );
						}
					}

					$field_html
						= sprintf(
						'<div class="search-item search-select"><select name="filters[_field_%d]" id="%s" data-placeholder="%s" class="select2">%s</select></div>',
						absint( $field->getFieldId() ),
						$id,
						$field->getLabel(),
						$options_html
					);
					break;
				case 'checkbox':
					$options       = $field->getOptions();
					$value         = isset( $_GET['filters'][ '_field_' . $field->getFieldId() ] ) ? array_map( 'sanitize_text_field', wp_unslash( (array) $_GET['filters'][ '_field_' . $field->getFieldId() ] ) ) : []; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
					$choices       = ! empty( $options['choices'] ) && is_array( $options['choices'] ) ? $options['choices'] : [];
					$check_options = null;
					if ( ! empty( $choices ) ) {
						foreach ( $choices as $key => $choice ) {
							$_attr = '';
							if ( in_array( $key, $value ) ) {
								$_attr .= ' checked="checked"';
							}
							$check_options .= sprintf(
								'<div class="form-check"><input class="form-check-input" id="%s" type="checkbox" name="filters[_field_%d][]" value="%s"%s><label class="form-check-label" for="%s">%s</label></div>',
								$id . $key,
								absint( $field->getFieldId() ),
								$key,
								$_attr,
								$id . $key,
								$choice
							);
						}
					}
					$field_html = sprintf( '<div class="search-item checkbox-wrapper">%s</div>', $check_options );
					break;
				case 'radio':
					$options       = $field->getOptions();
					$choices       = ! empty( $options['choices'] ) && is_array( $options['choices'] ) ? $options['choices'] : [];
					$check_options = null;
					if ( ! empty( $choices ) ) {
						foreach ( $choices as $key => $choice ) {
							$check_options .= sprintf(
								'<div class="form-check"><input class="form-check-input" id="%s" type="radio" name="filters[_field_%d]" value="%s"><label class="form-check-label" for="%s">%s</label></div>',
								$id . $key,
								absint( $field->getFieldId() ),
								$key,
								$id . $key,
								$choice
							);
						}
					}
					$field_html = sprintf( '<div class="search-item search-type"><div class="search-check-box">%s</div></div>', $check_options );
					break;
				case 'number':
					$hidden_field = sprintf(
						'<input type="hidden" class="min-volumn" name="filters[_field_%d][min]" value="%s">',
						absint( $field->getFieldId() ),
						isset( $_GET['filters'][ '_field_' . $field->getFieldId() ]['min'] ) ? absint( $_GET['filters'][ '_field_' . $field->getFieldId() ]['min'] ) : ''
					);
					$hidden_field .= sprintf(
						'<input type="hidden" class="max-volumn" name="filters[_field_%d][max]" value="%s">',
						absint( $field->getFieldId() ),
						isset( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) ? absint( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) : ''
					);

					$field_html = sprintf(
						'<div class="search-item">
							<div class="price-range">
								<label>%s</label>
								<input type="number" class="ion-rangeslider" id="%s" data-step="%s" %s %s data-min="%d" data-max="%s" />
								%s
							</div>
						</div>',
						esc_attr( $field->getLabel() ),
						$id,
						$field->getStepSize() ? esc_attr( $field->getStepSize() ) : 'any',
						isset( $_GET['filters'][ '_field_' . $field->getFieldId() ]['min'] ) ? sprintf(
							'data-from="%s"',
							absint( $_GET['filters'][ '_field_' . $field->getFieldId() ]['min'] )
						) : '',
						isset( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) && ! empty( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) ? sprintf(
							'data-to="%s"',
							absint( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] )
						) : '',
						$field->getMin() !== '' ? absint( $field->getMin() ) : '',
						! empty( $field->getMax() ) ? absint( $field->getMax() ) : absint( $field->getMin() ) + 100,
						$hidden_field
					);
					break;
				case 'url':
					$field_html = sprintf(
						'<input type="url" class="rtcl-url form-control rtcl-cf-field" id="%s" name="filters[_field_%d]" placeholder="%s" value="" />',
						$id,
						absint( $field->getFieldId() ),
						esc_attr( $field->getPlaceholder() )
					);
					break;
			}
		}

		return $field_html;
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended

	public function widget_filter_custom_fields_item() {
		$group_id = '';
		$group_id = isset( Options::$options['custom_fields_search_items'] ) ? Options::$options['custom_fields_search_items'] : 0;
		if ( is_array( $group_id ) && count( $group_id ) < 2 ) {
			$group_id = end( $group_id );
		}
		if ( ! empty( $group_id ) ) {
		?>
		<div class="rtcl-cfg-filter ui-accordion-item is-open">
			<?php
				$field_ids = Functions::get_cf_ids_by_cfg_id( $group_id );
				if ( ! empty( $field_ids ) ) {
					?>
						<?php
							$args      = [
								'is_searchable'     => true,
								'exclude_group_ids' => $group_id,
							];
							$fields_id = Functions::get_cf_ids( $args );
							$html      = '';
							foreach ( $field_ids as $field ) {
								$field_label = new RtclCFGField( $field );
								if ( $field_label->getLabel() ) {
									$html .= '<a class="ui-accordion-title"><span>' . $field_label->getLabel() . '</span><span class="ui-accordion-icon rtcl-icon rtcl-icon-anchor"></span></a>';
								}
								$html .= '<div class="ui-accordion-content" style="display: block;">' . self::get_advanced_search_field_html( $field ) . '</div>';
							}
							Functions::print_html( $html, true );
						?>
			<?php } ?>
		</div>
	<?php }
	}

	public function listing_more_details_button() {
		$mod_settings = Functions::get_option( 'rtcl_archive_listing_settings' );
		$show_readmore = ! empty( $mod_settings['display_options'] ) && in_array( 'readmore', $mod_settings['display_options'] );

		if ( !empty( $show_readmore )) {
		?>
		<div class="btn-wrap">
            <a href="<?php the_permalink(); ?>" class="item-btn">
                <span class="btn__text"><?php esc_html_e( 'Read More', 'clrestaurant' ) ?></span>
            </a>
        </div>
		<?php }
	}

	public function cl_restaurant_colorpicker_field_add_new_category( $taxonomy ) { ?>
		<div class="form-field term-colorpicker-wrap">
			<label for="term-colorpicker"><?php esc_html_e( 'Category Color', 'clrestaurant' ); ?></label>
			<input name="rt_category_color" value="#f22929" class="colorpicker" id="term-colorpicker" />
			<p><?php esc_html_e( 'This is category background color.', 'clrestaurant' ); ?></p>
		</div>
		<?php
	}

	public function cl_restaurant_colorpicker_field_edit_category($term){
		$color = get_term_meta( $term->term_id, 'rt_category_color', true );
		$color = ( ! empty( $color ) ) ? "#{$color}" : '#f22929';
		?>
		<tr class="form-field term-colorpicker-wrap">
			<th scope="row"><label for="term-colorpicker"><?php esc_html_e( 'Category Color', 'clrestaurant' ); ?></label></th>
			<td>
				<input name="rt_category_color" value="<?php echo esc_attr( $color ); ?>" class="colorpicker" id="term-colorpicker" />
				<p class="description"><?php esc_html_e( 'This is category background color.', 'clrestaurant' ); ?></p>
			</td>
		</tr>
		<?php
	}

	public function cl_restaurant_save_termmeta( $term_id ) {
		// phpcs:disable WordPress.Security.NonceVerification.Missing -- term edit nonce is verified by WordPress core before this hook
		// Save term color if possible
		if( isset( $_POST['rt_category_color'] ) && ! empty( $_POST['rt_category_color'] ) ) {
			update_term_meta( $term_id, 'rt_category_color', sanitize_hex_color_no_hash( wp_unslash( $_POST['rt_category_color'] ) ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
		} else {
			delete_term_meta( $term_id, 'rt_category_color' );
		}

		if( isset( $_POST['rt_category_image'] ) && ! empty( $_POST['rt_category_image'] ) ) {
			update_term_meta( $term_id, 'rt_category_image', absint( wp_unslash( $_POST['rt_category_image'] ) ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
		} else {
			delete_term_meta( $term_id, 'rt_category_image' );
		}
		// phpcs:enable WordPress.Security.NonceVerification.Missing
	}

	public static function form_builder_custom_group_field_check(  ) {
        global $listing;
		$form = $listing->getForm();
		if($form) {
			$fields = $form->getFieldAsGroup( FBField::CUSTOM );
			$fields_available = false;
			if ( count( $fields ) ) {
				foreach ( $fields as $fieldName => $field ) {
					$field = new FBField( $field );
					$value
					       = $field->getFormattedCustomFieldValue( $listing->get_id() );
					if ( ! empty( $value ) ) {
						return true;
					}
				}

				return $fields_available;
			}
		}
    }

	/**
	 * @param $listing
	 * @param $icon
	 *
	 * @return void
	 */
	public static function business_open_close_status( $listing, $icon ) {
		$business_hours = $onoff = '';
		$form           = null;
		if ( FBHelper::isEnabled() ) {
			$_form = $listing->getForm();
			if ( $_form && $_form->getFieldByElement( 'business_hours' ) ) {
				$form = $_form;
			}
		}

		if ( FBHelper::isEnabled() && $form ) {
			$business_hours = BHS::get_business_hours( $listing->get_id() );
			if ( ! empty( $business_hours['bhs'] ) ) {
				$business_hours = $business_hours['bhs'];
			}
		} else {
			if ( Functions::is_enable_business_hours() ) {
				$business_hours = BHS::get_old_business_hours( $listing->get_id() );
			}
		}

		$status = BHS::openStatus( $business_hours );

		if ( Functions::is_enable_business_hours() || ( FBHelper::isEnabled() && $business_hours ) ) {
			$show_icon = $icon;
			if ( $status ) {
				$onoff = '<span class="item-status status-open">';
				if ( $show_icon ) {
					$onoff .= '<i class="fas fa-check-circle"></i>';
				}
				$onoff .= esc_html__( 'Open Now', 'clrestaurant' ) . '</span>';
			} else {
				$onoff = '<span class="item-status status-close">';
				if ( $show_icon ) {
					$onoff .= '<i class="fas fa-times-circle"></i>';
				}
				$onoff .= esc_html__( 'Closed Now', 'clrestaurant' ) . '</span>';
			}
		}

		echo wp_kses_post( $onoff );
	}

	public function rtcl_get_icon_list_modify( $icons_lists ) {
		$new_icons = [
			" clr-icon-check-icon",
			" clr-icon-email-icon",
			" clr-icon-rt18-arrow2-left",
			" clr-icon-button-arrow-icon-right",
			" clr-icon-home-icon",
			" clr-icon-icon-cafe",
			" clr-icon-arrow-right-circle",
			" clr-icon-r-cat7",
			" clr-icon-arrow-right3",
			" clr-icon-cafe-small-icon",
			" clr-icon-phone-icon",
			" clr-icon-museum-small-icon",
			" clr-icon-rt18-arrow3-left",
			" clr-icon-icon",
			" clr-icon-star-icon",
			" clr-icon-rt18-arrow-down",
			" clr-icon-d-book",
			" clr-icon-share-icon",
			" clr-icon-check",
			" clr-icon-d-brain",
			" clr-icon-rt18-arrow-left",
			" clr-icon-rt18-arrow-right",
			" clr-icon-rt18-arrow-right-cirkle",
			" clr-icon-vector-22",
			" clr-icon-element8",
			" clr-icon-search-normal",
			" clr-icon-gym",
			" clr-icon-shop",
			" clr-icon-d-calendar",
			" clr-icon-01-map-1",
			" clr-icon-02-star-2",
			" clr-icon-03-calendar-check",
			" clr-icon-rt18-berger",
			" clr-icon-d-eye",
			" clr-icon-vector-25",
			" clr-icon-vector-3",
			" clr-icon-vector-4",
			" clr-icon-vector-5",
			" clr-icon-vector-17",
			" clr-icon-vector-18",
			" clr-icon-vector-20",
			" clr-icon-vector-21",
			" clr-icon-r-cat8",
			" clr-icon-r-cat9",
			" clr-icon-r-cat10",
			" clr-icon-icon-restaurant",
			" clr-icon-r-cat12",
			" clr-icon-d-heart",
			" clr-icon-d-heart1",
			" clr-icon-d-teeth",
			" clr-icon-d-user1",
			" clr-icon-d-user2",
			" clr-icon-d-user3",
			" clr-icon-d-clock",
			" clr-icon-arrow-left",
			" clr-icon-arrow-right2",
			" clr-icon-berger",
			" clr-icon-berger2",
			" clr-icon-calendar1-1",
			" clr-icon-rt18-checck",
			" clr-icon-rt18-comments",
			" clr-icon-rt18-cross",
			" clr-icon-rt18-dotdot",
			" clr-icon-rt18-drinks",
			" clr-icon-rt18-faluda",
			" clr-icon-rt18-gamecard",
			" clr-icon-rt18-grid",
			" clr-icon-rt18-heart",
			" clr-icon-rt18-heart-stroke",
			" clr-icon-rt18-icecream",
			" clr-icon-rt18-list",
			" clr-icon-rt18-lock",
			" clr-icon-rt18-marker",
			" clr-icon-rt18-paragraph",
			" clr-icon-rt18-phone",
			" clr-icon-rt18-phone2",
			" clr-icon-rt18-plus",
			" clr-icon-rt18-quote",
			" clr-icon-rt18-search",
			" clr-icon-rt18-select",
			" clr-icon-rt18-share",
			" clr-icon-rt18-smoke",
			" clr-icon-rt18-tea",
			" clr-icon-rt18-updown",
			" clr-icon-rt18-user",
			" clr-icon-rt18-user2",
			" clr-icon-rt18-users",
			" clr-icon-rt18-vector",
			" clr-icon-rt18-vector2",
			" clr-icon-rt18-vector3",
			" clr-icon-rt18-walet",
			" clr-icon-rt18-eye-01",
			" clr-icon-rt18-keyboard-01",
			" clr-icon-rt18-papper2-01",
			" clr-icon-rt18-papper-01",
			" clr-icon-rt18-star-01",
			" clr-icon-rt18-subtract-01"
		];
		return array_merge( $icons_lists, $new_icons );
	}

}