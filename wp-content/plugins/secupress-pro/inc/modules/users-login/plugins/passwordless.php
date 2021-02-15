<?php
/**
 * Module Name: PasswordLess Double Authentication
 * Description: When you try to log in, you'll receive an email containing a validation link, without clicking on it, you can't log in.
 * Main Module: users_login
 * Author: SecuPress
 * Version: 1.1.1
 */

defined( 'SECUPRESS_VERSION' ) or die( 'Cheatin&#8217; uh?' );

if ( ! secupress_get_option( 'secupress_passwordless_activation_validation' ) ) {
	return;
}

// EMERGENCY BYPASS!
if ( defined( 'SECUPRESS_ALLOW_LOGIN_ACCESS' ) && SECUPRESS_ALLOW_LOGIN_ACCESS ) {
	return;
}

add_filter( 'authenticate', 'secupress_passwordless_login_authenticate', SECUPRESS_INT_MAX - 10, 3 );
/**
 * Send an email with the new unique login link.
 *
 * @since 1.0
 * @author Julio Potier
 *
 * @param (object) $raw_user A WP_Error object if user is not correctly authenticated, a WP_User object if he is.
 * @param (string) $username A username or email address.
 * @param (string) $password User password.
 *
 * @return (object) A WP_Error or WP_User object.
 */
