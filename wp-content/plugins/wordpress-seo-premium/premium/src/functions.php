<?php
/**
 * WPSEO plugin file.
 *
 * @package Yoast\WP\SEO\Premium
 */

if ( ! defined( 'WPSEO_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

use Yoast\WP\SEO\Premium\Main;

/**
 * Retrieves the main instance.
 *
 * @phpcs:disable WordPress.NamingConventions -- Should probably be renamed, but leave for now.
 *
 * @return Main The main instance.
 */
function YoastSEOPremium() {
	// phpcs:enable

	static $main;

	if ( $main === null ) {
		// Ensure free is loaded as loading premium will fail without it.
		YoastSEO();
		$main = new Main();
		$main->load();
	}

	return $main;
}
