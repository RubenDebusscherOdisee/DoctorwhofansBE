<?php
/**
*
* @package phpBB Extension - Advanced Active Topics
* @copyright (c) 2017 Galandas
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace galandas\lasttopics\acp;

class lasttopics_info
 {
    function module()
    {
        return array(
        'filename'  => '\galandas\lasttopics\acp\lasttopics_module',
        'title'     => 'ACP_LAST_TOPIC',
        'modes'     => array(
        'config'    => array(
		'title'     => 'ACP_LAST_TOPIC_CONF',
		'auth'      => 'ext_galandas/lasttopics && acl_a_board',
		'cat'       => array('ACP_LAST_TOPIC')),
        ),
    );
    }
}
