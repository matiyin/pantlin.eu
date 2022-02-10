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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pantlin.eu' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define('AUTH_KEY',         '?M$glM[-?.z-3-M*woJF2-y0LuD&$9(K1;xMT02ICY3Z}oZ|[S[#Y<?snyN_z=[ ');
define('SECURE_AUTH_KEY',  '@9QFeVntA!t6U~1)dZ&2OpVL5~uQ+vZ&483|MF]!X{.v@W}t*KWKp1.gCkLZj&Fi');
define('LOGGED_IN_KEY',    '/btbE9^Vav0QZ^kv01hA~b,<kO<Hg2=f+.&>cR.o__nGa+;^M^v%F8O:EfzhXn<-');
define('NONCE_KEY',        '?dn51Ldf:[Bqrb@:k7m}HN(phXE,40)|CiNyC2@fgft)/N2w>u81*Yw,a4gra0oi');
define('AUTH_SALT',        '+]G1_jzX$+)vVa 3u4dg ;7B>o6t{oH3||eCqb3@:xQ85NaGeQilyw_{ol{|X@XW');
define('SECURE_AUTH_SALT', 'T[q:wY rUQbwzrCf^yx=yOT<Yhm${v}lK#qv;2`JG-gx.e%p%ha)w;HQ>tY#NQ1E');
define('LOGGED_IN_SALT',   ' i6(p6vx-L>j_G.[1|:jYUIx@=+e$,H?XEUVJi4hvP9Fl*Pao6#/B){X:Fb3jT/3');
define('NONCE_SALT',       '.*A/.yKT{skAubju_ql?-e,l;SOG/E-. ^JZSO[~#na+{)f ?t)Mc:!AC2ywHp:|');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'pan_';




/** Disallow theme and plugin editor in admin */
define( 'DISALLOW_FILE_EDIT', true );

/** Include server config */
include_once('inc_serverconfig.php');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
