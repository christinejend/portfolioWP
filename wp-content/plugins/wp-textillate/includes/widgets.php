<?php
    /**
     * This file will eventually place the codes for plugin widgets.
     *
     * @package    WpTextillate
     * @subpackage WpTextillate Plugin
     * @since      WpTextillate 0.1
     */
    add_action( 'widgets_init', 'cf_widgets_wptextillate_init', 1 );

    // Register Widgets.
    function cf_widgets_wptextillate_init() {
        // Widget Main Search.
        register_widget( 'WpTextillate_Widget' );
    }

    /**
     * WpTextillate_Widget class.
     *
     * @since   WpTextillate 0.1
     * @extends WP_Widget
     */
    class WpTextillate_Widget extends WP_Widget {
        /**
         * Constructor.
         *
         * @since 0.1
         */
        public function __construct() {
            $widget_args = array(
                'classname'   => 'wptextillate_widget',
                'description' => __( 'Textillate.js combines some awesome libraries to provide an easy-to-use plugin for applying CSS3 animations to any text.', WpTextillate::$i18n_prefix ),
            );
            $this->WP_Widget( 'wptextillate_widget', 'Wp Textillate', $widget_args );
        }

        public function form( $instance ) {
            $options     = CF_Textillate_Settings::get_options();
            $textillates = $options[ 'textillates' ];
            ?>

            <br />
            <label><?php _e( 'Select textillate.', WpTextillate::$i18n_prefix ) ?></label>
            <br />
            <select name="<?php echo $this->get_field_name( 'id' ); ?>" id="<?php echo $this->get_field_id( 'id' ); ?>">
                <option value=" "></option>
                <?php if ( ! empty( $textillates ) ) : ?>
                    <?php foreach ( $textillates as $textillate ): ?>
                        <option value="<?php echo $textillate[ 'id' ]; ?>" <?php if (isset( $instance[ 'id' ] ) && $instance[ 'id' ] == $textillate[ 'id' ]): ?>selected="selected"<?php endif ?>><?php echo $textillate[ 'name' ]; ?></option>
                    <?php endforeach ?>
                <?php endif; ?>
            </select>
            <br />
            <br />

        <?php
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance[ 'id' ] = $new_instance[ 'id' ];

            return $instance;
        }

        public function widget( $args, $instance ) {
            extract( $args );

            if ( class_exists( 'WpTextillate' ) ) {
                WpTextillate::show_textillates( $instance[ 'id' ] );
            }
        }
    }