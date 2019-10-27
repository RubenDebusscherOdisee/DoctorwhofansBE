<?php
/**
 *
 * Advanced login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, Galandas, http://phpbb3world.altervista.org
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
	'ACP_WIDTH_ADVLOGIN'			=> 'Width in pixels',
	'ACP_WIDTH_ADVLOGIN_EXPLAIN'	=> 'It is recommended not to exceed the recommended requirements for better viewing also for mobile devices Minimum 300, Maximum 350.',	
	'ACP_HEIGHT_ADVLOGIN'			=> 'Height in pixels',
	'ACP_HEIGHT_ADVLOGIN_EXPLAIN'	=> 'It is recommended not to exceed the recommended requirements for better viewing. Minimum 150, maximum 600',	
	'ACP_ADVLOGIN'			        => 'Advanced login',
	'ACP_ADVLOGIN_SETTINGS'	        => 'Configuration',
	'ACP_ADVLOGIN_CONFIG_SET'		=> 'Enable or Disable',
	'ACP_ADVLOGIN_CONFIG'		    => 'Enter Text',	
	'ACP_ADVLOGIN_CONFIG_SAVED'		=> 'Advanced login settings saved',
	'ACP_ADVLOGIN_VERSION'			=> 'Version',
	'ACP_ADVLOGIN_DONATE'			=> '<a href="https://www.paypal.me/Galandas"><strong>Donate</strong></a>',
	'ACP_ADVLOGIN_DONATE_EXPLAIN'	=> 'If you like this extension considers a donation offer a pizza',	
	'ACP_ADVLOGIN_CREDITS'			=> 'Extension created by <a href="http://phpbb3world.altervista.org"><strong>Galandas</strong></a>',
	'ACP_ADVLOGIN_ENABLE'			=> 'Enable Advanced login',
	'ACP_ADVLOGIN_ENABLE_EXPLAIN'	=> 'Enable Advanced login extension in global display the forum',
	'ACP_ADVLOGIN_TEXT'				=> 'Display text',
	'ACP_ADVLOGIN_TEXT_EXPLAIN'		=> 'Enter the text you want to show you can use HTML.',
	'ACP_ADVLOGIN_COLOR'			=> 'Sets the background color',
	'ACP_ADVLOGIN_COLOR_EXPLAIN'	=> 'You can change the background color using a hex code (e.g: A1D490). Leave this field blank to use the default color.',
	'ACP_ADVLOGIN_ASPECT'           => 'Choice of image ON - OF',
	'ACP_ADVLOGIN_ASPECT_EXPLAIN'   => 'Choose whether you want to display the image. Note this also changes the default background.',
    // Appearance choice	
	'ACP_ASPECT_A'           => 'Appearance 1',
	'ACP_ASPECT_B'           => 'Appearance 2',
));
