<?php
/**
 *
 * Recent searches on index. An extension for the phpBB Forum Software package.
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

$lang = array_merge($lang, array(
	'RSI_TITLE'			    => 'Recent searches on index',
	'RSI_INTRO'	            => 'This is configuration page for the Recent searches on index by Galandas.',	
	'RSI_VERSION'           => 'Version',
	'RSI_SETTINGS'          => 'Settings',
	'RSI_ALLOW'		        => 'Enable or Disable',	
	'RSI_ALLOW_EXPLAIN'     => 'Enable or Disable Recent searches on index',
	'RSI_NUMBER'            => 'Number Searches',
    'RSI_NUMBER_EXPLAIN'    => 'Number of Recent searches to display',	
	'RSI_SETTING_SAVED'	    => 'Recent searches Settings have been saved successfully!',
    //Add permissions acp	
	'ACL_A_RSI'		=> 'Can manage Recent searches on index',	
));
