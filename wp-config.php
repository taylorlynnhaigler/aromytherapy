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
define('DB_NAME', 'romytherapy');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         ')1x5B.a0M1)[=i[_KQLzFr=-gQ8jB%X]&8d`5P6~:9um[t7_i4X7N<G`9{ eE>P*');
define('SECURE_AUTH_KEY',  ' h93DSlM,}=k9iZ?6EOFol3tAa8W?@6gahki`~B/x4~f]>W.o6 -eH>>Ev;`yJWU');
define('LOGGED_IN_KEY',    'n6Qv~#ie3T$y|U`zgLz0N{7(/qo4Gp2-I+cEg%6a6V0@QxZOqhPgJ c+[%bk2pT=');
define('NONCE_KEY',        'Zg_-<c]){)Z{5^PQ4*@s!l<E?!K9LF=MBo^y=i~%5?4$rmHpl_.,ZsETJ OH_<1w');
define('AUTH_SALT',        '{^k~P6m,#zG4c3D|,ITg!67`O982R>k@8d[Lo`d;/%}iBI}MAz-WWQ.R~Mot-4*B');
define('SECURE_AUTH_SALT', 'kN,:>7kJaa=hl.zauJ[A4W?NBv..eF}_H9{}TxWxiHCEt5OKi0iu_<WY`js+Tgc%');
define('LOGGED_IN_SALT',   'VO[541Z1}Eld+QQHvo=xm3-If5`xL`]KGm&bv(E@1wusoyEqy=1;f5IrdyqXCb@4');
define('NONCE_SALT',       'B==1gw1]BJXq]wN==UK,^yn]_~=G`3vg2Q?&9rKJ4]<g<>$?+*7z6$.7ja>6ktQi');

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
