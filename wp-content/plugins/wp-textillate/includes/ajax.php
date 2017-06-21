<?php

	/**
	 * Operations with Ajax.
	 *
	 * @since   0.1
	 */

	/**
	 * -----------------------------------------------------------------------------------------------------------------
	 * API AngularJS Widgets.
	 * -----------------------------------------------------------------------------------------------------------------
	 */

	/**
	 * CRUDs.
	 */

	add_action( "wp_ajax_get_url_img_by_id", "get_url_img_by_id" );
	/**
	 * Get Image Url by ID.
	 */
	function get_url_img_by_id() {
		$json = str_replace( array( '[', ']', '\\' ), '', $_GET[ 'data' ] );
		$data = json_decode( $json, true );

		$url_img = Post_Functions::get_img_by_id( $data[ 'id' ] );
		if ( $url_img != null ) {
			echo '{"type": "success", "data": "' . $url_img . '"}';
		} else {
			echo '{"type": "error", "msg": "' . __( 'Error: Imagen no encontrada para el ID ' . $data[ 'id' ], WpTextillate::$i18n_prefix ) . '"}';
		}

		die();
	}

	add_action( "wp_ajax_get_all_posts", "get_all_posts" );
	/**
	 * Get all posts.
	 */
	function get_all_posts() {
		CF_Ng_Widgets::get_all_posts();

		die();
	}

	add_action( "wp_ajax_get_all_categories", "get_all_categories" );
	/**
	 * Get all posts.
	 */
	function get_all_categories() {
		CF_Ng_Widgets::get_all_categories();

		die();
	}

	add_action( "wp_ajax_get_posts_by_category", "get_posts_by_category" );
	/**
	 * Get all posts.
	 */
	function get_posts_by_category() {
		$json = str_replace( array( '[', ']', '\\' ), '', $_GET[ 'data' ] );

		CF_Ng_Widgets::get_posts_by_category( $json );

		die();
	}

	add_action( "wp_ajax_get_post_by_id", "get_post_by_id" );
	/**
	 * Get all posts.
	 */
	function get_post_by_id() {
		$json = str_replace( array( '[', ']', '\\' ), '', $_GET[ 'data' ] );

		CF_Ng_Widgets::get_post_by_id( $json );

		die();
	}

	add_action( "wp_ajax_get_options", "get_options" );
	/**
	 * Get all posts.
	 */
	function get_options() {
		CF_Ng_Widgets::get_options();
		die();
	}

	add_action( "wp_ajax_create_textillate", "create_textillate" );
	/**
	 * Create new textillate.
	 */
	function create_textillate() {
		$json = str_replace( array( '[', ']', '\\' ), '', $_GET[ 'data' ] );

		CF_Ng_Widgets::create_textillate( $json );
		die();
	}

	add_action( "wp_ajax_save", "save" );
	/**
	 * Save options.
	 */
	function save() {
		$json = str_replace( array( '\\' ), '', $_GET[ 'data' ] );

		CF_Ng_Widgets::save( $json );
		die();
	}

	add_action( "wp_ajax_delete_textillate", "delete_textillate" );
	/**
	 * Delete textillate.
	 */
	function delete_textillate() {
		$json = str_replace( array( '\\' ), '', $_GET[ 'data' ] );

		CF_Ng_Widgets::delete_textillate( $json );
		die();
	}

	add_action( "wp_ajax_delete_line_of_textillate", "delete_line_of_textillate" );
	/**
	 * Delete line of textillate.
	 */
	function delete_line_of_textillate() {
		$json = str_replace( array( '\\' ), '', $_GET[ 'data' ] );

		CF_Ng_Widgets::delete_line_of_textillate( $json );
		die();
	}