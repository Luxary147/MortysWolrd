<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mortysworld' );

/** Database username */
define( 'DB_USER', 'Luxar' );

/** Database password */
define( 'DB_PASSWORD', 'cp14Rm69' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'o2)dj^F+CDteXPND~Vq+e(`j7g&h0AR`kdlH*c}drbB7KklFOWnG! wnfK5tAMIc' );
define( 'SECURE_AUTH_KEY',  'm~!<9(H^?VGx9`xU^d)!LAPr$!5uW0}d;c):@61f3`AgJ$}[}=!g&IwdA7+iX0dl' );
define( 'LOGGED_IN_KEY',    '(yMnldu L1;2)WsH/YH$@He<-Y/31fB|a2.y:mt&nQ-HF]Sh&uHPfe`>wk-I{_u_' );
define( 'NONCE_KEY',        'P:m %mPeQSxpf%)Ai]+G~Q%cS/ij_MF88!mKZ|hFO7qg5[7~50.*Dq-?2!FUG8jl' );
define( 'AUTH_SALT',        'v+eRKMccG>vQ_=CwH@RdkELS)cZnPBW2M6&Ds05.4$W6RULp=!s&?qN0XF$`HGXz' );
define( 'SECURE_AUTH_SALT', 'AMZBZtrTfb=Gf(qUGir&IjO6(8A2<dep;5p&b,F/m~`+kAg-L]BouXRS hLR:w<c' );
define( 'LOGGED_IN_SALT',   '4yTu],TcMkGs=phQ79V%LYyt[XcQor+v^4CAksu7]F,V-hhRPG%o6|z4Hp*>X*,%' );
define( 'NONCE_SALT',       'RX]tr*vQaug!pNS~@=gUnP-]:@T`JgW0m;GQyV5_+X-lbC)^s~[]^tDs#PQ!J8 v' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
