<?php
	if ( !class_exists( 'Post_Functions' ) ) {
		/**
		 * Class Post Extras Functions.
		 */
		class Post_Functions
		{

			/**
			 * Constructor
			 */
			function __construct()
			{
			}

			/**
			 * Get image url and image id of post meta from page url ID.
			 *
			 * @param $page_id ID of page.
			 *
			 * @return array
			 */
			static function get_img_post_meta( $page_id )
			{
				// Get array with meta post of page ind in $item['page_url'].
				// In $meta_post_array[0] is id of image.
				$meta_post_array = get_post_meta( $page_id, 'custom_image_repeat', true );

				if ( isset( $meta_post_array[ 0 ] ) ) {
					$img_id  = $meta_post_array[ 0 ];
					$image   = wp_get_attachment_image_src( $img_id, 'full' );
					$img_url = $image[ 0 ];
					return array( 'image_url' => $img_url, 'image_id' => $img_id );
				} else {
					return __return_empty_array();
				}
			}

			/**
			 * Get images of post met from page url ID.
			 *
			 * @param $page_id
			 *
			 * @return array
			 */
			static function get_imgs_post_meta( $page_id )
			{
				// Get array with meta post of page ind in $item['page_url'].
				// In $meta_post_array[0] is id of image.
				if ( isset( $page_id ) ) {
					$meta_post_array = get_post_meta( $page_id, 'custom_image_repeat', true );

					if ( isset( $meta_post_array ) && $meta_post_array != '' ) {
						$array_images = array();

						foreach ( $meta_post_array as $post_meta ) {
							$img_id  = $post_meta;
							$image   = wp_get_attachment_image_src( $img_id, 'full' );
							$img_url = $image[ 0 ];
							array_push( $array_images, array( 'image_url' => $img_url ) );
						}

						return $array_images;
					} else {
						return __return_empty_array();
					}
				}
			}

			/**
			 * Get images url bu id.
			 *
			 * @param $image_id
			 *
			 * @return null
			 */
			static function get_img_by_id( $image_id )
			{
				$image = wp_get_attachment_image_src( $image_id, 'full' );

				if ( isset( $image ) && !empty( $image ) ) {
					$img_url = $image[ 0 ];

					return $img_url;
				} else {
					return null;
				}

			}

			/**
			 * Get background color of post in the main page.
			 *
			 * @param $post_id
			 *
			 * @return null
			 */
			static function get_main_color_post( $post_id )
			{
				if ( isset( $post_id ) ) {
					$color = get_post_meta( $post_id, 'main_color_post', true );
					if ( isset( $color ) && $color != '#ffffff' ) {
						return $color;
					} else {
						return '#FB6D00';
					}
				}
			}

			/**
			 * Get header color of post in the main page.
			 *
			 * @param $post_id
			 *
			 * @return string
			 */
			static function get_main_color_head( $post_id )
			{
				if ( isset( $post_id ) ) {
					$color = get_post_meta( $post_id, 'main_color_head', true );
					if ( isset( $color ) && $color != '#ffffff' ) {
						return $color;
					} else {
						return '#FFF';
					}
				}
			}

			/**
			 * Get content color of post in the main page.
			 *
			 * @param $post_id
			 *
			 * @return string
			 */
			static function get_main_color_content( $post_id )
			{
				if ( isset( $post_id ) ) {
					$color = get_post_meta( $post_id, 'main_color_content', true );
					if ( isset( $color ) && $color != '#ffffff' ) {
						return $color;
					} else {
						return '#FFF';
					}
				}
			}

			/**
			 * Get content translated by ID post.
			 *
			 * @param        $post_id
			 * @param int    $length
			 * @param string $excerpt_end
			 *
			 * @return mixed|string|void
			 */
			static function get_the_content_by_id( $post_id, $length = 20, $excerpt_end = '' )
			{
				//$the_post   = get_post( $post_id ); //Gets post ID
				$arry_trans = Superior::translator_post_by_id( $post_id );
				$title      = $arry_trans[ 'title' ];
				$content    = apply_filters( 'the_content', $arry_trans[ 'content' ] );

				$content = strip_tags( strip_shortcodes( $content ) ); //Strips tags and images
				$words   = explode( ' ', $content, $length + 1 );
				$words   = preg_replace( '/<h[1-6]>(.*?)<\/h[1-6]>/', '$1', $words );

				if ( count( $words ) > $length ) :
					array_pop( $words );
					array_push( $words, $excerpt_end );
					$content = implode( ' ', $words );
				endif;
				$content = $content;
				return $content;
			}
		}
	}