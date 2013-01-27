<?php
/*
Plugin Name: XML-RPC Theme Changer
Plugin URI: http://blog.dailyinvention.com
Description: Allows the ability to get and switch themes using XML-RPC.
Author: Stefan Holodnick
Author URI: http://blog.dailyinvention.com
Version: 1.0
*/

function theme_get_themes() {
	return wp_get_themes(false, true);
}

function theme_switch_themes($params) {
	$theme = $params[3];
	switch_theme( $theme );
}
 
function theme_methods($methods) {
	$methods['themes.getThemes'] = 'theme_get_themes';
	$methods['themes.switchThemes'] = 'theme_switch_themes';
	return $methods;
}

add_filter('xmlrpc_methods', 'theme_methods');

?>