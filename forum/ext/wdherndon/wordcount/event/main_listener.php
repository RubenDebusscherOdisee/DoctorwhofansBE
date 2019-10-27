<?php
/**
 *
 * Word Count. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, William D. Herndon,
 * http://www.softwareschmiede-herndon.de
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace wdherndon\wordcount\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Word Count Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'load_language_on_setup',
			'core.viewtopic_modify_post_row'	=> 'viewtopic_modify_post_row',
			'core.posting_modify_template_vars'	=> 'posting_modify_template_vars',
		);
	}

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\template\template	$template	Template object
	 * @param \phpbb\user				 $user
	 */
	public function __construct(\phpbb\template\template $template, \phpbb\user $user)
	{
		$this->template = $template;
		$this->user = $user;
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'wdherndon/wordcount',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Count the words in an unformatted (stripped) string:
	 * Words are any set of alphanumeric characters separated
	 * by non-alphanumeric characters.
	 *
	 * @param string	$message	String to count words in
	 */
	public function count_words($message)
	{
		$count = 0;
		$inbetween_words = true;
		$msg_len = strlen($message);
		for ($ii = 0; $ii < $msg_len; $ii++)
		{
			$c = substr($message, $ii, 1);
			if ( !ctype_alnum($c) )
			{
				$inbetween_words = true;
			}
			else
			{
				if ($inbetween_words)
				{
					$count = $count + 1;
				}
				$inbetween_words = false;
			}
		}
		return $count;
	}

	 /**
	 * Strip HTML commands from the message.
	 *
	 * @param string	$message	String to strip
	 *
	 * return: stripped string.
	 */
	public function strip_html($message)
	{
		$retval = '';
		$in_tag = false;
		$msg_len = strlen($message);
		for ($ii = 0; $ii < $msg_len; $ii++)
		{
			$c = substr($message, $ii, 1);
			if ($c == '<')
			{
				$in_tag = true;
			}
			else if ($c == '>')
			{
				$in_tag = false;
			}
			else if (!$in_tag)
			{
				$retval .= $c;
			}
		}
		return html_entity_decode($retval);
	}

	 /**
	 * Strip Markdown commands from the message.
	 * The preview uses markdown, while the database uses the HTML.
	 * Do not ask me why.
	 *
	 * @param string	$message	String to strip
	 *
	 * return: stripped string.
	 */
	public function strip_markdown($message)
	{
		$retval = '';
		$in_tag = false;
		$msg_len = strlen($message);
		for ($ii = 0; $ii < $msg_len; $ii++)
		{
			$c = substr($message, $ii, 1);
			if ($c == '[')
			{
				$in_tag = true;
			}
			else if ($c == ']')
			{
				$in_tag = false;
			}
			else if (!$in_tag)
			{
				$retval .= $c;
			}
		}
		return $retval;
	}

	/**
	 * Add the word count at the bottom of the post.
	 */
	public function viewtopic_modify_post_row($event)
	{
		$post_row = $event['post_row'];
		$message = $post_row['MESSAGE'];
		$count = $this->count_words($this->strip_html($message));
		$post_row['EDITED_MESSAGE'] .=
			$this->user->lang('WORDCOUNT_WORDCOUNT', (string)$count);
		$event['post_row'] = $post_row;
	}

	public function posting_modify_template_vars($event)
	{

		if ($event['preview'])
		{
			$post_data = $event['post_data'];
			$count = $this->count_words($this->strip_markdown($post_data['post_text']));
			$this->template->assign_vars(array(
				'U_WORD_COUNT'	=> $this->user->lang('WORDCOUNT_WORDCOUNT', (string)$count),
			));
		}
	}
}
