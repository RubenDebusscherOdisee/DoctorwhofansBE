<?php
/**
*
* WTTU Extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 Ather
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace ather\wttu\acp;

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package module_install
*/
class wttu_info
{
	function module()
	{
		return array(
			'filename'	=> '\ather\wttu\acp\wttu_module',
			'title'		=> 'WTTU',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'WTTU_CONFIG', 'auth'	=> 'ext_ather/wttu', 'cat'	=> array('WTTU')),
			),
		);
	}
}
