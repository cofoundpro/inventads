<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'yogiswap_wp872' );

/** Database username */
define( 'DB_USER', 'yogiswap_wp872' );

/** Database password */
define( 'DB_PASSWORD', 'S)7p16j2!B' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'harftxinadjz2p71ignl7fwqn5cw9k15cfmfeokpfjxxtunxmwj1gf0sakrvwf9x' );
define( 'SECURE_AUTH_KEY',  'zqj0uvlk6plajoa2pdhjaohv5kdwcxdxrkfdimjhbo8ezrj6qi74j43n1warhzbx' );
define( 'LOGGED_IN_KEY',    'xc7mc7anrl3vv2wls22sfoauzfg5y18qxncmakeksp7lbar3ztxnvryv59peivqm' );
define( 'NONCE_KEY',        'mxitzcomnoqdfxeh4zbjabxzy2kxlbsldbvyxven1qxmsudvhlyw8hqb7ffvpkmm' );
define( 'AUTH_SALT',        'bmrmeaxp0cedigx9jlkdrs2maa1bf5u3vhxfwsonxcc9rnh8hbv83gvau9dowlm8' );
define( 'SECURE_AUTH_SALT', 'xup5fenys2mpr93v6hu7knznujgkbprwi9tidxfl1xcvdcjup0ird8nzbsqvsy8l' );
define( 'LOGGED_IN_SALT',   'd7cajop4y0sggyip0psfymcl00ancrpw1ge7bf5ybve58ndjswztumyvpjchahon' );
define( 'NONCE_SALT',       'iosqpp6swpq1k1f9wa8oyxtpbmeejp5ow1ctjhckfxwttlm1yjxohvywkdju0jhm' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wprp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
