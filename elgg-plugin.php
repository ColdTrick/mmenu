<?php

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'settings' => [
		'topbar_to_site' => 0,
	],
	'views' => [
		'default' => [
			'jquery.mmenu/' => $composer_path . 'vendor/jQuery.mmenu/dist',
		],
	],
	'actions' => [
		'mmenu/save_menu_state' => [],
	],
];
