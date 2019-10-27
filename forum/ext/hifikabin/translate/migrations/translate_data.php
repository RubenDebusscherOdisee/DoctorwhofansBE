<?php
/**
*
* @package phpBB Extension - Google Translator
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\translate\migrations;

class translate_data extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
		'\phpbb\db\migration\data\v31x\v314'
		);
	}

	public function update_data()
	{
		return array(
		// Add configs
			array('config.add', array('translate_default_lang', 'en')),
			array('config.add', array('translate_choice_lang', 'de,fr,es')),
			array('config.add', array('translate_version', '1.0.0')),

			// Add module
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_TRANSLATE')),
			array('module.add', array('acp', 'ACP_TRANSLATE',
			array('module_basename' => '\hifikabin\translate\acp\translate_module', 'modes' => array('config'),
				),
			)),
		);
	}
}
