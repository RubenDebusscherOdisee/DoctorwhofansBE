<?php
/**
*
* @package Favourite Icon Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\favicon\migrations;

class version_1_0_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('version_favicon', '1.0.0')),
		);
	}
}
