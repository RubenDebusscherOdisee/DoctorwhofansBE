<?php
/**
*
* @package phpBB Extension - Active Extensions List
* @copyright (c) 2016 spaceace - http://www.livemembersonly.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace spaceace\activeextlist\controller;

use phpbb\exception\http_exception;

class controller
{
	/* @var \phpbb\auth\auth */
	protected $auth;

	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/* @var extension_manager */
	protected $extension_manager;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth				$auth
	* @param \phpbb\config\config			$config
	* @param \phpbb\controller\helper		$helper
	* @param \phpbb\template\template		$template
	* @param \phpbb\user					$user
	* @param \phpbb\extension_manager 		$extension_manager
	*/
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\controller\helper $helper,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\extension\manager $extension_manager)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->extension_manager = $extension_manager;
	}

	/**
	* Get the extension info
	*/
	public function get_ext_info()
	{
		// check auth
		if (!$this->auth->acl_get('u_activeextlist_view'))
		{
			throw new http_exception(403, 'NOT_AUTHORISED');
		}

		$this->user->add_lang_ext('spaceace/activeextlist', 'common');

		foreach ($this->extension_manager->all_enabled() as $name => $location)
		{
			$md_manager = $this->extension_manager->create_extension_metadata_manager($name, $this->template);
			$meta = $md_manager->get_metadata('all');

			$this->template->assign_block_vars('activeextlist', array(
				'NAME'			=> $meta['extra']['display-name'],
				'DESCRIPTION'	=> $meta['description'],
				'VERSION'		=> $meta['version'],
			));
		}
		return $this->helper->render('activeextlist_body.html', $this->user->lang['ACTIVE_EXT']);
	}
}
