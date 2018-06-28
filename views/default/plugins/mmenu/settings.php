<?php

$plugin = elgg_extract('entity', $vars);
if (!$plugin instanceof \ElggPlugin) {
	return;
}

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('mmenu:settings:topbar_to_site'),
	'name' => 'params[topbar_to_site]',
	'checked' => $plugin->topbar_to_site,
	'switch' => true,
	'default' => 0,
	'value' => 1,
]);
