<?php
/**
*
* @package Print all posts in a topic
* @copyright (c) 2020 Rich McGirr(RMcGirr83)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace rmcgirr83\printallposts\event;

/**
* @ignore
*/
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\request\request;
use phpbb\template\template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var printallposts */
	protected $printallposts = false;

	/** @var printallposts_view */
	protected $printallposts_view = '';

	public function __construct(
		auth $auth,
		config $config,
		language $language,
		request $request,
		template $template
	)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
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
			'core.acp_extensions_run_action_after'		=> 'acp_extensions_run_action_after',
			'core.viewtopic_before_f_read_check'		=> 'viewtopic_before_f_read_check',
			'core.viewtopic_assign_template_vars_before'	=> 'viewtopic_assign_template_vars_before',
			'core.viewtopic_highlight_modify'			=> 'viewtopic_highlight_modify',
			'core.viewtopic_modify_page_title'			=> 'viewtopic_modify_page_title',
		);
	}

	/* Display additional metadata in extension details
	*
	* @param $event			event object
	* @param return null
	* @access public
	*/
	public function acp_extensions_run_action_after($event)
	{
		if ($event['ext_name'] == 'rmcgirr83/printallposts' && $event['action'] == 'details')
		{
			$this->language->add_lang('acp_printallposts', $event['ext_name']);
			$this->template->assign_var('S_BUY_ME_A_BEER_PAPIT', true);
		}
	}

	/**
	* Perform an auth check
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_before_f_read_check($event)
	{
		$this->printallposts_view = $this->request->variable('view', '');

		$this->language->add_lang('printallposts', 'rmcgirr83/printallposts');

		// is the user allowed to print posts
		if ($this->auth->acl_get('f_print', $event['forum_id']))
		{
			$this->printallposts = true;
		}
		else if ($this->printallposts_view == 'printall' && !$this->auth->acl_get('f_print', $event['forum_id']))
		{
			send_status_line(403, $this->language->lang('FORBIDDEN'));
			trigger_error('NO_AUTH_PRINT_TOPIC');
		}
	}

	/**
	* Change start and config vars
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_highlight_modify($event)
	{
		if ($this->printallposts_view == 'printall')
		{
			$event['start'] = '0';
			$this->config->offsetSet('posts_per_page', $event['total_posts']);
		}
	}

	/**
	* Change some vars in viewtopic
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_assign_template_vars_before($event)
	{
		if ($this->printallposts == true)
		{
			$printallposts_url = $event['viewtopic_url'] . '&amp;view=printall';
			$this->template->assign_var('U_PRINTALLPOSTS', $printallposts_url);
		}
	}

	/**
	* Overwrite $view var to use the correct template
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_modify_page_title($event)
	{
		if ($this->printallposts_view == 'printall')
		{
			// Output the page
			page_header($event['page_title'], true, $event['forum_id']);

			$this->template->set_filenames(array(
				'body' => 'viewtopic_print.html'
			));

			page_footer();
		}
	}
}
