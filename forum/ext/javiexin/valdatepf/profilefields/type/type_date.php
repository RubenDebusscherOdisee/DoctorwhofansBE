<?php
/**
 *
 * Validated Date Profile Fields
 *
 * @copyright (c) 2017 javiexin ( www.jxtools.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */

namespace javiexin\valdatepf\profilefields\type;

class type_date extends \phpbb\profilefields\type\type_date
{
	/**
	* {@inheritDoc}
	*/
	public function get_template_filename()
	{
		return '@javiexin_valdatepf/' . 'profilefields/' . $this->get_name_short() . '.html';
	}

	/**
	* {@inheritDoc}
	*/
	public function get_options($default_lang_id, $field_data)
	{
		$profile_row[0] = array(
			'var_name'				=> 'field_default_value',
			'lang_name'				=> $field_data['lang_name'],
			'lang_explain'			=> $field_data['lang_explain'],
			'lang_id'				=> $default_lang_id,
			'field_default_value'	=> $field_data['field_default_value'],
			'field_ident'			=> 'field_default_value',
			'field_type'			=> $this->get_service_name(),
			'field_length'			=> $field_data['field_length'],
			'lang_options'			=> $field_data['lang_options'],
			'field_minlen'			=> $field_data['field_minlen'],
			'field_maxlen'			=> $field_data['field_maxlen'],
		);

		$profile_row[1] = array_merge($profile_row[0], array(
			'var_name'				=> 'field_minlen',
			'field_ident'			=> 'field_minlen',
			'field_default_value'	=> $field_data['field_minlen'] ? $field_data['field_minlen'] : ' 0- 0-   0',
			'field_length'			=> '0',
			'field_minlen'			=> '',
			'field_maxlen'			=> '',
		));

		$profile_row[2] = array_merge($profile_row[0], array(
			'var_name'				=> 'field_maxlen',
			'field_ident'			=> 'field_maxlen',
			'field_default_value'	=> $field_data['field_maxlen'] ? $field_data['field_maxlen'] : ' 0- 0-   0',
			'field_length'			=> '0',
			'field_minlen'			=> ' 0- 0-   0',
			'field_maxlen'			=> '31-12-9999',
		));

		$date_dropdown = $this->request->variable('date_dropdown', -1);
		if ($date_dropdown == -1)
		{
			$s_dropdown = ($field_data['field_length']) ? true : false;
		}
		else
		{
			$s_dropdown = ($date_dropdown) ? true : false;
		}

		$always_now = $this->request->variable('always_now', -1);
		if ($always_now == -1)
		{
			$s_checked = ($field_data['field_default_value'] == 'now') ? true : false;
		}
		else
		{
			$s_checked = ($always_now) ? true : false;
		}

		$options = array(
			0 => array(
				'TITLE'		=> $this->user->lang['DEFAULT_VALUE'],
				'FIELD'		=> $this->process_field_row('preview', $profile_row[0])
			),
			1 => array(
				'TITLE'		=> $this->user->lang['ALWAYS_TODAY'],
				'FIELD'		=> '<label><input type="radio" class="radio" name="always_now" value="1"' . (($s_checked) ? ' checked="checked"' : '') . ' onchange="document.getElementById(\'add_profile_field\').submit();" /> ' . $this->user->lang['YES'] . '</label><label><input type="radio" class="radio" name="always_now" value="0"' . ((!$s_checked) ? ' checked="checked"' : '') . ' onchange="document.getElementById(\'add_profile_field\').submit();" /> ' . $this->user->lang['NO'] . '</label>',
			),
			2 => array(
				'TITLE'		=> $this->user->lang['MIN_DATE'],
				'EXPLAIN'	=> $this->user->lang['MIN_DATE_EXPLAIN'],
				'FIELD'		=> $this->process_field_row('preview', $profile_row[1])
			),
			3 => array(
				'TITLE'		=> $this->user->lang['MAX_DATE'],
				'EXPLAIN'	=> $this->user->lang['MAX_DATE_EXPLAIN'],
				'FIELD'		=> $this->process_field_row('preview', $profile_row[2])
			),
			4 => array(
				'TITLE'		=> $this->user->lang['DATE_SELECT_AS'],
				'EXPLAIN'	=> $this->user->lang['DATE_SELECT_AS_EXPLAIN'],
				'FIELD'		=> '<label><input type="radio" class="radio" name="date_dropdown" value="10"' . (($s_dropdown) ? ' checked="checked"' : '') . ' onchange="document.getElementById(\'add_profile_field\').submit();" /> ' . $this->user->lang['DATE_AS_DROPDOWN'] . '</label><label><input type="radio" class="radio" name="date_dropdown" value=""' . ((!$s_dropdown) ? ' checked="checked"' : '') . ' onchange="document.getElementById(\'add_profile_field\').submit();" /> ' . $this->user->lang['DATE_AS_FIELD'] . '</label>'
			),
		);

		return $options;
	}

