<?php
/**
 * External Links for Binder
 *
 * @link              https://github.com/mkdo/external_links_for_binder
 * @package           mkdo\external_links_for_binder
 *
 * Plugin Name:       External Links for Binder
 * Plugin URI:        https://github.com/mkdo/external_links_for_binder
 * Description:       External documents for the Binder Document Management System (DMS) for WordPress.
 * Version:           0.1.0
 * Author:            Make Do <hello@makedo.net>
 * Author URI:        https://makedo.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       external-links-for-binder
 * Domain Path:       /languages
 */

// Abort if this file is called directly.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Constants.
define( 'MKDO_EXTERNAL_LINKS_FOR_BINDER_ROOT', __FILE__ );
define( 'MKDO_EXTERNAL_LINKS_FOR_BINDER_NAME', 'External Links for Binder' );
define( 'MKDO_EXTERNAL_LINKS_FOR_BINDER_PREFIX', 'mkdo_external_links_for_binder' );

// Classes.
require_once 'php/class-helper.php';
require_once 'php/class-controller-assets.php';
require_once 'php/class-controller-main.php';
require_once 'php/class-meta-binder-add-entry.php';
require_once 'php/class-notices-admin.php';

// Namespaces.
use mkdo\external_links_for_binder\Helper;
use mkdo\external_links_for_binder\Controller_Assets;
use mkdo\external_links_for_binder\Controller_Main;
use mkdo\external_links_for_binder\Notices_Admin;
use mkdo\external_links_for_binder\Meta_Binder_Add_Entry;

// Instances.
$controller_assets  	  = new Controller_Assets();
$meta_binder_add_entry    = new Meta_Binder_Add_Entry();
$notices_admin  	      = new Notices_Admin();
$controller_main          = new Controller_Main(
	$controller_assets,
	$meta_binder_add_entry,
	$notices_admin
);

// Go.
$controller_main->run();
