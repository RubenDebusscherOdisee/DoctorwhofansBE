<?php
/**
*
* @package phpBB Extension - Advanced Active Topics
* @copyright (c) 2017 Galandas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_LAST_TOPIC'					=> 'Advanced Active Topics',
	'ACP_LAST_TOPIC_EXPLAIN'		    => 'Extension Advanced Active Topics by <a href="http://phpbb3world.altervista.org"><strong>Galandas</strong></a>',
    'ACP_LAST_TOPIC_SETTINGS'			=> 'Enable Disable',
	'ACP_LAST_TOPIC_CONF'				=> 'Configuration',
    'ACP_LAST_TOPIC_CONFS'			    => 'Settings',
	'ACP_LAST_TOPIC_DONATE'			    => '<a href="https://www.paypal.me/Galandas"><strong>Donate</strong></a>',
	'ACP_LAST_TOPIC_DONATE_EXPLAIN'	    => 'If you like this extension considers a donation offer a pizza',	
    'LAST_TOPIC_CONFIG_SAVED'         	=> 'Advanced Active Topics settings saved',	
	'ALLOW_LAST_TOPIC'					=> 'Enable',
	'ALLOW_LAST_TOPIC_EXPLAIN'			=> 'Enable or Disable Advanced Active Topics',
	'ALLOW_LAST_TUTTO'					=> 'Enable for overall',
	'ALLOW_LAST_TUTTO_EXPLAIN'			=> 'Enable or Disable the view the Advanced Active Topics in overall forum and not only in index',
	'LAST_TOPIC_ALLERTS'                => 'Note If you enable the view around the forum you have to disable the view in the index, otherwise they will see two',
    'ALLOW_LAST_INDEX'                  => 'Enable on Index',
    'ALLOW_LAST_INDEX_EXPLAIN'          => 'Enable or Disable the view of the Advanced Active Topics on index',
    'LAST_TOPIC_ALLERT'                 => 'Note If you enable the view only in index you have to disable the view around the forum, otherwise they will see two',	
	'LAST_TOPIC_TOTAL'				    => 'Total Topics',
	'LAST_TOPIC_TOTAL_EXPLAIN'			=> 'Enter the number of topics that you wish to show users',
	'LAST_TYPE'				            => 'Template',
	'LAST_TYPE_EXPLAIN'				    => 'Select the template to display - the current options are <strong>Forabg, Panel bg3</strong>',
	'LAST_DIRECTION'					=> 'Ticker direction',
	'LAST_DIRECTION_EXPLAIN'			=> 'Choose the direction of js - current options are Up or Down',
	'LAST_UP_DIRECTION'					=> 'Up',
	'LAST_DOWN_DIRECTION'				=> 'Down',	
	'LAST_TITLETEXT'			        => 'Active Topics',
    'LAST_POS'                          => 'Position',
    'LAST_POS_EXPLAIN'                  => 'Choose the position. High after the navbar, appears before the forum list on top.<br />In low after Statistics, it appears after the forum Statistics.',
    'LAST_AT_TOP'                       => 'High after the navbar',
	'LAST_AT_FUT'                       => 'In low after Statistics',
	'LAST_ASPECT_A'                     => 'Panel bg3',
	'LAST_ASPECT_B'                     => 'Forabg',
    // Buttons ON OFF	
	'LAST_NAVIGATION'		        => 'Enable Buttons',
	'LAST_NAVIGATION_EXPLAIN'		=> 'You can decide whether to display the buttons under the Advanced Active Topics',	
	'PREVIOUS_SCROLL'			    => 'Back',
	'NEXT_SCROLL'				    => 'Forward',
	'START_SCROLL'				    => 'Play',
	'STOP_SCROLL'				    => 'Stop',
    // Permission groups	
	'ACL_U_AT_ADV'	                => 'Can see Advanced Active Topics',
));