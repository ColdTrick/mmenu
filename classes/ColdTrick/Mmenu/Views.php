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
				
		$menu_classes = ['mm-wrapper_sidebar-expanded'];
		
		if (elgg_get_plugin_user_setting('mmenu-closed', 0, 'mmenu', false)) {
			$menu_classes[] = 'mm-wrapper_sidebar-closed';
		} else {
			$menu_classes[] = 'mm-wrapper_sidebar-opened';
		}
		
		$body_attrs = elgg_extract('body_attrs', $result, []);
		$body_attrs['class'] = elgg_extract_class($body_attrs, $menu_classes);
		
		$result['body_attrs'] = $body_attrs;
				
		return $result;
	}
}
