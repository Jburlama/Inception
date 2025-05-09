<?php

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

// Force Redis cache drop-in
define('WP_REDIS_DISABLED', false);
define('WP_REDIS_IGNORE_GLOBAL_GROUPS', true);

define('WP_CACHE', true);

/**#@+
 * Authentication unique keys and salts.
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
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
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
