<?php
/**
 *
 * Recent searches on index. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\searchindex\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}

	public function update_data()
	{
		return array(
			// Add configs		
			array('config.add', array('rsi_enabled', 1)),
            array('config.add', array('rsi_limit', 5)),			
            array('config.add', array('rsi_version', '1.0.0')),			
			// Add permission
			array('permission.add', array('a_rsi', true)),
			// Set permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_rsi')),
			// Add ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'RSI_TITLE'
			)),
			array('module.add', array(
				'acp',
				'RSI_TITLE',
				array(
					'module_basename'	=> '\galandas\searchindex\acp\searchindex_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
