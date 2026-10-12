<?php
/**
 * Author Listing
 *
 * @author     RadiusTheme
 * @package    ClassifiedListing/Templates
 * @version    2.2.1.1
 */

use Rtcl\Helpers\Functions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$author   = get_user_by( 'slug', get_query_var( 'author_name' ) );
$user_id  = $author->ID;
$store_id = get_user_meta( $user_id, '_rtcl_store_id', true );
$phone    = get_user_meta( $user_id, '_rtcl_phone', true );
$whatsApp = get_user_meta( $user_id, '_rtcl_whatsapp_number', true );
$website  = get_user_meta( $user_id, '_rtcl_website', true );
$pp_id    = absint( get_user_meta( $user_id, '_rtcl_pp_id', true ) );
?>
<div class="rtcl-user-single-wrapper rtcl">
	<div class="rtcl-user-info-wrap">

		<div class="rtcl-user-img">
			<?php
                if ( $pp_id ) {
                    echo wp_kses_post( wp_get_attachment_image( (int) $pp_id, [400, 240] ) );
                } else {
                    echo wp_kses_post( get_avatar( (int) $user_id ) );
                }
			?>
		</div>

		<div class="rtcl-user-info">
			<h3 class="user-name">
				<?php echo esc_html($author->display_name); ?>
				<?php do_action('rtcl_after_author_meta', $user_id ); ?>
			</h3>
			<?php echo esc_html($author->description); ?>
			<div class="rtcl-user-meta">
				<?php if ( $phone && Functions::check_visibility( $user_id, 'phone' ) ): ?>
					<div class="item-phone">
						<i class="rtcl-icon rtcl-icon-phone"></i>
						<a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a>
					</div>
				<?php endif; ?>
				<?php if ( $whatsApp && Functions::check_visibility( $user_id, 'whatsapp' ) ): ?>
					<div class="item-whatsapp">
						<i class="rtcl-icon rtcl-icon-whatsapp"></i>
						<a target="_blank"
						   href="https://wa.me/<?php echo esc_attr( $whatsApp ); ?>"><?php echo esc_html( $whatsApp ); ?></a>
					</div>
				<?php endif; ?>
				<?php if ( Functions::check_visibility( $user_id, 'email' ) ): ?>
				<div class="item-contact">
					<i class="rtcl-icon rtcl-icon-envelope-open"></i>
					<a href="mailto:<?php echo esc_attr( $author->user_email ); ?>"><?php echo esc_html( $author->user_email ); ?></a>
				</div>
				<?php endif; ?>
				<?php if ( $website ): ?>
					<div class="item-whatsapp">
						<i class="rtcl-icon rtcl-icon-link"></i>
						<a target="_blank"
						   href="<?php echo esc_url( $website ); ?>"><?php echo esc_url( $website ); ?></a>
					</div>
				<?php endif; ?>
			</div>
			<?php
			$social_list = Functions::get_user_social_profile( $user_id );
			if ( ! empty( $social_list ) ) {
				?>
				<div class="rtcl-user-social">
					<?php
					foreach ( $social_list as $item => $value ) {
						?>
						<a target="_blank" href="<?php echo esc_url( $value ) ?>">
							<i class="rtcl-icon rtcl-icon-<?php echo esc_attr( $item ) ?>"></i>
						</a>
						<?php
					}
					?>
				</div>
			<?php } ?>
			<?php do_action( 'rtcl_author_details_after_meta', $user_id ); ?>
		</div>
	</div>
	<?php Functions::get_template( 'listing/author-listing'); ?>
</div>