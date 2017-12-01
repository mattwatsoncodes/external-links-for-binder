<?php
/**
 * Class Controller_Main
 *
 * @since	0.1.0
 *
 * @package mkdo\external_links_for_binder
 */

namespace mkdo\external_links_for_binder;

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
	 * Add additional meta to the binder entry screen.
	 *
	 * @var 	object
	 * @access	private
	 * @since	0.1.0
	 */
	private $meta_binder_add_entry;

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
	 * @param Controller_Assets $controller_assets Enqueue the public and admin assets.
	 * @param Notices_Admin     $notices_admin     Notices on the admin screens.
	 *
	 * @since 0.1.0
	 */
	public function __construct(
		Controller_Assets $controller_assets,
		Meta_Binder_Add_Entry $meta_binder_add_entry,
		Notices_Admin $notices_admin
	) {
		$this->controller_assets     = $controller_assets;
		$this->meta_binder_add_entry = $meta_binder_add_entry;
		$this->notices_admin         = $notices_admin;
	}

	/**
	 * Go.
	 *
	 * @since		0.1.0
	 */
	public function run() {
		load_plugin_textdomain(
			'external-links-for-binder',
			false,
			MKDO_EXTERNAL_LINKS_FOR_BINDER_ROOT . '\languages'
		);

		$this->controller_assets->run();
		$this->meta_binder_add_entry->run();
		$this->notices_admin->run();
	}
}
