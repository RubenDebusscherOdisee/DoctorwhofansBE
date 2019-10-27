<?php
/**
*
* @package Announcements on index
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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

$lang = array_merge($lang, array(
	'ALLOW_EVENTS'					=> 'Tema olaylarını kullan',
	'ALLOW_EVENTS_EXPLAIN'			=> 'Duyuruların tema olaylarını kullanmasına izin verir.<br />Tema olayları sorunlara ve/veya istenmeyen durumlara neden olursa kapatabilirsiniz.',
	'ALLOW_GUESTS'					=> 'Misafirlere duyuruları göster',
	'ALLOW_GUESTS_EXPLAIN'			=> 'Misafirlerin duyuruları görüntülemesine izin verir.',

	'ANNOUNCE_ON_INDEX'				=> 'Duyurular Anasayfada',
	'ANNOUNCE_ON_INDEX_ENABLE'		=> 'Duyuruları Etkinleştir',
	'ANNOUNCE_ON_INDEX_EXPLAIN' 	=> 'Duyuru seçeneklerini yönetin.',
	'ANNOUNCE_ON_INDEX_LOG'			=> '<strong>Duyurular Anasayfada ayarları güncellendi </strong>',
	'ANNOUNCE_ON_INDEX_MANAGE'		=> 'Duyuruları yönet',
	'ANNOUNCE_ON_INDEX_OPTIONS'		=> 'Duyuru seçenekleri',

	'SHOW_ANNOUNCEMENTS'			=> 'Duyuruları Göster',
	'SHOW_ANNOUNCEMENTS_EXPLAIN'	=> 'Tüm duyuruları anasayfada gösterir.',
	'SHOW_GLOBALS'					=> 'Genel duyuruları göster',
	'SHOW_GLOBALS_EXPLAIN'			=> 'Tüm genel duyuruları anasayfada gösterir.',
));
