<?php
/**
*
* @package phpBB Extension - Google Search
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\translate\acp;

class translate_module
{
var $u_action;

	function main($id, $mode)
	{
		global $user, $template, $request;
		global $config;

		$this->tpl_name = 'acp_translate_config';
		$this->page_title = $user->lang('ACP_TRANSLATE');
		$form_name = 'acp_translate_config';
		add_form_key($form_name);

		$submit = $request->is_set_post('submit');
		if ($submit)
		{
			if (!check_form_key('acp_translate_config'))
		{
			trigger_error('FORM_INVALID');
		}
			$config->set('translate_default_lang', ($request->variable('translate_default_lang', '')));
			$config->set('translate_choice_lang', ($request->variable('translate_choice_lang', '')));

			trigger_error($user->lang('TRANSLATE_CONFIG_SAVED') . adm_back_link($this->u_action));
		}
			$template->assign_vars(array(
			'TRANSLATE_DEFAULT_LANG'	=> (isset($config['translate_default_lang'])) ? $config['translate_default_lang'] : '',
			'TRANSLATE_CHOICE_LANG'		=> (isset($config['translate_choice_lang'])) ? $config['translate_choice_lang'] : '',
			'U_ACTION'					=> $this->u_action,
		));
	}
}