function secupress_passwordless_login_authenticate( $raw_user, $username, $password ) {
	static $running = false;

	if ( $running ) {
		return $raw_user;
	}
	$running = true;

	// Make sure to process only credentials provided by the login form.
	$username = ! empty( $_POST['log'] ) && $username === $_POST['log'] ? $username : ''; // WPCS: CSRF ok.
	$password = ! empty( $_POST['pwd'] ) && $password === $_POST['pwd'] ? $password : ''; // WPCS: CSRF ok.

	if ( ! $username && ! $password || $username && $password ) {
		$running = false;
		return $raw_user;
	}

	// Errors from other plugins.
	if ( is_wp_error( $raw_user ) ) {
		// Remove WP errors related to empty fields.
		unset( $raw_user->errors['empty_username'], $raw_user->errors['empty_password'] );

		if ( $raw_user->errors ) {
			// There are still errors, don't go further.
			$running = false;
			return $raw_user;
		}
	}

	// Step 2 for the user roles that don't use PasswordLess. The user filled the password (only).
	if ( $password ) {
		$token              = ! empty( $_POST['token'] ) ? $_POST['token'] : ''; // WPCS: CSRF ok.
		$fallback_error_msg = sprintf( __( 'This link is not valid for this user, please try to <a href="%s">log-in again</a>.', 'secupress-pro' ), esc_url( wp_login_url( '', true ) ) );
		$fallback_wp_error  = new WP_Error( 'authentication_failed', $fallback_error_msg );

		if ( ! $token ) {
			$running = false;
			return $fallback_wp_error;
		}

		$users = get_users( array(
			'meta_key'   => 'passwordless_token',
			'meta_value' => $token,
			'fields'     => 'ID',
			'number'     => 1,
		) );

		$userid   = is_array( $users ) && $users ? (int) reset( $users ) : 0;
		$raw_user = $userid ? get_user_by( 'id', $userid ) : false;

		if ( ! secupress_is_user( $raw_user ) ) {
			$running = false;
			return $fallback_wp_error;
		}

		$raw_user = wp_signon( array(
			'user_login'    => $raw_user->user_login,
			'user_password' => $password,
			'remember'      => ! empty( $_POST['rememberme'] ), // WPCS: CSRF ok.
		) );

		// Authentication failed.
		if ( ! secupress_is_user( $raw_user ) ) {
			// Errors from other plugins.
			if ( is_wp_error( $raw_user ) && $raw_user->errors ) {
				$running = false;
				return $raw_user;
			}

			$running = false;
			return $fallback_wp_error;
		}

		$running = false;
		return $raw_user;
	}

	// Step 1 for everybody: try to find the user by username, email, or backup email.
	if ( $username ) {
		$by       = is_email( $username ) ? 'email' : 'login';
		$raw_user = get_user_by( $by, $username );

		if ( ! secupress_is_user( $raw_user ) && 'email' === $by ) {
			// Try the backup email.
			$users = get_users( array(
				'meta_key'   => 'secupress_recovery_email',
				'meta_value' => $username,
				'fields'     => 'ID',
				'number'     => 1,
			) );
			$userid   = is_array( $users ) && $users ? (int) reset( $users ) : 0;
			$raw_user = $userid ? get_user_by( 'id', $userid ) : false;
		}
	}

	// Authentication failed.
	if ( ! secupress_is_user( $raw_user ) ) {
		// Display a vague error message.
		if ( ! is_wp_error( $raw_user ) ) {
			$raw_user = new WP_Error();
		}

		$raw_user->add( 'invalid_username', __( '<strong>ERROR</strong>: Invalid username or email.', 'secupress-pro' ) );
		$running = false;
		return $raw_user;
	}

	// Step 1 succeeded: generate a token.
	$user_is_affected = secupress_is_affected_role( 'users-login', 'double-auth', $raw_user );
	$redirect_to      = ! empty( $_POST['redirect_to'] ) ? wp_unslash( $_POST['redirect_to'] ) : ''; // WPCS: CSRF ok.

	remove_all_filters( 'random_password' );
	$key = wp_generate_password( 32, false );
	update_user_meta( $raw_user->ID, 'passwordless_token', $key );

	if ( ! $user_is_affected ) {
		// Redirect the user to step 2.
		wp_redirect( esc_url_raw( add_query_arg( array( 'action' => 'notpasswordless', 'token' => $key ), wp_login_url( $redirect_to, true ) ) ) );
		die();
	}

	// Send the email and redirect.
	$rememberme = ! empty( $_POST['rememberme'] ); // WPCS: CSRF ok.

	update_user_meta( $raw_user->ID, 'passwordless_timeout', time() + 10 * MINUTE_IN_SECONDS );
	update_user_meta( $raw_user->ID, 'passwordless_rememberme', (int) $rememberme );

	$subject = sprintf( __( '[%s] Secure Login Request', 'secupress-pro' ), '###SITENAME###' );

	/**
	 * Filter the subject of the mail sent to the user.
	 *
	 * @since 1.0
	 *
	 * @param (string) $subject The email subject.
	 */
	$subject   = apply_filters( 'secupress.plugin.passwordless_email_subject', $subject );
	$token_url = admin_url( 'admin-post.php?action=passwordless_autologin&token=' . $key . ( $redirect_to ? '&redirect_to=' . rawurlencode( $redirect_to ) : '' ) );
	$body      = sprintf(
		/** Translators: 1 is a user name, 2 is a blog name, 3 is a URL. */
		__( 'Hello %1$s, a log-in has been requested for %2$s. <a href="%3$s">Open this page to really log in</a>.', 'secupress-pro' ),
		esc_html( $raw_user->display_name ),
		'###SITENAME###',
		esc_url_raw( $token_url )
	);

	/**
	 * Filter the body of the mail sent to the user.
	 *
	 * @since 1.0
	 *
	 * @param (string) $body The email body.
	 */
	$body = apply_filters( 'secupress.plugin.passwordless_email_message', $body );

	secupress_send_mail( $raw_user->user_email, $subject, $body );

	wp_redirect( esc_url_raw( add_query_arg( 'action', 'passwordless_autologin', wp_login_url() ) ) );
	die();
}


add_action( 'login_head', 'secupress_passwordless_buffer_start_login' );
/**
 * Start the buffer if we are on the login page.
 *
 * @since 1.0
 * @author Julio Potier
 */
function secupress_passwordless_buffer_start_login() {
	if ( ! isset( $_GET['action'] ) || 'login' === $_GET['action'] ) {
		ob_start( 'secupress_passwordless_hide_password_field_ob' );
	}
}


add_action( 'login_head', 'secupress_passwordless_buffer_start_notpasswordless' );
/**
 * Start the buffer if we are on the login page, not passwordless.
 *
 * @since 1.0
 * @author Julio Potier
 */
function secupress_passwordless_buffer_start_notpasswordless() {
	if ( isset( $_GET['action'] ) && 'notpasswordless' === $_GET['action'] ) {
		if ( ! empty( $_GET['rememberme'] ) ) {
			$_POST['rememberme'] = 1; // Ugly hack to autocheck the rememberme checkbox without JS. // WPCS: CSRF ok.
		}
		ob_start( 'secupress_passwordless_hide_login_field_ob' );
	}
}


