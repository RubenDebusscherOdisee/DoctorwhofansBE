<?php
/**
*
* @package Announcements on index
* @copyright (c) 2015 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\announceonindex\event;

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

	/** @var \phpbb\template\twig\twig */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $phpEx;

	protected $phpbb_container;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\template\twig\twig	$template	Template object
	* @param \phpbb\user                $user		User object
	* @param \phpbb\db\driver\driver_interface $db
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\template\twig\twig $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $root_path, $php_ext, $phpbb_container, \phpbb\auth\auth $auth, $cache)
	{
		$this->config			= $config;
		$this->template			= $template;
		$this->user				= $user;
		$this->db				= $db;
		$this->root_path		= $root_path;
		$this->phpEx			= $php_ext;
		$this->phpbb_container	= $phpbb_container;
		$this->auth				= $auth;
		$this->cache			= $cache;
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
			'core.index_modify_page_title'	=> 'add_announcements_to_index',
			'core.page_header_after'		=> 'add_to_header',
		);
	}


	public function add_to_header($event)
	{
		$this->template->assign_vars(array(
				'S_ALLOW_GUESTS' 		=> ($this->config['announce_guest']) ? true : false,
				'S_ANNOUNCE_ENABLED'	=> ($this->config['announce_on_index_enable']) ? true : false,
		));
	}

	/**
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function add_announcements_to_index($event)
	{
		if ($this->config['announce_on_index_enable'] && ($this->config['announce_global_on_index'] || $this->config['announce_announcement_on_index']))
		{
			$phpbb_content_visibility = $this->phpbb_container->get('content.visibility');

			$sql_from	= TOPICS_TABLE . ' t ';
			$sql_select	= '';

			if ($this->config['load_db_track'])
			{
				$sql_from .= ' LEFT JOIN ' . TOPICS_POSTED_TABLE . ' tp ON (tp.topic_id = t.topic_id
					AND tp.user_id = ' . $this->user->data['user_id'] . ')';
				$sql_select .= ', tp.topic_posted';
			}

			if ($this->config['load_db_lastread'])
			{
				$sql_from .= ' LEFT JOIN ' . TOPICS_TRACK_TABLE . ' tt ON (tt.topic_id = t.topic_id
					AND tt.user_id = ' . $this->user->data['user_id'] . ')';
				$sql_select .= ', tt.mark_time';
			}

			// Get cleaned up list... return only those forums not having the f_read permission
			$forum_ary = $this->auth->acl_getf('!f_read', true);
			$forum_ary = array_unique(array_keys($forum_ary));

			// Determine first forum the user is able to read into - for global announcement link
			$sql = 'SELECT forum_id
				FROM ' . FORUMS_TABLE . '
				WHERE forum_type = ' . FORUM_POST;

			if (sizeof($forum_ary))
			{
				$sql .= ' AND ' . $this->db->sql_in_set('forum_id', $forum_ary, true);
			}

			$result = $this->db->sql_query_limit($sql, 1);

			$g_forum_id = (int) $this->db->sql_fetchfield('forum_id');
			$this->db->sql_freeresult($result);

			if ($g_forum_id)
			{
				$topic_list = $rowset = array();
				$sql_where = POST_GLOBAL;

				if ($this->config['announce_announcement_on_index'])
				{
					$sql_where = POST_ANNOUNCE;
				}

				if ($this->config['announce_global_on_index'] && $this->config['announce_announcement_on_index'])
				{
					$sql_where = POST_ANNOUNCE . ' OR t.topic_type =  ' . POST_GLOBAL;
				}

				$sql = "SELECT t.* $sql_select
					FROM $sql_from
					WHERE t.topic_type =  $sql_where
					ORDER BY t.topic_last_post_time DESC";

				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$topic_list[] = $row['topic_id'];
					$rowset[$row['topic_id']] = $row;
				}
				$this->db->sql_freeresult($result);

				$topic_tracking_info = array();
				if ($this->config['load_db_lastread'] && $this->user->data['is_registered'])
				{
					$topic_tracking_info = get_topic_tracking(0, $topic_list, $rowset, false, $topic_list);
				}
				else
				{
					$topic_tracking_info = get_complete_topic_tracking(0, $topic_list, $topic_list);
				}

				foreach ($topic_list as $topic_id)
				{
					$row = &$rowset[$topic_id];

					$forum_id = $row['forum_id'];
					$topic_id = $row['topic_id'];

					$unread_topic = (isset($topic_tracking_info[$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$topic_id]) ? true : false;

            		// Grab icons
            		$icons = $this->cache->obtain_icons();

					$folder_img = 'icon ';

					$folder_img	.= ($unread_topic) ? 'forum_unread' : 'forum_read';
					$folder_alt	= ($unread_topic) ? 'UNREAD_POSTS' : (($row['topic_status'] == ITEM_LOCKED) ? 'TOPIC_LOCKED' : 'NO_UNREAD_POSTS');

					if ($row['topic_status'] == ITEM_LOCKED)
					{
						$folder_img .= '_locked';
					}

					$this->template->assign_block_vars('topicrow', array(
						'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
						'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
						'LAST_POST_AUTHOR'		=> get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
						'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
						'TOPIC_TITLE'			=> censor_text($row['topic_title']),

	               		'REPLIES'				=> $phpbb_content_visibility->get_count('topic_posts', $row, $forum_id) - 1,
	            		'VIEWS'					=> $this->user->lang($row['topic_views']),
						'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
		        		'TOPIC_LAST_AUTHOR'		=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
						'TOPIC_FOLDER_IMG'		=> $this->user->img($folder_img, $folder_alt),
                		'TOPIC_ICON_IMG'		=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
						'TOPIC_IMG_STYLE'		=> 'icon ' . $folder_img,

						'S_ALLOW_EVENTS'		=> ($this->config['announce_event']) ? true : false,
						'S_UNREAD'				=> $unread_topic,

						'U_LAST_POST'			=> append_sid("{$this->root_path}viewtopic.$this->phpEx", "f=$g_forum_id&amp;t=$topic_id&amp;p=" . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
						'U_NEWEST_POST'			=> append_sid("{$this->root_path}viewtopic.$this->phpEx", "f=$g_forum_id&amp;t=$topic_id&amp;view=unread") . '#unread',
						'U_VIEW_TOPIC'			=> append_sid("{$this->root_path}viewtopic.$this->phpEx", "f=$g_forum_id&amp;t=$topic_id"),
					));
				}
			}
		}
	}
}
