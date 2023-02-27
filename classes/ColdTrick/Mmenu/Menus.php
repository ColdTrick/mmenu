<?php

namespace ColdTrick\Mmenu;

/**
 * Menu callbacks
 */
class Menus {
	
	/**
	 * Registers topbar menu items to the site menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:site'
	 *
	 * @return array
	 */
	public static function topbarToSite(\Elgg\Event $event) {
		if (!elgg_get_plugin_setting('topbar_to_site', 'mmenu')) {
			return;
		}
		
		$result = $event->getValue();
		
		$menu = _elgg_services()->menus->getUnpreparedMenu('topbar');
		foreach ($menu->getItems() as $item) {
			$item->setSection('account_'. $item->getSection());
			
			if ($item->getName() === 'account') {
				$viewer = elgg_get_logged_in_user_entity();
				unset($item->icon_alt);
				$item->setLinkClass('elgg-avatar-tiny');
				$item->icon = elgg_view('output/img', [
					'src' => $viewer->getIconURL('tiny'),
					'alt' => $viewer->getDisplayName(),
				]);
			}
			
			$result[] = $item;
		}
		
		return $result;
	}
}