	/**
	* {@inheritDoc}
	*/
	public function get_default_option_values()
	{
		return array(
			'field_length'		=> 10,
			'field_minlen'		=> '',
			'field_maxlen'		=> '',
			'field_validation'	=> '',
			'field_novalue'		=> ' 0- 0-   0',
			'field_default_value'	=> ' 0- 0-   0',
		);
	}

	/**
	* {@inheritDoc}
	*/
	public function validate_profile_field(&$field_value, $field_data)
	{
		list($day, $month, $year) = array_map('intval', explode('-', (strpos($field_value, '-') ? $field_value : ' 0- 0-   0')));

		// Empty date when not required is valid
		if (!$day && !$month && !$year && !$field_data['field_required'])
		{
			return false;
		}

		// If any component is missing and the field is required, it is invalid
		if ((!$day || !$month || !$year) && $field_data['field_required'])
		{
			return $this->user->lang('FIELD_REQUIRED', $this->get_field_name($field_data['lang_name']));
		}

		// If a minimum date is specified, check it
		list($mindate_day, $mindate_month, $mindate_year) = array_map('intval', explode('-', (strpos($field_data['field_minlen'], '-') ? $field_data['field_minlen'] : ' 0- 0-   0')));
		if ($mindate_day && !$day || $mindate_month && !$month || $mindate_year && !$year)
		{
			return $this->user->lang('FIELD_INVALID_DATE', $this->get_field_name($field_data['lang_name']));
		}
		if ($mindate_year && ($year < $mindate_year ||
				($year == $mindate_year && ($mindate_month && ($month < $mindate_month ||
						($month == $mindate_month && ($mindate_day && $day < $mindate_day)))))))
		{
			return $this->user->lang('FIELD_DATE_BEFORE_MINIMUM', $field_data['field_minlen'], $this->get_field_name($field_data['lang_name']));
		}

		// If a maximum date is specified, check it
		list($maxdate_day, $maxdate_month, $maxdate_year) = array_map('intval', explode('-', (strpos($field_data['field_maxlen'], '-') ? $field_data['field_maxlen'] : ' 0- 0-   0')));
		if ($maxdate_day && !$day || $maxdate_month && !$month || $maxdate_year && !$year)
		{
			return $this->user->lang('FIELD_INVALID_DATE', $this->get_field_name($field_data['lang_name']));
		}
		if ($maxdate_year && ($year > $maxdate_year ||
				($year == $maxdate_year && ($maxdate_month && ($month > $maxdate_month ||
						($month == $maxdate_month && ($maxdate_day && $day > $maxdate_day)))))))
		{
			return $this->user->lang('FIELD_DATE_AFTER_MAXIMUM', $field_data['field_maxlen'], $this->get_field_name($field_data['lang_name']));
		}

		// In case no range specified, we check for the default year range for backward compatibility
		if (!$mindate_year && !$maxdate_year && (($year < 1901 && $year > 0) || ($year > gmdate('Y', time()) + 50)))
		{
			return $this->user->lang('FIELD_INVALID_DATE', $this->get_field_name($field_data['lang_name']));
		}

		// Check for parcial validated date being coherent (no month but day specified)
		if (($mindate_year || $maxdate_year) && $day && !$month)
		{
			return $this->user->lang('FIELD_INVALID_DATE', $this->get_field_name($field_data['lang_name']));
		}

		// Check for parcial date and validation specifications, and validate partial dates
		if (!$mindate_day && !$maxdate_day && !$day || !$mindate_month && !$maxdate_month && !$month || !$mindate_year && !$maxdate_year && !$year)
		{
			return false;
		}

		// If the date as specified does not exist, it is invalid
		if (checkdate($month, $day, $year) === false)
		{
			return $this->user->lang('FIELD_INVALID_DATE', $this->get_field_name($field_data['lang_name']));
		}

		return false;
	}

