<?php

$site = elgg_get_site_entity();
$link = elgg_view('output/url', [
	'href' => $site->getURL(),
	'text' => $site->getDisplayName(),
	'trusted' => true,
]);

$open = elgg_view_icon('chevron-right');
$close = elgg_view_icon('chevron-left');
$toggle = elgg_view('output/url', [
	'class' => 'mmenu-toggle',
	'href' => '#elgg-mmenu',
	'text' => $open . $close,
]);

echo elgg_format_element('div', ['class' => 'mmenu-topbar'], $link . $toggle);
