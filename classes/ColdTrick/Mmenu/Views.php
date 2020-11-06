<?php

namespace ColdTrick\Mmenu;

class Views {
	
	/**
	 * Adds classes to html
	 *
	 * @param \Elgg\Hook $hook the hook
	 *
	 * @return array
	 */
	public static function addHtmlClasses(\Elgg\Hook $hook) {
		$result = $hook->getValue();
				
		$menu_classes = [];
		
		$closed = false;
		if (elgg_is_logged_in()) {
			$closed = (bool) elgg_get_plugin_user_setting('mmenu-closed', elgg_get_logged_in_user_guid(), 'mmenu', $closed);
		}
		
		if ($closed) {
			$menu_classes[] = 'mm-wrapper_sidebar-closed';
			$menu_classes[] = 'mm-wrapper_sidebar-collapsed';
		} else {
			$menu_classes[] = 'mm-wrapper_sidebar-opened';
			$menu_classes[] = 'mm-wrapper_sidebar-expanded';
		}
		
		$body_attrs = elgg_extract('body_attrs', $result, []);
		$body_attrs['class'] = elgg_extract_class($body_attrs, $menu_classes);
		
		$result['body_attrs'] = $body_attrs;
				
		return $result;
	}
	
	/**
	 * Adds classes to html
	 *
	 * @param \Elgg\Hook $hook the hook
	 *
	 * @return array
	 */
	public static function addPageClasses(\Elgg\Hook $hook) {
		$result = $hook->getValue();
		
// 		$page_vars = elgg_extract('page_attrs', $result, []);
// 		$page_vars['class'] = elgg_extract_class($page_vars, ['mm-page', 'mm-slideout']);
		
// 		$result['page_attrs'] = $page_vars;
		
		return $result;
	}
}
