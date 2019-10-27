<?php
/**
 *
 * Recent searches on index. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Galandas, http://phpbb3world.altervista.org
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace galandas\searchindex\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Recent searches on index Event listener.
 */
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'	=> 'add_permission',
			'core.page_header'	=> 'page_header',
			'core.user_setup'	=> 'load_language_on_setup',
		);
	}
	/** @var \phpbb\config\config */
	protected $config;
	
	/** @var \phpbb\user */
	protected $user;
	
	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;
	
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\auth\auth */
	protected $auth;
	
	/** @var string */
	protected $phpbb_root_path;

	/** @var string */
	protected $phpEx;
	
	/**
	* Constructor
	*
	* @param \phpbb\config\config				$config	
	* @param \phpbb\user						$user
	* @param \phpbb\controller\helper			$helper	
	* @param \phpbb\template\template			$template
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\auth\auth					$auth
	* @param									$phpbb_root_path
	* @param									$phpEx	
	*
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, $phpbb_root_path, $phpEx, \phpbb\collapsiblecategories\operator\operator $operator = null)
	{
		$this->config = $config;
		$this->user	= $user;		
		$this->helper = $helper;
		$this->template = $template;
		$this->db		= $db;
		$this->auth 	= $auth;
		$this->phpbb_root_path 	= $phpbb_root_path;
		$this->phpEx 	= $phpEx;
		$this->operator = $operator;		
	}
	
	/**
	* Add permissions acp Recent searches on index
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_rsi'] = array('lang' => 'ACL_A_RSI', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}	

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'galandas/searchindex',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function page_header($event)
	{
		if ($this->operator !== null)
		{
			$fid = 'research'; // Può essere qualsiasi stringa univoca per identificare l'elemento pieghevole delle estensioni
			$this->template->assign_vars(array(
				'RESEARCH_IS_COLLAPSIBLE'	=> true,
				'S_RESEARCH_HIDDEN' => in_array($fid, $this->operator->get_user_categories()),
				'U_RESEARCH_COLLAPSE_URL' => $this->helper->route('phpbb_collapsiblecategories_main_controller', array('forum_id' => $fid, 'hash' => generate_link_hash("collapsible_$fid")))
			));			
		}		
		
// Mostra solo le ricerche recenti per gli amministratori
if ($this->auth->acl_get('a_search'))
{
	// Maneggiare oggetti di grandi dimensioni Diversamente per Oracle e MSSQL
$sql_layer = $this->db->get_sql_layer();	
	switch ($sql_layer)
	{
		case 'oracle':
			$sql = 'SELECT search_time, search_keywords
				FROM ' . SEARCH_RESULTS_TABLE . '
				WHERE dbms_lob.getlength(search_keywords) > 0
				ORDER BY search_time DESC';
		break;

		case 'mssql':
		case 'mssql_odbc':
		case 'mssqlnative':
			$sql = 'SELECT search_time, search_keywords
				FROM ' . SEARCH_RESULTS_TABLE . '
				WHERE DATALENGTH(search_keywords) > 0
				ORDER BY search_time DESC';
		break;

		default:
			$sql = 'SELECT search_time, search_keywords
				FROM ' . SEARCH_RESULTS_TABLE . '
				WHERE search_keywords <> \'\'
				ORDER BY search_time DESC';
		break;
	}
	$result = $this->db->sql_query_limit($sql, $this->config['rsi_limit']);

	while ($row = $this->db->sql_fetchrow($result))
	{
		$keywords = $row['search_keywords'];

		$this->template->assign_block_vars('recentsearch', array(
			'KEYWORDS'	=> $keywords,
			'TIME'		=> $this->user->format_date($row['search_time']),

			'U_KEYWORDS'	=> append_sid("{$this->phpbb_root_path}search.$this->phpEx", 'keywords=' . urlencode(htmlspecialchars_decode($keywords)))
		));
	}
	$this->db->sql_freeresult($result);
}

    // Inizia Ricerche recente sull'indice
    $this->template->assign_vars(array(
 	'RSI_ENABLED' 	     	=> (!empty($this->config['rsi_enabled'])) ? true : false,
	'RSI_LIMIT'				=> (isset($this->config['rsi_limit'])) ? $this->config['rsi_limit'] : '',	
    ));
    
	}
}
