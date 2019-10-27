<?php
/**
*
* @package Log New User Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\lognewuser\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\log\log */
	protected $log;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config	$config		phpBB config
	* @param \phpbb\request\request	$request	phpBB request
	* @param \phpbb\log\log			$log		phpBB log
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\log\log $log)
	{
		$this->config	= $config;
		$this->request	= $request;
		$this->log		= $log;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'	=> 'acp_board_settings',
			'core.user_add_after'				=> 'add_new_user',
		);
	}

	/**
	* Set ACP board settings
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function acp_board_settings($event)
	{
		if ($event['mode'] == 'registration')
		{
			$new_display_var = array(
				'title'	=> $event['display_vars']['title'],
				'vars'	=> array(),
			);

			foreach ($event['display_vars']['vars'] as $key => $content)
			{
				$new_display_var['vars'][$key] = $content;
				if ($key == 'chg_passforce')
				{
					$new_display_var['vars']['log_new_user'] = array(
						'lang'		=> 'LOG_NEW_USER',
						'validate'	=> 'bool',
						'type'		=> 'radio:yes_no',
						'explain' 	=> true,
					);
				}
			}

			$event->offsetSet('display_vars', $new_display_var);
		}
	}

	/**
	* Log the new user
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function add_new_user($event)
	{
		$user_id	= $event['user_id'];
		$user_row	= $event['user_row'];

		if ($this->config['log_new_user'] == true)
		{
			$this->log->add('user', $user_id, $user_row['user_ip'], 'LOG_NEW_USER_CREATED', time(), array('reportee_id' => $user_id));
		}
	}
}
