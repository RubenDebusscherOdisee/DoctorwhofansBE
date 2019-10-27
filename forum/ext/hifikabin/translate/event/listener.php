<?php
/**
*
* @package phpBB Extension - Google Translate
* @copyright (c) 2015 HiFiKabin
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace hifikabin\translate\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'   => 'load_language_on_setup',
			'core.page_header_after'  => 'navbar_header_after',
		);
	}

	protected $template;
	protected $config;

	public function __construct(\phpbb\template\template $template, \phpbb\config\config $config)
	{
		$this->template = $template;
		$this->config = $config;
	}
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
		'ext_name' => 'hifikabin/translate',
		'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	public function navbar_header_after($event)
	{
		$this->template->assign_vars(array(
		'TRANSLATE_DEFAULT_LANG'	=> (isset ($this->config['translate_default_lang'])) ? $this->config['translate_default_lang'] : '',
		'TRANSLATE_CHOICE_LANG'		=> (isset ($this->config['translate_choice_lang'])) ? $this->config['translate_choice_lang'] : '',
        ));
    }
}