	/**
	* {@inheritDoc}
	*/
	public function generate_field($profile_row, $preview_options = false)
	{
		$profile_row['field_ident'] = (isset($profile_row['var_name'])) ? $profile_row['var_name'] : 'pf_' . $profile_row['field_ident'];
		$field_ident = $profile_row['field_ident'];

		$now = getdate();

		if (!$this->request->is_set($profile_row['field_ident'] . '_day'))
		{
			if ($profile_row['field_default_value'] == 'now')
			{
				$profile_row['field_default_value'] = sprintf('%2d-%2d-%4d', $now['mday'], $now['mon'], $now['year']);
			}
			list($day, $month, $year) = array_map('intval', explode('-', ((!isset($this->user->profile_fields[$field_ident]) || $preview_options !== false) ? $profile_row['field_default_value'] : $this->user->profile_fields[$field_ident])));
		}
		else
		{
			if ($preview_options !== false && $profile_row['field_default_value'] == 'now')
			{
				$profile_row['field_default_value'] = sprintf('%2d-%2d-%4d', $now['mday'], $now['mon'], $now['year']);
				list($day, $month, $year) = array_map('intval', explode('-', ((!isset($this->user->profile_fields[$field_ident]) || $preview_options !== false) ? $profile_row['field_default_value'] : $this->user->profile_fields[$field_ident])));
			}
			else
			{
				$day = $this->request->variable($profile_row['field_ident'] . '_day', 0);
				$month = $this->request->variable($profile_row['field_ident'] . '_month', 0);
				$year = $this->request->variable($profile_row['field_ident'] . '_year', 0);
			}
		}

		$profile_row['s_day_options'] = '<option value="0"' . ((!$day) ? ' selected="selected"' : '') . '>--</option>';
		for ($i = 1; $i < 32; $i++)
		{
			$profile_row['s_day_options'] .= '<option value="' . $i . '"' . (($i == $day) ? ' selected="selected"' : '') . ">$i</option>";
		}

		$profile_row['s_month_options'] = '<option value="0"' . ((!$month) ? ' selected="selected"' : '') . '>--</option>';
		for ($i = 1; $i < 13; $i++)
		{
			$profile_row['s_month_options'] .= '<option value="' . $i . '"' . (($i == $month) ? ' selected="selected"' : '') . ">$i</option>";
		}

		list($mindate_day, $mindate_month, $mindate_year) = array_map('intval', explode('-', (strpos($profile_row['field_minlen'], '-') ? $profile_row['field_minlen'] : ' 0- 0-   0')));
		list($maxdate_day, $maxdate_month, $maxdate_year) = array_map('intval', explode('-', (strpos($profile_row['field_maxlen'], '-') ? $profile_row['field_maxlen'] : ' 0- 0-   0')));

		$mindate_year = ($preview_options === false && !$mindate_year) ? 1901 : $mindate_year;
		$maxdate_year = $maxdate_year ?: (($preview_options === false) ? ($now['year'] + 50) : 9999);

		if ($mindate_year)
		{
			$profile_row['s_year_options'] = '<option value="0"' . ((!$year) ? ' selected="selected"' : '') . '>--</option>';
			for ($i = $mindate_year; $i <= $maxdate_year; $i++)
			{
				$profile_row['s_year_options'] .= '<option value="' . $i . '"' . (($i == $year) ? ' selected="selected"' : '') . ">$i</option>";
			}
		}

		$profile_row['field_value'] = 0;
		$profile_row['field_value_day'] = $day;
		$profile_row['field_value_month'] = $month;
		$profile_row['field_value_year'] = $year;
		$profile_row['field_value_minyear'] = $mindate_year;
		$profile_row['field_value_maxyear'] = $maxdate_year;
		$this->template->assign_block_vars('date', array_change_key_case($profile_row, CASE_UPPER));
	}

