<?php
/**
 *
 * Simple News Admin. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
 
namespace galandas\news\migrations;

class news_1_0_3 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\galandas\news\migrations\news_install',
		);
	}
	public function update_data()
	{
		return array(
			array('config.update', array('news_version', '1.0.3')),
		);
	}
}