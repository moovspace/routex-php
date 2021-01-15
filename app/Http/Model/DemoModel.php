<?php
namespace App\Http\Model;

use Exception;
use App\Core\Mysql\Db;
use App\Core\Mail\SendEmail;
use App\Core\Curl\CurlClient;

class DemoModel
{
	static function AddJsonHeader()
	{
		header("Content-Type: application/json; charset=UTF-8");
	}

	static function AddHtmlHeader()
	{
		header('Content-Type: text/html; charset=UTF-8');
	}

	/**
	 * Get users from database
	 *
	 * @param integer $limit Limit records
	 * @return mixed Users list
	 */
	static function Users(int $limit = 1)
	{
		// Mysql
		$rows = Db::Query('SELECT * FROM user LIMIT ' . $limit, [])->FetchAllObj();

		// Mysql Redis Cache
		// $rows = Db::QueryCache('SELECT * FROM user LIMIT ' . $limit, []);

		// Return rows
		return $rows;
	}

	/**
	 * Send email
	 *
	 * @return int Return 1 or 0
	 */
	static function Mail()
	{
		return SendEmail::Send('mail@woo.xx', 'E-mail subject', 'Hello world!');
	}

	/**
	 * Send data with curl
	 *
	 * @return mixed Request response
	 */
	static function CurlPostJson()
	{
		try
		{
			// Init Curl
			$curl = new CurlClient();
			// Host
			$curl->AddUrl("http://router.xx/api.php");
			$curl->SetMethod("POST");
			$curl->SetJson();
			$curl->SetAllowSelfsigned();
			// Optional token
			$curl->AddToken('token-hash-here-123');
			// Data
			$curl->AddData("username","Max");
			$curl->AddData("email","ho@email.xx");
			// Send data and get response
			$data = $curl->Send();
			// Errors
			// echo $curl->Error;
			// Status code
			// echo $curl->StatusCode

		}
		catch(Exception $e)
		{
			throw $e;
			// echo $e->getMessage()
		}

		return $data;
	}
}