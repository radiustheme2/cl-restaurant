<?php
/**
 * Modal
 *
 * @var Store  $store
 * @var string $store_oh_type
 * @var array  $store_oh_hours
 * @var string $today
 * @package    cl-restaurant/templates
 * @version    1.0.0
 *
 * @author     RadiusTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use RtclStore\Models\Store;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $store;

$store_oh_type  = get_post_meta( $store->get_id(), 'oh_type', true );
$store_oh_hours = get_post_meta( $store->get_id(), 'oh_hours', true );
$store_oh_hours = is_array( $store_oh_hours ) ? $store_oh_hours : ( $store_oh_hours ? (array) $store_oh_hours : [] );
$today          = strtolower( gmdate( 'l' ) );

?>

<div class="store-information-wrapper widget">
    <h3 class="widget-heading"><?php esc_html_e( 'Agency Information', 'clrestaurant' ); ?></h3>
    <div class="store-more-details">
        <ul>
            <?php if ( $store_phone = $store->get_phone() ) : ?>
                <li>
                    <i class="demo-icon clr-icon-rt18-phone2"></i>
                    <span><?php esc_html_e( "Call: ", "clrestaurant" ) ?></span>
                    <a target="_blank" href="tel:<?php echo esc_attr( $store_phone ) ?>">
                        <?php echo esc_html( $store_phone ) ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( $store_email = $store->get_email() ) : ?>
                <li>
                    <i class="rtcl-icon-mail"></i>
                    <span><?php esc_html_e( "E-mail: ", "clrestaurant" ) ?></span>
                    <a href="mailto:<?php echo esc_attr( $store_email ) ?>">
                        <?php echo esc_html( $store_email ) ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( $store_location = $store->get_address() ) : ?>
                <li>
                    <i class="clr-icon-rt18-marker"></i>
                    <span><?php esc_html_e( "Location: ", "clrestaurant" ) ?></span>
                    <?php echo esc_html( $store_location ) ?>
                </li>
            <?php endif; ?>

            <?php if ( $store_website = $store->get_website() ) : ?>
                <li>
                    <i class="demo-icon fas fa-globe"></i>
                    <span><?php esc_html_e( "Website: ", "clrestaurant" ) ?></span>
                    <a target="_blank" href="<?php echo esc_url_raw( $store_website ) ?>" <?php echo Functions::is_external( $store_website ) ? ' rel="nofollow"'
                        : ''; ?>><?php echo esc_html( $store_website ) ?></a>
                </li>
            <?php endif; ?>

            <?php if ( $store->get_social_media() ): ?>
                <li>
                    <i class="demo-icon rt-custom-icon-d-clock"></i>
                    <span><?php esc_html_e( "Share: ", "clrestaurant" ) ?></span>
                    <div class="store-socials">
                        <?php
                        echo wp_kses( $store->get_social_media_html(), [
                            'a' => [
                                'href'  => [],
                                'title' => [],
                            ],
                            'i' => [
                                'class' => [],
                            ],
                        ] );
                        ?>
                    </div>
                </li>
            <?php endif; ?>
        </ul>

        <div class="more-item store-hours-list-wrap">
            <div class="rtin-oh-title">
                <i class="far fa-clock label-icon" aria-hidden="true"></i>
                <span><?php esc_html_e( "Opening Hours", "clrestaurant" ) ?></span>
            </div>
            <div class="store-hours-list">
                <?php if ( $store_oh_type == "selected" ): ?>
                    <?php if ( is_array( $store_oh_hours ) && ! empty( $store_oh_hours ) ): ?>
                        <?php foreach ( $store_oh_hours as $hKey => $oh_hour ): ?>
                            <div class="row store-hour<?php echo esc_attr( ( $hKey == $today ) ? ' current-store-hour' : '' ); ?>">
                                <div class="col-4">
                                    <span class="hour-day"><?php echo esc_html( $hKey ); ?></span>
                                </div>
                                <div class="col-8 oh-hours-wrap">
                                    <?php if ( isset( $oh_hour['active'] ) ): ?>
                                        <div class="oh-hours">
                                            <span class="open-hour"><?php echo isset( $oh_hour['open'] ) ? esc_html( $oh_hour['open'] ) : ''; ?></span>
                                            <span class="close-hour"><?php echo isset( $oh_hour['close'] ) ? esc_html( $oh_hour['close'] ) : ''; ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="off-day"><?php esc_html_e( "Closed", "clrestaurant" ) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="always-open"><?php esc_html_e( "Permanently Closed", "clrestaurant" ) ?></div>
                    <?php endif; ?>
                <?php elseif ( $store_oh_type == 'always' ): ?>
                    <div class="always-open"><?php esc_html_e( "Always Open", "clrestaurant" ) ?></div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php if ( $store_email = $store->get_email() ) : ?>
    <div class="store-form-wrapper widget">
        <h3 class="widget-heading"><?php esc_html_e( 'Message Store Owner', 'clrestaurant' ); ?></h3>
        <?php Functions::get_template( 'store/contact-form', '', '', rtclStore()->get_plugin_template_path() ); ?>
    </div>
<?php endif; ?>