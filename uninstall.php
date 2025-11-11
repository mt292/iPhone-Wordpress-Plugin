<?php
/**
 * Uninstall Script
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options
delete_option('iphone_sim_default_apps');
delete_option('iphone_sim_tutorial_speed');
delete_option('iphone_sim_avatar_style');

// If you need to delete custom database tables, do it here
// global $wpdb;
// $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}iphone_simulator_data");

// Clear any cached data or transients
delete_transient('iphone_simulator_cache');

// Clean up any user meta if stored
// delete_metadata('user', 0, 'iphone_sim_progress', '', true);
