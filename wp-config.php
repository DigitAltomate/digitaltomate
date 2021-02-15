<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'u925013848_ubgr6' );

/** MySQL database username */
define( 'DB_USER', 'u925013848_n7FB1' );

/** MySQL database password */
define( 'DB_PASSWORD', 'yIp1q8dziz' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',          '~F+S.9q`s_z^z;03%c6O;8&ctTuvHPJfRSPU=q*5m+zuSxKD ENo{vgDPq&:a^md' );
define( 'SECURE_AUTH_KEY',   '0>MR.bC,a<_fwhwHdSiw|ZN*E[IH*YOm>(rO}0c^Ax!^7>Ofnd?c>C?ss*JMB|1X' );
define( 'LOGGED_IN_KEY',     'By1KZl61d!{u}-jU]05[Hy@E~pc4xlt+:Se$L+W|sUYe271|WV2(47p<EVI`l;~^' );
define( 'NONCE_KEY',         '=Q+6XP+R:k3PDGvm~K4mDo~olXKI]Tc%nZs7JydRZF`H|K ?-)F4{)`To[?_?E9*' );
define( 'AUTH_SALT',         '-u|JWx2<Q7|]d^n;H+CX|nI*{B82Blpu>,,ZXT^06a1;~@??`OQuXK&hvd9M8]Sa' );
define( 'SECURE_AUTH_SALT',  'FAT,Jx*%>*m[sV4$U#2g~+$k=dI>Pt?])$tGc_XBE(mAXX:y4vCnqt/0iS9[i#}6' );
define( 'LOGGED_IN_SALT',    'YC8X1+H7lpy?~s(A2A.N?nzn>:S:0Nsa9y<ovpF^N|K*x?$>io2m~~=Lv?gp9{=T' );
define( 'NONCE_SALT',        '}lT{tBx:s{zV*l1su)9`-e*P%YFdpF@u~4|j^;|asZ|[&a<%3P(J5gi[*j 6Gi-]' );
define( 'WP_CACHE_KEY_SALT', 'q9+ghmvoW}*g6mM4n$?N[yUg-Dc-Cv-Nc^{u_JD7#QeFYj5X=wEFY2KGaTj**K#_' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
