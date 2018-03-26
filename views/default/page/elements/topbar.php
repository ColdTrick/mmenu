<?php

/**
 * Topbar
 */

echo elgg_view('output/url', [
	'id' => 'mmenu-toggle',
	'href' => '#',
	'text' => false,
	'icon' => 'bars',
]);

echo elgg_view_menu('site', ['menu_view' => 'mmenu/menu']);
echo elgg_view_menu('footer');
?>

<div class="elgg-nav-logo">
	<?php
	echo elgg_view('page/elements/header_logo');
	?>
</div>

<?php
//elgg_view('core/account/login_dropdown');

echo elgg_format_element('div', [
	'class' => 'elgg-nav-search',
], elgg_view('search/search_box'));
