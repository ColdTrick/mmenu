<?php

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'plugin' => [
		'version' => '3.0',
	],
	'settings' => [
		'topbar_to_site' => 0,
	],
	'actions' => [
		'mmenu/save_menu_state' => [],
	],
	'hooks' => [
		'prepare' => [
			'menu:site' => [
				'_elgg_site_menu_setup' => [
					'unregister' => true,
				],
			],
		],
		'register' => [
			'menu:site' => [
				'\ColdTrick\Mmenu\Menus::topbarToSite' => [],
			],
		],
		'view_vars' => [
			'page/elements/html' => [
				'\ColdTrick\Mmenu\Views::addHtmlClasses' => [],
			],
			'page/default' => [
				'\ColdTrick\Mmenu\Views::addPageClasses' => [],
			],
		],
	],
	'views' => [
		'default' => [
			'jquery.mmenu/' => $composer_path . 'vendor/bower-asset/mmenu/dist',
		],
	],
	'view_extensions' => [
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
