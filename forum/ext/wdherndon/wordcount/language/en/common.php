<?php
/**
 *
 * Word Count. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, William D. Herndon, http://www.softwareschmiede-herndon.de
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
	'WORDCOUNT_WORDCOUNT'	=> ' word count: %1s',
));
