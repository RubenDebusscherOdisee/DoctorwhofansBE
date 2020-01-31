<?php
/**
 *
 * Online Since. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2005 - 2019, 3Di, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace threedi\os;

/**
 * Online Since Extension base
 */
class ext extends \phpbb\extension\base
{
	/**
	 * Check whether or not the extension can be enabled.
	 *
	 * @return bool
	 */
	public function is_enableable()
	{
		$is_enableable = true;

		$user = $this->container->get('user');
		$user->add_lang_ext('threedi/os', 'ext_require');
		$lang = $user->lang;

		if (!(phpbb_version_compare(PHPBB_VERSION, '3.2.7', '>=') && phpbb_version_compare(PHPBB_VERSION, '4.0.0@dev', '<')))
		{
			$lang['EXTENSION_NOT_ENABLEABLE'] .= '<br>' . $user->lang('ERROR_PHPBB_VERSION', '3.2.7', '4.0.0@dev');

			$is_enableable = false;
		}

		$user->lang = $lang;

		return $is_enableable;
	}
}
