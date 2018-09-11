<?php

use WP_CLI_Notification;

if ( ! defined('WP_CLI') ) {
    return;
}

$autoload = dirname( __FILE__ ) . '/vendor/autoload.php';

if ( file_exists( $autoload ) ) {

	require_once $autoload;

}
