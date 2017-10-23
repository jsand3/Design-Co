<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'alpha_john');

/** MySQL database username */
define('DB_USER', 'alpha_john');

/** MySQL database password */
define('DB_PASSWORD', '~.bcc#%bbJQR');

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
define('AUTH_KEY',         '^^IlA0lxOya=W8mRcuva!O72>_!/P=lFJu;AII&vVbDFp,$,/3VLbyl-y.-5R!$n');
define('SECURE_AUTH_KEY',  'E^AErP}ojx/6G#ipMdmy XH%PT4.ly[&ik.@!Ss[sgJaYE[{(-&MjxOe^Isv(cIx');
define('LOGGED_IN_KEY',    '(,~8-c$`Kh=1@ZB?p.ghrGUC&OjZHC*7a}/ h7_FX2*||Tf{5[)!l4VJ~v4q<YT#');
define('NONCE_KEY',        '`Z_@U=qpXMIGlP)aQ#|RA:E}b0^-1wXK]Q$Qq]s-]U#%PD4T~C|r@-`+z2?3J|[d');
define('AUTH_SALT',        'Ibq4wO2-4JF^)8cBA8^U(A-DR5=F]@pC5-NCKXpTv|p3;H{ceg+A~0_-S+#9OFCa');
define('SECURE_AUTH_SALT', 'Tvg9Jx~ *6!ep535>~6I3]e7}|=709{f /A~&OHb0Mf+Tq6z=p~9SQayX7GhVWQ^');
define('LOGGED_IN_SALT',   'Vv[>Szxg<LR7h@vuW[rr)-_z2aW[J|~j;T92K,ea<QD#.&/QhjIive.,DslW6:**');
define('NONCE_SALT',       'FqA$Gy+- w<;vxN2d@kv41Dk}Rcv.0>8T0sjIY>ZB4Z7Ht*]fCaN elWsq{,f(;4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
