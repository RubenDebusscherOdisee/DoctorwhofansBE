<?php
/**
 *
 * Advanced login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\advlogin\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;
	
	/** @var \phpbb\auth\auth */
	protected $auth;
	
	/** @var \phpbb\config\config */
	protected $config;
	
	/** @var \phpbb\config\db_text */
	protected $config_text;
	
	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;
	
	/** @var \phpbb\db\driver\driver */
	protected $db;

	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface $cache             Cache driver interface
	* @param \phpbb\request\request				$request
	* @param \phpbb\template\template			$template
	* @param \phpbb\user						$user
	* @param \phpbb\auth\auth					$auth
	* @param \phpbb\db\driver\driver			$db
	* @param \phpbb\config\config				$config
	*/
	public function __construct(\phpbb\cache\driver\driver_interface $cache, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db)
	{
		$this->cache = $cache;
		$this->auth = $auth;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
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
			'core.user_setup'	        => 'load_language_on_setup',		
			'core.page_header_after'	=> 'page_header_after',
		);
	}

	/**
	* @param object $event The event object 
	*/
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'galandas/advlogin',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function page_header_after($event)
	{		
		$advlogin_data = $this->cache->get('_advlogin_data');

		if ($advlogin_data === false)
		{
			$advlogin_data = $this->config_text->get_array(array(
				'advlogin_text',
			));

			$this->cache->put('_advlogin_data', $advlogin_data);
		}
		
		$this->template->assign_vars(array(
			'ENABLE_ADVLOGIN' 			=> $this->config['enable_advlogin'],
			'ASPECT_ADVLOGIN' 			=> $this->config['aspect_advlogin'],			
			'COLOR_ADVLOGIN' 			=> $this->config['color_advlogin'],
			'WIDTH_ADVLOGIN'		    => $this->config['width_advlogin'],
			'HEIGHT_ADVLOGIN'		    => $this->config['height_advlogin'],			
            'ADVLOGIN_TEXT'				=> htmlspecialchars_decode($advlogin_data['advlogin_text']),
		));
	}
}