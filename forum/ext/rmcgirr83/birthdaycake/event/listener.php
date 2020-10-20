<?php
/**
*
* Birthday Cake extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\birthdaycake\event;

/**
* @ignore
*/
use phpbb\language\language;
use phpbb\user;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\language\language			$language			Language object
	* @param \phpbb\user                        $user           	User object
	* @access public
	*/
	public function __construct(language $language, user $user)
	{
		$this->language = $language;
		$this->user = $user;
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
			'core.viewtopic_assign_template_vars_before'	=> 'assign_lang_var',
			'core.viewtopic_cache_user_data'			=> 'viewtopic_cache_user_data',
			'core.viewtopic_cache_guest_data'			=> 'viewtopic_cache_guest_data',
			'core.viewtopic_modify_post_row'			=> 'viewtopic_modify_post_row',
			'core.memberlist_prepare_profile_data'		=> 'memberlist_prepare_profile_data',
			'core.search_get_posts_data'				=> 'search_get_posts_data',
			'core.search_modify_tpl_ary'				=> 'search_modify_tpl_ary',
			'core.search_results_modify_search_title'	=> 'assign_lang_var',
		);
	}

	/**
	 * Add lang var
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function assign_lang_var($event)
	{
		$this->language->add_lang('birthdaycake', 'rmcgirr83/birthdaycake');
	}

	/**
	* Update viewtopic user data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_cache_user_data($event)
	{
		$array = $event['user_cache_data'];
		$array['user_birthday'] = $event['row']['user_birthday'];
		$event['user_cache_data'] = $array;
	}

	/**
	* Update viewtopic guest data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_cache_guest_data($event)
	{
		$array = $event['user_cache_data'];
		$array['user_birthday'] = '';
		$event['user_cache_data'] = $array;
	}

	/**
	* Modify the viewtopic post row
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_modify_post_row($event)
	{
		$event['post_row'] = array_merge($event['post_row'],array(
			'BIRTHDAYCAKE' => $this->birthdaycake($event['user_poster_data']['user_birthday']),
		));
	}

	/**
	* Modify the users profile view
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function memberlist_prepare_profile_data($event)
	{
		$this->language->add_lang('birthdaycake', 'rmcgirr83/birthdaycake');

		$array = $event['template_data'];
		$array['BIRTHDAYCAKE'] = $this->birthdaycake($event['data']['user_birthday']);
		$event['template_data'] = $array;
	}

	/**
	* Display birthdaycake on search
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function search_get_posts_data($event)
	{
		$array = $event['sql_array'];
		$array['SELECT'] .= ', u.user_birthday';
		$event['sql_array'] = $array;
	}

	/**
	* Display birthdaycake on search
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
		$array = array_merge($array, [
			'USER_BIRTHDAYCAKE'	=> $this->birthdaycake($event['row']['user_birthday']),
		]);
		$event['tpl_ary'] = $array;
	}

	/**
	 * birthdaycake
	 *
	 * @param string $user_birthday User's Birthday
	 * @return bool
	 */
	private function birthdaycake($user_birthday)
	{
		$is_birthday = false;
		if (!empty($user_birthday))
		{
			$time = $this->user->create_datetime();
			$now = phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());

			list($bday, $bmonth) = array_map('intval', explode('-', $user_birthday));

			if ($bday === (int) $now['mday'] && $bmonth === (int) $now['mon'])
			{
				$is_birthday = true;

			}
		}
		return $is_birthday;
	}
}
