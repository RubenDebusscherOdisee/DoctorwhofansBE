<?php
/**
*
* WTTU Extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 Ather
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace ather\wttu\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.common'							=> 'common_setup',
			'core.user_setup'						=> 'load_language_on_setup',
			'core.viewtopic_get_post_data'		=> 'viewtopic_get_post_data',
			
		);
	}

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	* Constructor
	* 
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template			$template	Template object
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\config $config, $php_ext)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->config = $config;
		$this->php_ext = $php_ext;
	}

	public function common_setup($event)
	{
		$this->template->assign_vars(array(
			'WTTU_STATUS'		=> $this->config['wttu_status'] ? true : false,
			'WTTU_LINK_ENABLED'		=> $this->config['wttu_link'] ? true : false,
			'WTTU_BBCODE_ENABLED'		=> $this->config['wttu_bbcode'] ? true : false,
			'WTTU_HTML_ENABLED'		=> $this->config['wttu_html'] ? true : false,
			//'WTTU_LINK' 	=> append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext, 'f=' . $event['data']['forum_id'] . '&amp;t=' . $event['data']['topic_id'] . '&amp;p=' . $event['data']['post_id'] . '#p' . $event['data']['post_id']),
			
		));
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'ather/wttu',
			'lang_set' => 'wttu',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	
	public function viewtopic_get_post_data($event)
    {
		if (!$this->config['wttu_status'])
		{
			return;
		}
		
        $row = $event['row'];
		$postrow = $event['post_row'];		
		$forum_id = (int) $row['forum_id'];
		
		$canon_url = append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext, 't=' . $event['topic_id']);	
		$simple_url = append_sid(generate_board_url() . '/viewtopic.' . $this->php_ext, 'f=' . $event['forum_id'] . '&amp;t=' . $event['topic_id']);

		$share_url = !$this->config['wttu_type'] ? $canon_url : $simple_url;
	
		$this->template->assign_vars(array(
		'WTTU_LINK' 	=> $share_url,
		'WTTU_BBCODE'	=> $share_url,
		'WTTU_HTML'		=> htmlentities('<a href="' . $share_url . '">'),
		));
    } 
}
