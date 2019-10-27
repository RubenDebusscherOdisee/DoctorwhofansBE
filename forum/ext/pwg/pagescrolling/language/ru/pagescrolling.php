<?php
/**
+-------------------------------------------------------------------------------+
|	Extension for the phpBB3 Forum Software package:	Page Scrolling			|
+-------------------------------------------------------------------------------+
|	Version:	1.4.0															|
|	Charset:	utf-8 without BOM												|
|	Date:		2018-08-14 10:00:00												|
|	License:	GNU General Public License, version 2 (GPL-2.0)					|
|	Homepage:	https://github.com/PWG-Extension/pagescrolling					|
|	Email:																		|
|	Author:		© Alexander Kadnikov [Predator]									|
+-------------------------------------------------------------------------------+
|	© «PWG», 2004-2018. All Rights Reserved.									|
+-------------------------------------------------------------------------------+
*/

/**
 * DO NOT CHANGE
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
	'PS_UP' => 'Прокрутить страницу вверх',
	'PS_DOWN' => 'Прокрутить страницу вниз',
));
