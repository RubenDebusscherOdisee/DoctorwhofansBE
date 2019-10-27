<?php
/**
 *
 * Simple News Admin. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\news\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Simple News Admin listener.
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;
	
	/** @var \phpbb\auth\auth */
	protected $auth;	

	/** @var \phpbb\user */
	protected $user;
	
	/** @var string */
	protected $operator;	

	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface $cache			 Cache driver interface
	* @param \phpbb\config\config				  $config			 Config object
	* @param \phpbb\config\db_text				  $config_text		 DB text object
	* @param \phpbb\controller\helper			  $helper			 helper object
	* @param \phpbb\request\request				  $request			 Request object
	* @param \phpbb\template\template			  $template			 Template object
	* @param \phpbb\auth\auth					  $auth				 auth object	
	* @param \phpbb\user						  $user				 User object
	*/
	public function __construct(\phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\auth\auth $auth, \phpbb\user $user, \phpbb\collapsiblecategories\operator\operator $operator = null)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->helper = $helper;
		$this->request = $request;
		$this->template = $template;
		$this->auth = $auth;		
		$this->user = $user;
		$this->operator = $operator;		
	}
	
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'			=> 'add_permission',
			'core.page_header_after'	=> 'display_simple_news_admin',
		);
	}
	
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_sna'] = array('lang' => 'ACL_U_AT_NEW', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}	

	public function display_simple_news_admin($event)
	{
		$news_data = $this->cache->get('_news_data');
		
		if ($news_data === false)
		{		
		$news_data = $this->config_text->get_array(array(
				'news_info',
				'news_info_uid',
				'news_info_bitfield',
				'news_info_flags',
		));
		
		$this->cache->put('_news_data', $news_data);
		}
		
		$news_text = generate_text_for_display(
			$news_data['news_info'],
			$news_data['news_info_uid'],
			$news_data['news_info_bitfield'],
			$news_data['news_info_flags']
		);
		
		// Add collapsiblecategories		
		if ($this->operator !== null)
		{
			$fid = 'news'; // Può essere qualsiasi stringa univoca per identificare l'elemento pieghevole delle estensioni
			$this->template->assign_vars(array(
				'NEWS_IS_COLLAPSIBLE'	=> true,
				'S_NEWS_HIDDEN' => in_array($fid, $this->operator->get_user_categories()),
				'U_NEWS_COLLAPSE_URL' => $this->helper->route('phpbb_collapsiblecategories_main_controller', array('forum_id' => $fid, 
				'hash' => generate_link_hash("collapsible_$fid")))
			));			
		}
		
		$this->template->assign_vars(array(
			'NEWS_ADMIN'			=> $news_text,
			'NEWS_ENABLE'			=> ($this->config['news_enable']),
			'NEWS_TYPE'				=> ($this->config['news_type']) ? true : false,			
			'U_SN_NEWS'				=> ($this->auth->acl_get('u_sna')) ? true : false,			
		));		
	}
}
