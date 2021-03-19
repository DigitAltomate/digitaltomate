<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/** --------------------------------------------------------------------------------------------- */
/** HALP!!! ===================================================================================== */
/** ----------------------------------------------------------------------------------------------*/

add_action( 'secupress.services.ask_for_support', 'secupress_pro_send_support_request', 10, 4 );
/**
 * Send an email message to our awesome support team (yes it is).
 *
 * @since 1.0.3
 * @author Grégory Viguier
 *
 * @param (string) $summary          A title. The value is not escaped.
 * @param (string) $description      A message. The value has been sanitized with `wp_kses()`.
 * @param (array)  $data             An array of infos related to the site:
 *                                   // Support request.
 *                                      - (string) $support_scanner   The title of the scanner the user asks help for.
 *                                   // License.
 *                                      - (string) $license_email     The email adress used for the license.
 *                                      - (string) $license_key       The license key.
 *                                      - (string) $site_url          Site URL.
 *                                   // SecuPress.
 *                                      - (string) $sp_free_version   Version of SecuPress Free.
 *                                      - (string) $sp_pro_version    Version of SecuPress Pro | Version of SecuPress Free required by SecuPress Pro.
 *                                      - (string) $sp_active_plugins List of active sub-modules.
 *                                   // WordPress.
 *                                      - (string) $wp_version        Version of WordPress.
 *                                      - (string) $is_multisite      Tell if it's a multisite: Yes or No.
 *                                      - (string) $is_ssl            Tell if SSL is used in back and front: Yes or No.
 *                                      - (string) $server_type       Apache, Nginx, or IIS.
 *                                      - (string) $wp_active_plugins List of active WordPress plugins.
 * @param (object) $support_instance The `SecuPress_Admin_Support` instance.
 */
function secupress_pro_send_support_request( $summary, $description, $data, $support_instance ) {
	$current_user = wp_get_current_user();

	$summary = esc_html( $summary );
	if ( function_exists( 'mb_convert_encoding' ) ) {
		$summary = preg_replace_callback( '/(&#[0-9]+;)/', function( $m ) {
			return mb_convert_encoding( $m[1], 'UTF-8', 'HTML-ENTITIES' );
		}, $summary );
	}
	$summary = wp_specialchars_decode( $summary );

	$data = array_merge( array(
		// Support request.
		'support_email'   => sanitize_email( $current_user->data->user_email ),
		'support_subject' => $summary,
		'support_message' => $description,
		'support_locale'  => get_locale(),
	), $data );

	$url = SECUPRESS_WEB_MAIN . 'key-api/1.0/?sp_action=send_support_request';

	// Send the request.
	$response = wp_remote_post( $url, array(
		'timeout' => 10,
		'body'    => $data,
	) );
	$error = false;

	// Deal with the response.
	if ( is_wp_error( $response ) ) {
		// The request couldn't be sent.
		$error = 'request_error';
	}
	elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
		// The server couldn't be reached. Maybe a server error or something.
		$error = 'server_error';
	} else {
		$body = wp_remote_retrieve_body( $response );
		$body = @json_decode( $body );

		if ( ! is_object( $body ) ) {
			// The response is not a json.
			$error = 'server_bad_response';
		}
		elseif ( empty( $body->success ) ) {
			// The response is not a success.
			if ( ! empty( $body->data->code ) ) {
				$error = $body->data->code;
			} else {
				$error = true;
			}
		}
	}

	if ( ! $error ) {
		secupress_add_settings_error( 'general', 'message_sent', __( 'Your message has been sent, we will come back to you shortly. Thank you.', 'secupress-pro' ), 'updated' );
	} else {
		$messages = array(
			'request_error'       => __( 'Something on your website is preventing the request to be sent.', 'secupress-pro' ),
			'server_error'        => __( 'Our server is not accessible at the moment.', 'secupress-pro' ),
			'server_bad_response' => __( 'Our server returned an unexpected response and might be in error.', 'secupress-pro' ),
			// Some of the error codes that can be received.
			'invalid_license'     => __( 'Our server returned an error related to your license.', 'secupress-pro' ),
			'invalid_license_key' => __( 'Our server returned an error related to your license key.', 'secupress-pro' ),
			'invalid_customer'    => __( 'Our server returned an error related to your customer account.', 'secupress-pro' ),
		);
		$message1 = ! empty( $messages[ $error ] ) ? $messages[ $error ] : __( 'Your message could not be sent.', 'secupress-pro' );
		/** Translators: %s is an email address. */
		$message2 = __( 'Please send your message manually to %s. Thank you.', 'secupress-pro' );
		$message  = is_rtl() ? $message2 . ' ' . $message1 : $message1 . ' ' . $message2;

		$to          = 'sserpuces';
		$to          = strrev( 'em.' . $to . chr( 64 ) . 'troppus' );
		$summary     = str_replace( '+', '%20', urlencode( $summary ) );
		$data        = $support_instance->get_formatted_data();
		$data        = '<br/>' . str_repeat( '-', 40 ) . '<br/>' . implode( '<br/>', $data );
		$description = str_replace( array( '+', '%3E%0A' ), array( '%20', '%3E' ), urlencode( $description . $data ) );
		$url         = 'mailto:' . $to . '?subject=' . $summary . '&body=' . $description;

		secupress_add_settings_error( 'general', 'message_failed', sprintf(
			$message,
			'<a href="' . esc_url( $url ) . '">' . $to . '</a>'
		) );
	}
}
