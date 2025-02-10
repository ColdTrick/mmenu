<?php
/**
 * Topbar
 */

echo elgg_view('output/url', [
	'icon' => 'bars',
	'text' => false,
	'title' => elgg_echo('mmmenu:menu:topbar:toggle'),
	'aria-label' => elgg_echo('mmmenu:menu:topbar:toggle'),
	'href' => '#elgg-mmenu',
	'class' => 'mmenu-toggle',
]);

echo elgg_view_menu('site', ['menu_view' => 'mmenu/menu']);

echo elgg_format_element('div', [
	'class' => 'elgg-nav-search',
], elgg_view('search/search_box'));
