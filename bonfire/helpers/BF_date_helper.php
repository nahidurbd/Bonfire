<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers to jumpstart their development of
 * CodeIgniter applications.
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2014, Bonfire Dev Team
 * @license   http://opensource.org/licenses/MIT
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

/**
 * Date helper functions.
 *
 * Includes additional date-related functions helpful in Bonfire development.
 *
 * @package    Bonfire\Helpers\BF_date_helper
 * @author     Bonfire Dev Team
 * @link       http://cibonfire.com/docs/developer
 */

if ( ! function_exists('date_difference')) {
	/**
	 * Return the difference between two dates.
	 *
	 * @todo Consider updating this to use date_diff() and/or DateInterval.
	 *
	 * @param mixed  $start    The start date as a unix timestamp or in a format
	 * which can be used within strtotime().
	 * @param mixed  $end      The ending date as a unix timestamp or in a
	 * format which can be used within strtotime().
	 * @param string $interval A string with the interval to use. Valid values
	 * are 'week', 'day', 'hour', or 'minute'.
	 * @param bool   $reformat If TRUE, will reformat the time using strtotime().
	 *
	 * @return int A number representing the difference between the two dates in
	 * the interval desired.
	 */
	function date_difference($start = null, $end = null, $interval = 'day', $reformat = false)
	{
		if (is_null($start)) {
			return false;
		}

		if (is_null($end)) {
			$end = date('Y-m-d H:i:s');
		}

		$times = array(
			'week'		=> 604800,
			'day'		=> 86400,
			'hour'		=> 3600,
			'minute'	=> 60,
		);

		if ($reformat === true) {
			$start = strtotime($start);
			$end   = strtotime($end);
		}

		$diff = $end - $start;

		return round($diff / $times[$interval]);
	}
}

if ( ! function_exists('relative_time')) {
	/**
	 * Return a string representing how long ago a given UNIX timestamp was,
	 * e.g. "moments ago", "2 weeks ago", etc.
	 *
	 * @todo Consider updating this to use date_diff() and/or DateInterval.
	 *
	 * @param $timestamp int A UNIX timestamp.
	 *
	 * @return string A human-readable amount of time 'ago'.
	 */
	function relative_time($timestamp)
	{
		if ($timestamp != '' && ! is_int($timestamp)) {
			$timestamp = strtotime($timestamp);
		}

		if ( ! is_int($timestamp)){
			return "never";
		}

		$difference = time() - $timestamp;

		$periods = array('moment', 'min', 'hour', 'day', 'week', 'month', 'year', 'decade');
		$lengths = array('60', '60', '24', '7', '4.35', '12', '10', '10');

		if ($difference >= 0) {
			// This was in the past
			$ending = "ago";
		} else {
			// This is in the future
			$difference = -$difference;
			$ending = "to go";
		}

		for ($j = 0; $difference >= $lengths[$j]; $j++) {
			$difference /= $lengths[$j];
		}

		$difference = round($difference);
		if ($difference != 1) {
			$periods[$j] .= "s";
		}

		if ($difference < 60 && $j == 0) {
			return "{$periods[$j]} {$ending}";
		}

        return "{$difference} {$periods[$j]} {$ending}";
	}
}

if ( ! function_exists('standard_timezone')) {
    /**
     * Convert CodeIgniter's time zone strings to standard PHP time zone strings.
     *
     * @param string $ciTimezone A time zone string generated by CodeIgniter.
     *
     * @return string    A PHP time zone string.
     */
    function standard_timezone($ciTimezone)
    {
        switch ($ciTimezone) {
            case 'UM12':
                return 'Pacific/Kwajalein';
            case 'UM11':
                return 'Pacific/Midway';
            case 'UM10':
                return 'Pacific/Honolulu';
            case 'UM95':
                return 'Pacific/Marquesas';
            case 'UM9':
                return 'Pacific/Gambier';
            case 'UM8':
                return 'America/Los_Angeles';
            case 'UM7':
                return 'America/Boise';
            case 'UM6':
                return 'America/Chicago';
            case 'UM5':
                return 'America/New_York';
            case 'UM45':
                return 'America/Caracas';
            case 'UM4':
                return 'America/Sao_Paulo';
            case 'UM35':
                return 'America/St_Johns';
            case 'UM3':
                return 'America/Buenos_Aires';
            case 'UM2':
                return 'Atlantic/St_Helena';
            case 'UM1':
                return 'Atlantic/Azores';
            case 'UP1':
                return 'Europe/Berlin';
            case 'UP2':
                return 'Europe/Kaliningrad';
            case 'UP3':
                return 'Asia/Baghdad';
            case 'UP35':
                return 'Asia/Tehran';
            case 'UP4':
                return 'Asia/Baku';
            case 'UP45':
                return 'Asia/Kabul';
            case 'UP5':
                return 'Asia/Karachi';
            case 'UP55':
                return 'Asia/Calcutta';
            case 'UP575':
                return 'Asia/Kathmandu';
            case 'UP6':
                return 'Asia/Almaty';
            case 'UP65':
                return 'Asia/Rangoon';
            case 'UP7':
                return 'Asia/Bangkok';
            case 'UP8':
                return 'Asia/Hong_Kong';
            case 'UP875':
                return 'Australia/Eucla';
            case 'UP9':
                return 'Asia/Tokyo';
            case 'UP95':
                return 'Australia/Darwin';
            case 'UP10':
                return 'Australia/Melbourne';
            case 'UP105':
                return 'Australia/LHI';
            case 'UP11':
                return 'Asia/Magadan';
            case 'UP115':
                return 'Pacific/Norfolk';
            case 'UP12':
                return 'Pacific/Fiji';
            case 'UP1275':
                return 'Pacific/Chatham';
            case 'UP13':
                return 'Pacific/Samoa';
            case 'UP14':
                return 'Pacific/Kiritimati';
            case 'UTC':
            default:
                return 'UTC';
        }
    }
}

