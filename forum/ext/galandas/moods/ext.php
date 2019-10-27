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

namespace galandas\moods;

/**
* Extension class for custom enable/disable/purge actions
*/
class ext extends \phpbb\extension\base
{
	/**
	* Enable extension if phpBB version requirement is met
	*
	* @return bool
	* @access public
	*/
	public function is_enableable()
	{
		$config = $this->container->get('config');
		return version_compare($config['version'], '3.1.10', '>=');
	}
}
