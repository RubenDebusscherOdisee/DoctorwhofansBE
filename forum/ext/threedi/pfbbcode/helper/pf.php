<?php
/**
 * 3Di's PFbbcode extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 phpBB Studio <https://www.phpbbstudio.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace threedi\pfbbcode\helper;

/**
 * 3Di's PFbbcode Common functions.
 */
class pf
{
	/**
	* {@inheritDoc}
	*/
	public function pf_validate($field_value, $field_data)
	{
		if ($s_parse_bbcodes = ((int) $field_data['field_novalue']) & OPTION_FLAG_BBCODE)
		{
			$uid = $bitfield = $options = '';

			generate_text_for_storage($field_value, $uid, $bitfield, $options, $s_parse_bbcodes, false, false);

			strip_bbcode($field_value, $uid);
		}
	}

	/**
	* {@inheritDoc}
	*/
	public function pf_profile_values($field_value, $field_data)
	{
		if (($field_value === null || $field_value === '') && !$field_data['field_show_novalue'])
		{
			return null;
		}

		if ($field_data['field_novalue'])
		{
			/**
			 * This line to prevent errors if the field is empty but forced to be shown.
			 * /includes/message_parser.php on line 1198: Undefined index: TOO_FEW_CHARS
			 * A space char, in case, does the trick.
			 */
			$field_value = (!empty($field_value)) ? $field_value : ' ';

			$uid = $bitfield = $options = '';

			$s_parse_bbcodes = ((int) $field_data['field_novalue']) & OPTION_FLAG_BBCODE;
			$s_parse_smilies = ((int) $field_data['field_novalue']) & OPTION_FLAG_SMILIES;
			$s_parse_urls = ((int) $field_data['field_novalue']) & OPTION_FLAG_LINKS;

			generate_text_for_storage($field_value, $uid, $bitfield, $options, $s_parse_bbcodes, $s_parse_urls, $s_parse_smilies);

			$field_value = generate_text_for_display($field_value, $uid, $bitfield, $options);
		}
		else
		{
			$field_value = make_clickable($field_value);
			$field_value = censor_text($field_value);
			$field_value = bbcode_nl2br($field_value);
		}

		return $field_value;
	}

}
