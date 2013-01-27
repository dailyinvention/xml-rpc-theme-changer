<?php
/*
Plugin Name: XML-RPC Theme Changer
Plugin URI: https://github.com/dailyinvention/xml-rpc-theme-changer
Description: Allows the ability to get and switch themes using XML-RPC.
Author: Stefan Holodnick
Author URI: http://blog.dailyinvention.com
Version: 1.0
*/

// Returns an array of themes in Wordpress
function theme_get_themes() {
	global $wp_xmlrpc_server;
	$wp_xmlrpc_server->escape( $params );
	
	$username = $params[0];
	$password = $params[1];
	
	if ( ! $user = $wp_xmlrpc_server->login( $username, $password ) ) {
        return $wp_xmlrpc_server->error;
	}
	else {
		return wp_get_themes(false, true);
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
	$methods['themes.switchThemes'] = 'theme_switch_themes';
	return $methods;
}

// Adds methods to Wordpress's XML-RPC methods
add_filter('xmlrpc_methods', 'theme_methods');

?>