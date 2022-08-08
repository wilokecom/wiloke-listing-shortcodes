<?php
/*
 * Plugin Name: Wiloke Listgo Shortcode
 * Plugin URI: https://wiloke.com
 * Author: Wiloke
 * Author URI: https://wiloke.com
 * Version: 1.0
 * Description: This plugin is required with List Go
 * Text Domain: wiloke
 * Domain Path: /languages/
 */
if ( !defined('ABSPATH') ){
    die();
}
define('WILOKE_LISTING_SHORTCODES_VER', 1.2);

define('WILOKE_LISTING_SHORTCODES_URI', plugin_dir_url(__FILE__));
include plugin_dir_path(__FILE__) . 'vendor/autoload.php';
new WilokeListgoShortcode\Shortcodes\Shortcodes();
new WilokeListgoShortcode\Controllers\EnqueueScriptController();
