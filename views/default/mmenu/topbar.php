<?php

$site = elgg_get_site_entity();
$link = elgg_view_entity_url($site);

$toggle = elgg_view('output/url', [
	'icon' => 'chevron-right',
	'text' => false,
	'href' => false,
	'title' => elgg_echo('mmenu:menu:topbar:toggle:open'),
	'class' => ['mmenu-toggle', 'mmenu-toggle-open'],
]);

$toggle .= elgg_view('output/url', [
	'icon' => 'chevron-left',
	'text' => false,
	'title' => elgg_echo('mmenu:menu:topbar:toggle:close'),
	'href' => false,
	'class' => ['mmenu-toggle', 'mmenu-toggle-close'],
]);

echo elgg_format_element('div', ['class' => 'mmenu-topbar'], $link . $toggle);
