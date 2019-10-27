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
	'ACP_WIDTH_ADVLOGIN'			=> 'Larghezza in pixel',
	'ACP_WIDTH_ADVLOGIN_EXPLAIN'	=> 'Si raccomanda di non superare i requisiti consigliati per una migliore visualizzazione anche per i dispositivi mobili. Minimo 300, Massimo 350.',
	'ACP_HEIGHT_ADVLOGIN'			=> 'Altezza in pixel',
	'ACP_HEIGHT_ADVLOGIN_EXPLAIN'	=> 'Si raccomanda di non superare i requisiti consigliati per una migliore visualizzazione. Minimo 150, massimo 600',
	'ACP_ADVLOGIN'			        => 'Login Avanzato',
	'ACP_ADVLOGIN_SETTINGS'	        => 'Configurazione',	
	'ACP_ADVLOGIN_CONFIG_SET'		=> 'Abilita o Disabilita',
	'ACP_ADVLOGIN_CONFIG'		    => 'Inserisci il testo',	
	'ACP_ADVLOGIN_CONFIG_SAVED'		=> 'Login Avanzato impostazioni salvate',
	'ACP_ADVLOGIN_VERSION'			=> 'Versione',
	'ACP_ADVLOGIN_DONATE'			=> '<a href="https://www.paypal.me/Galandas"><strong>Donate</strong></a>',
	'ACP_ADVLOGIN_DONATE_EXPLAIN'	=> 'Se ti piace questa estensione considera una donazione offrimi una pizza',	
	'ACP_ADVLOGIN_CREDITS'			=> 'Estensione creata da <a href="http://phpbb3world.altervista.org"><strong>Galandas</strong></a>',
	'ACP_ADVLOGIN_ENABLE'			=> 'Abilita Login Avanzato',
	'ACP_ADVLOGIN_ENABLE_EXPLAIN'	=> 'Abilita l’estensione Login Avanzato nella visualizzazione globale del forum.',
	'ACP_ADVLOGIN_TEXT'				=> 'Testo Visualizzato',
	'ACP_ADVLOGIN_TEXT_EXPLAIN'		=> 'Inserisci il testo che si desidera visualizzare è possibile usare l’HTML.',
	'ACP_ADVLOGIN_COLOR'			=> 'Imposta il colore di sfondo',
	'ACP_ADVLOGIN_COLOR_EXPLAIN'	=> 'È possibile cambiare il colore di sfondo usando un codice esadecimale (per esempio A1D490). Lascia questo campo vuoto per usare il colore predefinito.',
	'ACP_ADVLOGIN_ASPECT'           => 'Scelta dell’immagine ON - OFF',
	'ACP_ADVLOGIN_ASPECT_EXPLAIN'   => 'Scegli se vuoi far visualizzare l’immagine. Nota questo cambia anche lo sfondo predefinito.',
    // Scelta aspetto	
	'ACP_ASPECT_A'           => 'Aspetto 1',
	'ACP_ASPECT_B'           => 'Aspetto 2',	
));
