<?php
/**
*
* @package phpBB Extension - Header Banner
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\headerbanner\acp;

class headerbanner_module
{
	var $u_action;
	var $page_title;
	var $tpl_name;

	function main($id, $mode)
	{
		global $user, $template, $request;
		global $config;

		$this->tpl_name = 'acp_headerbanner_config';
		$this->page_title = $user->lang('HEADERBANNER_CONFIG');
		$form_name = 'acp_headerbanner_config';

		$user->add_lang_ext('hifikabin/headerbanner', 'common');

		add_form_key($form_name);

		$submit = $request->is_set_post('submit');
		if ($submit)
		{
			if (!check_form_key('acp_headerbanner_config'))
			{
				trigger_error('FORM_INVALID');
			}
			$config->set('headerbanner', $request->variable('headerbanner', ''));
			$config->set('headerbanner_responsive', $request->variable('headerbanner_responsive', ''));
			$config->set('headerbanner_logo', $request->variable('headerbanner_logo', ''));
			$config->set('headerbanner_responsive_size', $request->variable('headerbanner_responsive_size', 0));
			$config->set('headerbanner_select', $request->variable('headerbanner_select', 0));
			$config->set('headerbanner_mobile', $request->variable('headerbanner_mobile', 0));
			$config->set('headerbanner_background', $request->variable('headerbanner_background', 0));
			$config->set('headerbanner_corner', $request->variable('headerbanner_corner', 0));
			$config->set('headerbanner_size', $request->variable('headerbanner_size', 0));
			$config->set('headerbanner_search', $request->variable('headerbanner_search', 0));

			trigger_error($user->lang('HEADERBANNER_SAVED') . adm_back_link($this->u_action));
		}
		$template->assign_vars(array(
			'HEADERBANNER'					=> $config['headerbanner'],
			'HEADERBANNER_RESPONSIVE'		=> $config['headerbanner_responsive'],
			'HEADERBANNER_LOGO'				=> $config['headerbanner_logo'],
			'HEADERBANNER_RESPONSIVE_SIZE'	=> $config['headerbanner_responsive_size'],
			'HEADERBANNER_SELECT'			=> $config['headerbanner_select'],
			'HEADERBANNER_MOBILE'			=> $config['headerbanner_mobile'],
			'HEADERBANNER_BACKGROUND'		=> $config['headerbanner_background'],
			'HEADERBANNER_CORNER'			=> $config['headerbanner_corner'],
			'HEADERBANNER_SIZE'				=> $config['headerbanner_size'],
			'HEADERBANNER_SEARCH'			=> $config['headerbanner_search'],
			'U_ACTION'						=> $this->u_action,
		));
	}
}