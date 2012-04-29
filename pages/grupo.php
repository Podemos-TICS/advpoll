<?php
/**
* /var/www/elgg/mod/polls/pages/all.php
 *
 * Copyright 2012 DRY Team
 *              - aruberuto
 *              - joker
 *              - ******
 *              y otros
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */
$title = elgg_echo('votaciones:grupo:titulo');
$container_guid = get_input('guid');
$container = get_entity($container_guid);
$group_context = get_input('group_context');
// Obtiene una lista de polls ordenada por fecha

if ("$group_context" == 'totus'){
	elgg_push_breadcrumb($container->name, "votaciones/group/" . $container->guid);
	elgg_push_breadcrumb(elgg_echo('votaciones:totus'));
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => 5,
	'full_view' => false,
	'container_guid' =>  $container_guid,
	));
	
} else {
if ("$group_context" == 'cerradas'){
	elgg_push_breadcrumb($container->name, "votaciones/group/" . $container->guid);
	elgg_push_breadcrumb(elgg_echo('votaciones:cerradas'));
$content = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => 5,
	'full_view' => false,
	'container_guid' =>  $container_guid,
	'metadata_name' => 'poll_cerrada',
	'metadata_value' => 'yes',
	));
	
} else {
	elgg_push_breadcrumb($container->name, "votaciones/group/" . $container->guid);
	elgg_push_breadcrumb(elgg_echo('votaciones:activas'));

$content = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => 5,
	'full_view' => false,
	'container_guid' =>  $container_guid,
	'metadata_name' => 'poll_cerrada',
	'metadata_value' => 'no',
	));
	
}
}

// Registra un botón "añadir nueva" si no se especifican parámetros añade
// ese por defecto
elgg_register_title_button('votaciones', 'nueva');
$filtros = elgg_view('votaciones/filtros_grupos', array(
	'filter_context' => "$group_context",
	'context' => 'votaciones'
	));

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filtros,
	'filter_context' => "$group_context",
	'sidebar' => ''
));
// Renderiza la página con el título y el cuerpo
echo elgg_view_page($title, $body);
