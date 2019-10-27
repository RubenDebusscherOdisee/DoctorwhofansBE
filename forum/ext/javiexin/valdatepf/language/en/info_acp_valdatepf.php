<?php
/**
 *
 * Validated Date Profile Fields [English]
 *
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
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
// Validated Date
	'MIN_DATE'					=> 'Minimum date',
	'MIN_DATE_EXPLAIN'			=> 'If specified, the entered value must be later than this. It is possible to specify partial minimum dates (only year, or year and month).',
	'MAX_DATE'					=> 'Maximum date',
	'MAX_DATE_EXPLAIN'			=> 'If specified, the entered value must be earlier than this. It is possible to specify partial maximum dates (only year, or year and month).',
	'DATE_SELECT_AS'			=> 'Enter date as',
	'DATE_SELECT_AS_EXPLAIN'	=> 'What type of entry method will be used for this field: dropdowns or numeric fields.',
	'DATE_AS_DROPDOWN'			=> 'Dropdown',
	'DATE_AS_FIELD'				=> 'Number field',

	'FIELD_VALIDATION_DEFAULT'				=> 'The default date specified is invalid.',
	'FIELD_VALIDATION_DATE_INVALID_MIN'		=> 'The minimum date specified is invalid.',
	'FIELD_VALIDATION_DATE_INVALID_MAX'		=> 'The maximum date specified is invalid.',
	'FIELD_VALIDATION_DATE_MAX_BEFORE_MIN'	=> 'Inconsistent options: minimum date later than maximum date.',

	'FIELD_DATE_BEFORE_MINIMUM'	=> 'The date specified for field “%2$s” is earlier than required minimum. Specify a date after %1$s.',
	'FIELD_DATE_AFTER_MAXIMUM'	=> 'The date specified for field “%2$s” is later than required maximum. Specify a date before %1$s.',

));
