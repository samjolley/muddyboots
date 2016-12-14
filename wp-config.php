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
define('DB_NAME', 'samjolle_muddyboots_db');

/** MySQL database username */
define('DB_USER', 'samjolle_super');

/** MySQL database password */
define('DB_PASSWORD', 'Samuel1990!');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '?FMIj&86S^bNA~Tj@8p^]k8_j^Pxa7cv,51m^X>9l[taRb~j &0;qsXQ+4^e9+=~');
define('SECURE_AUTH_KEY',  '-3Izq)/id#nccoiYf<FO!u<5:5qWV@u^Jqy`fEp>T=86Y<-E!17pbC?,0>mdi6I*');
define('LOGGED_IN_KEY',    '5Lrngo$XXk@y^fZ C>PChbAOpdKF@f2s]AgN?G3V-zrCCe{#pb/%DDj?1LyW-~$C');
define('NONCE_KEY',        'N+c9r7@,UlowfcythdADSCdSAoA0bjTA9nA(1E!t5a8K&<ogyOEl#k<v|XZI<.2!');
define('AUTH_SALT',        '.,&#fC)x[vNy_R.8Nq9KASGQB{YQ&KtV80B;pxbh>w sf{`5/}iK,p mIx*dOBR+');
define('SECURE_AUTH_SALT', 'qb.a6Nws3ZtfpaO/LT|x]8XEFUvj01&thEmc5#=QLn1xGF:d$&+|P.fUy-Kw!dcv');
define('LOGGED_IN_SALT',   '?<#o2F})J.ylCjk=J;67vTN/l=`S_S0T,h9*yhZT!_%WKZ4Zd0){o{8XJVdW><Cq');
define('NONCE_SALT',       'bP7Zb&a2-9MO{9FCeYWN/19/w`#mtglqS3?NWsP8A7s0|/ZBXQ37hs.K)@H>-~zU');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/** Remove the built-in code editor */
define('DISALLOW_FILE_EDIT', true);