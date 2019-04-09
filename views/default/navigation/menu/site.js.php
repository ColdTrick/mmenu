define(['elgg', 'jquery', 'jquery.mmenu/jquery.mmenu.all'], function (elgg, $) {
	elgg.register_hook_handler('init', 'system', function() {
		var $menu_selector = $('.elgg-menu-site-container');
		
		var options = elgg.trigger_hook('config:options', 'mmenu', {}, {
			drag: true,
			navbar: {
				title: '&nbsp;'
			},
			setSelected: {
				hover: true,
				parent: true
			},
			iconPanels: {
				add: true,
				visible: "first"
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
						'<?php
							echo elgg_view('mmenu/bottombar');
						?>'
					]
				}
			]
		});
		
		var configuration = elgg.trigger_hook('config:configuration', 'mmenu', {}, {
			classNames: {
				selected: 'elgg-state-selected'
			},
			offCanvas: {
				pageSelector: '.elgg-page'
			}
		});
		
		$menu_selector.mmenu(options, configuration);
		
		$(document).on('click', '.mm-menu__blocker', function() {
			setTimeout(function() {
				$menu_selector.trigger('mmenu.toggle');
			}, 400);
		});
		
		$(document).on('mouseenter', '.mm-menu__blocker', function() {
			$('html').addClass('mmenu-slide-open');
			$('.mm-slideout').on('mouseenter.mmenu', function() {
				$(this).off('mouseenter.mmenu');
				$('html').removeClass('mmenu-slide-open');
				
				var mmenu = $('.elgg-menu-site-container').data('mmenu');
				mmenu.openPanel($('#mm-1'));
				mmenu.close();
			});
			
			$(this).click();
		});
		
		$(document).on('click', '.mmenu-toggle', function() {
			$menu_selector.data('mmenu').close();
			setTimeout(function() {
				$menu_selector.trigger('mmenu.toggle');
			}, 400);
			
			if (elgg.is_logged_in()) {
				require(['elgg/Ajax'], function(Ajax) {
					var ajax = new Ajax(false);
					ajax.action('mmenu/save_menu_state', {
						data: {
							closed: $menu_selector.data('mmenu').getInstance().vars.opened ? 1 : 0
						}
					});
				});
			};
		});
		
		// keeps default browser tab behaviour, otherwise tabbing only works when menu is collapsed
		$(window).off('keydown.mm-offCanvas');
	}, 1000);
});
