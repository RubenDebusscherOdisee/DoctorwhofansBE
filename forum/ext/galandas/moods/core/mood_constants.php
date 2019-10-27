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

namespace galandas\moods\core;

class mood_constants
{
// aggiungi o sottrai per soddisfare le tue esigenze.
	public static function getMoodChoices()
	{
		return array(
			'MOOD_NONE'	=> 0,
			'EM-BIGGRIN' => 1,
			'EM-CONFUSED' => 2,
			'EM-COOL' => 3,
			'EM-CRY' => 4,
			'EM-EEK' => 5,			
			'EM-EVIL' => 6,
			'EM-LOL' => 7,			
			'EM-MAD' => 8,
			'EM-MRGREEN' => 9,
			'EM-NEUTRAL' => 10,
			'EM-RAZZ' => 11,			
			'EM-REDFACE' => 12,
			'EM-ROLLEYES' => 13,
			'EM-SAD' => 14,
			'EM-SCREAM' => 15,
			'EM-SMILE' => 16,			
			'EM-SURPRISED' => 17,
			'EM-TWISTED' => 18,
			'EM-UGEEK' => 19,
			'EM-WINK' => 20,			
		);
	}
}
