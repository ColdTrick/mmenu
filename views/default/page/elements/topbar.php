<?php

/**
 * Topbar
 */

echo elgg_view('output/url', [
	'class' => 'mmenu-toggle',
	'href' => '#elgg-mmenu',
	'text' => false,
	'icon' => 'bars',
]);

echo elgg_view_menu('site', ['menu_view' => 'mmenu/menu']);
echo elgg_view_menu('footer');

echo elgg_format_element('div', [
	'class' => 'elgg-nav-search',
], elgg_view('search/search_box'));
