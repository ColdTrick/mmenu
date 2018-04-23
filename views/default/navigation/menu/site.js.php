define(['elgg', 'jquery', 'jquery.mmenu/jquery.mmenu.all'], function (elgg, $) {
	elgg.register_hook_handler('init', 'system', function() {
		var $menu_selector = $('.elgg-menu-site-container');
		
		$menu_selector.mmenu({
			// options
			drag: true,
			backButton: true,
			setSelected: {
				hover: true,
				parent: true
			},
			sidebar: {
				collapsed: {
					use: true,
					size: 40
				},
				expanded: {
					use: true,
					size: 25,
				}
			},
			keyboardNavigation: {
				enabled: false,
			},
			navbars: [
				{
					"position": "top",
					"content": [
						'<?php
							$site = elgg_get_site_entity();
							echo elgg_view('output/url', [
								'href' => $site->getURL(),
								'text' => $site->getDisplayName(),
								'trusted' => true,
							]);
						?>'
					]
				},
				{
					"position": "bottom",
					"content": [
						$('.elgg-menu-footer').html()
						]
				}
			],
			hooks: {
				'open:finish': function() {
					setTimeout(function() {
						$('#my-button > .elgg-icon').addClass('elgg-icon-times fa-times').removeClass('elgg-icon-bars fa-bars');
					}, 100);
				},
				'close:finish': function() {
					setTimeout(function() {
						$('#my-button > .elgg-icon').removeClass('elgg-icon-times fa-times').addClass('elgg-icon-bars fa-bars');
					}, 100);
				}
			}
		}, {
			// configuration
			classNames: {
				selected: 'elgg-state-selected'
			},
			offCanvas: {
				pageSelector: '.elgg-page'
			}
		});
		
		$('#mmenu-toggle').click(function() {
			$menu_selector.data('mmenu').open();
		});
	});
});
