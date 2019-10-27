<?php
/**
*
* @package phpBB Extension - Google Translator
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\translate\acp;

class translate_info
	{
		function module()
	{
		return array(
		'filename'	=> '\hifikabin\translate\acp\translate_module',
		'title'		=> 'ACP_TRANSLATE',
		'modes'		=> array(
		'config'	=> array('title' => 'ACP_TRANSLATE_CONFIG', 'auth' => 'ext_hifikabin/translate && acl_a_board', 'cat' => array('ACP_TRANSLATE')),
			),
		);
	}
}