/**
 * Timezone Menu
 *
 * Generate a drop-down menu of timezones.
 *
 * @internal A similar version of the timezone_menu function was originally
 * accepted as a commit to CodeIgniter in June 2012 (see link below). The
 * signature of the function remains the same in the CI 3.x base, though the
 * internals have changed somewhat. Pulling in the current version would require
 * bringing in changes outside of this file. The $attributes argument could take
 * the place of the $class and $name arguments, but this allows for backwards
 * compatibility (since the $class and $name arguments were already in place).
 * If/when the CI date_helper is updated in Bonfire, this function should be
 * removed (to allow the CI function to be used).
 * @link https://github.com/EllisLab/CodeIgniter/commit/7540dede0f01acd7aa1ffd224defc5189305a815
 *
 * @param	string	$default    The default/selected timezone.
 * @param	string	$class      The class attribute of the select element.
 * @param	string	$name       The name attribute of the select element.
 * @param	mixed	$attributes Additional attributes to set on the menu's
 * select element. If a name or class are passed here, the behavior is likely to
 * be browser-dependant, as the function does not attempt to prevent it.
 *
 * @return	string  The HTML for the timezone menu.
 */
if ( ! function_exists('timezone_menu')) {
	function timezone_menu($default = 'UTC', $class = '', $name = 'timezones', $attributes = '')
	{
		$CI =& get_instance();
		$CI->lang->load('date');

        $default = $default === 'GMT' ? 'UTC' : $default;

		$menu = "<select name='{$name}'";

		if ($class != '') {
			$menu .= " class='{$class}'";
		}

		// Generate a string from the attributes submitted, if any.
        $atts = '';
		if (is_array($attributes)) {
			foreach ($attributes as $key => $val) {
				$atts .= " {$key}='{$val}'";
			}
		} elseif (is_string($attributes) && strlen($attributes) > 0) {
			$atts = " {$attributes}";
        }
		$menu .= "{$atts}>\n";

        // The timezones() function should be defined in the CI date_helper.
		foreach (timezones() as $key => $val) {
			$selected = $default == $key ? " selected='selected'" : '';
			$menu .= "<option value='{$key}'{$selected}>"
                  . $CI->lang->line($key)
                  . "</option>\n";
		}

		$menu .= "</select>";

		return $menu;
	}
}

if ( ! function_exists('user_time')) {
	/**
	 * Convert unix time to a human readable time in the user's timezone or in a
	 * given timezone.
	 *
	 * For supported timezones visit - http://php.net/manual/timezones.php
	 * For accepted formats visit - http://php.net/manual/function.date.php
	 *
	 * @example echo user_time();
	 * @example echo user_time($timestamp, 'EET', 'l jS \of F Y h:i:s A');
	 *
	 * @param int    $timestamp A UNIX timestamp. If none is given, current time
	 * will be used.
	 * @param string $timezone  The destination timezone for the conversion. If
	 * none is given, the current user's configured timezone will be used.
	 * @param string $format    The format string to apply to the converted
	 * timestamp.
	 *
	 * @return string A string containing the timestamp in the requested format.
	 */
	function user_time($timestamp = null, $timezone = null, $format = 'r')
	{
		if ( ! $timezone) {
			$CI =& get_instance();
			$CI->load->library('users/auth');
			if ($CI->auth->is_logged_in()) {
				$timezone = standard_timezone($CI->auth->user()->timezone);
			}
		}

		$timestamp = $timestamp ?: time();
        $dtime = new DateTime($timestamp, new DateTimeZone($timezone));

		return $dtime->format($format);
	}
}
/* End /helpers/BF_date_helper.php */