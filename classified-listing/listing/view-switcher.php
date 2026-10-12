<?php
/**
 * View switcher
 *
 * @version     1.5.5
 *
 * @var array  $views
 * @var string $current_view
 * @var string $default_view
 */

if (!defined('ABSPATH')) {
    exit;
}
if (empty($views)) {
    return;
}

use radiustheme\clrestaurant\Helper;

?>
<div class="rtcl-view-switcher">
    <?php
    foreach ($views as $value => $label) {
        $active = $current_view === $value ? ' active' : '';
        $thIcon = $value === 'grid' ? "clr-icon-rt18-grid" : 'clr-icon-rt18-list';
        ?>
        <a class="rtcl-view-trigger<?php echo esc_attr($active); ?>" data-type="<?php echo esc_attr($value); ?>" href="<?php echo esc_url( add_query_arg( 'view', $value ) ); ?>">
            <i class="<?php echo esc_attr( $thIcon ); ?>"></i>
        </a>
    <?php } ?>
</div>




