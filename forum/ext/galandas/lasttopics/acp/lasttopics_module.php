<?php
/**
*
* @package phpBB Extension - Advanced Active Topics
* @copyright (c) 2017 Galandas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace galandas\lasttopics\acp;
class lasttopics_module
{
var $u_action;
   function main($id, $mode)
   {
      global $config, $user, $template, $request;
  
      $this->tpl_name = 'acp_lasttopics_config';
      $this->page_title = $user->lang('ACP_LAST_TOPIC');
      add_form_key('acp_lasttopics_config');
      
      $submit = $request->is_set_post('submit');
      if ($submit)
      {
         if (!check_form_key('acp_lasttopics_config'))
         {
            trigger_error('FORM_INVALID');
         }
		 $config->set('last_total', ($request->variable('last_total', '')));		 
         $config->set('lastat_direction', ($request->variable('lastat_direction', '')));
         $config->set('lastat_type', ($request->variable('lastat_type', 0)));		 
         $config->set('lastat_enable', ($request->variable('lastat_enable', '')));
         $config->set('lastat_t_pos', ($request->variable('lastat_t_pos', 1)));
         $config->set('lastat_t_pos', ($request->variable('lastat_t_pos', 0)));
		 $config->set('lastat_tutto', ($request->variable('lastat_tutto', '')));
		 $config->set('lastat_index', ($request->variable('lastat_index', '')));
		 $config->set('lastat_navigation', ($request->variable('lastat_navigation', '')));		 
		 $config->set('last_groups', ($request->variable('last_groups', '')));
		 
         trigger_error($user->lang['LAST_TOPIC_CONFIG_SAVED'] . adm_back_link($this->u_action));
      }
	    $template->assign_vars(array(
		'LASTAT_VERSION'			  => (isset($config['last_topic_version'])) ? $config['last_topic_version'] : '',
		'LASTAT_TOTAL'                => (isset($config['last_total'])) ? $config['last_total'] : '',
        'LASTAT_DIRECTION'            => (!empty($config['lastat_direction'])) ? true : false,		
        'LASTAT_TYPE'                 => (!empty($config['lastat_type'])) ? true : false,
		'LASTAT_ENABLE'			      => (!empty($config['lastat_enable'])) ? true : false,
		'LASTAT_TOP'		          => (!empty($config['lastat_t_pos'])) ? true : false,
		'LASTAT_FUT'	              => (!empty($config['lastat_t_pos'])) ? true : false,
		'LASTAT_TUTTO'	              => (!empty($config['lastat_tutto'])) ? true : false,
		'LASTAT_INDEX'	              => (!empty($config['lastat_index'])) ? true : false,		
		'LASTAT_NAVIGATION'	          => (!empty($config['lastat_navigation'])) ? true : false,
        'U_ACTION'                    => $this->u_action,
      ));
    }   
 }