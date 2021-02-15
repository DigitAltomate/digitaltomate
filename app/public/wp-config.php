<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '8V3zUy2UDcG9LWM8tirWaa1mH2Ny7MDWFPTyaj6Sqlr0XPTknkCltcNs060qyxeailV/TgnWZf3WEldUPQ9zKw==');
define('SECURE_AUTH_KEY',  'Zf68sWo83W3YVhHXsa0RpLevP3YkcsWLzcsA3hPjT8oSsvM/NeSoZVeTAPE+TNK/hf7d8bWuJ00aqZ4ChMnaHg==');
define('LOGGED_IN_KEY',    '0SbhuNH9ktQa1bHxUAQKZoczq3z8ckDs7ThhA2fDqFNlxIrJYQQoBCQSlLeagcnIkfovKUU1zemHODduOFYMIQ==');
define('NONCE_KEY',        'Vv+hfkAhFfASLsgDLmRHUoe57gpsLdVX7C6BgW3k3FJDukTPX/VKYilwG/xa2zzEpMkRv0PrCgqP+3RqVeEJGw==');
define('AUTH_SALT',        'rrqRyWnqqrMgIGq1sfKz4t2jQKrdfIjKfS6R19r70w61Enk1b9b+SZcbo3opPRUIHe1ZjXfOuhEMZxWcC1E7OQ==');
define('SECURE_AUTH_SALT', 'OfgsY/aBtf2eVquIXXPOelxKTQcXWw5ZZ4LvI9/h+peUpzgEa91GgwpvZdEPJ/ZegXlMqGnZK6Zq5qjoJ/7A3g==');
define('LOGGED_IN_SALT',   'pxPxxuSJcwVxYoOYMYLhPVKvFtVHxodJwSBk1aRWqfqJaP3BrwIWF6VIY2U58OLoydil8m37x3RsKScTPp+3Gg==');
define('NONCE_SALT',       'k/QgzmHdThQzA9BOeUAX6HZCezKMQnwTYdicAbFVgAQLWv7E8SVCxL2doK3kDdZG4nZmg+bnwvC0Hiram98Hfg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
