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

class user_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['mood_version']) && version_compare($this->config['mood_version'], '1.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\galandas\moods\migrations\user_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('mood_version', '1.0.0')),
		);
	}
}
