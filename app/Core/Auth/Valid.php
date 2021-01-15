<?php
namespace App\Core\Auth;

use Exception;
use DateTime;

/**
 * Valid class
 */
class Valid
{
	/**
	 * Uuid - Test unique id string
	 *
	 * @param string $str UUID String
	 * @return void
	 */
	static function Uuid(string $str): void
	{
		if(preg_match('/^(\w+\-){4}\w+$/', $str) != 1)
		{
			throw new Exception("ERR_UUID", 1);
		}
	}

	/**
	 * Alias - Test alias
	 *
	 * @param string $str
	 * @return void
	 */
	static function Alias(string $str): void
	{
		if(preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9\.]{2,30}[a-zA-Z0-9]{1}$/', $str) != 1)
		{
			throw new Exception("ERR_ALIAS", 1);
		}
	}

	/**
	 * Email - Validate email
	 *
	 * @param string $val
	 * @param integer $size
	 * @return void
	 */
	static function Email(string $val, int $size = 190): void
	{
		if(preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $val) != 1 || strlen($val) > $size)
		{
			throw new Exception("ERR_EMAIL", 1);
		}
	}

	/**
	 * Pass - Validate password
	 *
	 * @param string $str
	 * @param integer $length
	 * @return void
	 */
	static function Pass(string $str, int $length = 8): void
	{
		if(strlen($str) < $length || empty($str))
		{
			throw new Exception("ERR_PASS_LENGTH", 1);
		}
	}

	/**
	 * Date - Validate date string in format
	 *
	 * @param string $date Date string
	 * @param string $format Format string
	 * @return void
	 */
	static function Date(string $date, string $format = 'Y-m-d H:i:s'): void
	{
		$d = DateTime::createFromFormat($format, $date);
		if(!($d && $d->format($format) == $date))
		{
			throw new Exception("ERR_TIMESTAMP", 1);
		}
	}

	/**
	 * Empty - Test is string empty
	 *
	 * @param string $str Test string
	 * @return void
	 */
	static function Empty(string $str): void
	{
		if(empty($str))
		{
			throw new Exception("ERR_EMPTY_VALUE", 1);
		}
	}

	/**
	 * InArray - Test is value exists in array
	 *
	 * @param string $val String value
	 * @param array $arr Array with values
	 * @return void
	 */
	static function InArray(string $val, array $arr): void
	{
		if(!in_array($val, $arr))
		{
			throw new Exception("ERR_ARRAY", 1);
		}
	}
}