<?php
/**
 *
 * Registration email subscription. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Sitesplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\regmailsub\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
		    'core.user_setup'	                => 'load_language_on_setup',
			'core.ucp_register_data_before'		=> 'add_email_subscription_field',
			'core.ucp_register_user_row_after'	=> 'add_email_subscription_sql',
		);
	}

	private $request;
	private $template;
	private $user;
	public function __construct(\phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
	}

	public function add_email_subscription_field($event)
	{
		$this->user->add_lang_ext('sitesplat/regmailsub', 'common');

		$this->template->assign_var('S_ALLOW_MASSEMAIL', $this->request->variable('allow_massemail', 0));
	}

	public function add_email_subscription_sql($event)
	{
		$event['user_row'] = array_merge($event['user_row'], array(
			'user_allow_massemail' => $this->request->variable('allow_massemail', 0),
		));
	}
	
	public function load_language_on_setup($event)
	{
		$lang_set_ext 		= $event['lang_set_ext'];
		$lang_set_ext[] 	= array(
			'ext_name' 		=> 'sitesplat/regmailsub',
			'lang_set' 		=> 'copyright_common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
}