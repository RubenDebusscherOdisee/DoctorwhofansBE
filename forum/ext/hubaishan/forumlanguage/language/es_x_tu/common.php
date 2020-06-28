<?php

/**
 *
 * Forum Language. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Saeed Hubaishan, http://salafitech.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'FORUM_LANGUAGE'			=> 'Idioma del foro',
	'DEFAULT_LANGUAGE'			=> 'Idioma por defecto',
	'FL_AFTER_LANGUAGE_PACK_DELETED' => 'Y todos los foros que usan este idioma se han restablecido al idioma predeterminado del foro.',
));
