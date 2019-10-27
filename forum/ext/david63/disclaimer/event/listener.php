<?php
/**
*
* @package Disclaimer Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\disclaimer\event;

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

	/** @var \phpbb\template\twig\twig */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config $config phpBB config
	* @param \phpbb\request\request $request phpBB request
	* @param \phpbb\template\twig\twig $template phpBB template
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\template\twig\twig $template, \phpbb\user $user)
	{
		$this->config	= $config;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
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
			'core.user_setup'					=> 'load_language_on_setup',
			'core.page_header'					=> 'page_header',
			'core.acp_board_config_edit_add'	=> 'acp_board_settings',
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
		if ($event['mode'] == 'features')
		{
			$new_display_var = array(
				'title'	=> $event['display_vars']['title'],
				'vars'	=> array(),
			);

			foreach ($event['display_vars']['vars'] as $key => $content)
			{
				$new_display_var['vars'][$key] = $content;
				if ($key == 'display_last_subject')
				{
					$new_display_var['vars']['show_disclaimer'] = array(
						'lang'		=> 'SHOW_DISCLAIMER',
						'validate'	=> 'bool',
						'type'		=> 'radio:enabled_disabled',
						'explain' 	=> true,
					);
				}
			}

			$event->offsetSet('display_vars', $new_display_var);
		}
	}

	/**
	* Load common disclaimer language files during user setup
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function load_language_on_setup($event)
	{
		$lang_set_ext	= $event['lang_set_ext'];
		$lang_set_ext[]	= array(
			'ext_name' => 'david63/disclaimer',
			'lang_set' => 'disclaimer',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* Add some additional template variables
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function page_header($event)
	{
		$this->template->assign_vars(array(
			'DISCLAIMER_BODY'	=> sprintf($this->user->lang['DISCLAIMER_TEXT'], $this->config['sitename']),
			'S_DISCLAIMER'		=> $this->config['show_disclaimer'],
			'SITE'				=> $this->config['sitename'],
		));
	}
}
