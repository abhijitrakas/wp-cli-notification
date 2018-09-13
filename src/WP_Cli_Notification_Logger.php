<?php
/**
 * File to load custom logger for WP CLI.
 *
 * @package WP CLI Notification Logger
 */

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use WP_CLI\Loggers\Base;

/**
 * Extend default logger to display Desktop notification.
 */
class WP_Cli_Notification_Logger extends Base {

	/**
	 * Constructor to set default settings.
	 *
	 * @param bool $in_color Whether or not to Colorize strings.
	 */
	public function __construct( $in_color ) {
		$this->in_color = $in_color;
	}

	/**
	 * Write an informational message to STDOUT.
	 *
	 * @param string $message Message to write.
	 */
	public function info( $message ) {
		$this->write( STDOUT, $message . "\n" );
	}

	/**
	 * Write a success message, prefixed with "Success: ".
	 *
	 * @param string $message Message to write.
	 */
	public function success( $message ) {

		$this->desktop_notification( 'Success', $message );
		$this->_line( $message, 'Success', '%G' );

	}

	/**
	 * Write a warning message to STDERR, prefixed with "Warning: ".
	 *
	 * @param string $message Message to write.
	 */
	public function warning( $message ) {

		$this->desktop_notification( 'Warning', $message );
		$this->_line( $message, 'Warning', '%C', STDERR );
	}

	/**
	 * Write an message to STDERR, prefixed with "Error: ".
	 *
	 * @param string $message Message to write.
	 */
	public function error( $message ) {

		$this->desktop_notification( 'Error', $message );

		$this->_line( $message, 'Error', '%R', STDERR );
	}

	/**
	 * Similar to error( $message ), but outputs $message in a red box
	 *
	 * @param  array $message_lines Message to write.
	 */
	public function error_multi_line( $message_lines ) {

		// convert tabs to four spaces, as some shells will output the tabs as variable-length.
		$message_lines = array_map(
			function( $line ) {
				return str_replace( "\t", '    ', $line );
			},
			$message_lines
		);

		$longest = max( array_map( 'strlen', $message_lines ) );

		// write an empty line before the message.
		$empty_line = \cli\Colors::colorize( '%w%1 ' . str_repeat( ' ', $longest ) . ' %n' );
		$this->write( STDERR, "\n\t$empty_line\n" );

		foreach ( $message_lines as $line ) {
			$padding = str_repeat( ' ', $longest - strlen( $line ) );
			$line    = \cli\Colors::colorize( "%w%1 $line $padding%n" );
			$this->write( STDERR, "\t$line\n" );
		}

		// write an empty line after the message.
		$this->write( STDERR, "\t$empty_line\n\n" );
	}

	/**
	 * Function to set desktop notification.
	 *
	 * @param string $title   // Notification title.
	 * @param string $message // Message to display in desktop notification.
	 *
	 * @return void
	 */
	public function desktop_notification( $title, $message ) {

		if ( empty( $title ) && empty( $message ) ) {
			return;
		}

		// Create a Notifier.
		$notifier = NotifierFactory::create();

		// Create your notification.
		$notification = new Notification();

		$notification
					->setTitle( $title )
					->setBody( $message )
					->setIcon( __DIR__ . '/assets/images/wp-cli-logo.png' );

		// Fire Display notification command.
		$notifier->send( $notification );

	}

}
