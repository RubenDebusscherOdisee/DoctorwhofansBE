<?php
/**
 *
 * Online Since. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2005 - 2019, 3Di, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// Some characters you may want to copy&paste:
// ’ » “ ” …

$lang = array_merge($lang, [
	'ACL_CAT_3DI'	=> '3Di',

	'OS_START'		=> 'Board start date',
	'OS_ELAPSED'	=> 'Elapsed time',
	'OS_TITLE'		=> 'Online since',
	'OS_AT'			=> 'at',

	'OS_YEAR'	=> [
		1	=> '<strong>%d</strong> Year',
		2	=> '<strong>%d</strong> Years',
	],
	'OS_MONTH'	=> [
		1	=> '<strong>%d</strong> Month',
		2	=> '<strong>%d</strong> Months',
	],
	'OS_DAY'	=> [
		1	=> '<strong>%d</strong> Day',
		2	=> '<strong>%d</strong> Days',
	]
]);
