<?php

$closed = (bool) get_input('closed', false);

$user = elgg_get_logged_in_user_entity();
if (!$user instanceof \ElggUser) {
	return elgg_error_response();
}

if (!$user->setPluginSetting('mmenu', 'mmenu-closed', $closed)) {
	return elgg_error_response();
}

return elgg_ok_response();
