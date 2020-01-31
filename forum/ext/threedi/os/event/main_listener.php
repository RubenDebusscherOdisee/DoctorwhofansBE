<?php
/**
 *
 * Online Since. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2005 - 2019, 3Di, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace threedi\os\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Online Since Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth			$auth			Authentication object
	 * @param \phpbb\config\config		$config			Config Object
	 * @param \phpbb\language\language	$language		Language object
	 * @param \phpbb\template\template	$template		Template object
	 * @param \phpbb\user				$user			User Object
	 * @return void
	 * @access public
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\phpbb\language\language $language,
		\phpbb\template\template $template,
		\phpbb\user $user
	)
	{
		$this->auth			= $auth;
		$this->config		= $config;
		$this->language		= $language;
		$this->template		= $template;
		$this->user			= $user;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup_after'		=> 'onlinesince_load_language',
			'core.page_footer'			=> 'onlinesince_display',
			'core.permissions'			=> 'onlinesince_permissions',
		];
	}

	/**
	 * Load extension language file after user set up.
	 *
	 * @event  core.user_setup_after
	 * @return void
	 * @access public
	 */
	public function onlinesince_load_language()
	{
		$this->language->add_lang('common', 'threedi/os');
	}

	/**
	 * Adds OS permissions to my custom category
	 *
	 * @event  core.permissions
	 * @param  \phpbb\event\data	$event		The event object
	 * @return void
	 * @access public
	 */
	public function onlinesince_permissions($event)
	{
		$categories = $event['categories'];
		$permissions = $event['permissions'];

		if (empty($categories['3Di']))
		{
			/* Setting up a custom CAT */
			$categories['3Di'] = 'ACL_CAT_3DI';

			$event['categories'] = $categories;
		}

		$perms = [
			'a_new_threedi_os',
			'u_new_threedi_os',
		];

		foreach ($perms as $permission)
		{
			$permissions[$permission] = ['lang' => 'ACL_' . utf8_strtoupper($permission), 'cat' => '3Di'];
		}

		$event['permissions'] = $permissions;
	}

	/**
	 * Send OS variables to the template
	 *
	 * @event  core.page_footer
	 * @return void
	 * @access public
	 */
	public function onlinesince_display()
	{
		if ($this->auth->acl_get('u_new_threedi_os') || $this->auth->acl_get('a_new_threedi_os'))
		{
			list($diff_year, $diff_month, $diff_day) = $this->onlinesince();

			/* Plural Rules and cast to INT */
			$os_year = $this->language->lang('OS_YEAR', (int) $diff_year);
			$os_month = $this->language->lang('OS_MONTH', (int) $diff_month);
			$os_day = $this->language->lang('OS_DAY', (int) $diff_day);

			/* Converts the board start date into an human readable format */
			$onlinesince_start_date = $this->user->format_date($this->config['threedi_os_startdate'], 'd m Y');
			$onlinesince_start_time = $this->user->format_date($this->config['threedi_os_startdate'], 'H:i');

			$this->template->assign_vars([
				'OS_START_DATE'		=> $onlinesince_start_date,
				'OS_START_TIME'		=> $onlinesince_start_time,

				'L_OS_YEAR'			=> $os_year,
				'L_OS_MONTH'		=> $os_month,
				'L_OS_DAY'			=> $os_day,

				'S_ALLOW_OS'		=> true,
			]);
		}
	}

	/**
	 * Calculates the time spent in years, months and days taking into account leap years.
	 *
	 * @return array		[$diff_year, $diff_month, $diff_day]
	 * @access protected
	 */
	protected function onlinesince()
	{
		$days_of_month = [
			[0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
			[0, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
		];

		$start_date = gmdate('Y-m-d', $this->config['threedi_os_startdate']);
		$today_date = gmdate('Y-m-d', time());

		list($year1, $month1, $day1) = explode('-', $start_date);
		list($year2, $month2, $day2) = explode('-', $today_date);

		$diff_year = $year2 - $year1;
		$diff_month = $month2 - $month1;
		$diff_day = $day2 - $day1;

		/* Leap years have got to be calculated */
		$is_leap = (($year2 % 4) == 0 && ($year2 % 100) != 0 || ($year2 % 400) == 0) ? 1 : 0;

		/**
		 * Do obvious corrections (days before months!)
		 *
		 * This is a loop in case the previous month is
		 * February, and days < -28.
		 */
		$prev_month_days = $days_of_month[$is_leap][$month2 - 1];

		while ($diff_day < 0)
		{
			/* Borrow from the previous month */
			if ($prev_month_days == 0)
			{
				$prev_month_days = 31;
			}

			--$diff_month;

			$diff_day += $prev_month_days;
		}

		if ($diff_month < 0)
		{
			/* Borrow from the previous year */
			--$diff_year;

			$diff_month += 12;
		}

		return [$diff_year, $diff_month, $diff_day];
	}
}
