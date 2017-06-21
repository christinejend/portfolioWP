<?php
if (!class_exists('CF_Textillate_Settings')) {
	/**
	 * Class CF_Textillate_Settings
	 *
	 * All Settings the WpTextillate.
	 *
	 */
	class CF_Textillate_Settings {
		/**
		 * The name for plugin options in the DB
		 *
		 * @var string
		 */
		static $db_option = 'WpTextillate_Options';

		/**
		 * Updates the General Settings of Plugin
		 *
		 * @param array $options
		 *
		 * @return array
		 * @access public
		 */
		static public function update_options($options) {
			// Save Class variable
			WpTextillate::$options = $options;

			return update_option(self::$db_option, $options);
		}

		/**
		 * Return the General Settings of Plugin, and set them to default values if they are empty
		 *
		 * @return array general options of plugin
		 * @access public
		 */
		static function get_options() {
			// If isn't empty, return class variable
			if (WpTextillate::$options) {
				return WpTextillate::$options;
			}

			// default values
			$options = array( // Global Settings
				// Textillates content.
				'textillates' => array(),

				// Requirements
				'requirements' => array(
					'wp_version' => '3.5.2',
					'php_version_min' => '5.2.9',
					'php_version_tested' => '5.4.1'), // end requirements
			);

			// get saved options
			$saved = get_option(self::$db_option);

			// assign them
			if (!empty($saved)) {
				foreach ($saved as $key => $option) {
					$options[$key] = $option;
				}
			}

			// update the options if necessary
			if ($saved != $options) {
				update_option(self::$db_option, $options);
			}

			// Save class variable
			WpTextillate::$options = $options;

			//return the options
			return $options;
		}
	}
}
