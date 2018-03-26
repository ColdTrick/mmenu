define(['elgg', 'jquery', 'jquery.mmenu/jquery.mmenu.all'], function (elgg, $) {
	$(document).ready(function() {
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
					size: 60
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
					"position": "bottom",
					"content": [
						$('.elgg-menu-footer').html()
					]
				}
			]
		}, {
			// configuration
			offCanvas: {
				pageSelector: '.elgg-page'
			},
		});
		
		var menu = $menu_selector.data('mmenu');
		var $toggle_button = $('#mmenu-toggle');
		
		
		$toggle_button.click(function() {
			menu.open();
		});
		
		
		
		
		menu.bind('open:finish', function() {
			setTimeout(function() {
				$('#my-button > .elgg-icon').addClass('elgg-icon-times fa-times').removeClass('elgg-icon-bars fa-bars');
			}, 100);
		});
		menu.bind('close:finish', function() {
			setTimeout(function() {
				$('#my-button > .elgg-icon').removeClass('elgg-icon-times fa-times').addClass('elgg-icon-bars fa-bars');
			}, 100);
		});
	});
});
