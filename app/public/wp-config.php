<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'mk,d5A;+tt^liA=jC(a1KXVA**2p[?[UF3S_4rW=8u!/k?2 >Lu-U*3Q@NLo,xl]' );
define( 'SECURE_AUTH_KEY',   'CD|Gv-%]C^(4FKwPG_<CVl5/zm@wiw)ysuSQ.%.3C F$1_!D?RA;;yrXtDT-lRi ' );
define( 'LOGGED_IN_KEY',     ';ezpxquo0_JJl64_j5$q{U_rpl<~P.;kLTo3o6tGV6pGQ(:K+Sczlak3Qj@T*2pb' );
define( 'NONCE_KEY',         'yi!$^Vv%Eqb_xlSlESL)Jj~hM_Ch?R&m~~m:YTn%h98@ !5=~ =j8k#6d>o4baOw' );
define( 'AUTH_SALT',         ' 4FU^YBg0k_~OR[g(@-|&[Rvw3_-RPtl3`YsC7F){EnzMtvX@YPVO![oZNa}<>*%' );
define( 'SECURE_AUTH_SALT',  '75GH:bUy F:m59gyc4X.D_4)/h{oyFQU~xGo!t?-m3S~+>ZkTA%k?-X!p TG[Ovt' );
define( 'LOGGED_IN_SALT',    ' 48Bj,6cK:v,%o7wNc,lrfR^f=nY^K]J.#3#zD`gu*z;F$fegYIFoim7xn|$gz:Z' );
define( 'NONCE_SALT',        '^@r<ISD4Qs2nq.BeA6~|zOT7@;j_E,}c##pA_Cn:y_BH@g|GdjTCo8Z /uHb@zOC' );
define( 'WP_CACHE_KEY_SALT', 'T#vAPfqX`}3Lu=mb4!fB)MVz}05oPex-6k3_fTu3[I0;#sTiZ;DXCMEgCoog>l:e' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
