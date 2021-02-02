<?php
namespace WilokeListgoShortcode\Controllers;

/**
 * Class EnqueueScriptController
 * @package WilokeListgoShortcode\Controllers
 */
class EnqueueScriptController{
	public function __construct() {
		add_action('wp_enqueue_scripts',[$this,'enqueueStyle']);
	}

	public function enqueueStyle(){
		wp_enqueue_style( 'wiloke-listing-shortcodes-style', WILOKE_LISTING_SHORTCODES_URI.'asset/css/style.css',[],
			WILOKE_LISTING_SHORTCODES_VER,'all');
	}
}
