<?php
/**
*
* @package phpBB Extension - AccessNotification by SiteGuarding.com
* @author SiteGuarding.com team 
* @copyright (C) 2017 SiteGuarding.com team (https://SiteGuarding.com)
*
*/

namespace siteguarding\accessnotification\acp;

class pan_module_info
{
	function module()
	{
		return array(
			'filename'	=> 'pan_module',
			'title'		=> 'PAN_TITLE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'PAN_SETTINGS', 'auth' => 'acl_a_board', 'cat' => array('PAN_EXTENSION')),
			),
		);
	}
	
	function install()
    {
    }
                                
    function uninstall()
    {
    }
}
