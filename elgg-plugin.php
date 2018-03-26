<?php

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'views' => [
		'default' => [
			'jquery.mmenu/' => $composer_path . 'vendor/jQuery.mmenu/dist',
		],
	],
];