	/**
	* {@inheritDoc}
	*/
	public function validate_options_on_submit($error, $field_data)
	{
		$error = parent::validate_options_on_submit($error, $field_data);

		// If a minimum date is specified, check it
		list($mindate_day, $mindate_month, $mindate_year) = array_map('intval', explode('-', (strpos($field_data['field_minlen'], '-') ? $field_data['field_minlen'] : ' 0- 0-   0')));
		if (($mindate_day && (!$mindate_month || !$mindate_year)) || ($mindate_month && !$mindate_year))
		{
			$error[] = $this->user->lang('FIELD_VALIDATION_DATE_INVALID_MIN');
		}

		// If a maximum date is specified, check it
		list($maxdate_day, $maxdate_month, $maxdate_year) = array_map('intval', explode('-', (strpos($field_data['field_maxlen'], '-') ? $field_data['field_maxlen'] : ' 0- 0-   0')));
		if (($maxdate_day && (!$maxdate_month || !$maxdate_year)) || ($maxdate_month && !$maxdate_year))
		{
			$error[] = $this->user->lang('FIELD_VALIDATION_DATE_INVALID_MAX');
		}

		// Check that maximum is higher than minimum if specified
		if ($mindate_year && $maxdate_year && ($maxdate_year < $mindate_year ||
				($maxdate_year == $mindate_year && ($mindate_month && $maxdate_month && ($maxdate_month < $mindate_month ||
						($maxdate_month == $mindate_month && ($mindate_day && $maxdate_day && $maxdate_day < $mindate_day)))))))
		{
			$error[] = $this->user->lang('FIELD_VALIDATION_DATE_MAX_BEFORE_MIN');
		}

		// Check the default value
		$field_default_data = array_merge($field_data, array('field_required' => 0));
		if ($this->validate_profile_field($field_data['field_default_value'], $field_default_data))
		{
			$error[] = $this->user->lang('FIELD_VALIDATION_DEFAULT');
		}
		return $error;
	}

	/**
	* {@inheritDoc}
	*/
	public function get_excluded_options($key, $action, $current_value, &$field_data, $step)
	{
		if ($step == 2 && ($key == 'field_minlen' || $key == 'field_maxlen'))
		{
			if ($this->request->is_set($key . '_year'))
			{
				$field_data[$key . '_day'] = $this->request->variable($key . '_day', 0);
				$field_data[$key . '_month'] = $this->request->variable($key . '_month', 0);
				$field_data[$key . '_year'] = $this->request->variable($key . '_year', 0);
				$current_value = sprintf('%2d-%2d-%4d', $field_data[$key . '_day'], $field_data[$key . '_month'], $field_data[$key . '_year']);
				$current_value = ($current_value == ' 0- 0-   0') ? '' : $current_value;
				$this->request->overwrite($key , $current_value, \phpbb\request\request_interface::POST);
			}
			else
			{
				list($field_data[$key . '_day'], $field_data[$key . '_month'], $field_data[$key . '_year']) = array_map('intval', explode('-', strpos($current_value, '-') ? $current_value : ' 0- 0-   0'));
			}
			return $current_value;
		}

		if ($step == 2 && $key == 'field_length')
		{
			$current_value = $this->request->variable('date_dropdown', $current_value);

			return $current_value;
		}

		return parent::get_excluded_options($key, $action, $current_value, $field_data, $step);
	}

	/**
	* {@inheritDoc}
	*/
	public function prepare_hidden_fields($step, $key, $action, &$field_data)
	{
		if ($key == 'field_minlen' || $key == 'field_maxlen')
		{
			if ($this->request->is_set($key . '_year'))
			{
				$field_data[$key . '_day'] = $this->request->variable($key . '_day', 0);
				$field_data[$key . '_month'] = $this->request->variable($key . '_month', 0);
				$field_data[$key . '_year'] = $this->request->variable($key . '_year', 0);
				$current_value = sprintf('%2d-%2d-%4d', $field_data[$key . '_day'], $field_data[$key . '_month'], $field_data[$key . '_year']);
				return ($current_value == ' 0- 0-   0') ? '' : $current_value;
			}
		}

		return parent::prepare_hidden_fields($step, $key, $action, $field_data);
	}
}
