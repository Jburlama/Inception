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
define( 'DB_NAME', 'wp_site' );

/** Database username */
define( 'DB_USER', 'jburlama' );

/** Database password */
define( 'DB_PASSWORD', getenv('PASSWD') );

/** Database hostname */
define( 'DB_HOST', 'mariadb' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


define( 'WP_REDIS_HOST', 'redis' );
define( 'WP_REDIS_PORT', 6379 );     

define('WP_CACHE', true);

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
define('AUTH_KEY',         'zh;|yVI;%>*XTBx@S|N|2pd++h^{<S9s6GrHAP(d0Z>G-bzmeGpT}%& OQn=mWRU');
define('SECURE_AUTH_KEY',  'nk-(6~gr1t/g/F%~&7^^+o^N^qx70|tl:`PFUwMQJbq mE/t4-8K</{#BO$,=qNC');
define('LOGGED_IN_KEY',    ') JPuau*GjuU6H5_t}f;`;H0=3:OLFBU-.ful~(.aItVGP1dR!s3N6wC`leLN:0q');
define('NONCE_KEY',        '`H[9x4JK#>q$EVQ|e+G1G)Y{^fx/E[hZi+E&WX3Pr<R.3:R aZU7YFkY K>|9`g(');
define('AUTH_SALT',        '4U}?{(6l-7`xv=[jO. e9sm]`VDt6RN!akWL0#X,TL<I&Wvgz-h$}-Sqd7+f:gWi');
define('SECURE_AUTH_SALT', '*rIZ}$L8 .M$20[9pW,>* Ijs`#1zKNy<cG-1J>yrU|?r|pyYm2*yQL}y~;>&|^j');
define('LOGGED_IN_SALT',   'GuS,wFfx_D20|a*Pg9r8leEoZ^x-0/6E:j%I4`S)n(Y2e2oe+;+DURj0syFy|d[u');
define('NONCE_SALT',       'jbaU,@kEX{vn~gP08=xc3KR^aK/atvF0|QQ*$f8q7p&oBIOHdpy)u0qAAyu{3Q+w');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
