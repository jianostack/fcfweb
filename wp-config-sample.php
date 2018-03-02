<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

define('WP_SITEURL', '//' . $_SERVER['SERVER_NAME'] );
define('WP_HOME',    '//' . $_SERVER['SERVER_NAME'] );

define('DB_NAME', 'fcf_dev');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8');
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
define('AUTH_KEY',         '%+Dm)HG|D<hz-ELg;fd}3RkqrL>(:ANd$lOa(Qspy:3H|J4%?vYR}.M`E]}2;*;3');
define('SECURE_AUTH_KEY',  'Ra_0?!nu#Skm6]AZp^Y$CS`:3Wj{l4cy]mWk*NkY2dv7Wp)GB~SMG+KU#c9@+snL');
define('LOGGED_IN_KEY',    'ft=}4&OY-GM|!qe&xbM%Im&Yy(*^=ASOnJ1Yq6iJ%Tv5fnh-?n^AfVExA?M5YWjp');
define('NONCE_KEY',        'aL?B:-).a~Z+E(PU?@C:kAl^UE*%` jxzo/{|Jfr&F!+GJACE3S[28+:!W}PVo~(');
define('AUTH_SALT',        ',6C|[J|Y(Qe&$S -%ioE8YDi>6f7Gsm}CAp/]*w8_*O~Y/vVt+U#0$R}`Sp%REpk');
define('SECURE_AUTH_SALT', 'sN^Z?BMY~<LbV?&rq |oY/7>hboC:-|i(q_RY9i>hQ/@WAXuqa{8dz8O*uYp4qY;');
define('LOGGED_IN_SALT',   '}xb67&~sq|#1|KmxQ+Iwf-wNUYI$o%^$9lhFn:wK*4vtoze&WOrVxt^</4!L}9Hn');
define('NONCE_SALT',       'eW[Fx3lPDp05!@-l8hLB6CWFTnJ.-(Iw&hGr-p-5,ox%PtU5{O{PJZP|0-aa8KwV');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* Multisite */
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', '127.0.0.1:8000');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('DISALLOW_FILE_EDIT', true);
