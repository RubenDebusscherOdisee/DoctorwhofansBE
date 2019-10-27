<?php
/**
 *
 * Recent searches on index. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\searchindex\acp;

/**
 * Recent searches on index ACP module info.
 */
class searchindex_info
{
	public function module()
	{
		return array(
			'filename'	=> '\galandas\searchindex\acp\searchindex_module',
			'title'		=> 'RSI_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'RSI_SETTINGS',
					'auth'	=> 'ext_galandas/searchindex && acl_a_board',
					'cat'	=> array('RSI_TITLE')
				),
			),
		);
	}
}
