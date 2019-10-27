<?php
/**
+-------------------------------------------------------------------------------+
|	Extension for the phpBB3 Forum Software package:	Page Scrolling			|
+-------------------------------------------------------------------------------+
|	Version:	1.4.0															|
|	Charset:	utf-8 without BOM												|
|	Date:		2018-08-14 10:00:00												|
|	License:	GNU General Public License, version 2 (GPL-2.0)					|
|	Homepage:	https://github.com/PWG-Extension/pagescrolling					|
|	Email:																		|
|	Author:		© Alexander Kadnikov [Predator]									|
+-------------------------------------------------------------------------------+
|	© «PWG», 2004-2018. All Rights Reserved.									|
+-------------------------------------------------------------------------------+
*/


namespace pwg\pagescrolling\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup' => 'load_language_on_setup',
		);
	}
	
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'pwg/pagescrolling',
			'lang_set' => 'pagescrolling',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
}