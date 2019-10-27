<?php
/**
*
* @package phpBB Extension - AccessNotification by SiteGuarding.com
* @author SiteGuarding.com team 
* @copyright (C) 2017 SiteGuarding.com team (https://SiteGuarding.com)
*
*/

namespace siteguarding\accessnotification\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['pan_email']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('pan_enable', 0)),
			array('config.add', array('pan_send_failed', 0)),
			array('config.add', array('pan_send_success', 0)),
			array('config.add', array('pan_email', '')),
			array('config.add', array('pan_enable_telegram', '')),
			array('config.add', array('pan_telegram_token', '')),
			array('config.add', array('pan_telegram_chat_id', '')),


			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'PAN_TITLE'
			)),
			array('module.add', array(
				'acp',
				'PAN_TITLE',
				array(
					'module_basename'	=> '\siteguarding\accessnotification\acp\pan_module',
					'modes'			=> array('settings'),
				),
			)),
		);
	}

}
