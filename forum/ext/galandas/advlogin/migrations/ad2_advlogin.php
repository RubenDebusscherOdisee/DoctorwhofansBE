<?php
/**
 *
 * Advanced login. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\advlogin\migrations;

class ad2_advlogin extends \phpbb\db\migration\migration
{
		static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}
	
	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_ADVLOGIN'
			)),
			array('module.add', array(
				'acp',
				'ACP_ADVLOGIN',
				array(
					'module_basename'	=> '\galandas\advlogin\acp\advlogin_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
	
	public function revert_data()
	{
		return array(
			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_ADVLOGIN'
			)),
			array('module.remove', array(
				'acp',
				'ACP_ADVLOGIN',
				array(
					'module_basename'	=> '\galandas\advlogin\acp\advlogin_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
