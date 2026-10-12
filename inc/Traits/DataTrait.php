<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLRestaurant\Traits;

use Rtcl\Helpers\Functions;
use RadiusTheme\CLRestaurant\Options;
use Rtrs\Modules\Review\Helpers\ReviewFns;

trait DataTrait {

  protected static $instance = null;

  public static function instance() {
    if ( null == self::$instance ) {
      self::$instance = new self();
    }
    return self::$instance;
  }


  /* = Cl Restaurant Logo Settings
  ==========================================================*/
  public static function rt_logo_one(){
    if ( has_custom_logo() ) {
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo_one = wp_get_attachment_image( $custom_logo_id, 'full' );
    } else {
      if (!empty( Options::$options['logo_one'] )) {
        $logo_one = wp_get_attachment_image( Options::$options['logo_one'], 'full' );
      } else {
        $logo_one = '';
      }
    }
    return $logo_one;
  }
  
  public static function rt_logo_two(){
    if ( has_custom_logo() ) {
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo_two = wp_get_attachment_image( $custom_logo_id, 'full' );
    } else { 
      if (!empty( Options::$options['logo_two'] )) {
        $logo_two = wp_get_attachment_image( Options::$options['logo_two'], 'full' );
      } else {
        $logo_two = '';
      }
    }
    return $logo_two;
  }


  /* = Cl Restaurant Socials Settings
  ==========================================================*/
  public static function socials(){
    $rdtheme_socials = array(
      'rt_facebook' => array(
        'class' => 'facebook',
        'icon' => 'fa-brands fa-facebook-f',
        'url'  => Options::$options['rt_facebook'],
      ),
      'rt_twitter' => array(
        'class' => 'twitter',
        'icon' => 'fa-brands fa-twitter',
        'url'  => Options::$options['rt_twitter'],
      ),
      'rt_linkedin' => array(
        'class' => 'linkedin',
        'icon' => 'fa-brands fa-linkedin-in',
        'url'  => Options::$options['rt_linkedin'],
      ),
      'rt_instagram' => array(
        'class' => 'instagram',
        'icon' => 'fa-brands fa-instagram',
        'url'  => Options::$options['rt_instagram'],
      ),
      'rt_pinterest' => array(
        'class' => 'pinterest',
        'icon' => 'fa-brands fa-pinterest-p',
        'url'  => Options::$options['rt_pinterest'],
      ),
      'rt_youtube' => array(
        'class' => 'youtube',
        'icon' => 'fa-brands fa-youtube',
        'url'  => Options::$options['rt_youtube'],
      ),
    );
    return array_filter( $rdtheme_socials, array( __CLASS__ , 'filter_social' ) );
  }
  public static function filter_social( $args ){
    return ( $args['url'] != '' );
  }


  /**
	 * Get site footer list
	 *
	 * @param string $return_type
	 *
	 * @return array
	 */
	public static function get_hf_list( $return_type = '' ) {
		if ( 'footer' === $return_type ) {
			$layout = [
				'1' => [
					'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/theme/footer-1.jpg',
					'name'  => esc_html__( 'Layout 1', 'clrestaurant' )
        ],
        '2' => [
					'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/theme/footer-2.jpg',
					'name'  => esc_html__( 'Layout 2', 'clrestaurant' )
				]
			];
		} else {
			$layout = [
				'1' => [
					'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/theme/header-1.jpg',
					'name'  => esc_html__( 'Layout 1', 'clrestaurant' )
        ],
        '2' => [
					'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/theme/header-2.jpg',
					'name'  => esc_html__( 'Layout 2', 'clrestaurant' )
				],
        '3' => [
					'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/theme/header-3.jpg',
					'name'  => esc_html__( 'Layout 3', 'clrestaurant' )
				]
			];
		}

		return apply_filters( 'cl_restaurant_hf_layout', $layout );
	}

	public static function rt_grid_options(){
		return [
			'1'  => esc_html__( '1 Columns', 'clrestaurant' ),
			'2'  => esc_html__( '2 Columns', 'clrestaurant' ),
			'3'  => esc_html__( '3 Columns', 'clrestaurant' ),
			'4'  => esc_html__( '4 Columns', 'clrestaurant' ),
			'5'  => esc_html__( '5 Columns', 'clrestaurant' ),
			'6'  => esc_html__( '6 Columns', 'clrestaurant' ),
		];
	}


  public static function cl_restaurant_excerpt( $limit ) {
		if (!empty($limit)) {
			$limit = $limit;
		} else {
			$limit = 0;
		}
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
      array_pop($excerpt);
      $excerpt = implode(" ",$excerpt).'';
    } else {
      $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);

