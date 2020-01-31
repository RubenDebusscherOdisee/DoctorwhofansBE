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
	'ACL_A_NEW_THREEDI_OS'	=> '<strong>OS</strong> - Can administer the Online Since',
	'ACL_U_NEW_THREEDI_OS'	=> '<strong>OS</strong> - Can view the Online Since',
]);