add_action( 'login_footer', 'secupress_passwordless_buffer_stop' );
/**
 * End the buffer if we are on the login page + not passwordless.
 *
 * @since 1.0
 * @author Julio Potier
 */
function secupress_passwordless_buffer_stop() {
	if ( isset( $_GET['action'] ) && 'login' !== $_GET['action'] && 'notpasswordless' !== $_GET['action'] ) {
		return;
	}

	ob_end_flush();

	// Focus the password field.
	if ( ! isset( $_GET['action'] ) || 'notpasswordless' !== $_GET['action'] ) {
		return;
	}

	?>
<script type="text/javascript">
function secupress_attempt_focus() {
	setTimeout( function() {
		try {
			d = document.getElementById( 'user_pass' );
			d.focus();
			d.select();
		} catch( e ) {}
	}, 300 );
}

secupress_attempt_focus();

if ( typeof wpOnload === 'function' ) {
	wpOnload();
}
</script>
	<?php
}


/**
 * Alter the buffer content to hide the password label and field.
 *
 * @since 1.0
 * @author Julio Potier
 *
 * @param (string) $buffer Contains the login page between the action `login_head` and `login_footer`.
 *
 * @return (string)
 */
function secupress_passwordless_hide_password_field_ob( $buffer ) {
	$buffer = preg_replace( '@<p>\s*<label for="user_pass".+?</label>\s*</p>@s', '', $buffer );
	$buffer = preg_replace( '@<label for="user_pass".+?</label>@s', '', $buffer );
	$buffer = preg_replace( '@<div class="wp-pwd">.+?</div>@s', '', $buffer );
	$buffer = str_replace( 'value="' . esc_attr__( 'Log In' ) . '"', 'value="' . esc_attr__( 'Next', 'secupress-pro' ) . '"', $buffer ); // Wording ////.
	return $buffer;
}


/**
 * Alter the buffer content to hide the login label and field.
 *
 * @since 1.0
 * @author Julio Potier
 *
 * @param (string) $buffer Contains the login page between the action `login_head` and `login_footer`.
 *
 * @return (string)
 */
function secupress_passwordless_hide_login_field_ob( $buffer ) {
	$buffer = str_replace( '<label for="user_login"', '<label for="user_login" style="display:none"', $buffer );
	$buffer = str_replace( 'class="forgetmenot"', 'class="forgetmenot" style="display:none"', $buffer );
	return $buffer;
}


add_action( 'login_form', 'secupress_passwordless_add_token_field' );
/**
 * Add the token field to be sent in the next POST form
 *
 * @since 1.0
 * @author Julio Potier
 */
function secupress_passwordless_add_token_field() {
	if ( isset( $_GET['action'], $_GET['token'] ) && 'notpasswordless' === $_GET['action'] ) {
		echo '<input type="hidden" name="token" value="' . esc_attr( $_GET['token'] ) . '">';
	}
}


add_action( 'login_form_passwordless_autologin', 'secupress_passwordless_autologin_validation' );
/**
 * Modify the login header page message for our action
 *
 * @since 1.0
 * @author Julio Potier
 */
function secupress_passwordless_autologin_validation() {
	login_header( __( 'PasswordLess', 'secupress-pro' ), '<p class="message">' . __( 'Check your e-mail containing the confirmation link.', 'secupress-pro' ) . '</p>' );
	login_footer();
	die();
}


add_action( 'admin_post_passwordless_autologin',        'secupress_passwordless_autologin' );
add_action( 'admin_post_nopriv_passwordless_autologin', 'secupress_passwordless_autologin' );
/**
 * Automatically log-in a user with the correct token.
 *
 * @since 1.0
 * @author Julio Potier
 */
