<?php
/**
*
* @package phpBB Extension - Active Extensions List
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @copyright (c) 2016 spaceace - http://www.livemembersonly.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace spaceace\activeextlist\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var core.php_ext */
	protected $php_ext;

	/**
	* Constructor
	* @param \phpbb\auth\auth					$auth
	* @param \phpbb\controller\helper			$helper
	* @param \phpbb\template\template			$template
	* @param \phpbb\user						$user
	* @param \phpbb\db\driver\driver_interface	$db
	* @param string								$php_ext
	*/
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\controller\helper $helper,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		$php_ext)
	{
		$this->auth = $auth;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->db = $db;
		$this->php_ext = $php_ext;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.viewonline_overwrite_location'		=> 'add_page_viewonline',
			'core.page_header'							=> 'page_header',
			'core.permissions'							=> 'permissions',
		);
	}

	/**
	 * Modifies viewonline to show who is on what page
	 */
	public function add_page_viewonline($event)
	{
		if ($this->auth->acl_get('u_activeextlist_view'))
		{
			if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/activeextlist') === 0)
			{
				$this->user->add_lang_ext('spaceace/activeextlist', 'common');
				$event['location'] = $this->user->lang('VIEWING_ACTIVE_EXT');
				$event['location_url'] = $this->helper->route('spaceace_activeextlist_controller');
			}
		}
	}

	/*
	 * Add permission
	 */
	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_activeextlist_view'] = array('lang' => 'ACL_U_ACTIVEEXTLIST_VIEW', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function page_header($event)
	{
		if ($this->auth->acl_get('u_activeextlist_view'))
		{
			$this->user->add_lang_ext('spaceace/activeextlist', 'common');

			$sql = 'SELECT SUM(ext_active) AS count
				FROM ' . EXT_TABLE;
			$result = $this->db->sql_query($sql);
			$ext_count = (int) $this->db->sql_fetchfield('count');
			$this->db->sql_freeresult($result);

			$this->template->assign_vars(array(
				'ACTIVE_EXT'			=> $this->user->lang('ACTIVE_EXT', $ext_count),
				'U_ACTIVEEXTLIST_VIEW'	=> $this->helper->route('spaceace_activeextlist_controller', array()),
			));

		}
	}
}
