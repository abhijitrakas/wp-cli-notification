<?php
/**
 * File to bootstrap plugin.
 *
 * @package WP CLI Notification Logger
 */

// If WP_CLI class or set_logger method not found then return.
if ( ! class_exists( 'WP_CLI' ) || ! method_exists( 'WP_CLI', 'set_logger' ) ) {
	return;
}

$wpcli_notifiation_autoloader = dirname( __FILE__ ) . '/vendor/autoload.php';

if ( file_exists( $wpcli_notifiation_autoloader ) ) {
	require_once $wpcli_notifiation_autoloader;
}

use \WP_CLI\Notification\Logger;

// Creating object of Extended logger class.
$wpcli_notification_logger = new Logger( true );

WP_CLI::set_logger( $wpcli_notification_logger );
