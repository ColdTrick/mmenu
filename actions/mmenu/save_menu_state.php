<?php

$closed = (bool) get_input('closed', false);

if (!elgg_set_plugin_user_setting('mmenu-closed', $closed, elgg_get_logged_in_user_guid(), 'mmenu')) {
	return elgg_error_response();
}

return elgg_ok_response();
