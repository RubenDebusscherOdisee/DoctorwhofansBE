<?php
/**
*
* WTTU Extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 Ather
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace ather\wttu\migrations;

class install_wttu_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['wttu_version']) && version_compare($this->config['wttu_version'], '1.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('wttu_status', 1)),
			array('config.add', array('wttu_link', 1)),
			array('config.add', array('wttu_bbcode', 1)),
			array('config.add', array('wttu_html', 1)),
			array('config.add', array('wttu_type', 1)),
			array('config.add', array('wttu_version', '1.0.0')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'WTTU_TITLE'
			)),
			array('module.add', array(
				'acp',
				'WTTU_TITLE',
				array(
					'module_basename'	=> '\ather\wttu\acp\wttu_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}