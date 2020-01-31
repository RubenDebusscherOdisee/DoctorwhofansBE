<?php
/**
 *
 * Online Since. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2005 - 2019, 3Di, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace threedi\os\acp;

/**
 * Online Since ACP module info.
 */
class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\threedi\os\acp\main_module',
			'title'		=> 'ACP_OS_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'ACP_OS',
					'auth'	=> 'ext_threedi/os && acl_a_new_threedi_os',
					'cat'	=> ['ACP_OS_TITLE']
				],
			],
		];
	}
}
