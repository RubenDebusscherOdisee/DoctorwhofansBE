<?php

/**
 *
 * Forum Language. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Saeed Hubaishan, http://salafitech.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace hubaishan\forumlanguage\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'forum_language');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v32x\v322');
	}

	public function update_schema()
	{
		return array(
			'add_columns'    => array(
				$this->table_prefix . 'forums' => array(
					'forum_language'          => array('VCHAR:30', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'    => array(
				$this->table_prefix . 'forums' => array(
					'forum_language',
				),
			),
		);
	}
}