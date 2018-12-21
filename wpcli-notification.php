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

$autoload = dirname( __FILE__ ) . '/vendor/autoload.php';

if ( file_exists( $autoload ) ) {
	require_once $autoload;
}

// Creating object of Extended logger class.
$wp_cli_notification_logger = new WP_Cli_Notification_Logger( true );

WP_CLI::set_logger( $wp_cli_notification_logger );
