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

class ad3_advlogin extends \phpbb\db\migration\migration
{
		static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}
	
	public function update_data()
	{
		return array(
			// Add config
			array('config.add', array('advlogin_version', '1.0.6')),			
			array('config.add', array('color_advlogin', '')),
			array('config.add', array('width_advlogin', '300')),
			array('config.add', array('height_advlogin', '150')),			
		);
	}
	
	public function revert_data()
	{
		return array(
			// Remove config
			array('config.remove', array('advlogin_version', '')),			
			array('config.remove', array('color_advlogin', '')),
			array('config.remove', array('width_advlogin', '')),
			array('config.remove', array('height_advlogin', '')),			
		);
	}
}
