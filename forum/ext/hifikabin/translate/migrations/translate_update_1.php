<?php
/**
*
* @package phpBB Extension - Google Translator
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\translate\migrations;

class translate_update_1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\hifikabin\translate\migrations\translate_data');
	}

	public function update_data()
	{
		return array(
		// Remove configs
		array('config.remove', array('translate_version', '')),
		);
	}
}
