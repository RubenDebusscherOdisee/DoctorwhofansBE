<?php
/**
 *
 * Simple News Admin. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Galandas, http://phpbb3world.altervista.org
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
// ’ » „ “ — …
//

$lang = array_merge($lang, array(
	'ACP_NEWS_TITLE'				=> 'Simple News Admin',
	'ACP_NEWS_VERSION'				=> 'Version',
	'ACP_NEWS_ADMIN'				=> 'Manage Simple News Admin',
	'ACP_NEWS_CONFIG'				=> 'Configuration',
	'ACP_NEWS_PREVIEW'				=> 'Preview message Simple News Admin',
	'ACP_NEWS_SETTINGS'				=> 'Settings',
	'ACP_NEWS_ENABLE'				=> 'Enable Simple News Admin',
	'ACP_NEWS_ENABLE_EXPLAIN'		=> 'If you enable Simple News Admin, all will be able to see it, or you can decide which groups can see Simple News Admin in the Permissions -> Global Permissions -> Group permissions tab.',
	'ACP_NEWS_MESSAGE'				=> 'News Admin',
	'ACP_NEWS_MESSAGE_EXPLAIN'		=> 'Below you configure the news admin message you want to show to users.',
	'ACP_NEWS_SETTING_SAVED'		=> 'The Simple News Admin was successfully updated!',
	'ACP_NEWS_ADMIN_CREDITS'		=> 'Simple News Admin Extension by <a href="http://phpbb3world.altervista.org">Galandas</a>',
	'ACP_NEWS_DONATE'				=> '<a href="https://www.paypal.me/Galandas"><strong>Donate</strong></a>',
	'ACP_NEWS_DONATE_EXPLAIN'		=> 'If you like this extension considers a donation offer a pizza',	
	'ACP_NEWS_ASPECT'				=> 'Appearance Template',
	'ACP_NEWS_ASPECT_EXPLAIN'		=> 'Choose which template to use between the two made ​​available, the Forabg default or the alternative Forabg2',
	'ASPECT_A'						=> 'Forabg1',
	'ASPECT_B'						=> 'Forabg2',
	// Permission groups	
	'ACL_U_AT_NEW'					=> 'Can see Simple News Admin',
));