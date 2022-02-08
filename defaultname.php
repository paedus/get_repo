<?php
/*
Plugin Name: Default Name
Description: A WordPress Plugin Template
Author: Shahzaib Khan
Version: 1.0
*/

function theme_options_panel(){
 
  /* 	
		Adding Menu to Main WordPress Side Menu 
		add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
  */
  
  add_menu_page('Default Name', 'Default Name', 'manage_options', 'default-options', 'initialize_defaulplugin',plugins_url('/defaultname/img/icon.png',__DIR__));

  /* 
		Adding Sub Menu to your Menu 
		add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )
  */
  add_submenu_page( 'default-options', 'About', 'About', 'manage_options', 'default-about', 'default_about');
  add_submenu_page( 'default-options', 'FAQ', 'FAQ', 'manage_options', 'default-faq', 'default_faq');
  
}
add_action('admin_menu', 'theme_options_panel');

function initialize_defaulplugin(){
	echo "Hello World";
}
function default_about(){ 
	echo "About Page Here";
}
function default_faq(){
	echo "FAQ Page Here";
} 
?>