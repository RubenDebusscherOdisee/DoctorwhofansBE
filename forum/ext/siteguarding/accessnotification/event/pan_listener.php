<?php
/**
*
* @package phpBB Extension - AccessNotification by SiteGuarding.com
* @author SiteGuarding.com team 
* @copyright (C) 2017 SiteGuarding.com team (https://SiteGuarding.com)
*
*/

namespace siteguarding\accessnotification\event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class pan_listener implements EventSubscriberInterface
{
	protected $config;

	protected $user;

	protected $request;

	protected $php_ext;

	protected $phpbb_root_path;
	
	
	

	public function __construct(\phpbb\config\config $config, \phpbb\user $user, $request, $php_ext, $phpbb_root_path)
	{
		$this->config	= $config;
		$this->user		= $user;
		$this->request = $request;
		$this->php_ext  = $php_ext;
		$this->phpbb_root_path  = $phpbb_root_path;
	}

	static public function getSubscribedEvents()
	{
		return array(
		
			'core.user_setup'				=> 'load_language_on_setup',
			'core.auth_login_session_create_before' => 'send_login',
			
		);
	}	

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'siteguarding/accessnotification',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function send_login($event)
	{
		$data = array(
			'lang'				=> basename($this->request->variable('lang', $this->user->lang_name)),
		);
		$statusEmail = $this->config['pan_enable'] ? $this->config['pan_enable'] : '';
		$email = $this->config['pan_email'] ? $this->config['pan_email'] : '';
		$token = $this->config['pan_telegram_token'] ? $this->config['pan_telegram_token'] : '';
		$chatId = $this->config['pan_telegram_chat_id'] ? $this->config['pan_telegram_chat_id'] : '';
		$successAttempts = $this->config['pan_send_success'] ? $this->config['pan_send_success'] : '';
		$failAttempts = $this->config['pan_send_failed'] ? $this->config['pan_send_failed'] : '';
		$telegram = $this->config['pan_enable_telegram'] ? $this->config['pan_enable_telegram'] : '';
		$link = 'http://api.ipinfodb.com/v3/ip-city/?key=524ec42c675fe66c37cc26f5e289f98555be21e05720bda46e51da63aa58a2ca&ip='.$this->user->ip.'&format=json';
		$result = @file_get_contents($link);
		$geolocation = (array)@json_decode($result,true);
		$user		= $event['username'];
		$login		= $event['login'];
		$admin		= $event['admin'];
		$domain = $this->user->host;
		if ($login['error_msg'] === false) {
			$res = 1;
		} else {
			$res = 0;
		}

		if ($admin && ($failAttempts || $successAttempts)) {
				  
			if ($statusEmail && $email != '') { 
				if (!class_exists('messenger'))
					{
						include($this->phpbb_root_path . 'includes/functions_messenger.' . $this->php_ext);
					}

				$messengerToEmail = new \messenger(false);

				if (strpos(strtolower($email), 'gmail') === false) {
					if ($res == 1) {
						$messengerToEmail->template('@siteguarding_accessnotification/admin_notify_login_success', $data['lang']);
					} else {
						$messengerToEmail->template('@siteguarding_accessnotification/admin_notify_login_failed', $data['lang']);
					}
				} else {
					if ($res == 1) {
						$messengerToEmail->template('@siteguarding_accessnotification/admin_notify_login_no_html_success', $data['lang']);
					} else {
						$messengerToEmail->template('@siteguarding_accessnotification/admin_notify_login_no_html_failed', $data['lang']);
					}
				}
				
				$messengerToEmail->to($email);
				$messengerToEmail->im($email);
				$messengerToEmail->assign_vars(array(
					'DOMAIN'		 => $domain,
					'TIME'		 => date("Y-m-d H:i:s"),
					'USER'		=> $user,
					'BROWSER'		 => $this->user->browser,
					'USER_IP'		=> $this->user->ip,
					'CITY'		=> $geolocation['cityName'],
					'COUNTRY'		=> $geolocation['countryName']
				));

				$messengerToEmail->from('phpBBUserAccessNotification', 'phpBBUserAccessNotification');
				$messengerToEmail->headers('Content-type: text/html');

			}
			
			if ($token != '' && $chatId != '' && $telegram) {
				
				if (!class_exists('messenger'))
					{
						include($this->phpbb_root_path . 'includes/functions_messenger.' . $this->php_ext);
					}

				$messengerToTelegram = new \messenger(false);

				if ($res == 1) {
					$messengerToTelegram->template('@siteguarding_accessnotification/admin_notify_login_to_telegram_success', $data['lang']);
				} else {
					$messengerToTelegram->template('@siteguarding_accessnotification/admin_notify_login_to_telegram_failed', $data['lang']);
				}

				

				$messengerToTelegram->assign_vars(array(
					'DOMAIN'		 => $domain,
					'TIME'		 => date("Y-m-d H:i:s"),
					'USER'		=> $user,
					'BROWSER'		 => $this->user->browser,
					'USER_IP'		=> $this->user->ip,
					'CITY'		=> $geolocation['cityName'],
					'COUNTRY'		=> $geolocation['countryName']
				));

				$messengerToTelegram->send(NOTIFY_EMAIL, true);
										
			}
				
				
			if ($successAttempts && $failAttempts) {
				if ($token != '' && $chatId != '' && $telegram && isset($messengerToTelegram->msg)) @fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatId}&parse_mode=html&text={$messengerToTelegram->msg}","r");
				if ($statusEmail && $email != '' && isset($messengerToEmail)) $messengerToEmail->send(NOTIFY_EMAIL);
			} elseif ($successAttempts && !$failAttempts) {
				if ($res == 1) {
					if ($token != '' && $chatId != '' && $telegram && isset($messengerToTelegram->msg)) @fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatId}&parse_mode=html&text={$messengerToTelegram->msg}","r");
					if ($statusEmail && $email != '' && isset($messengerToEmail)) $messengerToEmail->send(NOTIFY_EMAIL);
				}
			} elseif (!$successAttempts && $failAttempts) {
				if ($res == 0) {
					if ($token != '' && $chatId != '' && $telegram && isset($messengerToTelegram->msg)) @fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatId}&parse_mode=html&text={$messengerToTelegram->msg}","r");
					if ($statusEmail && $email != '' && isset($messengerToEmail)) $messengerToEmail->send(NOTIFY_EMAIL);
				}
			}
			
		}	

	}

}
