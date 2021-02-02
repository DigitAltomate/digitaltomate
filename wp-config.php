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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u925013848_saasy' );

/** MySQL database username */
define( 'DB_USER', 'u925013848_saasy' );

/** MySQL database password */
define( 'DB_PASSWORD', 'k1Krcrj/B=Y' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '$Fkaq6JCc2X /K.,%/5@$G?iFdCrt3]YnW^ew7:8YL6%[+(q<`7DAkZkb4Moe0_-' );
define( 'SECURE_AUTH_KEY',  'PnOd^d$oGh{N^6 x8s:0t+[[{TFvxiPqIm1e1T[nsQom@0q*^H:EWeznEfI,4z1k' );
define( 'LOGGED_IN_KEY',    'CY0sM#:{:7P==_9-=zEKtr0eqP#3M.$D1$IhWF<?9ZTyrkxg)B/Aa=c{>rp_g$Vk' );
define( 'NONCE_KEY',        '=r.diMOoq~6WPaLx778w%1%1]S-D;4*w)#CT8e43e?Z@W`gc3Og~K 94I:w&b,Tw' );
define( 'AUTH_SALT',        ',j!dJ60%^8/}[|K${GVcFaNjd92E!`y~)zt]JSzhNAQgO(#|%JOCo0FF=~w@:#m^' );
define( 'SECURE_AUTH_SALT', 'mXL8mIT@qlxPW4l~<uRPCI_klz8RBHVp,2AMdtL^?3EOC3LjclE_1Ek^Phk=?)Ne' );
define( 'LOGGED_IN_SALT',   'c;v6-1@^g1KGOb aDuDF$<Fc)OG2[)4K8D/}O^o`Ls-aoXqgf.]|W!]mRwO$@~?/' );
define( 'NONCE_SALT',       '%9ryq9~fEL^O$@)?6JvYK$Rk_;)C^`fO~6mG/l0Nae=ODz?MnP>Nv 3cI~KAI*.r' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'rjBYk1Krcsaasy_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
