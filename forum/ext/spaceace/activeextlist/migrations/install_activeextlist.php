<?php

/**
*
* @package phpBB Extension - Active Extensions List
* @copyright (c) 2016 spaceace - http://www.livemembersonly.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace spaceace\activeextlist\migrations;

class install_activeextlist extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			// Add permission
			array('permission.add', array('u_activeextlist_view')),
			array('permission.permission_set', array('ADMINISTRATORS', 'u_activeextlist_view', 'group')),
		);
	}
}
