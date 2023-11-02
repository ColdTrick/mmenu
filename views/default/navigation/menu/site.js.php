<?php

$topbar = elgg_view('mmenu/topbar');
$bottombar = elgg_view('mmenu/bottombar');

?>
define(['jquery', 'elgg', 'elgg/hooks', 'jquery.mmenu/mmenu'], function ($, elgg, hooks) {

	var $menu_selector = $('.elgg-menu-site-container');
	
	var menuIsOpen = function() {
		return $menu_selector.hasClass('mm-menu--opened');
	}
	
	var saveMenuState = function() {
		if (!elgg.is_logged_in() || $('.elgg-page-topbar .mmenu-toggle').is(':visible')) {
			// do not save state on mobile and for logged out users
			return;
		}
		
		if (!$menu_selector.hasClass('mmenu-save-state')) {
			return;
		}
		
		require(['elgg/Ajax'], function(Ajax) {
			var ajax = new Ajax(false);
			ajax.action('mmenu/save_menu_state', {
				data: {
					closed: menuIsOpen() ? 0 : 1
				}
			});
		});
	}
			
	var options = hooks.trigger('config:options', 'mmenu', {}, {
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
				use: "(min-width: 700px)"
			},
			expanded: {
				use: "(min-width: 900px)",
				initial: $('body').hasClass('mm-wrapper--sidebar-closed') ? 'closed' : 'open'
			}
		},
		navbars: [
			{
				"position": "top",
				"content": [
					'<?= $topbar; ?>'
				]
			},
			<?php if (!empty($bottombar)) {	?>
			{
				"position": "bottom",
				"content": [
					'<?= $bottombar; ?>'
				]
			}
			<?php } ?>
		],
		hooks: {
			'close:after': function() {
				setTimeout(function() {
					$menu_selector.trigger('mmenu.toggle');
				}, 400);
				
				// close all open panels
				this.API.openPanel(document.querySelector('#mm-1'));

				var $menu = $(this.node.menu);
				$menu.removeAttr('inert');
				$menu.children().not('.mm-navbars--top').attr('inert', 'true');
				
				saveMenuState();
			},
			'open:after': function() {
				setTimeout(function() {
					$menu_selector.trigger('mmenu.toggle');
				}, 400);
			
				var $menu = $(this.node.menu);
				$menu.children().removeAttr('inert');
				
				saveMenuState();
			},
			'init:after': function() {
				var $menu = $(this.node.menu);
				if ($menu.is('[inert]')) {
					$menu.removeAttr('inert');
					$menu.children().not('.mm-navbars--top').attr('inert', 'true');
				}
			}
		},
	});
			
	var configuration = hooks.trigger('config:configuration', 'mmenu', {}, {
		language: elgg.config.current_language,
		classNames: {
			selected: 'elgg-state-selected'
		},
		offCanvas: {
			page: {
				selector: 'body > .elgg-page'
			}
		}
	});
	
	const menu = new Mmenu('.elgg-menu-site-container', options, configuration);
	
	$(document).on('click', '.mmenu-toggle', function(event) {
		$menu_selector.addClass('mmenu-save-state');
		
		if (menuIsOpen()) {
			menu.API.close();
		} else {
			menu.API.open();
		}
		
		$menu_selector.removeClass('mmenu-save-state');
		
		event.preventDefault();
		event.stopImmediatePropagation();
	});
	
	$(document).on('mouseenter click', '.elgg-menu-site-container', function(event) {
		if (menuIsOpen() || $(event.target).is('.mmenu-toggle')) {
			return;
		}
		
		if (event.type === 'mouseenter' && 'ontouchstart' in document.documentElement) {
			return;
		}
		
		menu.API.open();
		// restore local session state to closed as we do not want this persistent
		window.sessionStorage.setItem('mmenuExpandedState', 'closed');
		
		$('.mm-slideout').on('mouseenter.mmenu', function() {
			$(this).off('mouseenter.mmenu');
			
			menu.API.close();
		});
	});
});
