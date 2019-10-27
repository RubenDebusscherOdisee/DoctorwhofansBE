<?php
/**
*
* @package Global announcement on index
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\globalonindex\acp;

class globalonindex_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\globalonindex\acp\globalonindex_module',
			'title'		=> 'GLOBAL_ON_INDEX',
			'modes'		=> array(
				'manage'		=> array('title' => 'GLOBAL_ON_INDEX_MANAGE', 'auth' => 'ext_david63/globalonindex && acl_a_forum', 'cat' => array('GLOBAL_ON_INDEX')),
			),
		);
	}
}
