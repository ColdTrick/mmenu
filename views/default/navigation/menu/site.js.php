	define(['elgg', 'jquery', 'jquery.mmenu/mmenu'], function (elgg, $) {
	elgg.register_hook_handler('init', 'system', function() {
		var $menu_selector = $('.elgg-menu-site-container');
		
		var options = elgg.trigger_hook('config:options', 'mmenu', {}, {
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
				},
				expanded: {
					use: "(min-width: 900px)",
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
			extensions: ["pagedim-black"],
			hooks: [],
		});
		
		// do not save state on mobile and for logged out users
		if (elgg.is_logged_in() && (!$('.elgg-page-topbar .mmenu-toggle').is(':visible'))) {
			options.hooks['open:after'] = function() {
				if (!$('body').hasClass('mm-wrapper_sidebar-closed')) {
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
				page: {
					selector: 'body > .elgg-page'
				}
			}
		});
		
		$menu_selector.mmenu(options, configuration);
		
		$(document).on('click', '.mm-menu__blocker', function() {
			setTimeout(function() {
				$menu_selector.trigger('mmenu.toggle');
			}, 400);
		});
		
		$(document).on('mouseenter', '.mm-menu__blocker', function() {
			$('body').addClass('mmenu-do-not-save-state');
			$('.elgg-menu-site-container').data('mmenu').open();
			
			setTimeout(function() {
				$('.mm-slideout').on('mouseenter.mmenu', function() {
					$(this).off('mouseenter.mmenu');
					
					$('.elgg-menu-site-container').data('mmenu').close();
					$('.elgg-menu-site-container').data('mmenu').closeAllPanels();
					
					$('body').removeClass('mmenu-do-not-save-state');
				});
			}, 100);
		});
		
		$(document).on('click', '.mmenu-toggle', function() {
			$menu_selector.data('mmenu').close();
			setTimeout(function() {
				$menu_selector.trigger('mmenu.toggle');
			}, 400);
		});
		
		// keeps default browser tab behaviour, otherwise tabbing only works when menu is collapsed
		// see: https://github.com/FrDH/mmenu-js/issues/86
		document.body.removeEventListener('keydown', document.body.mmEventKeydownTabguard[0]);
	}, 1000);
});
