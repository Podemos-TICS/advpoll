<?php
/**
 * Main content filter
 *
 * Select between user, friends, and all content
 *
 * @uses $vars['filter_context']  Filter context: all, friends, mine
 * @uses $vars['filter_override'] HTML for overriding the default filter (override)
 * @uses $vars['context']         Page context (override)
 */

if (isset($vars['filter_override'])) {
	echo $vars['filter_override'];
	return true;
}

$context = elgg_extract('context', $vars, elgg_get_context());
$grupo = get_input('guid');

if (elgg_is_logged_in() && $context) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_context', $vars, 'all');

	// generate a list of default tabs
	$tabs = array(
		'en_curso' => array(
			'text' => elgg_echo('advpoll:filtros:encurso'),
			'href' => (isset($vars['en_curso_link'])) ? $vars['en_curso_link'] : "$context/group/$grupo/en_curso",
			'selected' => ($filter_context == 'activas'),
			'priority' => 100,
		),
		'totus' => array(
			'text' => elgg_echo('advpoll:filtros:totus'),
			'href' => (isset($vars['totus_link'])) ? $vars['totus_link'] : "$context/group/$grupo/totus",
			'selected' => ($filter_context == 'totus'),
			'priority' => 200,
		),
		
		'finalizadas' => array(
			'text' => elgg_echo('advpoll:filtros:finalizadas'),
			'href' => (isset($vars['finalizadas_link'])) ? $vars['finalizadas_link'] : "$context/group/$grupo/finalizadas",
			'selected' => ($filter_context == 'cerradas'),
			'priority' => 500,
		),
		'no_iniciadas' => array(
			'text' => elgg_echo('advpoll:filtros:noiniciadas'),
			'href' => (isset($vars['no_iniciadas_link'])) ? $vars['no_iniciadas_link'] : "$context/group/$grupo/no_iniciadas",
			'selected' => ($filter_context == 'cerradas'),
			'priority' => 500,
		),
		
			);
	
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		
		elgg_register_menu_item('filter', $tab);
	}

	echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
