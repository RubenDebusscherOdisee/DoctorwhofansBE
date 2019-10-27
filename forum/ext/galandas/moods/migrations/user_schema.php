<?php
/**
*
* Mood. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2017 Galandas, http://phpbb3world.altervista.org
* @copyright Used Code Genders extension, 2016 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace galandas\moods\migrations;

class user_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_mood');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314rc1');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_mood'	=> array('UINT', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users'	=> array(
					'user_mood',
				),
			),
		);
	}
}
