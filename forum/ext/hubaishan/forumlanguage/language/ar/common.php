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
	'FORUM_LANGUAGE'			=> 'لغة المنتدى',
	'DEFAULT_LANGUAGE'			=> 'اللغة الافتراضية',
	'FL_AFTER_LANGUAGE_PACK_DELETED' => 'وكل المنتديات التي تستخدم هذه اللغة تم تحويلهم إلى اللغة الافتراضية.',
));
