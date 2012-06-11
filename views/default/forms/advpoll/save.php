<?php
/**
 * Edit / add a poll
 *
 * @package Polls18
 *
 * Copyright 2012 DRY Team
 *              - aruberuto
 *              - joker
 *              - *****
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

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()
elgg_load_library('advpoll:model');



$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$tags = elgg_extract('tags', $vars, '');
$container_guid = elgg_extract('container_guid', $vars, '');
$guid = elgg_extract('guid', $vars, null);
$poll = elgg_extract('entity', $vars, null);
$path = elgg_extract('path', $vars, '');
$poll_closed = elgg_extract('poll_closed', $vars, 'no');
$auditoria = elgg_extract('auditoria', $vars, 'no');
$group = get_entity($container_guid);
$poll_tipo = elgg_extract('poll_tipo', $vars, 'normal');
$start_date = elgg_extract('start_date', $vars);
$end_date = elgg_extract('end_date', $vars);
$access_vote_id = elgg_extract('access_vote_id', $vars, ACCESS_DEFAULT);
$mostrar_resultados = elgg_extract('mostrar_resultados', $vars, 'no');
$can_change_vote = elgg_extract('can_change_vote', $vars, 'yes');

?>

<div>
	<label><?php echo elgg_echo('advpoll:pregunta'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>

<div>
	<label><?php echo elgg_echo('advpoll:discusion:previa'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'path', 'value' => $path)); 
	//TODO Modificarlo para enviar una lista de las páginas de discusión de
	// la votacion en el grupo?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('advpoll:acceso:ver'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>

<div>
	<label><?php echo elgg_echo('advpoll:acceso:vote'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_vote_id', 'value' => $access_vote_id)); ?>
</div>


<div id="opciones"><?php echo elgg_view('input/button', array('id' => 'nueva_opcion', 'value' => elgg_echo('advpoll:nueva:opcion')));?>
<label><?php echo elgg_echo('advpoll:opciones'); ?></label><br />

</div>

<div>
	<label><?php echo elgg_echo('advpoll:start_date'); ?>
	<?php echo elgg_view('input/date', array(
		'name' => 'start_date',
		'value' => $start_date,
		'timestamp' => true,
		'class' => 'continuos-date',
		)); ?>
	<?php echo elgg_echo('advpoll:end_date'); ?>
	<?php echo elgg_view('input/date', array(
		'name' => 'end_date',
		'value' => $end_date,
		'timestamp' => true,
		'class' => 'continuos-date',
		)); ?>
		</label>
	<?php echo elgg_echo('advpoll:help:date'); ?>
</div>
<?php /**
<div>
	<label><?php echo elgg_echo('advpoll:cerrada'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'poll_closed',
		 'options' => array(
			elgg_echo('option:no') => 'no' ,
			elgg_echo('option:yes') => 'yes',
			),
		'value' => $poll_closed,
		)); ?>
</div>
*/ ?>
<div>
	<label><?php echo elgg_echo('advpoll:auditoria'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'auditoria',
		 'options' => array(
			elgg_echo('option:no') => 'no' ,
			elgg_echo('option:yes') => 'yes',
			),
		'value' => $auditoria,
	));

	?>
</div>

<div>
	<label><?php echo elgg_echo('advpoll:tipo'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'poll_tipo',
		 'options' => array(
			elgg_echo('advpoll:option:normal') => 'normal' ,
			elgg_echo('advpoll:option:condorcet') => 'condorcet',
			),
		'value' => $poll_tipo,
		)); ?>
</div>

<div>
	<label><?php echo elgg_echo('advpoll:mostrar:resultados:durante'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'mostrar_resultados',
		 'options' => array(
			elgg_echo('option:no') => 'no' ,
			elgg_echo('option:yes') => 'yes',
			),
		'value' => $mostrar_resultados,
	));

	?>
</div>

<div>
	<label><?php echo elgg_echo('advpoll:can:change:vote'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'can_change_vote',
		 'options' => array(
			elgg_echo('option:no') => 'no' ,
			elgg_echo('option:yes') => 'yes',
			),
		'value' => $can_change_vote,
	));

	?>
</div>


<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
echo elgg_view('input/hidden', array('name' => 'num_opciones', 'id' => 'num_opciones', 'value' => $num_opciones));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>

<script type="text/javascript">
	$('#nueva_opcion').click(function() {
		// si estás aquí dentro es porque has pulsado el botón nueva_opcion
		// metemos en la variable número de opciones,
		// la longitud de opciones que haya o no haya... 0,1,2,3,4
		var num_opciones = $('.opcion').length;

		// Añadimos al selector <div id=opciones... un input text
		$('#opciones').append ('<div id="'+num_opciones+'"><br /><input type="text" name="opcion'+num_opciones+'" id="opcion'+num_opciones+'" class="elgg-input-text opcion" /><span class="eliminarcontomate" rel="'+num_opciones+'" ><?php echo elgg_echo('advpoll:opcion:borrame'); ?></span></div>');
		// cosa rara para que funcione el live, quizás.
		return false; 
	});
	$('.eliminarcontomate').live('click', function() {
	    // alert('hola caracola');
	    
	    // si estás aquí dentro es porque has pulsado alguna palabra,
	    // "borrame" contenida dentro de un class="eliminarcontomate"
	    // metemos dentro de la variable cual_borro, el contenido de 
	    // rel="0 o 1 o 2 o 3 o 4".....rel="'+num_opciones+'" para luego
	    // borrar todo el div de la opcion <div id="'+num_opciones+'">
	    var cual_borro = $(this).attr('rel');
	    
	    // metemos en la variable chapucilla, el selector(id) que se va a usar
	    var chapucilla = "#"+ cual_borro;
	    
	    // removemos chapucilla.
	    $(chapucilla).remove();
	    return false;
	});

	//$('.eliminarcontomate').click(function() {
		//alert('ha pulsado el boton borrame');
		//var cual_borro = $(this).attr('rel');
		//var x = '#'+ cual_borro
		//alert(x);
		//$(x).fadeOut();
	//});
	$('.elgg-form-advpoll-save').submit(function() {
		$('#num_opciones').val($('.opcion').length);
	});
</script>

