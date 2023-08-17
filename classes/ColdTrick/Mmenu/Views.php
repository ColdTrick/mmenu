<?php

namespace ColdTrick\Mmenu;

/**
 * View related callbacks
 */
class Views {
	
	/**
	 * Adds classes to html
	 *
	 * @param \Elgg\Event $event 'view_vars', 'page/elements/html'
	 *
	 * @return array
	 */
	public static function addHtmlClasses(\Elgg\Event $event) {
		$result = $event->getValue();
				
		$menu_classes = [];
		$menu_classes = ['mm-wrapper--sidebar-expanded'];
		
		if (elgg_get_plugin_user_setting('mmenu-closed', 0, 'mmenu', false)) {
			$menu_classes[] = 'mm-wrapper--sidebar-closed';
		} else {
			$menu_classes[] = 'mm-wrapper--opened';
		}
		
		$body_attrs = elgg_extract('body_attrs', $result, []);
		$body_attrs['class'] = elgg_extract_class($body_attrs, $menu_classes);
		
		$result['body_attrs'] = $body_attrs;
				
		return $result;
	}
}
