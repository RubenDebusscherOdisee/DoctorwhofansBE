<?php
/**
*
* @package phpBB Extension - User Posts in a topic
* @copyright (c) 2016 RMcGirr83 (Rich McGirr)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\userpostsinatopic\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	private $data = array();

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $php_ext;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth					$auth			Auth object
	* @param \phpbb\db\driver\driver			$db				Database object
	* @param \phpbb\template\template           $template       Template object
	* @param \phpbb\user                        $user           User object
	* @param string                             $root_path      phpBB root path
	* @param string                             $php_ext        phpEx
	* @access public
	*/
	public function __construct(
			\phpbb\auth\auth $auth,
			\phpbb\db\driver\driver_interface $db,
			\phpbb\template\template $template,
			\phpbb\user $user,
			$root_path,
			$php_ext)
	{
		$this->auth = $auth;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_assign_template_vars_before'	=> 'get_user_post_count',
			'core.viewtopic_modify_page_title'				=> 'add_user_lang',
			'core.viewtopic_cache_user_data'				=> 'viewtopic_cache_data',
			'core.viewtopic_cache_guest_data'				=> 'viewtopic_cache_data',
			'core.viewtopic_modify_post_row'				=> 'display_post_count',
		);
	}

	// build an array of poster ids and number of posts in the topic.
	public function get_user_post_count($event)
	{
		$topic_id = $event['topic_id'];

		$sql = 'SELECT poster_id, COUNT(post_id) AS postnum
					FROM ' . POSTS_TABLE . '
					WHERE topic_id = ' . (int) $topic_id . '
					AND poster_id <> ' . ANONYMOUS . '
					GROUP BY poster_id';

		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->data[$row['poster_id']] = $row['postnum'];
		}
		$this->db->sql_freeresult($result);
	}

	public function add_user_lang()
	{
		$this->user->add_lang_ext('rmcgirr83/userpostsinatopic', 'common');
	}

	/**
	* Update viewtopic data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_cache_data($event)
	{
		$poster_id = $event['poster_id'];
		$topic_array = $event['user_cache_data'];
		$topic_array['user_posts_in_topic'] = (!empty($this->data[$poster_id])) ? $this->data[$poster_id] : 0;
		$event['user_cache_data'] = $topic_array;
	}

	public function display_post_count($event)
	{
		$topic_id = $event['topic_data']['topic_id'];
		$poster_id = $event['poster_id'];
		$post_count = $event['user_poster_data']['user_posts_in_topic'];
		if ($this->auth->acl_get('u_search') && !empty($post_count))
		{
			$event['post_row'] = array_merge($event['post_row'], array(
				'POSTER_POST_COUNT'			=> $post_count,
				'U_POSTS_VIEWTOPIC_INTO'	=> append_sid("{$this->root_path}search.$this->php_ext", "author_id=$poster_id&amp;t=$topic_id&amp;sr=posts"),
			));
		}
	}
}
