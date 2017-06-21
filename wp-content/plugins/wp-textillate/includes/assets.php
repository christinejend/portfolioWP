<?php
	/**
	 * Includes needed for the needed frontend assets functionality.
	 *
	 * @since   0.1
	 */

	/**
	 * CSS Register Styles.
	 */

	// Add textillate style.
	wp_enqueue_style( 'textillate-animate', WpTextillate::$plugin_url . 'js/vendors/textillate/animate.css' );
	wp_enqueue_style( 'textillate-style', WpTextillate::$plugin_url . 'js/vendors/textillate/style.css' );

	/**
	 * JavaScript Register Styles.
	 */

	// Textillate plugin.
	wp_enqueue_script( 'textillate-fittext', WpTextillate::$plugin_url . 'js/vendors/textillate/jquery.fittext.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'textillate-lettering', WpTextillate::$plugin_url . 'js/vendors/textillate/jquery.lettering.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'textillate-plugin', WpTextillate::$plugin_url . 'js/vendors/textillate/jquery.textillate.js', array( 'jquery' ), false, true );