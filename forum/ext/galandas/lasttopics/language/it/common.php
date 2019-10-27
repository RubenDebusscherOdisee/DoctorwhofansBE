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
	'ACP_LAST_TOPIC'					=> 'Argomenti Attivi Avanzato',
	'ACP_LAST_TOPIC_EXPLAIN'		    => 'Estensione Argomenti Attivi Avanzato by <a href="http://phpbb3world.altervista.org"><strong>Galandas</strong></a>',
    'ACP_LAST_TOPIC_SETTINGS'			=> 'Abilita Disabilita',
	'ACP_LAST_TOPIC_CONF'				=> 'Configurazione',	
    'ACP_LAST_TOPIC_CONFS'			    => 'Impostazioni',	
	'ACP_LAST_TOPIC_DONATE'			    => '<a href="https://www.paypal.me/Galandas"><strong>Donate</strong></a>',
	'ACP_LAST_TOPIC_DONATE_EXPLAIN'	    => 'Se ti piace questa estensione considera una donazione offrimi una pizza',	
    'LAST_TOPIC_CONFIG_SAVED'         	=> 'Impostazioni Argomenti Attivi Avanzato salvate',	
	'ALLOW_LAST_TOPIC'					=> 'Abilita',
	'ALLOW_LAST_TOPIC_EXPLAIN'			=> 'Abilita o Disabilita Argomenti Attivi Avanzato',
	'ALLOW_LAST_TUTTO'					=> 'Abilita da per tutto',
	'ALLOW_LAST_TUTTO_EXPLAIN'			=> 'Abilita o Disabilita la visualizzazione degli Argomenti Attivi Avanzato in tutto il forum e non solo in indice',
    'LAST_TOPIC_ALLERTS'                => 'Nota se Abiliti la visuale in tutto il forum devi Disabilitare la visuale in indice, altrimenti ne vedrai due',	
    'ALLOW_LAST_INDEX'                  => 'Abilita in Indice',
    'ALLOW_LAST_INDEX_EXPLAIN'          => 'Abilita o Disabilita la visualizzazione degli Argomenti Attivi Avanzato sull’indice',
    'LAST_TOPIC_ALLERT'                 => 'Nota se Abiliti la visuale solo sull’indice devi Disabilitare la visuale in tutto il forum, altrimenti ne vedrai due',	
	'LAST_TOPIC_TOTAL'				    => 'Totale Argomenti',
	'LAST_TOPIC_TOTAL_EXPLAIN'			=> 'Inserisci il numero di argomenti che desideri mostrare agli utenti',
	'LAST_TYPE'				            => 'Template',
	'LAST_TYPE_EXPLAIN'				    => 'Scegli il template da visualizzare - le opzioni correnti sono <strong>Forabg, Panel bg3</strong>',
	'LAST_DIRECTION'					=> 'Direzione Ticker',
	'LAST_DIRECTION_EXPLAIN'			=> 'Scegli la direzione del js - le opzioni correnti sono, Su o Giù',
	'LAST_UP_DIRECTION'					=> 'Su',
	'LAST_DOWN_DIRECTION'				=> 'Giù',	
	'LAST_TITLETEXT'			        => 'Argomenti Attivi',
    'LAST_POS'                          => 'Posizione',
    'LAST_POS_EXPLAIN'                  => 'Scegli la posizione. In alto dopo la navbar, appare prima della lista forum in cima.<br />In basso dopo le Statistiche, appare dopo le Statistiche del forum.',
    'LAST_AT_TOP'                       => 'In alto dopo la navbar',
	'LAST_AT_FUT'                       => 'In basso dopo le Statistiche',
	'LAST_ASPECT_A'                     => 'Panel bg3',
	'LAST_ASPECT_B'                     => 'Forabg',
    // Pulsanti ON OFF	
	'LAST_NAVIGATION'		        => 'Abilita Pulsanti',
	'LAST_NAVIGATION_EXPLAIN'		=> 'Puoi decidere se visualizzare i pulsanti sotto gli Argomenti Attivi Avanzato',	
	'PREVIOUS_SCROLL'			    => 'Indietro',
	'NEXT_SCROLL'				    => 'Avanti',
	'START_SCROLL'				    => 'Play',
	'STOP_SCROLL'				    => 'Stop',
    // Permessi gruppi	
	'ACL_U_AT_ADV'	                => 'Può vedere Argomenti Attivi Avanzato',	
));