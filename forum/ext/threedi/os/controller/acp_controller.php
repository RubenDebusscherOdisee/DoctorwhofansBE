<?php
/**
 *
 * Online Since. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2005 - 2019, 3Di, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace threedi\os\controller;

/**
 * Online Since ACP controller.
 */
class acp_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\config\config		$config		Config object
	 * @param \phpbb\language\language	$language	Language object
	 * @param \phpbb\log\log			$log		Log object
	 * @param \phpbb\request\request	$request	Request object
	 * @param \phpbb\template\template	$template	Template object
	 * @param \phpbb\user				$user		User object
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user
	)
	{
		$this->config	= $config;
		$this->language	= $language;
		$this->log		= $log;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
	}

	/**
	 * Display the options a user can configure for this extension.
	 *
	 * @return void
	 */
	public function display_options()
	{
		$os_start = $this->request->variable('threedi_os_startdate', 0);

		/* Add our common language file */
		$this->language->add_lang('common', 'threedi/os');

		/* Create a form key for preventing CSRF attacks */
		add_form_key('threedi_os_acp_add');

		/* Request the action */
		$action = $this->request->variable('action', '');

		/* Create an array to collect errors that will be output to the user */
		$errors = [];

		switch ($action)
		{
			case 'change':
				if ($submit = $this->request->is_set_post('threedi_os_startdate_change'))
				{
					/* Test if the submitted form is valid */
					if (!check_form_key('threedi_os_acp_add'))
					{
						$errors[] = $this->language->lang('FORM_INVALID');
					}

					/**
					 * Valid range:
					 * February 10, 1653 6:13:21 AM
					 * to
					 * November 20, 2286 5:46:39 PM
					 * Yeah, a bit weird but imagine to use it as a countdown instead ;-)
					 */
					if ($os_start < -9999999999 || $os_start > 9999999999)
					{
						$errors[] = $this->language->lang('ACP_OS_UNIX_INVALID');
					}

					/* No errors? Very well.. */
					if (empty($errors))
					{
						/* Set the BSD to the desired one. */
						$this->config->set('threedi_os_startdate', (int) $os_start);

						/* Log the action */
						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_OS_BSD_CHANGED');

						/**
						 * Option change BSD has been updated and logged
						 * Confirm this to the user and provide link back to previous page
						 */
						trigger_error($this->language->lang('ACP_OS_CHANGE_SAVED') . adm_back_link($this->u_action));
					}
				}
			break;

			case 'setnow':
				if (confirm_box(true))
				{
					/* Set our configuration at the present time */
					$this->config->set('threedi_os_startdate', (int) time());

					/* Log the action */
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_OS_BSD_SETNOW', time());

					/* If the request/action is AJAX */
					if ($this->request->is_ajax())
					{
						/* Set up a JSON response */
						$json_response = new \phpbb\json_response();

						/* Send a JSON response */
						$json_response->send([
							'MESSAGE_TITLE'	=> $this->language->lang('INFORMATION'),
							'MESSAGE_TEXT'	=> $this->language->lang('ACP_OS_SETNOW'),
							'REFRESH_DATA'	=> [
								'url'	=> '',
								'time'	=> 2,
							],
						]);
					}

					/* Show success message when not using AJAX */
					trigger_error($this->language->lang('ACP_OS_SETNOW') . adm_back_link($this->u_action));
				}
				else
				{
					confirm_box(
						false,
						$this->language->lang('ACP_OS_SETNOW_CONFIRM'),
						build_hidden_fields(
							['action'	=> $action]
						)
					);

					/* Redirect if confirm box is cancelled ('No'). */
					redirect($this->u_action);
				}
			break;

			case 'restore':
				if (confirm_box(true))
				{
					/* Set our configuration back to the original one */
					$this->config->set('threedi_os_startdate', (int) $this->config['board_startdate']);

					/* Log the action */
					$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_OS_BSD_RESTORED', time());

					/* If the request/action is AJAX */
					if ($this->request->is_ajax())
					{
						/* Set up a JSON response */
						$json_response = new \phpbb\json_response();

						/* Send a JSON response */
						$json_response->send([
							'MESSAGE_TITLE'	=> $this->language->lang('INFORMATION'),
							'MESSAGE_TEXT'	=> $this->language->lang('ACP_OS_RESTORED'),
							'REFRESH_DATA'	=> [
								'url'	=> '',
								'time'	=> 2,
							],
						]);
					}

					/* Show success message when not using AJAX */
					trigger_error($this->language->lang('ACP_OS_RESTORED') . adm_back_link($this->u_action));
				}
				else
				{
					confirm_box(
						false,
						$this->language->lang('ACP_OS_RESTORE_CONFIRM'),
						build_hidden_fields(
							['action'	=> $action]
						)
					);

					/* Redirect if confirm box is cancelled ('No'). */
					redirect($this->u_action);
				}
			break;
		}

		$s_errors = !empty($errors);

		/* Converts the board start date into an human readable format */
		$os_board_startdate = $this->user->format_date($this->config['threedi_os_startdate'], 'd m Y H:i');

		/* Set output variables for display in the template */
		$this->template->assign_vars([
			'S_OS_GFX'			=> true,
			'S_ERROR'			=> $s_errors,

			'ERROR_MSG'			=> $s_errors ? implode('<br>', $errors) : '',

			'L_OS_BOARD_START'	=> $os_board_startdate,

			'OS_STARTDATE'		=> (int) $this->config['threedi_os_startdate'],

			'U_ACTION_CHANGE'	=> $this->u_action . '&action=change',
			'U_ACTION_SETNOW'	=> $this->u_action . '&action=setnow',
			'U_ACTION_RESTORE'	=> $this->u_action . '&action=restore',
		]);
	}

	/**
	 * Set custom form action.
	 *
	 * @param string	$u_action	Custom form action
	 * @return void
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
