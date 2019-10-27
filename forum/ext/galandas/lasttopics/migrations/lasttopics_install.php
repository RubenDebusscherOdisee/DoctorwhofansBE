<?php
/**
*
* @package phpBB Extension - Advanced Active Topics
* @copyright (c) 2017 Galandas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace galandas\lasttopics\migrations;
class lasttopics_install extends \phpbb\db\migration\migration
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
        array('config.add', array('last_topic_version', '1.0.1')),		 
        array('config.add', array('last_total', 5)),
        array('config.add', array('lastat_direction', 0)),
        array('config.add', array('lastat_type', 0)),		 
		array('config.add', array('lastat_enable', 1)),
		array('config.add', array('lastat_t_pos', 1)),		 
		array('config.add', array('lastat_tutto', 0)),
		array('config.add', array('lastat_index', 1)),		 
        array('config.add', array('jsdisplay_navigation', 1)),
		array('config.add', array('lastat_titletext', 'News topics')),		 
		// Add permissions
		array('permission.add', array('u_at_adv')),
		// Set permissions
		array('permission.permission_set', array('GUESTS', 'u_at_adv', 'group')),
		array('permission.permission_set', array('REGISTERED', 'u_at_adv', 'group')),
		array('permission.permission_set', array('NEWLY_REGISTERED', 'u_at_adv', 'group')),
		array('permission.permission_set', array('BOTS', 'u_at_adv', 'group', false)),		 
        // Add module
        array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_LAST_TOPIC')),
        array('module.add', array(
        'acp', 'ACP_LAST_TOPIC', array(
        'module_basename' => '\galandas\lasttopics\acp\lasttopics_module', 'modes'   => array('config'),
            ),
        )),
      );
    }
   
   	public function revert_data()
	{
		return array(
		// Remove config
        array('config.remove', array('last_topic_version', '')),
        array('config.remove', array('last_total', )),
        array('config.remove', array('lastat_direction', )),
        array('config.remove', array('lastat_type', )),		 
		array('config.remove', array('lastat_enable', )),
		array('config.remove', array('lastat_t_pos', )),		 
		array('config.remove', array('lastat_tutto', )),
		array('config.remove', array('lastat_index', )),		 
        array('config.remove', array('jsdisplay_navigation', )),
		array('config.remove', array('lastat_titletext', '')),		 
		// Remove permissions
		array('permission.remove', array('u_at_adv')),
		// Unset permissions
		array('permission.permission_unset', array('GUESTS', 'u_at_adv', 'group')),
		array('permission.permission_unset', array('REGISTERED', 'u_at_adv', 'group')),
		array('permission.permission_unset', array('NEWLY_REGISTERED', 'u_at_adv', 'group')),
		array('permission.permission_unset', array('BOTS', 'u_at_adv', 'group')),
		// Remove module
			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_LAST_TOPIC'
			)),
			array('module.remove', array(
				'acp',
				'ACP_LAST_TOPIC',
				array(
					'module_basename'	=> '\galandas\lasttopics\acp\lasttopics_module',
					'modes'				=> array('config'),
				),
			)),
		);
	}
}