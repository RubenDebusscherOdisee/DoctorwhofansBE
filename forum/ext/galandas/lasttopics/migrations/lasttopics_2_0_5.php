<?php
/**
*
* @package phpBB Extension - Advanced Active Topics
* @copyright (c) 2017 Galandas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace galandas\lasttopics\migrations;
class lasttopics_2_0_5 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\galandas\lasttopics\migrations\lasttopics_install',
		);
	}
	public function update_data()
	{
		return array(
			array('config.update', array('last_topic_version', '2.0.5')),
            array('config.remove', array('jsdisplay_navigation')),
            array('config.remove', array('lastat_titletext')),
            array('config.add', array('lastat_navigation', 0)),			
		);
	}
}