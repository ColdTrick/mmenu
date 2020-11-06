define(['elgg', 'jquery', 'jquery.mmenu/mmenu'], function (elgg, $) {
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
				<?php
				
					$bottombar = elgg_view('mmenu/bottombar');
					if (!empty($bottombar)) {
						?>
				{
					"position": "bottom",
					"content": [
						'<?php echo $bottombar;	?>'
					]
				}
				<?php
					}
				?>
			],
			hooks: [],
		});
		
		// do not save state on mobile and for logged out users
		if (elgg.is_logged_in() && (!$('.elgg-page-topbar .mmenu-toggle').is(':visible'))) {
			options.hooks['open:after'] = function() {
				if (!$('body').hasClass('mm-wrapper_sidebar-closed')) {
					// do not save on initial open
					return;
				}

				if (!$('body').hasClass('mm-wrapper_blocking')) {
					// do not save on initial open
					return;
				}
				
				if ($('body').hasClass('mmenu-do-not-save-state')) {
					return;
				}
				
				require(['elgg/Ajax'], function(Ajax) {
					var ajax = new Ajax(false);
					ajax.action('mmenu/save_menu_state', {
						data: {
							closed: 0
						}
					});
				});
			};

			options.hooks['close:after'] = function() {
				if ($('body').hasClass('mmenu-do-not-save-state')) {
					return;
				}
				
				require(['elgg/Ajax'], function(Ajax) {
					var ajax = new Ajax(false);
					ajax.action('mmenu/save_menu_state', {
						data: {
							closed: 1
						}
					});
				});
			};
		}
				
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
			$('body').addClass('mmenu-slide-open');
			$('body').addClass('mmenu-do-not-save-state');
			$('.mm-slideout').on('mouseenter.mmenu', function() {
				$(this).off('mouseenter.mmenu');
				$('body').removeClass('mmenu-slide-open');
				
				var mmenu = $('.elgg-menu-site-container').data('mmenu');
				mmenu.closeAllPanels();;
				mmenu.close();
				
				$('body').removeClass('mmenu-do-not-save-state');
			});
			
			$('.elgg-menu-site-container').data('mmenu').open();
		});
		
		$(document).on('click', '.mmenu-toggle', function() {
			$menu_selector.data('mmenu').close();
			setTimeout(function() {
				$menu_selector.trigger('mmenu.toggle');
			}, 400);
		});
		
		// keeps default browser tab behaviour, otherwise tabbing only works when menu is collapsed
		$(window).off('keydown.mm-offCanvas');
	}, 1000);
});
