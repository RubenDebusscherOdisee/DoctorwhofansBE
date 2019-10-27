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
 * Recent searches on index ACP module.
 */
class searchindex_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user;

		$user->add_lang_ext('galandas/searchindex', 'info_acp_searchindex');
		$this->tpl_name = 'acp_searchindex';
		$this->page_title = $user->lang('RSI_TITLE');
		add_form_key('acp_searchindex');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('acp_searchindex'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('rsi_enabled', $request->variable('rsi_enabled', 1));
			$config->set('rsi_limit', $request->variable('rsi_limit', 5));
			
			trigger_error($user->lang('RSI_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'RSI_ENABLED'		=> (!empty($config['rsi_enabled'])) ? true : false,
			'RSI_LIMIT'		    => (isset($config['rsi_limit'])) ? $config['rsi_limit'] : '',
			'RSI_VERSION'	    => (isset($config['rsi_version'])) ? $config['rsi_version'] : '',			
		));
	}
}
