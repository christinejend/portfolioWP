<?php
	/**
	 * Angular Widgets Loads.
	 *
	 * @package    Generic
	 * @subpackage Generic Theme
	 * @since      0.1
	 */

	if ( ! class_exists( 'CF_Ng_Widgets' ) ) {
		/**
		 * Class CF_Ng_Widgets
		 */
		class CF_Ng_Widgets {
			/**
			 * The path of AngularJS Widgets.
			 *
			 * @static
			 * @var string
			 */
			static $path_hg_widgets;

			/**
			 * The path of AngularJS Widgets config.json file.
			 *
			 * @static
			 * @var string
			 */
			static $hg_config_widgets;

			/**
			 * Name of the template list key.
			 *
			 * @static
			 * @var string
			 */
			static $template_list_name;

			/**
			 * A string containing the name of the meta value you want.
			 *
			 * @static
			 * @var string
			 */
			static $custom_widget_post_key;

			/**
			 * Constructor
			 */
			function __construct() {
				self::$path_hg_widgets   = CFTheme::$theme_dir . 'js/app/widgets/';
				self::$hg_config_widgets = CFTheme::$theme_dir . 'js/app/config.json';

				// Template.
				self::$template_list_name     = 'widget_post_templates';
				self::$custom_widget_post_key = 'widget_custom_';
			}

			/**
			 * Convert json to array.
			 *
			 * @param $json
			 *
			 * @return mixed
			 */
			function convert_json_to_array( $json ) {
				$data = json_decode( $json, true );

				return $data;
			}

			/**
			 * Mount assets of extra widgets.
			 *
			 * @param $json
			 */
			function mount_enqueue_script_widgets( $json ) {
				$data = self::convert_json_to_array( $json );

				// Mount all. js each list widgets.
				foreach ( $data[ 'widgets' ] as $value ) {
					wp_register_script( $value[ 'slug' ], CFTheme::$theme_url . $data[ 'path' ] . $value[ 'slug' ] . '/controller.js', array( 'app-js' ), null, false );
					wp_enqueue_script( $value[ 'slug' ] );
				}
			}

			/**
			 * Substitute the function get_post_meta by cf_get_post_meta.
			 * Esto es para en caso de que un día cambie la función "get_post_meta" de wordpress solo sea cambiarla en un solo lugar.
			 *
			 * @param $id    Is the ID of page or post.
			 * @param $token Token of Wodget.
			 *
			 * @return mixed Array.
			 */
			static function cf_get_post_meta( $id, $token ) {
				return get_post_meta( $id, self::$custom_widget_post_key . $token );
			}

			/**
			 * Get all Posts and return to json format.
			 */
			static function get_all_posts() {
				$arg = array( 'numberposts' => '-1', 'category' => '', 'post_type' => array( 'page', 'post' ) );

				$posts = get_posts( $arg );

				$array = array();

				foreach ( $posts as $post ) {
					array_push( $array, array( 'id'    => $post->ID,
											   'title' => $post->post_title,
											   'type'  => strtoupper( $post->post_type )
					) );
				}

				echo json_encode( $array );
			}

			/**
			 * Get posts by category.
			 *
			 * @param $json
			 */
			static function get_posts_by_category( $json ) {
				$data = json_decode( $json, true );

				$args = array( 'numberposts' => $data[ 'cant' ],
							   'category'    => $data[ 'id' ],
							   'numberposts' => - 1,
							   'post_type'   => array( 'page', 'post' )
				);

				$posts = get_posts( $args );
				$array = array();

				foreach ( $posts as $post ) {
					$image_post = Post_Functions::get_img_post_meta( $post->ID );
					$image_url  = CFTheme::$theme_url . '/images/not_exist.png';
					if ( ! empty( $image_post ) ) {
						$image_url = $image_post[ 'image_url' ];
					}
					array_push( $array, array( 'id'        => $post->ID,
											   'title'     => $post->post_title,
											   'image_url' => $image_url,
											   'type'      => strtoupper( $post->post_type )
					) );
				}

				echo json_encode( $array );
			}

			/**
			 * Get all Categories and return to json format.
			 */
			static function get_all_categories() {
				$args = array();

				$categories = get_categories( $args );

				$array = array();

				foreach ( $categories as $category ) {
					array_push( $array, array( 'id'    => $category->cat_ID,
											   'title' => $category->name,
											   'slug'  => $category->slug
					) );
				}

				echo json_encode( $array );
			}

			/**
			 * Get Post by ID, and include url of our images.
			 *
			 * @param $json
			 */
			static function get_post_by_id( $json ) {
				$data = json_decode( $json, true );

				// Get post.
				$post = get_post( $data[ 'id' ] );

				// Get images of post.
				$array_images = Post_Functions::get_imgs_post_meta( $post->ID );

				$array = array( 'post'   => array( 'id'    => $post->ID,
												   'title' => $post->post_title,
												   'type'  => strtoupper( $post->post_type )
				),
								'url'    => get_permalink( $post->ID ),
								'images' => $array_images
				);

				echo json_encode( $array );
			}

			/**
			 * Create new textillate.
			 *
			 * @param $json
			 */
			static function create_textillate( $json ) {
				$data = json_decode( $json, true );

				$options     = CF_Textillate_Settings::get_options();
				$textillates = $options[ 'textillates' ];

				array_push( $textillates, array( 'id'   => WpTextillate::generate_random_string(),
												 'name' => $data[ 'name' ]
				) );

				$options[ 'textillates' ] = $textillates;

				CF_Textillate_Settings::update_options( $options );
				echo json_encode( $options );
			}

			/**
			 * Save options.
			 *
			 * @param $json
			 */
			static function save( $json ) {
				$data = json_decode( $json, true );

				CF_Textillate_Settings::update_options( $data );
				$options = CF_Textillate_Settings::get_options();
				echo json_encode( $options );
			}

			/**
			 * Delete textillate.
			 *
			 * @param $json
			 */
			static function delete_textillate( $json ) {
				$data = json_decode( $json, true );

				$tmpArrayTextillate = array();

				$options = CF_Textillate_Settings::get_options();
				foreach ( $options[ 'textillates' ] as $item => $textillate ) {
					if ( $data[ 'id' ] != $textillate[ 'id' ] ) {
						array_push( $tmpArrayTextillate, $textillate );
					}
				}

				$options[ 'textillates' ] = $tmpArrayTextillate;

				CF_Textillate_Settings::update_options( $options );
				$options = CF_Textillate_Settings::get_options();
				echo json_encode( $options );
			}

			/**
			 * Delete line of textillate.
			 *
			 * @param $json
			 */
			static function delete_line_of_textillate( $json ) {
				$data = json_decode( $json, true );

				$tmpArrayLines = array();
				$tmpArrayTextillate = array();

				$options = CF_Textillate_Settings::get_options();
				foreach ( $options[ 'textillates' ] as $item => $textillate ) {
					if ( $data[ 'idTextillateParent' ] == $textillate[ 'id' ] ) {
						foreach ( $textillate[ 'lines' ] as $item1 => $line ) {
							if ( $data[ 'id' ] != $line[ 'id' ] ) {
								array_push( $tmpArrayLines, $line );
							}
						}
						$textillate[ 'lines' ] = $tmpArrayLines;
					}
					array_push( $tmpArrayTextillate, $textillate );
				}

				$options[ 'textillates' ] = $tmpArrayTextillate;

				CF_Textillate_Settings::update_options( $options );
				$options = CF_Textillate_Settings::get_options();
				echo json_encode( $options );
			}

			/**
			 * Get options of plugin.
			 */
			static function get_options() {
				$options = CF_Textillate_Settings::get_options();
				echo json_encode( $options );
			}

			/**
			 * Throw error.
			 */
			static function error() {
				echo '{"type": "error", "data": {"error": "error", "msg": "' . __( 'Error: Los datos enviados no son válidos', CFTheme::$i18n_prefix ) . '"}}';
			}
		}
	}
