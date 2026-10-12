<?php
/**
 *
 * @author        RadiusTheme
 * @package    classified-listing/templates
 * @version     1.0.0
 *
 * @var array $fields
 * @var int $listing_id
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use Rtcl\Models\RtclCFGField;

if ( count( $fields ) ) :
    ob_start();
    foreach ( $fields as $field ) :

        $facilities = Functions::get_cf_data( $field );
        $data      = $facilities['value'] ?? [];
        $options   = $facilities['options']['choices'] ?? [];

        $field = new RtclCFGField( $field->ID );
        $value = $field->getFormattedCustomFieldValue( $listing_id );

        if ( $value ) :
            ?>

            <ul class='rtcl-listable-item ul-ol'>
                <?php
                foreach ($options as $key => $value) {
                    if (in_array($key, $data)) {
                        echo '<li class="checked"><i class="fa-solid fa-check"></i>' . esc_html( $value ) . '</li>';
                    } else {
                        echo '<li class="cross"><i class="fa-solid fa-xmark"></i>' . esc_html( $value ) . '</li>';
                    }
                }
                ?>
            </ul>

        <?php endif;
    endforeach;

    $fields_html = ob_get_clean();
    if ( $fields_html ) {
        printf( '<div class="rtcl-listable">%s</div>', wp_kses_post( $fields_html ) );
    }
endif;
