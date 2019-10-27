<?php

/**
 *
 * Forum Language. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Saeed Hubaishan, http://salafitech.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace hubaishan\forumlanguage\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface {

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	
	/** @var \phpbb\request\request */
	protected $request;
	
	/**
	 * 	Constructor
	 * @param \phpbb\user 						$user		User object
	 * @param \phpbb\db\driver\driver_interface $db			Database object
	 * @param \phpbb\request\request 			$request	Request object
	 */
	public function __construct(\phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request)
	{
		$this->user 	= $user;
		$this->db		= $db;
		$this->request	= $request;
	}


	static public function getSubscribedEvents() {
		return array(
			'core.user_setup'	=> array('change_language', 1000),
			'core.acp_manage_forums_request_data'	=> 'acp_manage_forums_request_data',
			'core.acp_manage_forums_display_form'	=> 'acp_manage_forums_display_form',
			'core.acp_language_after_delete'		=> 'acp_language_delete',
		);
	}

	public function change_language($event)
	{
		$forum_id	= $this->request->variable('f', 0);
		$topic_id	= $this->request->variable('t', 0);
		$post_id	= $this->request->variable('p', 0);
		$module_id	= $this->request->variable('i', '');


		if (empty($module_id))
		{
			if (!$forum_id && ($topic_id || $post_id))
			{
				if ($topic_id)
				{
					$sql = 'SELECT forum_id
						FROM ' . TOPICS_TABLE . "
						WHERE topic_id = $topic_id";
				} else {
					$sql = 'SELECT forum_id
						FROM ' . POSTS_TABLE . "
						WHERE post_id = $post_id";
				}

				$result = $this->db->sql_query($sql);
				$forum_id = (int) $this->db->sql_fetchfield('forum_id');
				$this->db->sql_freeresult($result);
			}


			if ($forum_id>0)
			{
				$sql = "SELECT forum_language
				FROM " . FORUMS_TABLE . "
				WHERE forum_id = $forum_id";
				$result = $this->db->sql_query($sql);
				$forum_lang = $this->db->sql_fetchfield('forum_language');
				$this->db->sql_freeresult($result);

				if (!empty($forum_lang))
				{
					$event['user_lang_name'] = $forum_lang;

				}
			}
		}
	}

	public function acp_manage_forums_request_data($event)
	{
		$forum_data = $event['forum_data'];
		$forum_data += array(
			'forum_language'			=> $this->request->variable('forum_language', ''),
		);
		$event['forum_data'] = $forum_data;
	}

	public function acp_manage_forums_display_form($event)
	{
		$this->user->add_lang_ext('hubaishan/forumlanguage', 'common');
		$template_data = $event['template_data'];
		$forum_data = $event['forum_data'];

		$lang_options = language_select($forum_data['forum_language']);
		$template_data += array(
			'S_LANG_OPTIONS'	=> $lang_options,
		);
		$event['template_data'] = $template_data;
	}

	public function acp_language_delete($event)
	{
		$this->user->add_lang_ext('hubaishan/forumlanguage', 'common');
		$sql = 'UPDATE ' . FORUMS_TABLE . "
						SET forum_language = ''
						WHERE forum_language = '" . $this->db->sql_escape($event['lang_iso']) . "'";
		$this->db->sql_query($sql);

		$event['delete_message'] =  $event['delete_message'] . '<br>'. $this->user->lang['FL_AFTER_LANGUAGE_PACK_DELETED'];
	}
}
