<?php
/**
 *
 * Online Since. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2005 - 2019, 3Di, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace threedi\os\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration.
	 *
	 * @return array		Array of migration files
	 * @access public
	 * @static
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v32x\v327'];
	}

	/**
	 * Add the OS ACP module to the database.
	 *
	 * @return array		Array of module data
	 * @access public
	 */
	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_OS_TITLE'
			]],
			['module.add', [
				'acp',
				'ACP_OS_TITLE',
				[
					'module_basename'	=> '\threedi\os\acp\main_module',
					'modes'				=> ['settings'],
				],
			]],
		];
	}
}
