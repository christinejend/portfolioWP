<?php

	add_shortcode( 'wptextillate', 'wptextillate' );
	/**
	 * Shortcode to show wptextillate in Frontend.
	 *
	 * @param $args
	 *
	 * @return string
	 */
	function wptextillate( $atts, $args ) {
		extract( shortcode_atts( array( 'id' => null, 'category' => null ), $atts ) );
		$id    = "{$id}";
		return WpTextillate::show_textillates($id);
	}