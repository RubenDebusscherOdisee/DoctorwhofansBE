<?php
/**
*
* Prime User Topics extension for the phpBB Forum Software package.
*
* @copyright (c) 2018 Ken F. Innes IV <https://www.absoluteanime.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace primehalo\primeusertopics\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/**
	* Service Containers
	*/
	protected $auth;
	protected $template;
	protected $user;
	protected $root_path;
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth			$auth		Auth object
	* @param \phpbb\template\template 	$template	Template object
	* @param \phpbb\user				$user		User object
	* @param $root_path					$root_path	phpBB root path
	* @param $phpExt					$phpExt		php file extension
	*/
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$root_path,
		$phpExt)
	{
		$this->auth			= $auth;
		$this->template		= $template;
		$this->user			= $user;
		$this->root_path	= $root_path;
		$this->php_ext		= $phpExt;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.memberlist_prepare_profile_data'	=> 'memberlist_prepare_profile_data',
			'core.page_header_after'				=> 'page_header_after',
		);
	}

	/**
	* Set the user's topic link variable for the profile page.
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function memberlist_prepare_profile_data($event)
	{
		if ($this->auth->acl_get('u_search'))
		{
			$this->user->add_lang_ext('primehalo/primeusertopics', 'primeusertopics');
			$data = $event['data'];
			$user_id = $data['user_id'];
			$this->template->assign_var('U_SEARCH_USER_TOPICS',	 append_sid("{$this->root_path}search.{$this->php_ext}", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost"));
		}
	}

	/**
	* Set the self topic link variable for the page header (also used for the main page of the UCP).
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function page_header_after($event)
	{
		$user_id = $this->user->data['user_id'];
		if ($user_id != ANONYMOUS)
		{
			$this->user->add_lang_ext('primehalo/primeusertopics', 'primeusertopics');
			$this->template->assign_var('U_SEARCH_SELF_TOPICS',	 append_sid("{$this->root_path}search.{$this->php_ext}", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost"));
		}
	}
}
