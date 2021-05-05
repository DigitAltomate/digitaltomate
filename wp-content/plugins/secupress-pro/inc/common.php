<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

add_action( 'init', 'secupress_init_license_check_cron' );
/**
 * Initiate the cron that will check for the license validity twice-daily.
 *
 * @since 1.0.3
 * @author Grégory Viguier
 */
function secupress_init_license_check_cron() {
	if ( ! wp_next_scheduled( 'secupress_license_check' ) ) {
		wp_schedule_event( time(), 'twicedaily', 'secupress_license_check' );
	}
}


add_action( 'secupress_license_check', 'secupress_license_check_cron' );
/**
 * Cron that will check for the license validity.
 *
 * @since 1.0.3
 * @author Grégory Viguier
 */
function secupress_license_check_cron() {
	if ( ! secupress_is_pro() ) {
		return;
	}

	$url = SECUPRESS_WEB_MAIN . 'key-api/1.0/?' . http_build_query( array(
		'sp_action'  => 'check_pro_license',
		'user_email' => secupress_get_consumer_email(),
		'user_key'   => secupress_get_consumer_key(),
	) );

	$response = wp_remote_get( $url, array( 'timeout' => 10 ) );

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		return;
	}

	$body = wp_remote_retrieve_body( $response );
	$body = @json_decode( $body );

	if ( ! is_object( $body ) ) {
		return;
	}

	if ( ! empty( $body->success ) && ! empty( $body->data->site_is_pro ) ) {
		// The license is fine.
		return;
	}

	$options = get_site_option( SECUPRESS_SETTINGS_SLUG );
	$options = is_array( $options ) ? $options : array();
	unset( $options['site_is_pro'] );

	if ( ! empty( $body->data->error ) ) {
		// The error code returned by EDD.
		$options['license_error'] = esc_html( $body->data->error );
	}

	secupress_update_options( $options );
}

add_action( 'template_redirect', 'secupress_talk_to_me' );
/**
 * If plugin is active and license is + correct API (client) key is given, it will print the installed version
 *
 * @since 1.4.6
 * @author Julio Potier
 **/
function secupress_talk_to_me() {
	if ( ! secupress_is_pro() || ! isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
		return;
	}
	$consumer_key = secupress_get_option( 'consumer_key' );
	$api_key      = str_replace( 'SECUPRESS_API_KEY:', '', $_SERVER['HTTP_X_REQUESTED_WITH'] );
	if ( false !== $consumer_key && hash_equals( $consumer_key, $api_key ) ) {
		die( SECUPRESS_VERSION );
	}
}

add_action( 'secupress.loaded', 'secupress_check_licence_info' );
/**
 * (admin side only) Redirect to the pricing page if the email is a nulled one
 *
 * @since 1.4.9.5
 * @author Julio Potier
 **/
function secupress_check_licence_info() {
	if ( is_admin() && strpos( secupress_get_consumer_email(), 'nulled' ) !== false ) {
		// Use NULLEDVERSION to get 10% off to buy a real licence of SecuPress, you'll get full support and updates in real time.
		// Need more than 10%? Ask Julio on contact@secupress.me ;)
		wp_redirect( SECUPRESS_WEB_MAIN . __( '/pricing/', 'secupress-pro' ) . '?discount=nulledversion' );
		die();
	}
}
