<?php

$site = elgg_get_site_entity();
$link = elgg_view_entity_url($site);

$open = elgg_view_icon('chevron-right');
$close = elgg_view_icon('chevron-left');

$toggle = elgg_view('output/url', [
	'text' => $open . $close,
	'title' => elgg_echo('mmmenu:menu:topbar:toggle'),
	'href' => '#elgg-mmenu',
	'class' => 'mmenu-toggle',
]);

echo elgg_format_element('div', ['class' => 'mmenu-topbar'], $link . $toggle);
