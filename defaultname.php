<?php
/*
Plugin Name: Theme updater
Description: Plugin For updating theme automatically from GitHub
Author: Hakob Shaghikyan
Version: 1.0
*/

function theme_options_panel(){

    /*
          Adding Menu to Main WordPress Side Menu
          add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
    */

    add_menu_page('Theme Updater', 'Theme Updater', 'manage_options', 'default-options', 'initialize_default_page');

    /*
          Adding Sub Menu to your Menu
          add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )
    */

}
add_action('admin_menu', 'theme_options_panel');

function initialize_default_page(){

    require_once 'parts/update-button.php';

}

function default_about(){
    echo "Settings Page Here";
}

?>