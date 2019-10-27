<?php
/**
*
* WTTU Extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 Ather
* @license GNU General Public License, version 2 (GPL-2.0)
*
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	
	'WTTU_TITLE'					=> 'Was This Topic Useful',
	'WTTU_CONFIG'					=> 'Settings',
	'WTTU_EXPLAIN'					=> 'Here you can manage the Extension Was this topic useful?. You can set up which type of links will be shown or not',
	'WTTU_SAVED'					=> 'Settings have been updated!',
	'WTTU_ENABLE'					=> 'Enable Was This Topic Useful Extension.',
	'WTTU_ENABLE_EXPLAIN'			=> 'This will enable Was This Topic Useful Extension. Please note that even if this is option is enabled and all other options are disabled, The Extension will not function.',
	'WTTU_LINK_ENABLE'				=> 'Enable Link mode',
	'WTTU_LINK_EXPLAIN'				=> 'This option will enable link to thread in simple link',
	'WTTU_BBCODE_ENABLE'			=> 'Enable BBcode mode',
	'WTTU_BBCODE_EXPLAIN'			=> 'This option will enable link to thread in BB code format',
	'WTTU_HTML_ENABLE'				=> 'Enable HTML',
	'WTTU_HTML_EXPLAIN'				=> 'This option will enable link to thread in HTML format',
	'WTTU_TYPE'						=> 'Type of URL',
	'WTTU_TYPE_EXPLAIN'				=> 'Select Which Type of URL do you want<br /><a href="http://www.marketing-jive.com/2009/05/what-is-canonical-url.html" target="_blank">What is a canonical url?</a>',
	'SIMPLE'						=> 'Simple',
	'CANONICAL'						=> 'Canonical',
	
	
));
