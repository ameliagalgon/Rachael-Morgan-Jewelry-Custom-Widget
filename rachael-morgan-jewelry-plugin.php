<?php
/*
Plugin Name: Site Plugin for rachaelmorganjewelry.com
Description: Site specific code changes for rachaelmorganjewelry.com
*/
/* Start Adding Functions Below this Line */

// Register and load the widget
function wpb_load_widget() {
    register_widget( 'rachael_morgan_jewelry_landing_widget' );
    register_widget('rachael_morgan_jewelry_collection_widget');
}
add_action( 'widgets_init', 'wpb_load_widget' );

// Enqueue additional admin scripts
add_action('admin_enqueue_scripts', 'wpb_load_script');
function wpb_load_script() {
    wp_enqueue_media();
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('ads_script', plugin_dir_url( __FILE__ ) . '/js/widget.js', false, '1.0.0', true);
}

// Creating the landing widget
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

        $defaults = array(
            'logo_uri'      => '',
            'image_uri'     => ''
        );

        //extract( wp_parse_args($instance, $defaults));
        extract( wp_parse_args( ( array ) $instance, $defaults ) );

        // Logo ?>
        <p>
            <label for="<?= $this->get_field_id( 'logo_uri' ); ?>">Image</label>
            <img class="<?= $this->id ?>-logo_img" src="<?= (!empty($instance['logo_uri'])) ? $instance['logo_uri'] : ''; ?>" style="margin:0;padding:0;max-width:100%;display:block"/>
            <input type="text" class="widefat <?= $this->id ?>-logo_url" name="<?= $this->get_field_name( 'logo_uri' ); ?>" value="<?= $instance['logo_uri']; ?>" style="margin-top:5px;" />
            <input type="button" id="<?= $this->id ?>-logo" class="button button-primary js_custom_upload_media" value="Upload Logo" style="margin-top:5px;" />
        </p>

        <?php // Image ?>
        <p>
            <label for="<?= $this->get_field_id( 'image_uri' ); ?>">Image</label>
            <img class="<?= $this->id ?>-image_img" src="<?= (!empty($instance['image_uri'])) ? $instance['image_uri'] : ''; ?>" style="margin:0;padding:0;max-width:100%;display:block"/>
            <input type="text" class="widefat <?= $this->id ?>-image_url" name="<?= $this->get_field_name( 'image_uri' ); ?>" value="<?= $instance['image_uri']; ?>" style="margin-top:5px;" />
            <input type="button" id="<?= $this->id ?>-image" class="button button-primary js_custom_upload_media" value="Upload Image" style="margin-top:5px;" />
        </p>

    <?php
    }

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['logo_uri'] = wp_strip_all_tags( $new_instance['logo_uri'] );
        $instance['image_uri'] = wp_strip_all_tags( $new_instance['image_uri'] );
        return $instance;
    }

    // Display the widget
    public function widget( $args, $instance ) {

        extract( $args );

        // Check the widget options
        $image_uri  = isset( $instance['image_uri'] ) ? $instance['image_uri'] : '';
        $logo_uri   = isset( $instance['logo_uri'] ) ? $instance['logo_uri'] : '';

        // WordPress core before_widget hook (always include )
        echo $before_widget;

        // Display the widget
        echo '<div class="widget_content_box wp_widget_plugin_box">';

        if ( $logo_uri )?>
            <img id="landing-logo" src="<?php echo esc_url($instance['logo_uri']); ?>" />
        <?php

        if ( $image_uri )?>
            <img id="landing-img" src="<?php echo esc_url($instance['image_uri']); ?>" />
        <?php


        echo '</div>';
        
        // WordPress core after_widget hook (always include )
        echo $after_widget;

    }

} // Class wpb_widget ends here

class rachael_morgan_jewelry_collection_widget extends WP_Widget {

    function __construct() {
        parent::__construct(

        // Base ID of your widget
            'rachael_morgan_jewelry_collection_widget',

            // Widget name will appear in UI
            __('Rachael Morgan Jewelry Collection Widget', 'text_domain'),

            // Widget description
            array ('description'                 => __( 'Sample widget based on WPBeginner Tutorial', 'text_domain' ),
                'customize_selective_refresh'   => true,
                'classname'                     => 'widget_rachael-morgan-jewelry-collection'
            )
        );
    }

    // Widget Backend
    public function form( $instance ) {

        $defaults = array(
            'title'         => '',
            'description'   => '',
            'link'          => '',
            'image_uri'     => ''
        );

        //extract( wp_parse_args($instance, $defaults));
        extract( wp_parse_args( ( array ) $instance, $defaults ) );

        // Title ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <?php // Description ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( 'Description:', 'text_domain' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo wp_kses_post( $textarea ); ?></textarea>
        </p>

        <?php // Link ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php _e( 'Link', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
        </p>

        <?php // Image ?>
        <p>
            <label for="<?= $this->get_field_id( 'image_uri' ); ?>">Image</label>
            <img class="<?= $this->id ?>-image_url" src="<?= (!empty($instance['image_uri'])) ? $instance['image_uri'] : ''; ?>" style="margin:0;padding:0;max-width:100%;display:block"/>
            <input type="text" class="widefat <?= $this->id ?>-image_url" name="<?= $this->get_field_name( 'image_uri' ); ?>" value="<?= $instance['image_uri']; ?>" style="margin-top:5px;" />
            <input type="button" id="<?= $this->id ?>-image" class="button button-primary js_custom_upload_media" value="Upload Image" style="margin-top:5px;" />
        </p>

        <?php
    }

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        $instance['link']     = isset( $new_instance['link'] ) ? wp_strip_all_tags( $new_instance['link'] ) : '';
        $instance['description'] = isset( $new_instance['description'] ) ? wp_kses_post( $new_instance['description'] ) : '';
        $instance['image_uri'] = wp_strip_all_tags( $new_instance['image_uri'] );
        return $instance;
    }

    // Display the widget
    public function widget( $args, $instance ) {

        extract( $args );

        // Check the widget options
        $title          = isset( $instance['title'] ) ? $instance['title'] : '';
        $description    = isset( $instance['description'] ) ? $instance['description'] : '';
        $link           = isset( $instance['link'] ) ? $instance['link'] : '';
        $image_uri      = isset( $instance['image_uri'] ) ? $instance['image_uri'] : '';

        // WordPress core before_widget hook (always include )
        echo $before_widget;

        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box">';

        // Display widget title if defined
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        // Display textarea field
        if ( $description ) {
            echo '<p>' . $description . '</p>';
        }

        if ( $link ) {
            echo '<a href="' . $link . '"><p>' . $link . '</p></a>';
        }

        if ( $logo_uri )?>
            <img src="<?php echo esc_url($instance['logo_uri']); ?>" />
        <?php

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
