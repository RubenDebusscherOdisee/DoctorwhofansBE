<?php
/**
 *
 * Advanced login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\advlogin\acp;

/**
 * Advanced login and register ACP module info.
 */
class advlogin_info
{
	function module()
	{
		return array(
			'filename'	=> '\galandas\advlogin\acp\advlogin_module',
			'title'		=> 'ACP_ADVLOGIN',
			'modes'		=> array(
			'settings'	=> array(
			'title'     => 'ACP_ADVLOGIN_SETTINGS',
			'auth'      => 'ext_galandas/advlogin && acl_a_board',
			'cat'       => array('ACP_ADVLOGIN')
				),
			),
		);
	}
}
