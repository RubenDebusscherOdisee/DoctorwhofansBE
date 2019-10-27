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

class news_install extends \phpbb\db\migration\migration
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
		array('config.add', array('news_version', '1.0.1')),
		array('config.add', array('news_enable', 0)),
		array('config.add', array('news_type', 1)),
		// Add config text
		array('config_text.add', array('news_info', 'Simple News Admin Extension for the phpBB Forum Software package.')),
		array('config_text.add', array('news_info_uid', '')),
		array('config_text.add', array('news_info_bitfield', '')),
		array('config_text.add', array('news_info_flags', OPTION_FLAG_BBCODE + OPTION_FLAG_SMILIES + OPTION_FLAG_LINKS)),	
		// Add permissions
		array('permission.add', array('u_sna')),
		// Set permissions
		array('permission.permission_set', array('GUESTS', 'u_sna', 'group')),
		array('permission.permission_set', array('REGISTERED', 'u_sna', 'group')),
		array('permission.permission_set', array('NEWLY_REGISTERED', 'u_sna', 'group')),
		array('permission.permission_set', array('BOTS', 'u_sna', 'group', false)),		 
		 // Add module
		 array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_NEWS_TITLE')),
		 array('module.add', array(
		 'acp', 'ACP_NEWS_TITLE', array(
		 'module_basename' => '\galandas\news\acp\news_module', 'modes'	  => array('news_config'),
			 ),
		 )),
	  );
   }
   
	public function revert_data()
	{
		return array(
		// Remove config
		 array('config.remove', array('news_version', )),
		 array('config.remove', array('news_enable', )),
		 array('config.remove', array('news_type', )),
		// Remove config text
		array('config_text.remove', array('news_info', '')),
		array('config_text.remove', array('news_info_uid', '')),
		array('config_text.remove', array('news_info_bitfield', '')),
		array('config_text.remove', array('news_info_flags', OPTION_FLAG_BBCODE + OPTION_FLAG_SMILIES + OPTION_FLAG_LINKS)),		 
		// Remove permissions
		array('permission.remove', array('u_sna')),
		// Unset permissions
		array('permission.permission_unset', array('GUESTS', 'u_sna', 'group')),
		array('permission.permission_unset', array('REGISTERED', 'u_sna', 'group')),
		array('permission.permission_unset', array('NEWLY_REGISTERED', 'u_sna', 'group')),
		array('permission.permission_unset', array('BOTS', 'u_sna', 'group')),
		// Remove module
			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_NEWS_TITLE'
			)),
			array('module.remove', array(
				'acp',
				'ACP_NEWS_TITLE',
				array(
					'module_basename'	=> '\galandas\news\acp\news_module',
					'modes'				=> array('news_config'),
				),
			)),
		);
	}
}
