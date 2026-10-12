<?php
/**
 * Login Form Information
 *
 * @author        RadiusTheme
 * @package       classified-listing/templates
 * @version       1.0.0
 *
 * @var Listing $listing
 * @var int     $title_limit
 * @var array   $hidden_fields
 * @var string  $selected_type
 * @var string  $title
 * @var string  $listing_pricing
 * @var string  $price_type
 * @var string  $price
 * @var string  $post_content
 * @var string  $editor
 * @var int     $category_id
 * @var int     $post_id
 * @var int     $description_limit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use Rtcl\Resources\Options;

?>
<div class="rtcl-post-details rtcl-post-section">
  <div class="rtcl-post-section-title">
    <h3><?php esc_html_e("Listing Title", "clrestaurant"); ?></h3>
  </div>
  <div class="form-group">
    <label for="rtcl-title"><?php esc_html_e('Title', 'clrestaurant'); ?><span class="require-star">*</span></label>
    <input type="text" <?php echo esc_attr( $title_limit ? 'data-max-length="3" maxlength="' . $title_limit . '"' : '' ); ?> class="form-control" value="<?php echo esc_attr($title); ?>" id="rtcl-title" name="title" required/>
    <?php
      if ($title_limit) {
        echo wp_kses_post(
         sprintf('<div class="rtcl-hints">%s</div>',
            apply_filters('rtcl_listing_title_character_limit_hints', sprintf(__("Character limit <span class='target-limit'>%s</span>", 'clrestaurant'), $title_limit)
         )
        ));
      }
    ?>
  </div>

  <?php if (!in_array('price', $hidden_fields)):
    $listingPricingTypes = Options::get_listing_pricing_types(); ?>
    <div id="rtcl-pricing-wrap">
      <?php if (!Functions::is_pricing_disabled()) { ?>
        <div class="rtcl-post-section-title">
          <h3><?php esc_html_e("Listing Information:", "clrestaurant"); ?></h3>
        </div>
        <div class="rtcl-from-group rtcl-checkbox-list rtcl-checkbox-inline rtcl-listing-pricing-types">
          <?php
          foreach ($listingPricingTypes as $type_id => $type) { ?>
            <div class="rtcl-checkbox rtcl-listing-pricing-type">
              <input type="radio" name="_rtcl_listing_pricing" id="_rtcl_listing_pricing_<?php echo esc_attr($type_id) ?>"
              <?php echo esc_attr( $listing_pricing === $type_id ? 'checked' : '' ); ?> value="<?php echo esc_attr($type_id) ?>">
              <label for="_rtcl_listing_pricing_<?php echo esc_attr($type_id) ?>">
                <?php echo esc_html($type); ?>
              </label>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php do_action( 'rtcl_listing_form_price_items', $listing ); ?>
      <div id="rtcl-pricing-items" class="rtcl-pricing-price">
          <?php if (!Functions::is_price_type_disabled()): ?>
              <div id="rtcl-form-price-wrap" class="form-group rtcl-pricing-item rtcl-from-group">
                  <label for="rtcl-price-type">
                      <?php esc_html_e('Price Type', 'clrestaurant'); ?>
                      <span class="require-star">*</span>
                  </label>
                  <select class="form-control" id="rtcl-price-type" name="price_type">
                      <?php
                      $price_types = Options::get_price_types();
                      foreach ($price_types as $key => $type) {
                          $slt = $price_type == $key ? " selected" : null;
                          printf( '<option value="%s"%s>%s</option>', esc_attr( $key ), esc_attr( $slt ), esc_html( $type ) );
                      }
                      ?>
                  </select>
              </div>
          <?php endif; ?>
          <div id="rtcl-price-items" class="rtcl-pricing-item<?php echo ! Functions::is_price_type_disabled() ? ( ' rtcl-price-type-' . esc_attr( $price_type ) ) : '' ?>">
              <div class="form-group rtcl-price-item" id="rtcl-price-wrap">
                  <div class="price-wrap">
                      <label for="rtcl-price"><?php echo sprintf('<span class="price-label">%s [%s]</span>',
                              esc_html__("Price", 'clrestaurant'), esc_html( Functions::get_currency_symbol() ) ); ?><span
                                  class="require-star">*</span></label>
                      <input type="text"
                            class="form-control rtcl-price"
                            value="<?php echo esc_attr( $listing ? $listing->get_price() : '' ); ?>"
                            name="price"
                            id="rtcl-price"<?php echo esc_attr(!$price_type || $price_type == 'fixed' ? " required" : ''); ?>>
                  </div>
                  <div class="price-wrap rtcl-max-price rtcl-hide">
                      <label for="rtcl-max-price"><?php echo sprintf('<span class="price-label">%s [%s]</span>',
                              esc_html__("Max Price", 'clrestaurant'),
                              esc_html( Functions::get_currency_symbol() )
                          ); ?><span
                                  class="require-star">*</span></label>
                      <input type="text"
                            class="form-control rtcl-price"
                            value="<?php echo esc_attr( $listing ? $listing->get_max_price() : '' ); ?>"
                            name="_rtcl_max_price"
                            id="rtcl-max-price"<?php echo esc_attr(!$price_type || $price_type == 'fixed' ? " required" : ''); ?>>
                  </div>
              </div>
              <?php do_action('rtcl_listing_form_price_unit', $listing, $category_id); ?>
          </div>
      </div>
    </div>
  <?php endif; ?>

    <div id="rtcl-custom-fields-list" data-post_id="<?php echo esc_attr($post_id); ?>">
      <?php do_action('wp_ajax_rtcl_custom_fields_listings', $post_id, $category_id); ?>
    </div>


    <?php $discount = get_post_meta( $post_id, "listing_discount", true ); ?>
    <div class="price-discpunt">
      <label for="description"><?php esc_html_e('Discount', 'clrestaurant'); ?></label>
      <input type="text"
      name="listing_discount"
      class="form-control"
      value="<?php echo isset($discount) ? esc_attr($discount) : '' ?>"
      placeholder="<?php esc_attr_e( 'Price Discount', 'clrestaurant' ); ?>">
    </div>


    <?php if (!in_array('description', $hidden_fields)): ?>
    <div class="form-group">
      <label for="description"><?php esc_html_e('Description', 'clrestaurant'); ?></label>
      <?php
        if ('textarea' == $editor) { ?>
          <textarea id="description" name="description" class="form-control" <?php echo esc_attr( $description_limit ? 'maxlength="' . $description_limit . '"' : '' ); ?> rows="8"><?php Functions::print_html($post_content); ?></textarea>
        <?php } else {
          wp_editor(
            $post_content,
            'description',
            array(
              'media_buttons' => false,
              'editor_height' => 200
            )
          );
        }
        if ($description_limit) {
          echo wp_kses_post(
              sprintf('<div class="rtcl-hints">%s</div>',
                  apply_filters('rtcl_listing_description_character_limit_hints',
                      sprintf(__("Character limit <span class='target-limit'>%s</span>", 'clrestaurant'), $description_limit)
                  )
              )
          );
        }
      ?>
    </div>
    <?php endif; ?>

    <!-- Food Menu -->
    <?php
      $generalSettings = Functions::get_option( 'rtcl_single_listing_settings' );
      $sectionLabel = !empty( $generalSettings['listing_food_list_section_label'] ) ? $generalSettings['listing_food_list_section_label'] : '';
    ?>
    <div class="additional-input-wrap">
      <div class="rtcl-post-section-title">
        <h3><i class="rtcl-icon rtcl-icon-food"></i><?php echo esc_html( $sectionLabel ); ?>:</h3>
      </div>

      <div class="rn-recipe-wrapper">
        <div class="additional-input-wrap group-bottom">
          <div class="form-group row">
            <div class="col-md-12">
              <div class="rn-recipe-wrapper">
                <div class="rn-recipe-wrap">
                  <?php

                  $recipes = get_post_meta( $post_id, "listing_food_list", true );

                  if (!empty($recipes && $recipes['0']['gtitle'] !='')) {
                    foreach ($recipes as $key => $recipe) {

                      ?>
                      <div class="rn-recipe-item">
                        <span class="rn-remove"><i class="fa fa-times" aria-hidden="true"></i></span>
                        <div class="rn-recipe-title">
                          <input type="text"
                          name="listing_food_list[<?php echo absint($key); ?>][gtitle]"
                          class="form-control"
                          value="<?php echo isset($recipe['gtitle']) ? esc_attr($recipe['gtitle']) : '' ?>"
                          placeholder="Food Froup Title">
                        </div>
                        <div class="rn-ingredient-wrap">
                          <?php if (!empty($recipe['food_list'])) {
                            foreach ($recipe['food_list'] as $ikey => $food_list) {
                                $imgId = '';
                                if (isset($food_list['attachment_id'])) {
                                  $imgId = $food_list['attachment_id'];
                                }
                              ?>
                              <div class="rn-ingredient-item">
                                <div class="rn-ingredient-fields">
                                  <input type="text"
                                  placeholder="Food Name"
                                  class="form-control"
                                  value="<?php echo isset($food_list['title']) ? esc_attr($food_list['title']) : '' ?>"
                                  name="listing_food_list[<?php echo absint($key); ?>][food_list][<?php echo absint($ikey); ?>][title]">

                                  <input type="text"
                                  placeholder="Food Price"
                                  class="form-control"
                                  value="<?php echo isset($food_list['foodprice']) ? esc_attr($food_list['foodprice']) : '' ?>"
                                  name="listing_food_list[<?php echo absint($key); ?>][food_list][<?php echo absint($ikey); ?>][foodprice]">

                                  <textarea placeholder="Description"
                                  class="form-control"
                                  name="listing_food_list[<?php echo absint($key); ?>][food_list][<?php echo absint($ikey); ?>][description]"><?php echo isset($food_list['description']) ? esc_html($food_list['description']) : '' ?></textarea>
                                </div>

                                <div class="food-image-wrap">
                                  <?php
                                  $has_attachment = ! empty( $imgId ) && !empty(wp_get_attachment_image( $imgId ));
                                  if ($has_attachment){ ?>
                                    <div class="food-image">

                                      <input
                                        name="listing_food_list[<?php echo absint($key); ?>][food_list][<?php echo absint($ikey); ?>][attachment_id]"
                                        type="hidden" value="<?php echo esc_attr( $imgId ? $imgId : '' ); ?>">

                                        <?php echo wp_get_attachment_image( $imgId, 'full' ); ?>

                                      <div class="remove-food-image">
                                        <a href="#" data-index="<?php echo absint($key); ?>" data-post_id="<?php echo esc_attr( $post_id ); ?>" data-attachment_id="<?php echo esc_attr( $imgId ); ?>"><?php esc_html_e( 'Remove Image', 'clrestaurant' ); ?></a>
                                      </div>

                                    </div>
                                  <?php } ?>
                                  <div class="food-input-wrapper <?php echo esc_attr( $has_attachment ? 'd-none' : '' ); ?>">
                                    <input name="listing_food_images[<?php echo absint($key); ?>][food_list][<?php echo absint($ikey); ?>]" class="listing-food-image" type="file"/>
                                  </div>
                                </div>
                                <span class="rn-remove"><i class="fa fa-times" aria-hidden="true"></i></span>
                              </div>
                              <?php
                              }
                          } ?>
                        </div>
                        <div class="rn-ingredient-actions">
                          <a href="javascript:void()"
                          class="btn-upload add-ingredient btn-sm btn-primary"><?php esc_html_e('Add New Food', 'clrestaurant'); ?></a>
                        </div>
                      </div>
                      <?php
                      }
                    }
                  ?>
                </div>
                <div class="rn-recipe-actions">
                  <a href="javascript:void()"
                  class="btn-upload add-recipe btn-sm btn-primary"><?php esc_html_e('Add New Foods', 'clrestaurant'); ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>