<?php
/**
 *
 * Audio Attachment Player. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Hubaishan
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace hubaishan\audioplayer\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Audio Attachment Player Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/**
	 * Audio Exts supported, you can add to them but be aware for browser supporting
	 */

	protected $audio_ext = array(
		'mp3'	=> 'audio/mpeg',
		'm4a'	=> 'audio/mp4',
		'ogg'	=> 'audio/ogg',
		'oga'	=> 'audio/ogg',
		'aac'	=> 'audio/aac',
		);

	static public function getSubscribedEvents()
	{
		return array(
			'core.send_file_to_browser_before'				=> 'preserve_audio_mime',
			'core.parse_attachments_modify_template_data'	=> 'add_audio_attachment',
		);
	}

	/**
	 * 
	 * adds new array key 'S_AUDIO' when file is supported audio ext
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function add_audio_attachment($event)
	{
		if (!isset($event['block_array']['S_DENIED']))
		{
			if (array_key_exists($event['attachment']['extension'], $this->audio_ext))
			{
				$block_array = $event['block_array'];
				$block_array += array(
					'S_AUDIO'	=> true,
					'U_VIEW_LINK'	=> $event['download_link'] . '&amp;mode=view',
					'MIMETYPE'		=> $this->audio_ext[$event['attachment']['extension']],
					);
				unset($block_array['S_FILE']);
				unset($block_array['S_IMAGE']);
				$event['block_array'] = $block_array;
			}
		}
	}

	/**
	 * preserve MIME type for supported audio files
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function preserve_audio_mime($event)
	{
		if (array_key_exists($event['attachment']['extension'], $this->audio_ext))
		{
			$attachment = $event['attachment'];
			$attachment['mimetype'] = $this->audio_ext[$event['attachment']['extension']];
			$event['attachment'] = $attachment;
		}
	}

}
