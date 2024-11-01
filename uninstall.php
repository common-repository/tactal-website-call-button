<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       icommconnect.com
 * @since      1.0.0
 *
 * @package    Tactal
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
// Delete TACTAL settings option on deletion

delete_option( 'tactal_settings' );
