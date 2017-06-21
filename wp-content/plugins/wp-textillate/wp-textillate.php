<?php
/*
Plugin Name: Wp Textillate
Plugin URI:
Author: CodeField <codefield.group@gmail.com>
Description: The plugin allows you to add moving text with different animations both widgets and content via shortcode.
Version: 0.0.2
*/

// Avoid name collisions.
if (!class_exists('WpTextillate')) {
    /**
     * Class WpTextillate.
     */
    class WpTextillate
    {
        /**
         * The Plugin version
         *
         * @const string
         */
        const VERSION = '0.0.2';

        /**
         * The url to the plugin
         *
         * @static
         * @var string
         */
        static $plugin_url;

        /**
         * The path to the plugin
         *
         * @static
         * @var string
         */
        static $plugin_dir;

        /**
         * The path to the include plugin
         *
         * @static
         * @var string
         */
        static $include_dir;

        /**
         * The prefix to the Database tables
         *
         * @static
         * @var string
         */
        static $db_prefix;

        /**
         * The prefix for the plugin internationalization
         *
         * @static
         * @var string
         */
        static $i18n_prefix;

        /**
         * The path to the plugin templates files
         *
         * @static
         * @var string
         */
        static $theme_dir;

        /**
         * The path to the plugin templates files
         *
         * @static
         * @var string
         */
        static $theme_url;

        /**
         * The path to the plugin templates files
         *
         * @static
         * @var string
         */
        static $widgets_dir;

        /**
         * The path to the plugin templates files
         *
         * @static
         * @var string
         */
        static $widgets_url;

        /**
         * The Plugin settings
         *
         * @static
         * @var string
         */
        static $options;

        /**
         * Timeout for requests (in seconds)
         *
         * @static
         * @var int
         */
        static $timeout;

        /**
         * Plugin name
         *
         * @static
         * @var int
         */
        static $plugin_name;

        /**
         * Slug name
         *
         * @static
         * @var int
         */
        static $slug_name;

        /**
         * Executes all initialization code for the plugin.
         *
         * @return void
         * @access public
         */
        function WpTextillate()
        {
            // Define static values
            $dir_name = dirname(plugin_basename(__FILE__));

            self::$plugin_url = trailingslashit(WP_PLUGIN_URL . '/' . $dir_name);
            self::$plugin_dir = trailingslashit(WP_PLUGIN_DIR . '/' . $dir_name);

            self::$theme_dir = self::$plugin_dir . 'theme/';
            self::$theme_url = self::$plugin_url . 'theme/';

            self::$include_dir = self::$plugin_dir . 'includes/';

            self::$db_prefix = 'wp_textillate_';
            self::$timeout = 10; // By default is 5
            self::$i18n_prefix = 'textillate';

            self::$plugin_name = 'Wp Textillate';
            self::$slug_name = self::$db_prefix;

            // Operations with Ajax.
            include self::$include_dir . 'ajax.php';

            // Include all classes.
            include self::$include_dir . 'all-classes.php';

            // Enqueues scripts and styles for front end.
            add_action('wp_enqueue_scripts', array(&$this, 'load_front_end_assets'), 0);

            // Enqueues scripts and styles for admin panel.
            add_action('admin_enqueue_scripts', array(&$this, 'load_admin_assets'), 0);

            // Add action to embedded the panel in to dashboard.
            self::add_admin_panel();

            // ShortCodes.
            self::add_shortcodes();

            // Register sidebars.
            self::add_widgets();
        }

        /**
         * Add action to embedded the panel in to dashboard.
         *
         * @return    void
         * @access    public
         * @since     0.1
         */
        function add_admin_panel()
        {

            include self::$include_dir . 'admin/panel.php';
        }

        /**
         * Enqueues scripts and styles for front end.
         *
         * @since superior 0.1
         * @return void
         */
        function load_front_end_assets()
        {
            include self::$include_dir . 'assets.php';
        }

        /**
         * Enqueues scripts and styles for admin panel.
         *
         * @param $hook
         *
         * @since CFTheme 0.1
         * @return void
         */
        function load_admin_assets($hook)
        {

            include self::$include_dir . 'admin/assets.php';
        }

        static function update_main_options()
        {
            // Get all data from db.
            $data = CF_Textillate_Settings::get_options();

            // Update db.
            CF_Textillate_Settings::update_options($data);
        }

        /**
         * Generate random string.
         *
         * @param int $length
         *
         * @return string
         */
        static function generate_random_string($length = 10)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random_string = '';
            for ($i = 0; $i < $length; $i++) {
                $random_string .= $characters[rand(0, strlen($characters) - 1)];
            }

            return $random_string;
        }

        /**
         * Sidebar setup function, Widgets.
         *
         * @return void
         * @access public
         * @since  0.1
         */
        function add_widgets()
        {
            include self::$include_dir . 'widgets.php';
        }

        /**
         * Shortcodes function.
         *
         * @return void
         * @access public
         * @since  0.1
         */
        function add_shortcodes()
        {
            include self::$include_dir . 'shortcodes.php';
        }

        /**
         * Get and show textillate by ID.
         *
         * @param $id
         */
        static function show_textillates($id)
        {
            $options = CF_Textillate_Settings::get_options();

            if ($id != '') {
                foreach ($options['textillates'] as $index => $textillate) {
                    if ($id == $textillate['id']) {
                        ?>
                        <div class="<?php echo $textillate['id']; ?>">
                            <ul class="texts">
                                <?php
                                foreach ($textillate['lines'] as $index1 => $line) {
                                    ?>
                                    <li data-in-effect="<?php echo $line['inEffect'] ?>"
                                        data-in-sync="<?php echo ($line['inAnimation'] == 'sync') ? 'true' : 'false'; ?>"
                                        data-in-sequence="<?php echo ($line['inAnimation'] == 'sequence') ? 'true' : 'false'; ?>"
                                        data-in-reverse="<?php echo ($line['inAnimation'] == 'reverse') ? 'true' : 'false'; ?>"
                                        data-in-shuffle="<?php echo ($line['inAnimation'] == 'shuffle') ? 'true' : 'false'; ?>"

                                        data-out-effect="<?php echo $line['outEffect'] ?>"
                                        data-out-sync="<?php echo ($line['outAnimation'] == 'sync') ? 'true' : 'false'; ?>"
                                        data-out-sequence="<?php echo ($line['outAnimation'] == 'sequence') ? 'true' : 'false'; ?>"
                                        data-out-reverse="<?php echo ($line['outAnimation'] == 'reverse') ? 'true' : 'false'; ?>"
                                        data-out-shuffle="<?php echo ($line['outAnimation'] == 'shuffle') ? 'true' : 'false'; ?>"
                                        >
                                        <?php echo $line['text']; ?>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>

                        <script>
                            jQuery(document).ready(function ($) {
                                $('.<?php echo $textillate[ 'id' ]; ?>').textillate(<?php echo json_encode($textillate[ 'setting' ]); ?>);
                            });
                        </script>

                        <style>
                            <?php if($textillate[ 'setting' ]['autoContent'] == true): ?>
                            . <?php echo $textillate[ 'id' ] ?> {
                                overflow: hidden;
                            }

                            <?php endif; ?>

                            .animated {
                                -webkit-animation-duration: <?php echo $textillate[ 'setting' ]['timeTransition']; ?>s;
                                -moz-animation-duration: <?php echo $textillate[ 'setting' ]['timeTransition']; ?>s;
                                -o-animation-duration: <?php echo $textillate[ 'setting' ]['timeTransition']; ?>s;
                                animation-duration: <?php echo $textillate[ 'setting' ]['timeTransition']; ?>s;
                            }
                        </style>
                    <?php
                    }
                }
            }
        }

        /**
         * Execute code in activation
         *
         * @return    void
         * @access    public
         */
        function install()
        {
            // Update Settings.
            self::update_main_options();
        }

        /**
         * Execute code in deactivation
         *
         * @return    void
         * @access    public
         */
        function deactivation()
        {
            // Remove Settings in case you need.
            delete_option(CF_Textillate_Settings::$db_option);
        }

        /**
         * Execute code in deactivation
         *
         * @return    void
         * @access    public
         */
        function uninstall()
        {
            // Remove Settings in case you need.
            delete_option(CF_Textillate_Settings::$db_option);
        }
    }
}

try {
    // Create new instance of the class.
    $WpTextillate = new WpTextillate();
    if (isset($WpTextillate)) {
        // Register the activation function by passing the reference to our instance.
        register_activation_hook(__FILE__, array(&$WpTextillate, 'install'));
//			register_deactivation_hook( __FILE__, array( &$WpTextillate, 'deactivation' ) );
        register_uninstall_hook(__FILE__, array(&$WpTextillate, 'uninstall'));
    }
} catch (Exception $e) {
    $exit_msg = 'Problem activating: ' . $e->getMessage();
    exit ($exit_msg);
}