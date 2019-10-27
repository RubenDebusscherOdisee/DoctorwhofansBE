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
	'ACP_NEWS_VERSION'				=> 'Versione',
	'ACP_NEWS_ADMIN'				=> 'Gestisci Simple News Admin',
	'ACP_NEWS_CONFIG'				=> 'Configurazione',
	'ACP_NEWS_PREVIEW'				=> 'Anteprima messaggio Simple News Admin',
	'ACP_NEWS_SETTINGS'				=> 'Impostazioni',
	'ACP_NEWS_ENABLE'				=> 'Abilita Simple News Admin',
	'ACP_NEWS_ENABLE_EXPLAIN'		=> 'Se si abilita Simple News Admin, tutti saranno in grado di vederlo, oppure puoi decidere quali Gruppi può vedere Simple News Admin nella scheda Permessi -> Permessi globali -> Permessi gruppi.',
	'ACP_NEWS_MESSAGE'				=> 'News Admin',
	'ACP_NEWS_MESSAGE_EXPLAIN'		=> 'Di seguito puoi configurare il messaggio news che desideri mostrare agli utenti.',
	'ACP_NEWS_SETTING_SAVED'		=> 'Simple News Admin è stato aggiornato con successo!',
	'ACP_NEWS_ADMIN_CREDITS'		=> 'Estensione Simple News Admin by <a href="http://phpbb3world.altervista.org">Galandas</a>',
	'ACP_NEWS_DONATE'				=> '<a href="https://www.paypal.me/Galandas"><strong>Donate</strong></a>',
	'ACP_NEWS_DONATE_EXPLAIN'		=> 'Se ti piace questa estensione considera una donazione offrimi una pizza',	
	'ACP_NEWS_ASPECT'				=> 'Aspetto Template',
	'ACP_NEWS_ASPECT_EXPLAIN'		=> 'Scegli quale Template utilizzare tra i due disponibili, il Forabg di default o in alternativa Forabg2',
	'ASPECT_A'						=> 'Forabg1',
	'ASPECT_B'						=> 'Forabg2',
	// Permission groups	
	'ACL_U_AT_NEW'					=> 'Può vedere Simple News Admin',
));