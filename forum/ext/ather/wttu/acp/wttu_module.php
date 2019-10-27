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

class wttu_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		
		$this->config = $config;
		$this->request = $request;

		$user->add_lang('acp/common');
		$user->add_lang_ext('ather/wttu', 'acp/info_acp_wttu');
		$this->tpl_name = 'acp_wttu';
		$this->page_title = $user->lang['WTTU_TITLE'];
		add_form_key('acp_wttu');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_wttu'))
			{
				trigger_error('FORM_INVALID');
			}
			
			
			$config->set('wttu_status', $request->variable('wttu_status', 0));
			$config->set('wttu_link', $request->variable('wttu_link', 0));
			$config->set('wttu_bbcode', $request->variable('wttu_bbcode', 0));
			$config->set('wttu_html', $request->variable('wttu_html', 0));
			$config->set('wttu_type', $request->variable('wttu_type', 0));
			
			trigger_error($user->lang['WTTU_SAVED'] . adm_back_link($this->u_action));
		}
		
		$template->assign_vars(array(
			'WTTU_STATUS'		=> (!empty($this->config['wttu_status'])) ? true : false,
			'WTTU_LINK_ENABLED'		=> (!empty($this->config['wttu_link'])) ? true : false,
			'WTTU_BBCODE_ENABLED'		=> (!empty($this->config['wttu_bbcode'])) ? true : false,
			'WTTU_HTML_ENABLED'		=> (!empty($this->config['wttu_html'])) ? true : false,
			'WTTU_TYPE'		=> (!empty($this->config['wttu_type'])) ? true : false,
			'U_ACTION'		=> $this->u_action,
		));
	}
}
