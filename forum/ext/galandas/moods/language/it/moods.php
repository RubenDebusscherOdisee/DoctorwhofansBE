<?php
/**
*
* Mood. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2017 Galandas, http://phpbb3world.altervista.org
* @copyright Used Code Genders extension, 2016 Rich McGirr (RMcGirr83)
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

$lang = array_merge($lang, array(
	'MOOD'					=> 'Umore',
	'MOOD_NONE'				=> 'Non specificato',
	'EM-BIGGRIN'			=> 'Contento',
	'EM-CONFUSED'			=> 'Confuso',
	'EM-COOL'				=> 'Cool',
	'EM-CRY'				=> 'Stò piangendo',
	'EM-EEK'				=> 'Non ci posso credere',
	'EM-EVIL'				=> 'Indemoniato',
	'EM-LOL'				=> 'LOL',
	'EM-MAD'				=> 'Impazzito',
	'EM-MRGREEN'			=> 'Mr Green',
	'EM-NEUTRAL'			=> 'Neutro',
	'EM-RAZZ'				=> 'Sorridente',
	'EM-REDFACE'			=> 'Arrossito',
	'EM-ROLLEYES'			=> 'Non capisco',
	'EM-SAD'				=> 'Triste',
	'EM-SCREAM'				=> 'Sclerato',
	'EM-SMILE'				=> 'Faccia sorridente',
	'EM-SURPRISED'			=> 'Sorpreso',
	'EM-TWISTED'			=> 'Contorto',
	'EM-UGEEK'				=> 'A dondolo',
	'EM-WINK'				=> 'Strizzò l’occhio',
	'TOO_LARGE_USER_MOOD'	=> 'Il valore dell’umore è troppo grande.',
	'TOO_SMALL_USER_MOOD'	=> 'Il valore dell’umore è troppo piccolo.',
));
