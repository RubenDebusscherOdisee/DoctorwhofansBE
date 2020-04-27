<?php
/**
*
* @package		Breizh Ajax Preview Extension
* @copyright	(c) 2019-2020 Sylver35  https://breizhcode.com
* @license		http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace sylver35\ajaxpreview\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\controller\helper */
	protected $helper;

	public function __construct(\phpbb\template\template $template, \phpbb\controller\helper $helper)
	{
		$this->template	= $template;
		$this->helper	= $helper;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.posting_modify_template_vars'	=> 'posting_modify_template_vars',
			'core.ucp_pm_compose_template'		=> 'ucp_pm_compose_template',
			'core.ucp_profile_modify_signature'	=> 'ucp_profile_modify_signature'
		);
	}

	public function posting_modify_template_vars($event)
	{
		$event['page_data'] = array_merge($event['page_data'], array(
			'S_DISPLAY_PREVIEW'		=> true,
			'S_SHOW_AJAX_PREVIEW'	=> true,
			'S_IN_SIGNATURE'		=> false,
			'PREVIEW_DATA'			=> 'message',
			'U_PREVIEW_AJAX'		=> $this->helper->route('sylver35_ajaxpreview_controller_ajax'),
		));
	}

	public function ucp_pm_compose_template($event)
	{
		$event['template_ary'] = array_merge($event['template_ary'], array(
			'S_DISPLAY_PREVIEW'		=> true,
			'S_SHOW_AJAX_PREVIEW'	=> true,
			'S_IN_SIGNATURE'		=> false,
			'PREVIEW_DATA'			=> 'message',
			'U_PREVIEW_AJAX'		=> $this->helper->route('sylver35_ajaxpreview_controller_ajax'),
		));
	}

	public function ucp_profile_modify_signature($event)
	{
		$event['preview'] = true;
		$event['signature'] = ($event['signature'] == '') ? ' ' : $event['signature'];
		$this->template->assign_vars(array(
			'S_SHOW_AJAX_PREVIEW'	=> true,
			'S_IN_SIGNATURE'		=> true,
			'PREVIEW_DATA'			=> 'signature',
			'U_PREVIEW_AJAX'		=> $this->helper->route('sylver35_ajaxpreview_controller_ajax'),
		));
	}
}
