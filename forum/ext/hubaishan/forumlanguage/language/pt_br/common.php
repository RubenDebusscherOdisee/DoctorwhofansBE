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
	'FORUM_LANGUAGE'			=> 'Linguagem deste Fórum',
	'DEFAULT_LANGUAGE'			=> 'Linguagem Padrão',
	'FL_AFTER_LANGUAGE_PACK_DELETED' => 'E todos os foruns usando esta linguagem foram resetados para a linguagem padrão.',
));
