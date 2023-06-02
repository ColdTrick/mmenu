<?php

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'plugin' => [
		'version' => '6.0',
	],
	'settings' => [
		'topbar_to_site' => 0,
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
				'\ColdTrick\Mmenu\Menus\Site::topbarToSite' => [],
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
			'jquery.mmenu/' => $composer_path . 'vendor/bower-asset/mmenu/dist',
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'jquery.mmenu/mmenu.css' => [],
		],
		'elements/z-index.css' => [
			'mmenu/z-index.css' => [],
		],
		'jquery.mmenu/mmenu.css' => [
			'navigation/menu/site.css' => [],
		],
	],
	'view_options' => [
		'navigation/menu/site.js' => ['simplecache' => true],
	],
];
