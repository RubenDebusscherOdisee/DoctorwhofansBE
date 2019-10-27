<?php
/**
 *
 * Confirm Email. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, kinerity, https://www.layer-3.org/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kinerity\confirmemail\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Confirm Email Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/* @var \phpbb\language\language */
	protected $lang;

	/* @var \phpbb\request\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;
	
	/* @var \phpbb\user */
	protected $user;
	
	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language  $lang       Language object
	 * @param \phpbb\request\request    $request    Request object
	 * @param \phpbb\template\template  $template   Template object
	 * @param \phpbb\user               $user       User object
	 */
	public function __construct(\phpbb\language\language $lang, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->lang = $lang;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.ucp_register_data_after'	=> 'ucp_register_data_after',
			'core.ucp_register_data_before'	=> 'ucp_register_data_before',
		);
	}

	public function ucp_register_data_before($event)
	{
		$this->user->add_lang_ext('kinerity/confirmemail', 'common');

		$data = $event['data'];
		$data = array_merge($data, array(
			'email_confirm'		=> strtolower($this->request->variable('email_confirm', '')),
		));
		$event['data'] = $data;
	}

	public function ucp_register_data_after($event)
	{
		$data = $event['data'];
		$error = $event['error'];

		if (!empty($event['submit']) && $data['email'] !== $data['email_confirm'])
		{
			$error[] = $this->lang->lang('CONFIRM_EMAIL_ERROR');
		}

		$this->template->assign_var('EMAIL_CONFIRM', $data['email_confirm']);

		$event['data'] = $data;
		$event['error'] = $error;
	}
}
