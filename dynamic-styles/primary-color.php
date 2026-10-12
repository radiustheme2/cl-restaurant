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
// $evacon = EVACON_THEME_PREFIX_VAR;

$primary_color = Options::$options['primary_color'];

?>

<?php if ( !empty( $primary_color )) { ?>

	.schedule-inner-wrap-layout2 .tab-content .tab-item:nth-child(1n) .schedule-box-wrap-layout2 .schedule-box-layout2 .info-box .room-number,
	.elementor-930 .elementor-element.elementor-element-0c7ad32 .rtin-icon i,
	.elementor-3043 .elementor-element.elementor-element-ab65b27 .icon-box i,
	.elementor-3043 .elementor-element.elementor-element-9e9b782 .icon-box i,
	.elementor-3043 .elementor-element.elementor-element-e150733 .icon-box i,
	.each-comment .media-body .comment-header .comment-reply-link:hover,
	<!-- .sidebar-widget ul>li:hover span, .widget_archive ul>li:hover span, -->
	.portfolio-details-wrap .info-details .project-info-box a,
	.countdown-wrap-layout.layout-2 .countdown-section h3,
	<!-- .widget_categories ul>li:hover span,  -->
	.widget_meta ul li span, .widget_nav_menu ul li span, 
	<!-- .widget_pages ul li span, .widget_recent_entries ul li span, -->
	.speaker-box-layout2 .content-box .title a:hover,
	.address-box .list-info ul li.item-btn:before,
	.address-box.box-v2 .content-box .sub-title,
	.pricing-box-layout2:hover .pricing-price,
	.address-box .list-info ul li.item-btn a,
	.pricing-box-layout1 .pricing-title,
	<!-- .sidebar-widget ul>li:hover:before, -->
	.section-heading .heading-subtitle,
	ul.entry-meta li .meta-icon i,
	.comment-reply-title small a,
	.btn-fill.style-two:hover,
	.address-box .sub-title,
	.video-btn:hover i,
	.video-btn:hover,
	p.logged-in-as a,
	.btn-text {
		color: <?php echo esc_html( $primary_color ); ?>;
	}
	.schedule-inner-wrap-layout2 .tab-content .tab-item:nth-child(1n) .schedule-box-wrap-layout2 .schedule-box-layout2:hover .info-box,
	.schedule-inner-wrap-layout2 .tab-content .tab-item:nth-child(1n) .schedule-box-wrap-layout2 .schedule-box-layout2:hover:before,
	.swiper-pagination-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active,
	.schedule-inner-wrap-layout2 .tab-nav .menu-item:nth-child(1n) .menu-link.active,
	.newsletter-form .fluentform .frm-fluent-form .ff-el-group button,
	.address-box.box-v2:hover .content-box .video .video-link:hover,
	.each-comment .media-body .comment-header .comment-date:after,
	.schedule-box-layout3.schedule-content .panel-default:before,
	.search-form .stylish-input-group .input-group-addon button,
	.faq-box .panel-heading .accordion-button:not(.collapsed),
	.event-box-layout1:hover .content-box .btn-icon:hover,
	.countdown-wrap-layout.layout-1 .countdown-inner-wrap,
	.portfolio-box-layout.v1:hover .content-box,
	.wp-block-quote:before, blockquote:before,
	.section-heading span.line:before,
	.pagination ul li.active span,
	.btn-fill.style-three:before,
	.pagination ul li span:hover,
	.pagination ul li.active a, 
	.pagination ul li a:hover, 
	.btn-fill.style-two,
	.btn-fill.style-one,
	.tagcloud a:hover,
	.video-btn {
		background-color: <?php echo esc_html( $primary_color ); ?>;
	}
	
	.pagination ul li.next a:hover, .pagination ul li.prev a:hover,
	.schedule-box-layout3.schedule-content .panel-default.active,
	.faq-box .panel-heading .accordion-button:not(.collapsed),
	.event-box-layout1:hover .content-box .btn-icon:hover,
	.header-contact-info .icon-box,
	.pricing-box-layout2 .item-btn,
	.header-contact-info,
	.tagcloud a:hover {
		border-color: <?php echo esc_html( $primary_color ); ?>;
	}
	.about-box-layout1 .sub-figure ul li:nth-child(2) img {
		border: 5px solid <?php echo esc_html( $primary_color ); ?>;
	}
	.schedule-inner-wrap-layout2 .tab-content .tab-item:nth-child(1n) .schedule-box-wrap-layout2 .schedule-box-layout2:hover:nth-child(odd) .info-box:before {
		border-left: 20px solid <?php echo esc_html( $primary_color ); ?>;
	}
	.schedule-inner-wrap-layout2 .tab-content .tab-item:nth-child(1n) .schedule-box-wrap-layout2 .schedule-box-layout2:hover:nth-child(even) .info-box:before {
		border-right: 20px solid <?php echo esc_html( $primary_color ); ?>;
	}
	.schedule-inner-wrap-layout2 .tab-content .tab-item:nth-child(1n) .schedule-box-wrap-layout2 .schedule-box-layout2:hover .info-box .room-number,
	.elementor-930 .elementor-element.elementor-element-0c7ad32 .faq-box .panel-heading .accordion-button:not(.collapsed) .rtin-icon i,
	.address-box.box-v2:hover .content-box .sub-title {
		color: #fff !important;
	}
	.schedule-inner-wrap-layout2 .tab-content .tab-item:nth-child(1n) .schedule-box-wrap-layout2 .schedule-box-layout2 .info-box .room-number svg,
	.header-contact-info .icon-box svg {
		fill: <?php echo esc_html( $primary_color ); ?>;
	}
<?php } ?>