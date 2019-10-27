<?php
/**
*
* @package phpBB Extension - AccessNotification by SiteGuarding.com
* @author SiteGuarding.com team 
* @copyright (C) 2017 SiteGuarding.com team (https://SiteGuarding.com)
*
*/

namespace siteguarding\accessnotification\acp;

class pan_module
{
	function main()
	{
		global $user, $template, $request, $config, $phpbb_root_path;
		$images = array();	
		
		
		$pan_lang = $user->lang_name;
		$this->tpl_name = 'settings_body';
		$this->page_title = $user->lang('PAN_TITLE');
		add_form_key('siteguarding/accessnotification');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('siteguarding/accessnotification'))
			{
				trigger_error('FORM_INVALID');
			}	
			
			if ($request->variable('pan_enable_telegram', 0) != 0 && $request->variable('pan_telegram_token', '') == '')
			{
				trigger_error($user->lang('PAN_SETTINGS_NOTCORRECT_TELEGRAM') . adm_back_link($this->u_action), E_USER_WARNING);
			}	
			
			if ($request->variable('pan_enable', 0) != 0 && $request->variable('pan_email', '') == '')
			{
				trigger_error($user->lang('PAN_SETTINGS_NOTENTERED_EMAIL') . adm_back_link($this->u_action), E_USER_WARNING);
			}		
			
			if ($request->variable('pan_email', '') != '' && !filter_var($request->variable('pan_email', ''), FILTER_VALIDATE_EMAIL)) {
				trigger_error($user->lang('PAN_SETTINGS_NOTCORRECT_EMAIL') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			
			$config->set('pan_enable', $request->variable('pan_enable', 0));
			$config->set('pan_enable_telegram', $request->variable('pan_enable_telegram', 0));
			$config->set('pan_send_failed', $request->variable('pan_send_failed', 0));
			$config->set('pan_send_success', $request->variable('pan_send_success', 0));
			$config->set('pan_email', $request->variable('pan_email', ''));
			$config->set('pan_telegram_token', $request->variable('pan_telegram_token', ''));
			$config->set('pan_telegram_chat_id', $request->variable('pan_telegram_chat_id', ''));
			if (($config['pan_telegram_chat_id'] == '') && ($config['pan_telegram_token'] != '')) {
				$config->set('pan_telegram_chat_id', @json_decode(@file_get_contents("https://api.telegram.org/bot{$config['pan_telegram_token']}/getUpdates"))->result[0]->message->chat->id);
			}			

			trigger_error($user->lang('PAN_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}
		
		

		$images[] = $phpbb_root_path . 'ext/siteguarding/accessnotification/images/' . $user->lang_name . '/rek1.png';
		$images[] = $phpbb_root_path . 'ext/siteguarding/accessnotification/images/' . $user->lang_name . '/rek3.png';
		$images[] = $phpbb_root_path . 'ext/siteguarding/accessnotification/images/' . $user->lang_name . '/rek4.png';
		$images[] = $phpbb_root_path . 'ext/siteguarding/accessnotification/images/' . $user->lang_name . '/livechat.png';

		
		foreach ($images as $img) {
			if (!file_exists($img)) {
					$pan_lang = 'en';
				}	
		}			

			
			

		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'PAN_ENABLE'		=> $config['pan_enable'],
			'PAN_EMAIL'		=> $config['pan_email'],
			'PAN_ENABLE_TELEGRAM'		=> $config['pan_enable_telegram'],
			'PAN_SEND_FAILED'		=> $config['pan_send_failed'],
			'PAN_SEND_SUCCESS'		=> $config['pan_send_success'],
			'PAN_TELEGRAM_TOKEN'		=> $config['pan_telegram_token'],
			'PAN_TELEGRAM_CHAT_ID'		=> $config['pan_telegram_chat_id'],
			'PAN_LANG'		=> $pan_lang,
		));
	}
}
