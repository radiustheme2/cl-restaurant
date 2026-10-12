<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLRestaurant\Options;

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php
        if (Options::$options['preloader']) {
            do_action('site_prealoader');
        }
    ?>

	<div id="wrapper" class="wrapper">
		<div id="main_content">
			<!--=====================================-->
			<!--=           404 Area Start          =-->
			<!--=====================================-->
			<section class="error-wrap-layout section-padding bg-image text-center">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 mx-auto">
							<div class="item-logo">
							<?php echo wp_get_attachment_image(  Options::$options['error_bg_img'], 'full' ); ?>
							</div>
							<h1 class="main-title"><?php echo esc_html( Options::$options['error_page_title'] ); ?></h1>
							<p class="desc"><?php echo esc_html( Options::$options['error_page_desc'] ); ?></p>	
							<div class="btn-wrap btn-v2">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="item-btn">
									<?php echo esc_html( Options::$options['error_buttontext'] ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>	
			</section>
			<!--=====================================-->
			<!--=           404 Area End            =-->
			<!--=====================================-->			
		</div>
	</div>

	<?php wp_footer(); ?>

</body>
</html>