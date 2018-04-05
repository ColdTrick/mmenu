<?php

elgg_register_event_handler('init', 'system', 'mmenu_init');

/**
 * Used to perform initialization of the mmenu features.
 *
 * @return void
 */
function mmenu_init() {
	elgg_extend_view('elgg.css', 'navigation/menu/site.css');
	
	elgg_register_plugin_hook_handler('register', 'menu:site', '\ColdTrick\Mmenu\Menus::topbarToSite');
	
	elgg_register_simplecache_view('navigation/menu/site.js');
	
	elgg_unregister_plugin_hook_handler('prepare', 'menu:site', '_elgg_site_menu_setup');
}
