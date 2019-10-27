<?php
/**
*
* @package Disclaimer Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\disclaimer\migrations;

class version_1_0_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('disclaimer_version', '1.0.0')),
			array('config.add', array('show_disclaimer', '0')),
		);
	}
}
