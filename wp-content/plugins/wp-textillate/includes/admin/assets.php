<?php
	/**
	 * Includes needed for the needed admin assets functionality.
	 *
	 * @since   0.1
	 */
	global $post;

	/**
	 * CSS Register Styles.
	 */

	/**
	 * Register style in admin panel.
	 *
	 * @since CFPlugin 0.1
	 */
	function register_admin_panel_styles() {

		wp_enqueue_style( 'bootstrap', WpTextillate::$plugin_url . 'js/vendors/bootstrap/css/bootstrap.min.css' );
		wp_enqueue_style( 'gritter', WpTextillate::$plugin_url . 'js/vendors/gritter/css/jquery.gritter.min.css' );
		wp_enqueue_style( 'bootstrap-switch', WpTextillate::$plugin_url . 'js/vendors/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css' );
		wp_enqueue_style( 'chosen', WpTextillate::$plugin_url . 'js/vendors/angularjs/chosen/chosen.css' );
		wp_enqueue_style( 'chosen-spinner', WpTextillate::$plugin_url . 'js/vendors/angularjs/chosen/chosen-spinner.css' );
		wp_enqueue_style( 'textillate-animate', WpTextillate::$plugin_url . 'js/vendors/textillate/animate.css' );
		wp_enqueue_style( 'textillate-style', WpTextillate::$plugin_url . 'js/vendors/textillate/style.css' );
		wp_enqueue_style( 'custom', WpTextillate::$plugin_url . 'css/admin/styles.css' );
	}

	/**
	 * JavaScript Register Styles.
	 */

	/**
	 * Register script in admin panel.
	 *
	 * @since CFPlugin 0.1
	 */
	function register_admin_panel_scripts() {
		wp_register_script( 'jquery', WpTextillate::$plugin_url . 'js/vendors/jquery.min.js' );
		wp_enqueue_script( 'jquery' );

		// Enqueues all scripts, styles, settings, and templates necessary to use all media JavaScript APIs.
		wp_enqueue_media();

		// Loads bootstrap js.
		wp_enqueue_script( 'bootstrap', WpTextillate::$plugin_url . 'js/vendors/bootstrap/js/bootstrap.min.js', array( 'jquery' ), false, true );

		// Bootstrap Switch: Turn checkboxes and radio buttons in toggle switches.
		wp_enqueue_script( 'bootstrap-switch', WpTextillate::$plugin_url . 'js/vendors/bootstrap-switch/js/bootstrap-switch.min.js', array( 'jquery' ), false, true );

		// Chosen is a jQuery based replacement for select boxes.
		wp_enqueue_script( 'chosen', WpTextillate::$plugin_url . 'js/vendors/angularjs/chosen/chosen.jquery.js', array( 'jquery' ), false, true );

		// Gritter Plugin of notifications.
		wp_enqueue_script( 'gritter', WpTextillate::$plugin_url . 'js/vendors/gritter/js/jquery.gritter.min.js', array( 'jquery' ), false, true );

		// Textillate plugin.
		wp_enqueue_script( 'textillate-fittext', WpTextillate::$plugin_url . 'js/vendors/textillate/jquery.fittext.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'textillate-lettering', WpTextillate::$plugin_url . 'js/vendors/textillate/jquery.lettering.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'textillate-plugin', WpTextillate::$plugin_url . 'js/vendors/textillate/jquery.textillate.js', array( 'jquery' ), false, true );

		// Extra functions (notifications, etc).
		wp_enqueue_script( 'cf-notification', WpTextillate::$plugin_url . 'js/notification.js', array( 'jquery' ), false, true );

		// Angularjs.
		wp_enqueue_script( 'angular-core', WpTextillate::$plugin_url . 'js/vendors/angularjs/angular.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'angular-resource', WpTextillate::$plugin_url . 'js/vendors/angularjs/angular-resource.min.js', array( 'angular-core' ), false, true );
		wp_enqueue_script( 'angular-routes', WpTextillate::$plugin_url . 'js/vendors/angularjs/angular-route.min.js', array( 'angular-core' ), false, true );

		// Angularjs app.
		wp_enqueue_script( 'angular-app', WpTextillate::$plugin_url . 'js/app/app.js', array( 'angular-core' ), false, true );

		// Controllers Angularjs.
		wp_enqueue_script( 'angular-controller-textillate', WpTextillate::$plugin_url . 'js/app/controllers/textillate.js', array( 'angular-app' ), false, true );

        // Filters Angularjs.
        wp_enqueue_script( 'angular-filters-textillate', WpTextillate::$plugin_url . 'js/app/filters/filters.js', array( 'angular-app' ), false, true );

		// Directives Angularjs.
		wp_enqueue_script( 'angular-directives', WpTextillate::$plugin_url . 'js/app/directives/directives.js', array( 'angular-app' ), false, true );

		// Model Angularjs.
		wp_enqueue_script( 'angular-wp-model', WpTextillate::$plugin_url . 'js/app/model/wp.js', array( 'angular-app' ), false, true );

		// External Directives.
		// Chosen is a jQuery based replacement for select boxes.
		wp_enqueue_script( 'chosen-single', WpTextillate::$plugin_url . 'js/vendors/angularjs/chosen/chosen.js', array( 'chosen',
			'angular-app'
		), false, true );

		//- LOCALIZE

		//wp_localize_script( 'angular-core', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_localize_script( 'angular-core', 'Directory', array( 'url'    => get_bloginfo( 'template_directory' ),
																'site'   => get_bloginfo( 'wpurl' ),
																'public' => WpTextillate::$plugin_url
		) );
	}