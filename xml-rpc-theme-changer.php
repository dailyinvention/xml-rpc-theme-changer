<?php
/*
Plugin Name: XML-RPC Theme Changer
Plugin URI: https://github.com/dailyinvention/xml-rpc-theme-changer
Description: Allows the ability to get and switch themes using XML-RPC.
Author: Stefan Holodnick
Author URI: http://blog.dailyinvention.com
Version: 1.0
License: GPLv2
*/
//Enables editor access to necessary functions when plugin is enabled

function enable_theme_roles () {

        $editor = get_role('editor');
        $editor->add_cap('wp_get_themes');
        $editor->add_cap('get_current_theme');
        $editor->add_cap('switch_theme');

}

//Disables editor access to necessary functions when plugin is disabled

function disable_theme_roles () {

        $editor = get_role('editor');
        $editor->remove_cap('wp_get_themes');
        $editor->remove_cap('get_current_theme');
        $editor->remove_cap('switch_theme');

}


// Returns an array of themes in Wordpress
function theme_get_themes($params) {
	global $wp_xmlrpc_server;
	$wp_xmlrpc_server->escape( $params );
	
	$username = $params[0];
	$password = $params[1];
	
	if ( ! $user = $wp_xmlrpc_server->login( $username, $password ) ) {
        return $wp_xmlrpc_server->error;
	}
	else {
		$keys = wp_get_themes(false, true);
		foreach ($keys as $key => $value) {
			$theme_name = wp_get_theme($key);
			$theme_names->$key = $theme_name->Name;
		}
		return $theme_names;
	}	
	
}

// Returns active theme name
function theme_get_active_theme($params) {
	global $wp_xmlrpc_server;
	$wp_xmlrpc_server->escape( $params );
	
	$username = $params[0];
	$password = $params[1];
	
	if ( ! $user = $wp_xmlrpc_server->login( $username, $password ) ) {
        return $wp_xmlrpc_server->error;
	}
	else {
		return get_current_theme();
	}	
	
}

// Switches theme in Wordpress
function theme_switch_themes($params) {
	global $wp_xmlrpc_server;
	$wp_xmlrpc_server->escape( $params );
	
	$username = $params[0];
	$password = $params[1];
	$theme = $params[2];
	
	if ( ! $user = $wp_xmlrpc_server->login( $username, $password ) ) {
        return $wp_xmlrpc_server->error;
	}
	else {
		switch_theme( $theme );
	}
}

// Creates methods for theme functions 
function theme_methods($methods) {
	$methods['themes.getThemes'] = 'theme_get_themes';
	$methods['themes.getActiveTheme'] = 'theme_get_active_theme';
	$methods['themes.switchThemes'] = 'theme_switch_themes';
	return $methods;
}

// Adds methods to Wordpress's XML-RPC methods
register_activation_hook( __FILE__, 'enable_theme_roles' );
register_deactivation_hook( __FILE__, 'disable_theme_roles' );
add_filter('xmlrpc_methods', 'theme_methods');

?>
