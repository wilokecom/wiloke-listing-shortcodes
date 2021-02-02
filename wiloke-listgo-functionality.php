<?php
/*
 * Plugin Name: Wiloke Listing Shortcode
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

include plugin_dir_path(__FILE__) . 'vendor/autoload.php';
new WilokeListgoShortcode\Shortcodes\Shortcodes();
