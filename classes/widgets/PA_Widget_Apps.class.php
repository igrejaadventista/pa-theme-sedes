<?php 
class WPDocs_New_Widget extends WP_Widget {
 
    function __construct() {
        parent::__construct( false, __( 'IASD - Widgets', 'pa_iasd' ) );
    }
 
    function widget( $args, $instance ) {
		$title = $instance['title'];
		$size = $instance['widget-size'];
		require(get_template_directory() . '/components/widgets/'. $instance['widget-file']);
	}
 
    function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['widget-file'] = ( !empty( $new_instance['widget-file'] ) ) ? $new_instance['widget-file'] : '';
		$instance['widget-size'] = ( !empty( $new_instance['widget-size'] ) ) ? $new_instance['widget-size'] : '';
		return $instance;
	}
 
    public function form( $instance ) {
		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Novo widget', 'text_domain' );
		
		$widget_file = isset($instance['widget-file']) ? $instance['widget-file'] : '' ;
		$widget_size = isset($instance['widget-size']) ? $instance['widget-size'] : '' ;

		?>
		<p>
			<label for="<?= esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
			<input class="widefat" id="<?= esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?= esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?= esc_attr( $title ); ?>">
		</p>
		<div>
			<p>
				<label for="<?= $this->get_field_id('widget-file'); ?>"><?php _e( 'Widget:', 'iasd'); ?></label>
				<select name="<?= $this->get_field_name('widget-file'); ?>" id="<?= $this->get_field_id('widget-file'); ?>" class="widefat" onchange="checkValue('<?= $this->get_field_id('') ?>');">
					<option value="pa-app.php"<?php selected( $widget_file, 'pa-app.php' ); ?>>Widget - Apps</option>
					<option value="pa-carousel-feature.php"<?php selected( $widget_file, 'pa-carousel-feature.php' ); ?>>Widget - Carousel - Feature</option>
					<option value="pa-carousel-magazines.php"<?php selected( $widget_file, 'pa-carousel-magazines.php' ); ?>>Widget - Carousel - Magazines</option>
					<option value="pa-carousel-ministry.php"<?php selected( $widget_file, 'pa-carousel-ministry.php' ); ?>>Widget - Carousel - Ministry</option>
					<option value="pa-carousel-videos.php"<?php selected( $widget_file, 'pa-carousel-videos.php' ); ?>>Widget - Carousel - Videos</option>
					<option value="pa-list-buttons.php"<?php selected( $widget_file, 'pa-list-buttons.php' ); ?>>Widget - List - Buttons</option>
					<option value="pa-list-downloads.php"<?php selected( $widget_file, 'pa-list-downloads.php' ); ?>>Widget - List - Downloads</option>
					<option value="pa-list-news.php"<?php selected( $widget_file, 'pa-list-news.php' ); ?>>Widget - List - News</option>
					<option value="pa-list-posts.php"<?php selected( $widget_file, 'pa-list-posts.php' ); ?>>Widget - List - Posts</option>
					<option value="pa-list-videos.php"<?php selected( $widget_file, 'pa-list-videos.php' ); ?>>Widget - List - Videos</option>
					<option value="pa-feliz7play.php"<?php selected( $widget_file, 'pa-feliz7play.php' ); ?>>Widget - Feliz7Play</option>
					<option value="pa-find-church.php"<?php selected( $widget_file, 'pa-find-church.php' ); ?>>Widget - Find Church</option>
				</select>
			</p>
		</div>
		<div id="widget-size">
			<p>
				<label for="<?= $this->get_field_id('widget-size'); ?>"><?php _e( 'Widget size:', 'iasd'); ?></label>
				<select name="<?= $this->get_field_name('widget-size'); ?>" id="<?= $this->get_field_id('widget-size'); ?>" class="widefat">
					<option value="1/3"<?php selected( $widget_size, '1/3' ); ?>>1/3</option>
					<option value="2/3"<?php selected( $widget_size, '2/3' ); ?>>2/3</option>
				</select>
			</p>
		</div>

		<?php 
	}
}
 
add_action( 'widgets_init', 'wpdocs_register_widgets' );
function wpdocs_register_widgets() {
    register_widget( 'WPDocs_New_Widget' );
}