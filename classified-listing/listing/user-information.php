<?php
/**
 * @var string  $address
 * @var string  $phone
 * @var string  $whatsapp_number
 * @var string  $email
 * @var string  $website
 * @var array   $phone_options
 * @var bool    $has_contact_form
 * @var string  $email_to_seller_form
 * @var Listing $listing
 * @var array   $locations
 * @var int     $listing_id Listing id
 * @author       RadiusTheme
 * @package      classified-listing/templates
 * @version      1.0.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Link;
use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Text;
use RadiusTheme\CLRestaurant\Helper;
use RadiusTheme\CLRestaurant\Options;
use RtclMarketplace\Hooks\ActionHooks;

global $listing;

$address = get_post_meta( $listing->get_id(), 'address', true );
$phone = get_post_meta( $listing->get_id(), 'phone', true );
$whatsapp = get_post_meta( $listing->get_id(), '_rtcl_whatsapp_number', true );
$email = get_post_meta( $listing->get_id(), 'email', true );
// $website = str_replace(['https://', 'http://'], '', $website );

$pattern = array("(^https?://)", "(^http?://)");
$website_url = preg_replace( $pattern, "", $website );

?>

<?php
	if ( class_exists('RtclMarketplace') ) {
		ActionHooks::add_buy_button();
	}
?>

<?php
	if (Fns::is_enable_chat() && ((is_user_logged_in() && $listing->get_author_id() !== get_current_user_id()) || !is_user_logged_in())):
		$chat_btn_class = [ 'rtcl-chat-link' ];
		$chat_url = Link::get_my_account_page_link();
		$chat_label = esc_html__("Quick Chat", "clrestaurant");
		$chant_enable_class = "rtcl-contact-seller";
		if ( is_user_logged_in() ) {
			$chat_url = '#';
			array_push( $chat_btn_class, 'rtcl-contact-seller' );
		} else {
			array_push( $chat_btn_class, 'rtcl-no-contact-seller' );
			$chat_label = esc_html__("Login for Chat", "clrestaurant");
			$chant_enable_class = 'need-to-logedin';
		}
	?>
	<div class="rtcl-listing-user-info chat-form">
		<div class=<?php echo esc_attr( $chant_enable_class ); ?>>
			<a class="<?php echo esc_attr( implode( ' ', $chat_btn_class ) ) ?>" href="<?php echo esc_url( $chat_url ) ?>" data-listing_id="<?php the_ID() ?>">
				<i class="fa-brands fa-rocketchat"></i>
				<?php echo esc_html( $chat_label ) ?>
			</a>
		</div>
	</div>
<?php endif; ?>
<?php if ($has_contact_form && $email) : ?>
	<div class="rtcl-listing-user-info contact-form">
		<div class='rtcl-do-email list-group-item'>
			<div class='media'>
				<span class='rtcl-icon rtcl-icon-mail'></span>
				<div class='media-body'>
					<a class="rtcl-do-email-link" href='#'>
						<?php echo wp_kses_post( Text::get_single_listing_email_button_text() ); ?>
					</a>
				</div>
			</div>
			<?php Functions::print_html($email_to_seller_form, true); ?>
		</div>
	</div>
<?php endif; ?>

<div class="rtcl-listing-user-info">
	<?php if (Fns::registered_user_only('listing_seller_information') && !is_user_logged_in()) { ?>
	<p class="login-message">
		<?php echo wp_kses(sprintf(__("Please <a href='%s'>login</a> to view the seller information.", "clrestaurant"), esc_url(Link::get_my_account_page_link())), ['a' => ['href' => []]]); ?>
	</p>
	<?php } else { ?>
	<div class="rtcl-listing-side-title">
		<h3><?php esc_html_e( "Posted By", 'clrestaurant' ); ?></h3>
	</div>
	<div class="list-group">
		<div class="listing-author">
			<div class="author-logo-wrapper">
				<?php Helper::get_listing_author_image( $listing, '80' ); ?>
			</div>
			<div class="author-info-wrapper">
				<h4 class="author-name">
					<?php if ( $listing->can_add_user_link() && ! is_author() ) : ?>
					<a class="author-link" href="<?php echo esc_url( $listing->get_the_author_url() ); ?>">
						<?php echo esc_html( $listing->get_author_name() ); ?>
					</a>
					<?php else: ?>
					<?php echo wp_kses_post( $listing->get_author_name() ); ?>
					<?php endif; ?>
					<?php
						$status = apply_filters( 'rtcl_user_offline_text', esc_html__( 'Offline Now', 'clrestaurant' ) );
						if ( Fns::is_online( $listing->get_owner_id() ) ) {
							$status = apply_filters( 'rtcl_user_online_text', esc_html__( 'Online Now', 'clrestaurant' ) );
						}
					?>
					<div class="rtcl-user-status <?php echo esc_attr( strtolower( $status ) ); ?>"><span class="user-staus-text"><?php echo esc_html( $status ); ?></span></div>
				</h4>

				<div class="rtin-user-item">
					<?php do_action('rtcl_after_author_meta', $listing->get_owner_id() ); ?>
				</div>
			</div>
		</div>
		<ul class="info-list">
			<?php if ( $address ) : ?>
			<li>
				<i class="demo-icon clr-icon-rt18-marker"></i>
				<?php echo esc_html( $address ); ?>
			</li>
			<?php endif; ?>
			<?php if ( $phone && Functions::check_visibility( $listing->get_author_id(), 'phone' ) ) : ?>
			<li>
				<a class="rtcl-phone-link" href="tel:<?php echo esc_attr( $phone ); ?>" target="_blank">
					<i class="demo-icon clr-icon-rt18-phone2"></i><?php echo esc_html( $phone ); ?>
				</a>
			</li>
			<?php endif; ?>
			<?php if ( $whatsapp && Functions::check_visibility( $listing->get_author_id(), 'whatsapp' ) ) : ?>
			<li>
				<a class="rtcl-whatsapp-link"
					href="https://api.whatsapp.com/send?phone=<?php echo esc_attr( $whatsapp ); ?>" target="_blank">
					<i class="fab fa-whatsapp"></i>
					<?php echo esc_html( $whatsapp ); ?>
				</a>
			</li>
			<?php endif; ?>
			<?php if ( $website ) : ?>
			<li>
				<a class="rtcl-website-link" href="<?php echo esc_url( $website ); ?>" target="_blank"
					<?php echo Functions::is_external( $website ) ? ' rel="nofollow"' : ''; ?>>
					<?php echo Helper::globe_icon(); ?>
					<?php echo esc_html( $website_url ); ?>
				</a>
			</li>
			<?php endif; ?>
		</ul>
		<?php 
			if (Options::$options['listing_list_socials']) {
				do_action( 'rtcl_single_listing_social_profiles' );
			}
		?>
	</div>
	<?php } ?>
</div>

<?php do_action( 'rtcl_after_single_listing_sidebar', $listing->get_id() ); ?>


