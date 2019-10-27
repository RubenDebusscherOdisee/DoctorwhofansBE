<?php
/**
 *
 * Simple News Admin. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\news\acp;

/**
 * Simple News Admin ACP module info.
 */
class news_info
{
	public function module()
	{
		return array(
			'filename'	=> '\galandas\news\acp\news_module',
			'title'		=> 'ACP_NEWS_TITLE',
			'modes'		=> array(
			'news_config'	=> array(
			'title'		=> 'ACP_NEWS_CONFIG',
			'auth'		=> 'ext_galandas/news && acl_a_board',
			'cat'		=> array('ACP_NEWS_TITLE')),
			),
		);
	}
}
