<?php
/**
*
* @package phpBB Extension - AccessNotification by SiteGuarding.com
* @author SiteGuarding.com team 
* @copyright (C) 2017 SiteGuarding.com team (https://SiteGuarding.com)
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'PAN_TITLE'			            => 'phpBB User Access Notification',

	'PAN_SETTINGS'		            => 'User Access Notification settings',
	'PAN_SETTINGS_NOTIF'		            => 'Settings',
	'PAN_SETTINGS_SAVED'		        => 'Access Notification settings have been saved successfully!',
	'PAN_SETTINGS_NOTCORRECT_TELEGRAM'		        => 'Access Notification settings NOT saved! You have to fill “Telegram API token“ to activate notifications by telegram',
	'PAN_SETTINGS_NOTENTERED_EMAIL'		        => 'Access Notification settings NOT saved! You have to fill “Email“ to activate notifications by email',

	'PAN_ENABLE'		            => 'Enable notifications by email',
	'PAN_ENABLE_TELEGRAM'		            => 'Enable notifications by telegram',

	'PAN_SEND_FAILED'		        => 'Send for failed login action',

	'PAN_SEND_SUCCESS'		        => 'Send for successful login action',

	'PAN_EMAIL'		        => 'Email',
	'PAN_EMAIL_TITLE'		        => 'Email notifications',
	'PAN_TELEGRAM_TITLE'		        => 'Telegram notifications',
	'PAN_TELEGRAM_TOKEN'		        => 'Telegram API token',
	'PAN_TELEGRAM_CHAT_ID'		        => 'Chat ID',
	
	'PAN_FOR_MORE_INFORMATION'		        => 'For more information and details about phpBB User Access Notification please ',
	'PAN_LINK_CLICK'		        => 'click here',
	'PAN_FOR_ANY_QUESTIONS'		        => 'For any questions and support please use LiveChat or this ',
	'PAN_LINK_CONTACT'		        => 'contact form',
	'PAN_LINK_SITEGUARDING'		        => 'SiteGuarding.com',
	'PAN_SITEGUARDING'		        => ' - Website Security. Professional sequrity services against hacker activity.',
	'PAN_LINK_GET_API'		        => 'Get your API Token',
	'PAN_AUTOFILLED'		        => 'Send message to bot, and this field will be automatically filled after submit',
	'PAN_SETTINGS_NOTCORRECT_EMAIL'		        => 'Entered email address is invalid!',


));
