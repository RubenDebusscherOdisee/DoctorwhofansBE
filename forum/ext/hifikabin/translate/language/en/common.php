<?php
/**
*
* @package phpBB Extension - Google Translator
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_TRANSLATE_CONFIG_EXPLAIN'		=> 'This is configuration page for the Google Translator extension. ',

	'ACP_TRANSLATE_CONFIG_SET'			=> 'Configuration',
	'TRANSLATE_CONFIG_SAVED'			=> 'Google Translator settings saved',

	'TRANSLATE_DEFAULT_LANG'			=> 'Board Language',
	'TRANSLATE_DEFAULT_LANG_EXPLAIN'	=> 'Enter the code for the Default Language for your Board',

	'TRANSLATE_CHOICE_LANG'				=> 'Translations',
	'TRANSLATE_CHOICE_LANG_EXPLAIN'		=> 'Enter the codes of the languages you want to have available seperated by a comma for example de,fr,es',
));

