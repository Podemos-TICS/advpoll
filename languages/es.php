<?php
/**
 * The core language file is in /languages/en.php and each plugin has its
 * language files in a languages directory. To change a string, copy the
 * mapping into this file.
 *
 * For example, to change the blog Tools menu item
 * from "Blog" to "Rantings", copy this pair:
 * 			'blog' => "Blog",
 * into the $mapping array so that it looks like:
 * 			'blog' => "Rantings",
 *
 * Follow this pattern for any other string you want to change. Make sure this
 * plugin is lower in the plugin list than any plugin that it is modifying.
 *
 * If you want to add languages other than English, name the file according to
 * the language's ISO 639-1 code: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
 */

$mapping = array(
	'votaciones:titulo' => 'Votaciones',
	'votaciones:menu' => 'Votaciones',
	'votaciones:nueva' => 'Nueva Votación',
	'votaciones:editare' => 'Editor de votaciones',
	'votaciones:enviada:nueva' => 'Votación creada satisfactoriamente',
	'votaciones:discusion:previa' => 'Dirección de enlace a la discusión previa a la votación',
	'votaciones:opciones' => 'Opciones para la votación',
	'votaciones:nueva:opcion' => '+',
	'votaciones:numero:votos:opcion' => 'Numero de votos obtenidos -> ',
	'votaciones:resultados' => 'Resultados de la votación',
	'votaciones:votar:opcion' => 'Elige la opción que quieras',
	'votaciones:respuesta' => 'Opción',
	'votaciones:numero:votos:total' => 'Número Total de votos -> ',
	'votaciones:debate:previo:link' => 'Enlace al debate previo',
);

add_translation('es', $mapping);