		return $excerpt;
	}

  public static function cl_restaurant_get_post_meta( $post_id, $padmin, $pcom, $pcats, $type ) { 
      $post_meta_holder= "";

      $comments_number = get_comments_number($post_id);
      $comments_text   = sprintf( _n( '%s Comment', '%s Comments', $comments_number, 'clrestaurant' ), number_format_i18n( $comments_number ) );

      $post_meta  = $padmin || $pdate || $pcom || $pcats ? true : false;

      if ( $post_meta ){ ?>
      <div class="blog-post__content__meta">
        <ul class="list-inline">
          <?php if ( $padmin ){ ?>     
          <li class="entry-admin">
            <span class="meta-icon">
              <?php
                if ($type == 'icon') { ?>
                  <i class="clr-icon-rt18-user2"></i>
                <?php } else {
                  echo get_avatar( get_the_author_meta( 'ID' ), 30 ); 
                }
              ?>
          </span>
            <span><?php esc_html_e( 'By', 'clrestaurant' ); ?></span>
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
          </li>
          <?php } if ( $pcom ){ ?> 
          <li class="entry-comments">
            <span class="meta-icon"><i class="far fa-comments"></i></span><?php echo esc_html( $comments_text ); ?>
          </li>
          <?php } if ( $pcats && has_category() ){ ?> 
          <li class="entry-cats"><span class="meta-icon"><i class="fas fa-tags"></i></span><?php the_category( ', ' ); ?></li>
          <?php } ?>
        </ul>
      </div>
    <?php }
    return $post_meta_holder;
  }

  public static function listygo_get_attach_img( $img_id, $size ) {
    $attach_img = '';
    if (!empty( $img_id )) {
      $attach_img = wp_get_attachment_image( $img_id, $size );
    } else {
      $attach_img = '';
    }
    return $attach_img;
  }

  public static function rt_rating( $count ){ ?>
    <div class="item-rating">
      <?php 
        for ($i=0; $i <=4 ; $i++) {
          if ($i < $count) {
            $full = 'active';
          } else {
            $full = 'deactive';
          }
          echo '<i class="fa-regular fa-star ' . esc_attr( $full ) . '"></i>';
        }
      ?>
    </div>
    <?php 
  }


  // Time Elapsed
	public static function time_elapsed_string() {
		$ptime = get_the_time( 'U' );
		$etime = time() - $ptime;

		if ( $etime < 1 ) {
			return '0 seconds';
		}

		$a        = [
			365 * 24 * 60 * 60 => 'year',
			30 * 24 * 60 * 60  => 'month',
			24 * 60 * 60       => 'day',
			60 * 60            => 'hour',
			60                 => 'minute',
			1                  => 'second',
		];
		$a_plural = [
			'year'   => 'years',
			'month'  => 'months',
			'day'    => 'days',
			'hour'   => 'hours',
			'minute' => 'minutes',
			'second' => 'seconds',
		];

		foreach ( $a as $secs => $str ) {
			$d = $etime / $secs;
			if ( $d >= 1 ) {
				$r = round( $d );

				return $r . ' ' . ( $r > 1 ? $a_plural[ $str ] : $str ) . ' ago';
			}
		}
	}

  // public static function hex2rgb($hex) {
  //   $hex = str_replace("#", "", $hex);
  //   if(strlen($hex) == 3) {
  //     $r = hexdec(substr($hex,0,1).substr($hex,0,1));
  //     $g = hexdec(substr($hex,1,1).substr($hex,1,1));
  //     $b = hexdec(substr($hex,2,1).substr($hex,2,1));
  //   } else {
  //     $r = hexdec(substr($hex,0,2));
  //     $g = hexdec(substr($hex,2,2));
  //     $b = hexdec(substr($hex,4,2));
  //   }
  //   $rgb = "$r, $g, $b";
  //   return $rgb;
  // }

  public static function UserMeta(){
    $user_id = get_the_author_meta('ID');
    $f = get_user_meta( $user_id, 'facebook',true );
    $t = get_user_meta( $user_id, 'twitter',true );
    $l = get_user_meta( $user_id, 'linkdin',true );
    $p = get_user_meta( $user_id, 'pinterest',true );
    if(!empty( $f || $t || $l || $p )){  
    ?>

    <ul class="author-social">
      <?php if(!empty( $f )){ ?>
        <li>
            <a href="<?php echo esc_url ($f ); ?>"><i class="fab fa-facebook-f"></i></a>
        </li>
        <?php } if(!empty( $t )){ ?>
        <li>
            <a href="<?php echo esc_url ($t ); ?>"><i class="fab fa-twitter"></i></a>
        </li>
        <?php } if(!empty( $l )){ ?>
        <li>
            <a href="<?php echo esc_url ($l ); ?>"><i class="fab fa-linkedin-in"></i></a>
        </li>
        <?php } if(!empty( $p )){ ?>
        <li>
            <a href="<?php echo esc_url ($p ); ?>"><i class="fab fa-pinterest-p"></i></a>
        </li>
        <?php } ?>
    </ul>

    <?php } 
  }

  /**
   * Get Listing author image
   *
   * @param       $listing
   * @param  int  $size
   */
  static public function get_listing_author_image( $listing, $size = 70 ) {
    $owner_id   = $listing->get_owner_id();
    $pp_id      = absint( get_user_meta( $owner_id, '_rtcl_pp_id', true ) );
    if ($pp_id) {
    ?>
    <div class="item-poster-info">
      <div class="directory-block__poster__thumb">
      <?php if ( $listing->can_add_user_link() && ! is_author() ) : ?>
        <a class="directory-block__poster__link--image" href="<?php echo esc_url( $listing->get_the_author_url() ); ?>">
          <?php echo wp_get_attachment_image( $pp_id, [ $size, $size ] ); ?>
        </a>
        <?php else:
          echo wp_get_attachment_image( $pp_id, [ $size, $size ] );
          endif;
        ?>
      </div>
    </div>
    <?php } else { ?>
    <div class="item-poster-info">
      <div class="directory-block__poster__thumb">
        <?php if ( $listing->can_add_user_link() && ! is_author() ) : ?>
          <a class="directory-block__poster__link--image" href="<?php echo esc_url( $listing->get_the_author_url() ); ?>">
            <?php echo get_avatar( $listing->get_author_id(), $size ); ?>
          </a>
        <?php else:
          echo get_avatar( $listing->get_author_id(), $size );
          endif;
        ?>
      </div>
    </div>
    <?php }
  }

  static public function get_listing_rating( $listing ) {
    if( class_exists( ReviewFns::class ) ){
      $average_rating = ReviewFns::getAvgRatings( get_the_ID() );
      $rating_count   = ReviewFns::getTotalRatings( get_the_ID() );
    } else {
      $average_rating = $listing->get_average_rating();
      $rating_count   = $listing->get_rating_count();
    }
    if ( ! empty( $rating_count ) ):
    ?>
      <div class="product-rating">
        <div class="item-icon">
          <?php echo wp_kses_post( Functions::get_rating_html( $average_rating, $rating_count ) ); ?>
        </div>
        <div class="item-text"><?php echo wp_kses_post( apply_filters( 'listygo_rating_count_format', sprintf( __( '(<span>%s</span>)', 'clrestaurant' ), esc_html( $rating_count ) ) ) ); ?></div>
      </div>
    <?php 
    endif;
  }

  public static function listing_cat_icon( $term_id, $icon_type = NULL ) {
    $cat_img  = $cat_icon = $icon = null;
    $image_id = get_term_meta( $term_id, '_rtcl_image', true );
    if ( $image_id ) {
      $image_attributes = wp_get_attachment_image_src( (int) $image_id, 'medium' );
      $image            = $image_attributes[0];
      if ( '' !== $image ) {
        $cat_img = sprintf( '<img src="%s" class="rtcl-cat-img" alt="%s"/>', $image, esc_attr__( 'Category Image', 'clrestaurant' ) );
      }
    }
    $icon_id = get_term_meta( $term_id, '_rtcl_icon', true );
    if ( $icon_id ) {
      $cat_icon = sprintf( '<span class="rtcl-cat-icon rtcl-icon rtcl-icon-%s"></span>', $icon_id );
    }

    $icon = $icon_type == 'icon' ? $cat_icon : $cat_img;

    return $icon;
  }

  public static function CLR_listing_categories( $listingId, $icon_type = NULL ) {
    $terms = get_the_terms( $listingId, 'rtcl_category' );
    foreach ( $terms as $trm ) {
      ob_start();
        $catColor = get_term_meta($trm->term_id,'rt_category_color',true) ?:'27CCAB';
        $catIcon = self::listing_cat_icon($trm->term_id, 'icon' ); 
        printf(
          "<a href='%s' style='background-color: #%s'>%s %s</a>",
          esc_url( get_term_link( $trm ) ),
          esc_attr( $catColor ),
          wp_kses_post( $catIcon ),
          esc_html( $trm->name )
        );
      $category = ob_get_clean();
    }

    return $category;
  }
  public static function CLR_listing_rgba_categories( $listingId, $icon_type = NULL ) {
    $terms = get_the_terms( $listingId, 'rtcl_category' );
    foreach ( $terms as $trm ) {
      ob_start();
      $catColor = get_term_meta($trm->term_id,'rt_category_color',true) ?:'27CCAB';
      $catIcon = self::listing_cat_icon($trm->term_id, 'icon' );
      $catBg = self::hex2rgba($catColor, 0.1);
					printf(
						"<a href='%s' style='color: #%s; background-color: %s'>%s %s</a>",
						esc_url( get_term_link( $trm ) ),
            esc_attr( $catColor ),
            esc_attr( $catBg ),
            wp_kses_post( $catIcon ),
						esc_html( $trm->name )
					);
      $category = ob_get_clean();
    }

    return $category;
  }

}

