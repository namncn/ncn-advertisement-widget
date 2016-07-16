<?php
/**
 * Contains all the functions related to sidebar and widget.
 * 
 * @package Nam NCN
 */

/**
 * Function to register the widgets.
 */
function ncnaw_widgets_init() {
   register_widget( "ncnaw_advertisement_widget" );
}
add_action( 'widgets_init', 'ncnaw_widgets_init');


/****************************************************************************************/

/**
 * Advertisement Ads
 */
class ncnaw_advertisement_widget extends WP_Widget {

   function __construct() {
      $widget_ops = array( 'classname' => 'ncnaw_widget_advertisement', 'description' => __( 'Thêm quảng cáo của bạn ở đây', 'namncn') );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false,$name= __( 'NCN: Quảng cáo', 'namncn' ),$widget_ops);
   }

   function form( $instance ) {
      $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'image_url' => '', 'image_link' => '') );
      $title = esc_attr( $instance[ 'title' ] );

      $image_link = 'image_link';
      $image_url = 'image_url';

      $instance[ $image_link ] = esc_url( $instance[ $image_link ] );
      $instance[ $image_url ] = esc_url( $instance[ $image_url ] );

      ?>

      <p>
         <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Tiêu đề:', 'namncn' ); ?></label>
         <input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <p>
         <label for="<?php echo esc_attr( $this->get_field_id( $image_link ) ); ?>"> <?php esc_html_e( 'Liên kết đích đến của quảng cáo:', 'namncn' ); ?></label>
         <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( $image_link ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $image_link ) ); ?>" value="<?php echo esc_attr( $instance[$image_link] ); ?>"/>
      </p>
      <p>
         <label for="<?php echo esc_attr( $this->get_field_id( $image_url ) ); ?>"> <?php esc_html_e( 'Hình ảnh quảng cáo:', 'namncn' ); ?></label>

         <?php
         if ( $instance[ $image_url ] != '' ) :
            echo '<img id="preview" src="' . esc_attr( $instance[ $image_url ] ) . '" style="max-width: 100%;height: auto;margin-top: 5px;" alt="" /><br />';
         endif;
         ?>

         <input type="text" class="widefat custom_media_url" id="<?php echo esc_attr( $this->get_field_id( $image_url ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $image_url ) ); ?>" value="<?php echo esc_attr( $instance[$image_url] ); ?>" />

         <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo esc_attr( $this->get_field_name( $image_url ) ); ?>" value="<?php esc_attr_e( 'Upload ảnh', 'namncn' ); ?>" style="margin-top:5px;" onclick="imageWidget.uploader( '<?php echo esc_js( $this->get_field_id( $image_url ) ); ?>' ); return false;"/>
      </p>
      <p>
         <small>
            <?php print 'Ủng hộ tác giả plugin này, soạn tin: <br /> TT < cach > NAW < cach > NCN gửi 8585 (5.000đ).'; // WPCS: XSS OK. ?>
         </small>
      </p>
   <?php }
   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );

      $image_link = 'image_link';
      $image_url = 'image_url';

      $instance[ $image_link ] = esc_url_raw( $new_instance[ $image_link ] );
      $instance[ $image_url ] = esc_url_raw( $new_instance[ $image_url ] );

      return $instance;
   }

   function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );

      $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

      /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
      $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

      $image_link = 'image_link';
      $image_url = 'image_url';

      $image_link = isset( $instance[ $image_link ] ) ? $instance[ $image_link ] : '';
      $image_url = isset( $instance[ $image_url ] ) ? $instance[ $image_url ] : '';

      echo wp_kses_post( $before_widget ); ?>

      <div class="advertisement">
         <?php if ( ! empty( $title ) ) { ?>
            <div class="advertisement-title">
               <?php echo wp_kses_post( $before_title ) . esc_html( $title ) . wp_kses_post( $after_title ); ?>
            </div>
         <?php }
            $output = '';
            if ( ! empty( $image_url ) ) {
               $output .= '<div class="advertisement-content">';
               if ( ! empty( $image_link ) ) {
               $output .= '<a href="' . $image_link . '" class="single_ad" target="_blank" rel="nofollow">
                                    <img src="' . $image_url . '" alt="">
                           </a>';
               } else {
                  $output .= '<img src="' . $image_url . '" alt="">';
               }
               $output .= '</div>';
               print $output ; // WPCS: XSS OK.
            } ?>
      </div>
      <?php
      echo wp_kses_post( $after_widget );
   }
}

/****************************************************************************************/