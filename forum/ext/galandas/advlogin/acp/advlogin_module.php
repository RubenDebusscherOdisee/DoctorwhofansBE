<?php
/**
 *
 * Advanced login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\advlogin\acp;

/**
* @package acp
*/
class advlogin_module
{
    /** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	public $u_action;

    public function main($id, $mode)
    {
        global $cache, $config, $request, $template, $user, $phpbb_container;

		$this->cache = $cache;
        $this->config = $config;
		$this->config_text = $phpbb_container->get('config_text');
        $this->request = $request;
        $this->template = $template;
        $this->user = $user;
		
		$user->add_lang_ext('galandas/advlogin', 'advlogin_acp');
		$this->tpl_name = 'acp_advlogin';
        $this->page_title = $user->lang('ACP_ADVLOGIN');		

		$form_key = 'acp_advlogin';
		add_form_key($form_key);

		$advlogin_data = $this->config_text->get_array(array(
			'advlogin_text',
		));

        if ($this->request->is_set_post('submit'))
        {
            if (!check_form_key($form_key))
            {
                trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
            }

			$this->config->set('enable_advlogin', $this->request->variable('enable_advlogin', 0));
			$this->config->set('color_advlogin', $this->request->variable('color_advlogin', ''));
			$this->config->set('width_advlogin', $this->request->variable('width_advlogin', 0));
			$this->config->set('height_advlogin', $this->request->variable('height_advlogin', 0));
			$this->config->set('aspect_advlogin', $this->request->variable('aspect_advlogin', 1));

			$this->config_text->set_array(array(
				'advlogin_text'			=> $this->request->variable('advlogin_text', '', true),
			));

			$this->cache->destroy('_advlogin_data');

            trigger_error($this->user->lang('ACP_ADVLOGIN_CONFIG_SAVED') . adm_back_link($this->u_action));
        }

        $this->template->assign_vars(array(
			'ENABLE_ADVLOGIN'			=> (!empty($this->config['enable_advlogin'])) ? true : false,
			'ASPECT_ADVLOGIN'			=> (!empty($this->config['aspect_advlogin'])) ? true : false,
			'VERSION_ADVLOGIN'		    => (isset($this->config['advlogin_version'])) ? $config['advlogin_version'] : '',
			'A_COLOR_ADVLOGIN'			=> (isset($this->config['color_advlogin'])) ? addslashes($config['color_advlogin']) : '',
			'WIDTH_ADVLOGIN'		    => (isset($this->config['width_advlogin'])) ? $config['width_advlogin'] : '',
			'HEIGHT_ADVLOGIN'		    => (isset($this->config['height_advlogin'])) ? $config['height_advlogin'] : '',
            'ADVLOGIN_TEXT'			    => $advlogin_data['advlogin_text'],
            'U_ACTION'				    => $this->u_action,
        ));
    }
}
