<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLRestaurant\Helper;
use RadiusTheme\CLRestaurant\Options;
global $post;

$blog_style = Options::$options['blog_style'];
$cols = Options::$options['blog_grid'];

if ($cols > 1) {
	$imgSize = 'cl-restaurant-size1';
} else {
	$imgSize = 'full';
}
if ($blog_style == 1) {
    $imgSize = 'full';
} else {
    $imgSize = $imgSize;
}
$post_id = get_the_ID();
$excerpt_length = Options::$options['excerpt_length'];
$padmin = Options::$options['post_meta_admin'];
$pdate = Options::$options['post_meta_date'];
$pcom = Options::$options['post_meta_comnts'];

if ( has_post_thumbnail() ){
    $thumb_img = '';
} else {
    $thumb_img = 'no-image';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post blog-list blog-post-'.$cols. ' ' .$thumb_img ); ?>>
    <?php if ( has_post_thumbnail()):
        $thumb = get_the_post_thumbnail( get_the_ID(), $imgSize);
        ?>
        <div class="blog-post__figure">
            <a href="<?php the_permalink(); ?>">
                <?php echo wp_kses_post($thumb); ?>
            </a>
            <?php if ( $pdate ) : ?>
                <div class="date-meta">
                    <i class="clr-icon-calendar1-1"></i><?php the_time( get_option( 'date_format' ) ); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="blog-post__content">
        <?php Helper::cl_restaurant_get_post_meta( $post_id, $padmin, $pcom, $pcats = NULL, $type = 'icon' ); ?>
        <h3 class="blog-post__content__heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="blog-post__content__excerpt">
            <p><?php echo wp_kses_post( Helper::cl_restaurant_excerpt( $excerpt_length ) ); ?></p>
        </div>
        <div class="btn-wrap">
            <a href="<?php the_permalink(); ?>" class="item-btn">
                <span class="btn__text"><?php esc_html_e( 'Read More', 'clrestaurant' ); ?></span>
            </a>
        </div>
    </div>
    <?php if ( is_sticky() ) {
        echo '<sup class="meta-featured-post"> <i class="fas fa-thumbtack"></i> ' . esc_html__( 'Sticky', 'clrestaurant' ) . ' </sup>';
    } ?>
</article>