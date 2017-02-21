<?php
	if (!defined('WP_UNINSTALL_PLUGIN')) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
	}

	function TS_VCSC_DeleteOptionsPrefixed($prefix) {
		global $wpdb;
		$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '{$prefix}%'" );
	}
	function TS_VCSC_RemoveCap() {
		$roles = get_editable_roles();
		foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
			if (isset($roles[$key]) && $role->has_cap('ts_vcsc_extend')) {
				$role->remove_cap('ts_vcsc_extend');
			}
		}
	}
	
	if (!is_user_logged_in()) {
		wp_die('You must be logged in to run this script.');
	}

	if (!current_user_can('install_plugins')) {
		wp_die('You do not have permission to run this script.');
	}

	if (get_option('ts_vcsc_extend_settings_retain') != 2) {
		TS_VCSC_DeleteOptionsPrefixed('ts_vcsc_extend_settings_');
		unregister_setting('ts_vcsc_extend_custom_css', 	'ts_vcsc_extend_custom_css', 		'TS_VCSC_CustomCSS_Validation');
		unregister_setting('ts_vcsc_extend_custom_js', 		'ts_vcsc_extend_custom_js', 		'TS_VCSC_CustomJS_Validation');
		delete_option("ts_vcsc_extend_custom_css");
		delete_option("ts_vcsc_extend_custom_js");
		TS_VCSC_RemoveCap();
	}
?>
