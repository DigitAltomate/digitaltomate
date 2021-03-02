<?php
/**
 * Plugin Name: SecuPress Pro — WordPress Security
 * Plugin URI: https://secupress.me
 * Description: More than a plugin, the guarantee of a protected website by experts.
 * Author: SecuPress
 * Author URI: https://secupress.me
 * Version: 1.4.12
 * Code Name: Hotrod
 * Network: true
 * Contributors: SecuPress, juliobox, GregLone
 * License: GPLv2
 * License URI: https://secupress.me/gpl.txt
 *
 * Text Domain: secupress-pro
 * Domain Path: /languages/
 *
 * Copyright 2012-2017 SecuPress
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );


/** --------------------------------------------------------------------------------------------- */
/** DEAL WITH THE FREE VERSION ================================================================== */
/** ----------------------------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'inc/classes/admin/class-secupress-pro-admin-remove-free-plugin.php' );

SecuPress_Pro_Admin_Remove_Free_Plugin::get_instance( __FILE__ );


/** --------------------------------------------------------------------------------------------- */
/** DEFINES ===================================================================================== */
/** ----------------------------------------------------------------------------------------------*/

define( 'SECUPRESS_VERSION',                    '1.4.12' );
define( 'SECUPRESS_PRO_VERSION',                SECUPRESS_VERSION );
define( 'SECUPRESS_FILE',                       __FILE__ );
define( 'SECUPRESS_PATH',                       realpath( dirname( SECUPRESS_FILE ) ) . DIRECTORY_SEPARATOR );
define( 'SECUPRESS_INC_PATH',                   SECUPRESS_PATH . 'core' . DIRECTORY_SEPARATOR );
define( 'SECUPRESS_PRO_INC_PATH',               SECUPRESS_PATH . 'inc' . DIRECTORY_SEPARATOR );
define( 'SECUPRESS_PRO_ADMIN_PATH',             SECUPRESS_PRO_INC_PATH . 'admin' . DIRECTORY_SEPARATOR );
define( 'SECUPRESS_PRO_CLASSES_PATH',           SECUPRESS_PRO_INC_PATH . 'classes' . DIRECTORY_SEPARATOR );
define( 'SECUPRESS_PRO_MODULES_PATH',           SECUPRESS_PRO_INC_PATH . 'modules' . DIRECTORY_SEPARATOR );
define( 'SECUPRESS_PRO_ADMIN_SETTINGS_MODULES', SECUPRESS_PRO_ADMIN_PATH . 'modules' . DIRECTORY_SEPARATOR );


/** --------------------------------------------------------------------------------------------- */
/** INIT ======================================================================================== */
/** ----------------------------------------------------------------------------------------------*/

require_once( SECUPRESS_INC_PATH . 'core.php' );
require_once( SECUPRESS_PRO_INC_PATH . 'functions/pluggable.php' );
require_once( SECUPRESS_PRO_INC_PATH . 'activation.php' );


add_action( 'secupress.loaded', 'secupress_pro_init', 0 );
/**
 * Load the pro version after the free version.
 *
 * @since 1.0
 */
function secupress_pro_init() {
	// Functions.
	secupress_pro_load_functions();

	// Hooks.
	require_once( SECUPRESS_PRO_INC_PATH . 'common.php' );

	if ( ! is_admin() ) {
		return;
	}

	// Hooks.
	require_once( SECUPRESS_PRO_ADMIN_PATH . 'migrate.php' );

	if ( ! secupress_is_pro() ) {
		return;
	}

	if ( is_admin() ) {
		// Free downgrade.
		SecuPress_Pro_Admin_Free_Downgrade::get_instance();
	}

	require_once( SECUPRESS_PRO_ADMIN_PATH . 'admin.php' );
	require_once( SECUPRESS_PRO_ADMIN_PATH . 'ajax-post-callbacks.php' );
}


/**
 * Include files that contain our functions.
 *
 * @since 1.3
 * @author Grégory Viguier
 */
function secupress_pro_load_functions() {
	static $done = false;

	if ( $done ) {
		return;
	}
	$done = true;

	/**
	 * Require our functions.
	 */
	require_once( SECUPRESS_PRO_INC_PATH . 'functions/deprecated.php' );
	require_once( SECUPRESS_PRO_INC_PATH . 'functions/common.php' );

	if ( ! is_admin() ) {
		return;
	}

	// The Free downgrade class.
	secupress_pro_require_class( 'Admin', 'Free_Downgrade' );
}


/** --------------------------------------------------------------------------------------------- */
/** I18N ======================================================================================== */
/** ----------------------------------------------------------------------------------------------*/

add_action( 'secupress.plugin_textdomain_loaded', 'secupress_pro_load_plugin_textdomain_translations', 0 );
/**
 * Translations for the plugin textdomain.
 *
 * @since 1.0
 */
function secupress_pro_load_plugin_textdomain_translations() {
	static $done = false;

	if ( $done ) {
		return;
	}
	$done = true;

	load_plugin_textdomain( 'secupress-pro', false, dirname( plugin_basename( SECUPRESS_FILE ) ) . '/languages' );

	// Make sure Poedit keeps our plugin headers.
	/** Translators: Plugin Name of the plugin/theme */
	__( 'SecuPress Pro — WordPress Security', 'secupress-pro' );
	/** Translators: Description of the plugin/theme */
	__( 'More than a plugin, the guarantee of a protected website by experts.', 'secupress-pro' );
}
