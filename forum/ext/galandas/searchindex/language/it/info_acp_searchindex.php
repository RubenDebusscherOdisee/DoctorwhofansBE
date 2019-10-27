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
	'RSI_TITLE'			    => 'Ricerche recenti sull’indice',
	'RSI_INTRO'	            => 'Questa è la pagina di configurazione dell’Estensione Ricerche recenti sull’indice by Galandas.',	
	'RSI_VERSION'           => 'Versione',
	'RSI_SETTINGS'          => 'Impostazioni',
	'RSI_ALLOW'		        => 'Abilita o disabilita',	
	'RSI_ALLOW_EXPLAIN'     => 'Abilita o disabilita le ricerche recenti sull’indice',
	'RSI_NUMBER'            => 'Numero Ricerche',
    'RSI_NUMBER_EXPLAIN'    => 'Numero di ricerche recenti da visualizzare',	
	'RSI_SETTING_SAVED'	    => 'Ricerche recenti Le impostazioni sono state salvate correttamente!',
    //Add permissions acp	
	'ACL_A_RSI'		=> 'Può gestire Ricerche recenti sull’indice',	
));
