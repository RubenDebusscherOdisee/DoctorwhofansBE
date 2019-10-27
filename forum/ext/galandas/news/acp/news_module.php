<?php
/**
 *
 * Simple News Admin. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\news\acp;

/**
 * Simple News Admin ACP module.
 */
class news_module
{
	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $php_ext;
	
	/** @var string */
	public $u_action;

	public function main()
	{
		global $phpbb_container; 
		
		$this->cache = $phpbb_container->get('cache.driver');
		$this->config = $phpbb_container->get('config');
		$this->config_text = $phpbb_container->get('config_text');
		$this->db = $phpbb_container->get('dbal.conn');
		$this->request = $phpbb_container->get('request');
		$this->template = $phpbb_container->get('template');
		$this->user = $phpbb_container->get('user');
		$this->phpbb_root_path = $phpbb_container->getParameter('core.root_path');
		$this->php_ext = $phpbb_container->getParameter('core.php_ext');		
		
		$this->user->add_lang(array('posting'));
		$this->tpl_name = 'acp_news_conf';
		$this->page_title = ('ACP_NEWS_TITLE');
		
		$form_name = 'acp_news_conf';
		add_form_key($form_name);
		$error = '';
		
		if (!function_exists('display_custom_bbcodes'))
		{
			include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
		}
		
		// Ricevi tutti i dati news della board dalla tabella config_text nel database		
		$data = $this->config_text->get_array(array(
		'news_info',
		'news_info_uid',
		'news_info_bitfield',
		'news_info_flags',
		));
		
		if ($this->request->is_set_post('submit') || $this->request->is_set_post('preview'))
		{
			if (!check_form_key($form_name))
			{
				$error = $this->user->lang('FORM_INVALID');
			}
			
			$data['news_info'] = $this->request->variable('admin_news_info', '', true);
			
			generate_text_for_storage(
				$data['news_info'],
				$data['news_info_uid'],
				$data['news_info_bitfield'],
				$data['news_info_flags'],				
				!$this->request->variable('disable_bbcode', false),
				!$this->request->variable('disable_magic_url', false),
				!$this->request->variable('disable_smilies', false)
			);
			if (empty($error) && $this->request->is_set_post('submit'))
			{
				$this->config->set('news_enable', $this->request->variable('news_enable', false));
				$this->config->set('news_type', $this->request->variable('news_type', 1));
				$this->config->set('news_groups', $this->request->variable('news_groups', ''));				

				$this->config_text->set_array(array(
				'news_info'			  => $data['news_info'],
				'news_info_uid'		  => $data['news_info_uid'],
				'news_info_bitfield'  => $data['news_info_bitfield'],
				'news_info_flags'	  => $data['news_info_flags'],				
				));
				// Destroy news data
				$this->cache->destroy('_news_data');
				trigger_error($this->user->lang['ACP_NEWS_SETTING_SAVED'] . adm_back_link($this->u_action));
			}
		}
		
		$news_info_preview = '';
		
		if ($this->request->is_set_post('preview'))
		{
			$news_info_preview = generate_text_for_display($data['news_info'], $data['news_info_uid'], $data['news_info_bitfield'], $data['news_info_flags']);
		}
		$news_edit = generate_text_for_edit($data['news_info'], $data['news_info_uid'], $data['news_info_flags']);
		
		$this->template->assign_vars(array(
			'ERRORS'						=> $error,
			'NEWS_INFO'						=> $news_edit['text'],
			'NEWS_INFO_PREVIEW'				=> $news_info_preview,
			'NEWS_ENABLE'					=> $this->config['news_enable'],
			'NEWS_TYPE'						=> $this->config['news_type'] ? true : false,			
			'NEWS_VERSION'					=> $this->config['news_version'],				
			'S_BBCODE_DISABLE_CHECKED'		=> !$news_edit['allow_bbcode'],
			'S_SMILIES_DISABLE_CHECKED'		=> !$news_edit['allow_smilies'],
			'S_MAGIC_URL_DISABLE_CHECKED'	=> !$news_edit['allow_urls'],
			'BBCODE_STATUS'			=> $this->user->lang('BBCODE_IS_ON', '<a href="' . append_sid("{$this->phpbb_root_path}faq.{$this->php_ext}", 'mode=bbcode') . '">', '</a>'),
			'SMILIES_STATUS'				=> $this->user->lang['SMILIES_ARE_ON'],
			'IMG_STATUS'					=> $this->user->lang['IMAGES_ARE_ON'],
			'FLASH_STATUS'					=> $this->user->lang['FLASH_IS_ON'],
			'URL_STATUS'					=> $this->user->lang['URL_IS_ON'],
			
			'S_BBCODE_ALLOWED'				=> true,
			'S_SMILIES_ALLOWED'				=> true,
			'S_BBCODE_IMG'					=> true,
			'S_BBCODE_FLASH'				=> true,
			'S_LINKS_ALLOWED'				=> true,
			
			'U_ACTION'						=> $this->u_action,			
		));
		
	// Add custom bbcodes
	display_custom_bbcodes();
	}
}
