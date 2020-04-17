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
define( 'DB_NAME', 'wishonary' );

/** MySQL database username */
define( 'DB_USER', 'dbmasteruser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'A$qQ]L&Du+:7qu*5Tlh&aB#smM9QY&6m' );

/** MySQL hostname */
define( 'DB_HOST', 'ls-81242c5ea89fea2e10e8029998f7a31437747640.c13099vsjhcx.ap-south-1.rds.amazonaws.com:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY', '3db798506dd10574e4e53bf86204844d0c9318f15526060b8d7c49bdfa195d30');
define('SECURE_AUTH_KEY', '556337dacde37fbc8c7ff6058d5394b4d33015cdc65bd37984064af627e02602');
define('LOGGED_IN_KEY', '4be1971efe04f045c18b391b9be17a09019c4727c4d9d02152b47b7c22970969');
define('NONCE_KEY', 'ebe37cc2f1e699ad55264aa2833974d32d0083b2d850403f457874ad9dc397ea');
define('AUTH_SALT', 'fabfd89a2a8cb3a8d5d4e747b0b055c610217c5b09a9e73cd5bd2e048cb461b0');
define('SECURE_AUTH_SALT', '84100094a98243e6db1bdc79c913c7706421ef54d72496f2a2840823d3ff9aa2');
define('LOGGED_IN_SALT', '66e7d0a9adc146fb4bb42079055662fbae871b25edd6643bdc48e83fb8cd1eff');
define('NONCE_SALT', '4f9d6ac2a333ffe40988f5114e79df7504a7006bfbaeb0200363cffcc6fb666a');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

define('FS_METHOD', 'direct');

/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','https://example.com');
 *  define('WP_SITEURL','https://example.com');
 *
*/

if ( defined( 'WP_CLI' ) ) {
    $_SERVER['HTTP_HOST'] = 'localhost';
}

define('WP_SITEURL','https://' . $_SERVER['HTTP_HOST'] . '/');
define('WP_HOME','https://' . $_SERVER['HTTP_HOST'] . '/');


/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

define('WP_TEMP_DIR', '/opt/bitnami/apps/wordpress/tmp');


//  Disable pingback.ping xmlrpc method to prevent Wordpress from participating in DDoS attacks
//  More info at: https://docs.bitnami.com/general/apps/wordpress/troubleshooting/xmlrpc-and-pingback/

if ( !defined( 'WP_CLI' ) ) {
    // remove x-pingback HTTP header
    add_filter('wp_headers', function($headers) {
        unset($headers['X-Pingback']);
        return $headers;
    });
    // disable pingbacks
    add_filter( 'xmlrpc_methods', function( $methods ) {
            unset( $methods['pingback.ping'] );
            return $methods;
    });
    add_filter( 'auto_update_translation', '__return_false' );
}
