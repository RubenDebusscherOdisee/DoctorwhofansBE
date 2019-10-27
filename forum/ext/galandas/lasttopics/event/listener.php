<?php
/**
*
* @package phpBB Extension - Advanced Active Topics
* @copyright (c) 2017 Galandas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace galandas\lasttopics\event;
/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\content_visibility;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\cache\service as cache_interface;
/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'			=> 'add_permission',		
			'core.user_setup'	        => 'load_language_on_setup',
			'core.page_header_after'	=> 'page_header_after',			
		);
	}
	
    /** @var content_visibility */
    protected $content_visibility;
	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\controller\helper */
	protected $helper;
	/** @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\user */
	protected $user;
	/** @var \phpbb\auth\auth */
	protected $auth;
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	/** @var \phpbb\cache\service */
	protected $cache;
	
	/** @var string */
	protected $phpbb_root_path;
	
	/** @var string */	
	protected $phpEx;
	/**
	* Constructor
	*
	* @param config				$config
	* @param helper				$helper
	* @param template			$template
	* @param user				$user
	* @param auth				$auth
	* @param db_interface		$db
	* @param cache_interface	$cache
	* @param string				$phpbb_root_path
	* @param string				$phpEx
	*/
	public function __construct(\phpbb\content_visibility $content_visibility, \phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\cache\service $cache, $phpbb_root_path, $phpEx)
	{
		$this->content_visibility = $content_visibility;
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->db = $db;
		$this->cache = $cache;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->phpEx = $phpEx;
	}
	
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_at_adv'] = array('lang' => 'ACL_U_AT_ADV', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
	
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'galandas/lasttopics',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function page_header_after($event)
	{
    $flast = $this->auth->acl_getf('f_read', true);
    $flast = array_unique(array_keys($flast));
    $flast = array_merge($flast, array(0));
	
//Last active topics
    $sql = 'SELECT forum_id, topic_id, topic_title, topic_time, topic_views, topic_poster, topic_posts_approved, topic_first_poster_name, topic_first_poster_colour, topic_last_post_id, topic_last_poster_name, topic_last_poster_colour, topic_last_post_time, topic_last_view_time, topic_last_poster_id
		FROM ' . TOPICS_TABLE . '
        WHERE ' . $this->db->sql_in_set('forum_id', $flast) . '
        AND ' . $this->content_visibility->get_visibility_sql('topic', 'topic') . '
		ORDER BY topic_last_post_time DESC';
	$result = $this->db->sql_query_limit($sql, $this->config['last_total']);
	
	while ($row = $this->db->sql_fetchrow($result))
	{
	$this->template->assign_block_vars('last_topic', array(
            'LAST_LINK'      => append_sid("{$this->phpbb_root_path}viewtopic.$this->phpEx", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
		    'U_LAST_TOPIC'   => append_sid("{$this->phpbb_root_path}viewtopic.$this->phpEx", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']),
            'LAST_POSTER'     => append_sid("{$this->phpbb_root_path}memberlist.$this->phpEx", 'mode=viewprofile' . '&amp;u=' . $row['topic_poster']),
		    'USERNAME_LAST'	 => append_sid("{$this->phpbb_root_path}memberlist.$this->phpEx", 'mode=viewprofile' . '&amp;u=' . $row['topic_last_poster_id']),
			'TOPIC_TITLE'					=> $row['topic_title'],
			'TOPIC_VIEWS'					=> $row['topic_views'],
    	    'TOPIC_REPLIES'	                => $row['topic_posts_approved'],
			'TOPIC_LAST_POSTER_NAME'		=> $row['topic_last_poster_name'],
			'TOPIC_LAST_POSTER_COLOUR'		=> $row['topic_last_poster_colour'],
			'TOPIC_LAST_POST_TIME'			=> $this->user->format_date($row['topic_last_post_time']),
			'TOPIC_LAST_VIEW_TIME'			=> $this->user->format_date($row['topic_last_view_time']),
		));
	}
	$this->db->sql_freeresult($result);
	
	$this->template->assign_vars(array(
		'LASTAT_TOTAL'		        => (isset($this->config['last_total'])) ? $this->config['last_total'] : '',	
		'LASTAT_DIRECTION'		    => (!empty($this->config['lastat_direction'])) ? true : false,
		'LASTAT_TYPE'			    => (!empty($this->config['lastat_type'])) ? true : false,
		'LASTAT_ENABLE'	            => (!empty($this->config['lastat_enable'])) ? true : false,		
		'LASTAT_TOP'		        => (!empty($this->config['lastat_t_pos']) == 1) ? true : false,
		'LASTAT_FUT'		        => (!empty($this->config['lastat_t_pos']) == 0) ? true : false,
		'LASTAT_TUTTO'	            => (!empty($this->config['lastat_tutto'])) ? true : false,
		'LASTAT_INDEX'	            => (!empty($this->config['lastat_index'])) ? true : false,		
		'LASTAT_NAVIGATION'		    => (!empty($this->config['lastat_navigation'])) ? true : false,
		'U_AT_ADV' 				    => ($this->auth->acl_get('u_at_adv')) ? true : false,		
    ));
    }
}