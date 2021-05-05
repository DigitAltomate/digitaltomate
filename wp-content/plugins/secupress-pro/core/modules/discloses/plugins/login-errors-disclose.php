<?php
/**
 * Module Name: Login Errors Disclose
 * Description: Replace some login error messages.
 * Main Module: discloses
 * Author: SecuPress
 * Version: 1.0
 */

defined( 'SECUPRESS_VERSION' ) or die( 'Cheatin&#8217; uh?' );

add_filter( 'login_errors', 'secupress_replace_login_errors_disclose', SECUPRESS_INT_MAX );
/**
 * Replace some login error messages with a more generic message.
 *
 * @since 1.4.6 Remove "\n" from pattern + new $default value
 * @since 1.0
 *
 * @param (string) $errors Login error message.
 *
 * @return (string)
 */
function secupress_replace_login_errors_disclose( $errors ) {
	$pattern = secupress_login_errors_disclose_get_messages();

	$pattern = '@\s(' . implode( '|', $pattern ) . ')<br />@';
	$default = __( '<strong>Authentication failed</strong>.', 'secupress' );

	return preg_replace( $pattern, $default, $errors );
}
