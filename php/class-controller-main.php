<?php
/**
 * Class Controller_Main
 *
 * @since	0.1.0
 *
 * @package mkdo\ground_control
 */

namespace mkdo\ground_control;

/**
 * The main loader for this plugin
 */
class Controller_Main {

	/**
	 * Enqueue the public and admin assets.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $controller_assets;

	/**
	 * Define the settings page.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $settings;

	/**
	 * Notices on the admin screens.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $notices_admin;

	/**
	 * Constructor.
	 *
	 * @param 	Settings		  $settings          Define the settings page.
	 * @param 	Controller_Assets $controller_assets Enqueue the public and admin assets.
	 * @param 	Notices_Admin     $notices_admin     Notices on the admin screens.
	 *
	 * @since 0.1.0
	 */
	public function __construct(
		Settings $settings,
		Controller_Assets $controller_assets,
		Notices_Admin $notices_admin
	) {
		$this->settings           = $settings;
		$this->controller_assets  = $controller_assets;
		$this->notices_admin	  = $notices_admin;
	}

	/**
	 * Unleash Hell.
	 *
	 * @since		0.1.0
	 */
	public function run() {
		load_plugin_textdomain(
			'ground-control',
			false,
			MKDO_GROUND_CONTROL_ROOT . '\languages'
		);

		$this->settings->run();
		$this->controller_assets->run();
		$this->notices_admin->run();
	}
}
