<?php

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'plugin' => [
		'version' => '7.0.1',
	],
	'actions' => [
		'mmenu/save_menu_state' => [],
	],
	'events' => [
		'prepare' => [
			'menu:site' => [
				'Elgg\Menus\Site::reorderItems' => [
					'unregister' => true,
				],
			],
		],
		'register' => [
			'menu:site' => [
				'\ColdTrick\Mmenu\Menus\Site::topbarToSite' => ['priority' => 9999],
			],
		],
		'view_vars' => [
			'page/elements/html' => [
				'\ColdTrick\Mmenu\Views::addHtmlClasses' => [],
			],
		],
	],
	'views' => [
		'default' => [
			'jquery.mmenu/mmenu.mjs' => $composer_path . 'vendor/bower-asset/mmenu/dist/mmenu.js',
			'jquery.mmenu/mmenu.css' => $composer_path . 'vendor/bower-asset/mmenu/dist/mmenu.css',
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'jquery.mmenu/mmenu.css' => [],
		],
		'jquery.mmenu/mmenu.css' => [
			'navigation/menu/site.css' => [],
		],
	],
	'view_options' => [
		'navigation/menu/site.mjs' => ['simplecache' => true],
	],
];
