<?php
defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'Cheatin&#8217; uh?' );

$settings = get_site_option( 'secupress_settings' );

if ( is_array( $settings ) && ! empty( $settings['consumer_email'] ) && ! empty( $settings['consumer_key'] ) ) {
	// Deactivate the license.
	$settings['consumer_email'] = sanitize_email( $settings['consumer_email'] );
	$settings['consumer_key']   = sanitize_text_field( $settings['consumer_key'] );

	if ( ! empty( $settings['consumer_email'] ) && ! empty( $settings['consumer_key'] ) ) {
		$url  = 'https://secupress.me/';
		$url .= 'key-api/1.0/?' . http_build_query( array(
			'sp_action'  => 'deactivate_pro_license',
			'user_email' => $settings['consumer_email'],
			'user_key'   => $settings['consumer_key'],
		) );

		$args = array(
			'timeout'  => 0.01,
			'blocking' => false,
		);

		if ( ! function_exists( 'secupress_add_own_ua' ) ) {
			/** This filter is documented in wp-includes/class-http.php. */
			$user_agent      = apply_filters( 'http_headers_useragent', 'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_bloginfo( 'url' ) );
			$version         = '1.4.12';
			$args['headers'] = array(
				'X-SECUPRESS' => sprintf( '%s;SecuPress|%s|%s|;', $user_agent, $version, esc_url( home_url() ) ),
			);
		}

		wp_remote_get( $url, $args );
	}

	/**
	 * If we uninstall only the Pro version, we need to remove those values from the settings, or the license key will be shown as active while it's not.
	 * Side note: we don't check our server response. That means there's a possibility that it's not reachable, then the license key will remain active on our side.
	 */
	unset( $settings['consumer_email'], $settings['consumer_key'], $settings['site_is_pro'] );
	update_site_option( 'secupress_settings', $settings );
}

if ( defined( 'SECUPRESS_FILE' ) ) {
	$secupress_free_plugin_path = SECUPRESS_FILE;
} else {
	$secupress_free_plugin_path = dirname( dirname( __FILE__ ) ) . '/secupress/secupress.php';
}

if ( ! file_exists( $secupress_free_plugin_path ) ) {
	// Launch core uninstall scripts only if the Free version is not installed.
	require_once( plugin_dir_path( __FILE__ ) . 'uninstall-core.php' );
}
