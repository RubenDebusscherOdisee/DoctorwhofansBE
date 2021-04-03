<?php
/**
*
* @package IP Address Deletion v1.0.3
* @copyright (c) 2020 - 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace mot\ipdelete\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{

	public static function getSubscribedEvents()
	{
		return array(
			'core.delete_user_before'		=> 'delete_ip',
		);
	}

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface $db	Database object
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db)
	{
		$this->db = $db;
	}


	/**
	* Delete the IP stored with the user_id(s) belonging to users to be deleted in all phpBB tables by setting this entry to '0:0:0:0' to ensure data privacy
	*
	* @param array	$event	containing:
	*	@var string		mode				Mode of posts deletion (retain|delete)
	*	@var array		user_ids			ID(s) of the user(s) bound to be deleted
	*	@var bool		retain_username		True if username should be retained, false otherwise
	*	@var array		user_rows			Array containing data of the user(s) bound to be deleted (since 3.2.4-RC1)
	*
	*/
	public function delete_ip($event)
	{
		$user_ids = $event['user_ids'];

		$table_arr = array(
			array('table' => LOG_TABLE,				'ip_name' => 'log_ip',			'id_name' => 'user_id'),
			array('table' => LOGIN_ATTEMPT_TABLE,	'ip_name' => 'attempt_ip',		'id_name' => 'user_id'),
			array('table' => POLL_VOTES_TABLE,		'ip_name' => 'vote_user_ip',	'id_name' => 'vote_user_id'),
			array('table' => POSTS_TABLE,			'ip_name' => 'poster_ip',		'id_name' => 'poster_id'),
			array('table' => PRIVMSGS_TABLE,		'ip_name' => 'author_ip',		'id_name' => 'author_id'),
			array('table' => SESSIONS_TABLE,		'ip_name' => 'session_ip',		'id_name' => 'session_user_id'),
		);

		foreach ($table_arr as $row)
		{
			$sql = "UPDATE " . $row['table'] . "
					SET " . $row['ip_name'] . " = ''
					WHERE " . $this->db->sql_in_set($row['id_name'], $user_ids);
			$this->db->sql_query($sql);
		}
	}

}
