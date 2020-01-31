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

class install_sample_data extends \phpbb\db\migration\migration
{
	/**
	 * Allows you to check if the migration is effectively installed (entirely optional)
	 *
	 * @return bool		True if this migration is installed, False if this migration is not installed (checked on install)
	 * @access public
	 */
	public function effectively_installed()
	{
		return isset($this->config['threedi_os_startdate']);
	}

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
	 * Add, update or delete data stored in the database during extension installation.
	 *
	 * @return array Array of data update instructions
	 */
	public function update_data()
	{
		$orig_board_startdate = $this->config['board_startdate'];

		return [
			['config.add', ['threedi_os_startdate', (int) $orig_board_startdate]],

			['permission.add', ['a_new_threedi_os']],
			['permission.add', ['u_new_threedi_os']],

			['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_new_threedi_os']],
			['permission.permission_set', ['REGISTERED', 'u_new_threedi_os', 'group']],
		];
	}
}
