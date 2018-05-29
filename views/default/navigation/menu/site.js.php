define(['elgg', 'jquery', 'jquery.mmenu/jquery.mmenu.all'], function (elgg, $) {
	elgg.register_hook_handler('init', 'system', function() {
		var $menu_selector = $('.elgg-menu-site-container');
		
		$menu_selector.mmenu({
			// options
			drag: true,
			navbar: {
				title: '&nbsp;'
			},
			backButton: true,
			setSelected: {
				hover: true,
				parent: true
			},
			sidebar: {
				collapsed: {
					use: "(min-width: 700px)",
					size: 40
				},
				expanded: {
					use: "(min-width: 900px)",
					size: 25
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
							echo elgg_view('mmenu/topbar');
						?>'
					]
				},
				{
					"position": "bottom",
					"content": [
						$('.elgg-menu-footer').html()
					]
				}
			]
		}, {
			// configuration
			classNames: {
				selected: 'elgg-state-selected'
			},
			offCanvas: {
				pageSelector: '.elgg-page'
			}
		});
				
		$(document).on('click', '.mmenu-toggle', function() {
			$menu_selector.data('mmenu').close();
			
			require(['elgg/Ajax'], function(Ajax) {
				var ajax = new Ajax(false);
				ajax.action('mmenu/save_menu_state', {
					data: {
						closed: $menu_selector.data('mmenu').getInstance().vars.opened ? 1 : 0
					}
				});
			});
		});
		
	});
});
