<?php
/**
*
* Mood. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2017 Galandas, http://phpbb3world.altervista.org
* @copyright Used Code Genders extension, 2016 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace galandas\moods\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use galandas\moods\core\mood_constants;

/**
* Event listener Mood
*/
class listener implements EventSubscriberInterface
{

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $php_ext;

	public function __construct(
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$phpbb_root_path,
		$php_ext)
	{
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	/**
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.ucp_profile_modify_profile_info'		=> 'user_mood_profile',
			'core.ucp_profile_validate_profile_info'	=> 'user_mood_profile_validate',
			'core.ucp_profile_info_modify_sql_ary'		=> 'user_mood_profile_sql',
			'core.acp_users_modify_profile'				=> 'user_mood_profile',
			'core.acp_users_profile_validate'			=> 'user_mood_profile_validate',
			'core.acp_users_profile_modify_sql_ary'		=> 'user_mood_profile_sql',
			'core.viewtopic_cache_user_data'			=> 'viewtopic_cache_user_data',
			'core.viewtopic_cache_guest_data'			=> 'viewtopic_cache_guest_data',
			'core.viewtopic_modify_post_row'			=> 'viewtopic_modify_post_row',
			'core.memberlist_view_profile'				=> 'memberlist_view_profile',
			'core.search_get_posts_data'				=> 'search_get_posts_data',
			'core.search_modify_tpl_ary'				=> 'search_modify_tpl_ary',
			'core.ucp_register_data_before'				=> 'user_mood_profile',
			'core.ucp_register_data_after'				=> 'user_mood_profile_validate',
			'core.ucp_register_user_row_after'			=> 'user_mood_registration_sql',
		);
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_mood_profile($event)
	{
		if (DEFINED('IN_ADMIN'))
		{
			$user_mood = $event['user_row']['user_mood'];
		}
		else
		{
			$user_mood = $this->user->data['user_mood'];
		}
		// Request the user option vars and add them to the data array
		$event['data'] = array_merge($event['data'], array(
			'user_mood'	=> $this->request->variable('user_mood', $user_mood),
		));

		$this->user->add_lang_ext('galandas/moods', 'moods');

		$moods = mood_constants::getMoodChoices();
		$mood_image = $mood_options = '';

		foreach ($moods as $key => $value)
		{
			$selected = ($user_mood == $value) ? ' selected="selected"' : '';
			$mood_options .= '<option value="' . $value . '" ' . $selected . '>' . $this->user->lang($key) . '</option>';
			$mood_image .= ($user_mood == $value) ? strtolower($key) : '';
		}

		$this->template->assign_vars(array(
			'USER_MOOD'			=> $mood_image,
			'S_MOOD_OPTIONS'	=> $mood_options,
		));
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_mood_profile_validate($event)
	{
			$array = $event['error'];

			if (!function_exists('validate_data'))
			{
				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
			}
			$validate_array = array(
				'user_mood'	=> array('num', true, 0, 99),
			);
			$error = validate_data($event['data'], $validate_array);
			$event['error'] = array_merge($array, $error);
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_mood_profile_sql($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
				'user_mood' => $event['data']['user_mood'],
		));
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_cache_user_data($event)
	{
		$array = $event['user_cache_data'];
		$array['user_mood'] = $event['row']['user_mood'];
		$event['user_cache_data'] = $array;
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_cache_guest_data($event)
	{
		$array = $event['user_cache_data'];
		$array['user_mood'] = '';
		$event['user_cache_data'] = $array;
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_modify_post_row($event)
	{
		$mood = '';
		if ($event['user_poster_data']['user_type'] != USER_IGNORE)
		{
			$mood = $this->display_user_mood($event['user_poster_data']['user_mood']);
		}

		$event['post_row'] = array_merge($event['post_row'],array(
			'USER_MOOD' => $mood,
		));
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function memberlist_view_profile($event)
	{
		$mood = '';
		if ($event['member']['user_type'] != USER_IGNORE)
		{
			$mood = $this->display_user_mood($event['member']['user_mood']);
		}

		$this->template->assign_vars(array(
			'USER_MOOD'	=> $mood,
		));
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function search_get_posts_data($event)
	{
		$array = $event['sql_array'];
		$array['SELECT'] .= ', u.user_mood, u.user_type';
		$event['sql_array'] = $array;
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function search_modify_tpl_ary($event)
	{
		if ($event['show_results'] == 'topics')
		{
			return;
		}

		$array = $event['tpl_ary'];
		$mood = '';
		if ($event['row']['user_type'] != USER_IGNORE)
		{
			$mood = $this->display_user_mood($event['row']['user_mood']);
		}
		$array = array_merge($array, array(
			'USER_MOOD'	=> $mood,
		));

		$event['tpl_ary'] = $array;
	}

	/**
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_mood_registration_sql($event)
	{
		$event['user_row'] = array_merge($event['user_row'], array(
				'user_mood' => $this->request->variable('user_mood', 0),
		));
	}

	/**
	 * display user mood
	 *
	 * @author RMcGirr83
	 * @param int $user_mood User's mood
	 * @return string mood image
	 */
	private function display_user_mood($user_mood)
	{
		$this->user->add_lang_ext('galandas/moods', 'moods');
		$moods = mood_constants::getMoodChoices();
		$mood = '';
		foreach ($moods as $key => $value)
		{
			if ((int) $user_mood == $value && $user_mood <> 0)
			{
				$mood = '<i class="em ' . strtolower($key) . '" title="' . $this->user->lang($key) . '"></i>';
			}
		}

		return $mood;
	}
}
