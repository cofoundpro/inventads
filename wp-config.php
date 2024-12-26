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
define( 'DB_NAME', 'yogiswap_wp203' );

/** MySQL database username */
define( 'DB_USER', 'yogiswap_wp203' );

/** MySQL database password */
define( 'DB_PASSWORD', 'S.3[612prh' );

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
define( 'AUTH_KEY',         'txhz33xwkn7vcukifxducmpwmfksvdplczf8jgdonas5ejacxrr8eum5gmlra1jy' );
define( 'SECURE_AUTH_KEY',  'mlvnu3bgq5qot8p69mqx0sisqnq44cmzygabug4i22fwhsoyz8axofsxcj9rmxtd' );
define( 'LOGGED_IN_KEY',    'fk4jt4gjtsc5r2xxzympmjaullazsdj6tiiuwm0f1qgymyosq1ybycjsfgz7eawp' );
define( 'NONCE_KEY',        'vqkrpnaf5l59mjwajfawd9jb0niu3acncq3rxdhwbryp4fxclq5ggkbgcdm0cbha' );
define( 'AUTH_SALT',        'kxd5w0se5ohubwjaul2phkhl0mj4ofezddq6vwztj3u1gpkjvfblev6zcvbedzre' );
define( 'SECURE_AUTH_SALT', 'sbfr16hzscyotuwmkvpejpyyq2tcn8hlwn3a11ctrjdcpevu96nhnxzjor3fvope' );
define( 'LOGGED_IN_SALT',   'dl0cwrbj9fburf1dkhuolgb8v9f05rdgvcrh7ul3hiavchms8k9yhvlkiwlc3nqm' );
define( 'NONCE_SALT',       'dvcpfiety08fb9xxfr1eegecbqrvzr7heewtloq5djuegkbd70qn9fnmyotzlbzu' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp9v_';

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
