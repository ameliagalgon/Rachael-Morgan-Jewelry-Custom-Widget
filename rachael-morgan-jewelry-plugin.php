<?php
/*
Plugin Name: Site Plugin for rachaelmorganjewelry.com
Description: Site specific code changes for rachaelmorganjewelry.com
*/
/* Start Adding Functions Below this Line */

// Register and load the widget
function wpb_load_widget() {
    register_widget( 'rachael_morgan_jewelry_landing_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

// Enqueue additional admin scripts
add_action('admin_enqueue_scripts', 'wpb_load_script');
function wpb_load_script() {
    wp_enqueue_media();
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('ads_script', plugin_dir_url( __FILE__ ) . '/js/widget.js', false, '1.0.0', true);
}

// Creating the widget
class rachael_morgan_jewelry_landing_widget extends WP_Widget {

    function __construct() {
        parent::__construct(

            // Base ID of your widget
            'rachael_morgan_jewelry_landing_widget',

            // Widget name will appear in UI
            __('Rachael Morgan Jewelry Landing Widget', 'text_domain'),

            // Widget description
            array ('description'                 => __( 'Sample widget based on WPBeginner Tutorial', 'text_domain' ),
                'customize_selective_refresh'   => true,
                'classname'                     => 'widget_rachael-morgan-jewelry-landing'
            )
        );
    }

    // Widget Backend
    public function form( $instance ) {

        $defaults = array('title'   => '',
            'text'      => '',
            'textarea'  => '',
            'checkbox'  => '',
            'select'    => '',
            'image_uri'     => ''
        );

        //extract( wp_parse_args($instance, $defaults));
        extract( wp_parse_args( ( array ) $instance, $defaults ) );

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <?php // Text Field ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
        </p>

        <?php // Textarea Field ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>"><?php _e( 'Textarea:', 'text_domain' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'textarea' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'textarea' ) ); ?>"><?php echo wp_kses_post( $textarea ); ?></textarea>
        </p>

        <?php // Checkbox ?>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox ); ?> />
            <label for="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>"><?php _e( 'Checkbox', 'text_domain' ); ?></label>
        </p>

        <?php // Dropdown ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'select' ); ?>"><?php _e( 'Select', 'text_domain' ); ?></label>
            <select name="<?php echo $this->get_field_name( 'select' ); ?>" id="<?php echo $this->get_field_id( 'select' ); ?>" class="widefat">
                <?php
                // Your options array
                $options = array(
                    ''        => __( 'Select', 'text_domain' ),
                    'option_1' => __( 'Option 1', 'text_domain' ),
                    'option_2' => __( 'Option 2', 'text_domain' ),
                    'option_3' => __( 'Option 3', 'text_domain' ),
                );

                // Loop through options and add each one to the select dropdown
                foreach ( $options as $key => $name ) {
                    echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $select, $key, false ) . '>'. $name . '</option>';

                } ?>
            </select>
        </p>
        <?php // Image ?>
        <p>
            <label for="<?= $this->get_field_id( 'image_uri' ); ?>">Image</label>
            <img class="<?= $this->id ?>_img" src="<?= (!empty($instance['image_uri'])) ? $instance['image_uri'] : ''; ?>" style="margin:0;padding:0;max-width:100%;display:block"/>
            <input type="text" class="widefat <?= $this->id ?>_url" name="<?= $this->get_field_name( 'image_uri' ); ?>" value="<?= $instance['image_uri']; ?>" style="margin-top:5px;" />
            <input type="button" id="<?= $this->id ?>" class="button button-primary js_custom_upload_media" value="Upload Image" style="margin-top:5px;" />
        </p>
    <?php
    }

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        $instance['text']     = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
        $instance['textarea'] = isset( $new_instance['textarea'] ) ? wp_kses_post( $new_instance['textarea'] ) : '';
        $instance['checkbox'] = isset( $new_instance['checkbox'] ) ? 1 : false;
        $instance['select']   = isset( $new_instance['select'] ) ? wp_strip_all_tags( $new_instance['select'] ) : '';
        $instance['image_uri'] = wp_strip_all_tags( $new_instance['image_uri'] );
        return $instance;
    }

    // Display the widget
    public function widget( $args, $instance ) {

        extract( $args );

        // Check the widget options
        $title      = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $text       = isset( $instance['text'] ) ? $instance['text'] : '';
        $textarea   = isset( $instance['textarea'] ) ?$instance['textarea'] : '';
        $select     = isset( $instance['select'] ) ? $instance['select'] : '';
        $checkbox   = ! empty( $instance['checkbox'] ) ? $instance['checkbox'] : false;
        $image_uri  = isset( $instance['image_uri'] ) ? $instance['image_uri'] : '';

        // WordPress core before_widget hook (always include )
        echo $before_widget;

        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box">';

        // Display widget title if defined
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        // Display text field
        if ( $text ) {
            echo '<p>' . $text . '</p>';
        }

        // Display textarea field
        if ( $textarea ) {
            echo '<p>' . $textarea . '</p>';
        }

        // Display select field
        if ( $select ) {
            echo '<p>' . $select . '</p>';
        }

        // Display something if checkbox is true
        if ( $checkbox ) {
            echo '<p>Something awesome</p>';
        }

        if ( $image_uri )?>
            <img src="<?php echo esc_url($instance['image_uri']); ?>" />
        <?php


        echo '</div>';

        // WordPress core after_widget hook (always include )
        echo $after_widget;

    }

} // Class wpb_widget ends here

/* Stop Adding Functions Below this Line */
?>
