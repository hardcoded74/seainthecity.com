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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'seainthecity');

/** MySQL database username */
define('DB_USER', 'seainthecityu');

/** MySQL database password */
define('DB_PASSWORD', '2z@A#Mr3');

/** MySQL hostname */
define('DB_HOST', '198.143.141.78:3306');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '?0M*qW^zjCNp*Xk{vj!P<-[Vj8T4@Ut*J?%%k6-6]43I-|H6H<Inm@S9R/~3l-/c');
define('SECURE_AUTH_KEY',  'Y~rt!VT95!ujU4.Onc/5x>L)i~5NV7m ;qN{% VE(a>}cv][E.~%CS.|~-nt2ILc');
define('LOGGED_IN_KEY',    'F5Co7Uh2S&:C4OuVyFwD!0]F8Oo Z$|34!eAfY37RpLWVdkm.Vk)4[AoyW&.FL|t');
define('NONCE_KEY',        ')ZFK,E2aYH$>-WtQ?Y-lO?HQ-7^.5-52MFu|bmkjQSHw2_bbfY{be6*-P:6i=*]l');
define('AUTH_SALT',        'xVW/D&k|A6`3}?hFIy;}NNWF0/8?UgdSJ1T7j+nMRBH/?Q|Y:L1_,|l|[,9,v*MQ');
define('SECURE_AUTH_SALT', ';[2LNaZHiDWImB:!]hQ0|=DFT{5wcfHHjkqN,pS@Oc%4Jxm$5&m:>d3#$nP,qul^');
define('LOGGED_IN_SALT',   'o^k}mI*L,-RrSHnCr!*?o(f}&|A{-jf^@rUzD) f1w!Q$.udaC _xL(wk~V]G8]p');
define('NONCE_SALT',       'B^CK<3p{BAFhC^vUYi{3bnbQ-(i9BrBnlSRq(~Z7`?z?DxU!Y&np{12F8_{g oX+');


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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');