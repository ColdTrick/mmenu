<?php
/**
 * A single element of a menu.
 *
 * @package Elgg.Core
 * @subpackage Navigation
 *
 * @uses $vars['item']       ElggMenuItem
 * @uses $vars['item_class'] Additional CSS class for the menu item
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof \ElggMenuItem) {
	return;
}

$item_vars = [];
$child_menu_view = '';

$children = $item->getChildren();
if (!empty($children)) {
	$link_class = 'elgg-menu-closed';
	if ($item->getSelected()) {
		$link_class = 'elgg-menu-opened';
	}
	
	$item->addLinkClass($link_class);

	$item->addLinkClass('elgg-menu-parent');

	$child_menu_vars = $item->getChildMenuOptions();
	$child_menu_vars['id'] = $item->getId();
	$child_menu_vars['items'] = $children;
	$child_menu_vars['class'] = elgg_extract_class($child_menu_vars, ['elgg-menu', 'elgg-child-menu']);

	$display = elgg_extract('display', $child_menu_vars, 'default');
	unset($child_menu_vars['display']);

	switch ($display) {
		case 'dropdown':
			$item->addDeps(['elgg/menus/dropdown']);
			$item->addItemClass('elgg-menu-item-has-dropdown');
			break;

		case 'toggle':
			$item->addDeps(['elgg/menus/toggle']);
			$item->addItemClass('elgg-menu-item-has-toggle');
			break;
	}

	$child_menu_view = elgg_view('navigation/menu/elements/section', $child_menu_vars);
}

$item_vars['data-menu-item'] = $item->getName();

$item_vars['class'] = elgg_extract_class($vars, $item->getItemClass(), 'item_class');
if ($item->getSelected()) {
	$item_vars['class'][] = 'elgg-state-selected';
}


if ($child_menu_view && ($item->getHref() === false)) {
	$item_vars['class'][] = 'elgg-anchor';
	
	$span_vars = array_merge($item->getValues(), $vars);
	$span_vars['class'] = elgg_extract_class($vars, ['elgg-menu-content']);

	if ($item->getLinkClass()) {
		$span_vars['class'][] = $item->getLinkClass();
	}

	if ($item->getHref() === false || $item->getHref() === null) {
		$span_vars['class'][] = 'elgg-non-link';
	}
	
	$icon = elgg_extract('icon', $span_vars, '');
	unset($span_vars['icon']);
	
	if ($icon && !preg_match('/^</', $icon)) {
		$icon = elgg_view_icon($icon, [
			'class' => 'elgg-anchor-icon',
		]);
	}

	$item_content = elgg_format_element('span', $span_vars, $icon . elgg_format_element('span', ['class' => 'elgg-anchor-label'], $item->getText()));
} else {
	$item_content = elgg_view('navigation/menu/elements/item/url', ['item' => $item]);
}

$item_vars['title'] = elgg_extract('title', $item->getValues(), $item->getText());

$item_view = $item_content . $child_menu_view;

echo elgg_format_element('li', $item_vars, $item_view);
