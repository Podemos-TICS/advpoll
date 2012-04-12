<?php
/*
 * Copyright 2012 DRY Team
 *              - aruberuto
 *              - joker
 *              - ****
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
 
/*
checks for votes on the poll
@param ElggEntity $poll
@param guid
@return true/false
*/
function polls_check_for_previous_vote($poll, $user_guid)
{	
	$votes = get_annotations($poll->guid,"object","poll","vote","",$user_guid,1);
	if ($votes) {
		return true;
	} else {
		return false;
	}
}

function polls_get_choices($poll) {
	$options = array(
		'relationship' => 'poll_choice',
		'relationship_guid' => $poll->guid,
		'inverse_relationship' => TRUE,
		'order_by_metadata' => array('name'=>'display_order','direction'=>'ASC')
	);
	return elgg_get_entities_from_relationship($options);
}

function polls_get_choice_array($poll) {
	$choices = polls_get_choices($poll);
	$responses = array();
	if ($choices) {
		$i = 1;
		foreach($choices as $choice) {
			
			$label = elgg_echo('votaciones:respuesta') . " $i: "  . $choice->text;
			$responses[$label] = $choice->guid;
			$i = $i+1;
		}
	}	
	return $responses;
}

function polls_add_choices($poll,$choices) {
	$i = 0;
	if ($choices) {
		foreach($choices as $choice) {
			$poll_choice = new ElggObject();
			$poll_choice->subtype = "poll_choice";
			$poll_choice->text = $choice;
			$poll_choice->display_order = $i*10;
			$poll_choice->access_id = $poll->access_id;
			$poll_choice->save();
			add_entity_relationship($poll_choice->guid, 'poll_choice', $poll->guid);
			$i += 1;
		}
	}
}

function polls_delete_choices($poll) {
	$choices = polls_get_choices($poll);
	if ($choices) {
		foreach($choices as $choice) {
			$choice->delete();
		}
	}
}

function polls_replace_choices($poll,$new_choices) {
	polls_delete_choices($poll);
	polls_add_choices($poll, $new_choices);
}

function polls_activated_for_group($group) {
	$group_polls = get_plugin_setting('group_polls', 'polls');
	if ($group && ($group_polls != 'no')) {
		if ( ($group->polls_enable == 'yes') 
			|| ((!$group->polls_enable && ((!$group_polls) || ($group_polls == 'yes_default'))))) {
			return true;
		}
	}
	return false;		
}

function polls_can_add_to_group($group,$user=null) {
	$polls_group_access = get_plugin_setting('group_access', 'polls');
	if (!$polls_group_access || $polls_group_access == 'admins') {
		return $group->canEdit();
	} else {
		if (!$user) {
			$user = get_loggedin_user();
		}
		return $group->canEdit() || $group->isMember($user);
	}
}

function remove_anotation_by_entity_guid_user_guid($annotation, $entity_guid, $user_guid){
	$entity = get_entity($entity_guid);
	$all_annotations = $entity->getAnnotations($annotation);
	foreach ($all_annotations as $annotation_entity){
		if ($annotation_entity->owner_guid == $user_guid 
			&&
			$annotation_entity->entity_guid == $entity_guid){
				$annotation_id = $annotation_entity->id;
				elgg_delete_annotation_by_id($annotation_id);
				return TRUE;
				
			} else { 
				return FALSE;
			}
		}
	}

function votaciones_preparar_vars($votaciones = null) {

	// input names => default
	$container_guid = get_input('container_guid');
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => $container_guid,
		'guid' => '',
		'entity' => $votaciones,
		'path' => 'http://',
		'poll_cerrada' => 'no',
		'auditoria' => 'no',
	);

	if ($votaciones) {
		foreach (array_keys($values) as $field) {
			if (isset($votaciones->$field)) {
				$values[$field] = $votaciones->$field;
			}
		}
	}

	if (elgg_is_sticky_form('votaciones')) {
		$sticky_values = elgg_get_sticky_values('votaciones');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('votaciones');

	return $values;
}
?>
