<?php
/**
*
* @package		Breizh Ajax Preview Extension
* @copyright	(c) 2019-2020 Sylver35  https://breizhcode.com
* @license		http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace sylver35\ajaxpreview\controller;

use phpbb\json_response;

class ajax
{
	/** @var \phpbb\request\request */
	protected $request;

	/**
	 * Constructor
	 *
	 * @param \phpbb\request\request	$request	Request object
	 */
	public function __construct(\phpbb\request\request $request)
	{
		$this->request = $request;
	}

	/**
	 * Function construct_ajax
	 *
	 * @return with	$response
	 */
	public function construct_ajax()
	{
		$this->response = new json_response();
		$message = $this->request->variable('content', '', true);
		$uid = $bitfield = $options = '';
		generate_text_for_storage($message, $uid, $bitfield, $options, true, false, true);
		$message = generate_text_for_display($message, $uid, $bitfield, $options);
		$message = str_replace('class="smilies" src="./../', 'class="smilies" src="' . generate_board_url() . '/', $message);
		
		$content = array(
			'content'	=> $message,
		);
		
		$this->response->send($content, true);
	}
}
