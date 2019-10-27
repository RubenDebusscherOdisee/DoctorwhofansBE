<?php
/**
*
* @package Global announcement on index
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\globalonindex\acp;

class globalonindex_module
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	public $u_action;

	function main($id, $mode)
	{
		global $user, $template, $request, $config, $phpbb_log;

		$this->config	= $config;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;

		switch ($mode)
		{
			case 'manage':
				$this->tpl_name		= 'global_on_index';
				$this->page_title	= $user->lang('GLOBAL_ON_INDEX');
				$form_key			= 'global_on_index';
				add_form_key($form_key);

				if ($this->request->is_set_post('submit'))
				{
					if (!check_form_key($form_key))
					{
						trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$this->config->set('global_announce_announce', $this->request->variable('global_announce_announce', 0));
					$this->config->set('global_announce_event', $this->request->variable('global_announce_event', 0));
					$this->config->set('global_announce_guest', $this->request->variable('global_announce_guest', 0));
					$this->config->set('global_announce_index', $this->request->variable('global_announce_index', 0));
					$this->config->set('global_on_index', $this->request->variable('global_on_index', ''));

					$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'GLOBAL_ON_INDEX_LOG');
					trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
				}

				$this->template->assign_vars(array(
					'ALLOW_EVENTS'				=> isset($this->config['global_announce_event']) ? $this->config['global_announce_event'] : '',
					'ALLOW_GUESTS'				=> isset($this->config['global_announce_guest']) ? $this->config['global_announce_guest'] : '',
					'GLOBAL_ON_INDEX_ENABLED'	=> isset($this->config['global_on_index']) ? $this->config['global_on_index'] : '',
					'SHOW_ANNOUNCEMENTS'		=> isset($this->config['global_announce_announce']) ? $this->config['global_announce_announce'] : '',
					'SHOW_GLOBALS'				=> isset($this->config['global_announce_index']) ? $this->config['global_announce_index'] : '',

					'U_ACTION'					=> $this->u_action,
				));
			break;
		}
	}
}