function secupress_passwordless_autologin() {
	$user_id            = 0;
	$fallback_error_msg = sprintf( __( 'This link is not valid for this user, please try to <a href="%s">log-in again</a>.', 'secupress-pro' ), esc_url( wp_login_url( '', true ) ) );

	if ( empty( $_GET['token'] ) ) {
		$token = '';

		/**
		 * Triggers an action when an autologin action from the module has failed.
		 *
		 * @since 1.0
		 *
		 * @param (int)    $user_id    The user ID.
		 * @param (string) $token      The security token.
		 * @param (string) $error_code The error code.
		 */
		do_action( 'secupress.plugin.passwordless.autologin_error', $user_id, $token, 'no token' );

		secupress_die( $fallback_error_msg, '', array( 'force_die' => true ) );
	}

	// Get the user with the given token.
	$token   = $_GET['token'];
	// Prevent plugins to filter the users (like "Advanced Access Manager" does …)
	remove_all_actions( 'pre_get_users' );
	// Get the only user with that token
	$user_id = get_users( array(
		'meta_key'   => 'passwordless_token',
		'meta_value' => $token,
		'fields'     => 'ID',
		'number'     => 2, // 2, not 1!
	) );
	$user_id = count( $user_id ) === 1 ? (int) reset( $user_id ) : 0;
	$user    = $user_id ? get_user_by( 'id', $user_id ) : false;

	if ( ! secupress_is_user( $user ) ) {
		/** This action is documented in inc/modules/users-login/plugins/passwordless.php. */
		do_action( 'secupress.plugin.passwordless.autologin_error', $user_id, $token, 'no user' );

		secupress_die( $fallback_error_msg, '', array( 'force_die' => true ) );
	}

	// Test token validity period.
	$requested_redirect_to = ! empty( $_GET['redirect_to'] ) ? rawurldecode( $_GET['redirect_to'] ) : '';
	$time                  = get_user_meta( $user_id, 'passwordless_timeout', true );
	$rememberme            = get_user_meta( $user_id, 'passwordless_rememberme', true );

	delete_user_meta( $user_id, 'passwordless_token' );
	delete_user_meta( $user_id, 'passwordless_rememberme' );
	delete_user_meta( $user_id, 'passwordless_timeout' );

	if ( $time < time() ) {
		// The 10 minutes limit has passed.
		/** This action is documented in inc/modules/users-login/plugins/passwordless.php. */
		do_action( 'secupress.plugin.passwordless.autologin_error', $user_id, $token, 'expired token' );

		$message = sprintf( __( 'This link is now expired, please try to <a href="%s">log-in again</a>.', 'secupress-pro' ), esc_url( wp_login_url( $requested_redirect_to, true ) ) );
		secupress_die( $message, '', array( 'force_die' => true ) );
	}

	// Log in and redirect the user.
	$secure_cookie = is_ssl();
	$secure_args   = array(
		'user_login'    => $user->user_login,
		'user_password' => time(), // We don't have the real password, just pass something.
	);

	/** This filter is documented in wp-includes/user.php. */
	$secure_cookie = apply_filters( 'secure_signon_cookie', $secure_cookie, $secure_args );

	wp_set_auth_cookie( $user_id, (bool) $rememberme, $secure_cookie );

	if ( $requested_redirect_to ) {
		$redirect_to = $requested_redirect_to;
		// Redirect to https if user wants ssl.
		if ( $secure_cookie && false !== strpos( $redirect_to, 'wp-admin' ) ) {
			$redirect_to = preg_replace( '|^http://|', 'https://', $redirect_to );
		}
	} else {
		$redirect_to = admin_url();
	}

	/** This filter is documented in wp-login.php. */
	$redirect_to = apply_filters( 'login_redirect', $redirect_to, $requested_redirect_to, $user );

	/**
	 * Triggers an action when an autologin action from the module is a success.
	 *
	 * @since 1.0
	 *
	 * @param (int)    $user_id The user ID.
	 * @param (string) $token   The security token.
	 */
	do_action( 'secupress.plugin.passwordless.autologin_success', $user_id, $token );

	wp_redirect( esc_url_raw( $redirect_to ) );
	die();
}


add_filter( 'sfml_additional_slugs', 'secupress_passwordless_add_move_login_slug' );
/**
 * Add compatibility to Move Login.
 *
 * @since 1.0
 * @author Grégory Viguier
 *
 * @param (array) $slugs An array of URL slugs (key) and labels (value).
 *
 * @return (array)
 */
function secupress_passwordless_add_move_login_slug( $slugs ) {
	$slugs['notpasswordless'] = __( 'When PasswordLess is activated, for users that don\'t use it', 'secupress-pro' );
	return $slugs;
}
