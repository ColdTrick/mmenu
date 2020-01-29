<?php

namespace ColdTrick\Mmenu;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {

	/**
	 * {@inheritDoc}
	 */
	public function init() {
		elgg_register_simplecache_view('navigation/menu/site.js');
	}
}
