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

class update_1_0_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\galandas\searchindex\migrations\install_acp_module',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update', array('rsi_version', '1.0.1')),
		);
	}
}
