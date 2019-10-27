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

class ad1_advlogin extends \phpbb\db\migration\migration
{
		static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}
	
	public function update_data()
	{
		return array(
			// Add config
			array('config.add', array('enable_advlogin', 0)),
			array('config.add', array('aspect_advlogin', 1)),			
			// Add config text
			array('config_text.add', array('advlogin_text', '')),
		);
	}
	
	public function revert_data()
	{
		return array(
			// Remove config
			array('config.remove', array('enable_advlogin', )),
			array('config.remove', array('aspect_advlogin', )),
			// Remove config text
			array('config_text.remove', array('advlogin_text', '')),
		);
	}
}
