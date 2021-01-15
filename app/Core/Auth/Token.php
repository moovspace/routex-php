<?php
namespace App\Core\Auth;

use Exception;
use App\Core\Mysql\Db;

/**
 * Token class
 */
class Token
{
	/**
	 * Update - Create or update token (uuid format) in database
	 *
	 * @param int $id User id
	 * @return object Return user token object
	 */
	static function UpdateUuid(int $id, int $hours = 1)
	{
		$arr = [
			':id' => $id,
			':hours' => $hours,
			':uphours' => $hours
		];

		$sql = 'INSERT INTO user_auth(rf_user_id,token,expires) VALUES(:id,UUID(),(NOW() + INTERVAL :hours HOUR)) ON DUPLICATE KEY UPDATE token = UUID(), expires = (NOW() + INTERVAL :uphours HOUR)';

		Db::Query($sql,$arr)->LastInsertId();

		return self::GetWithId($id);
	}

	/**
	 * UpdateUuid - Create or update token (string format) in database
	 *
	 * @param int $id User id
	 * @return object Return user token object
	 */
	static function Update(int $id, int $hours = 1, int $token_length = 32)
	{
		$token = self::UniqueToken($token_length);

		$arr = [
			':id' => $id,
			':hours' => $hours,
			':uphours' => $hours,
			':token' => $token,
			':uptoken' => $token
		];

		$sql = 'INSERT INTO user_auth(rf_user_id,token,expires) VALUES(:id, :token, (NOW() + INTERVAL :hours HOUR)) ON DUPLICATE KEY UPDATE token = :uptoken, expires = (NOW() + INTERVAL :uphours HOUR)';

		Db::Query($sql,$arr)->LastInsertId();

		return self::GetWithId($id);
	}

	/**
	 * GetWithId - Find data with id
	 *
	 * @param integer $id User id
	 * @return object Return user token object
	 */
	static function GetWithId(int $id)
	{
		$arr = [
			':id' => $id
		];

		$sql = 'SELECT * FROM user_auth WHERE rf_user_id = :id LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}

	/**
	 * Get - Find data with token hash
	 *
	 * @param integer $id User id
	 * @return object Return user token object
	 */
	static function Get(string $hash)
	{
		$arr = [
			':token' => $hash
		];

		$sql = 'SELECT * FROM user_auth WHERE token = :token LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}

	/**
	 * Delete - Delete user token
	 *
	 * @param integer $id User id
	 * @return object Return user token object
	 */
	static function Delete(int $id)
	{
		$arr = [
			':id' => $id
		];

		$sql = 'DELETE FROM user_auth WHERE rf_user_id = :id';

		return Db::Query($sql,$arr)->RowCount();
	}

	/**
	 * Delete - Delete user token
	 *
	 * @param integer $token User  token
	 * @return object Return user token object
	 */
	static function DeleteHash(int $token)
	{
		$arr = [
			':token' => $token
		];

		$sql = 'DELETE FROM user_auth WHERE token = :token';

		return Db::Query($sql,$arr)->RowCount();
	}

	/**
	 * BearerToken - Get token from header
	 *
	 * @return string Token hash
	 */
	static function BearerToken()
	{
		return trim(str_replace('Bearer ', '', self::GetHeader()));
	}

	/**
	 * GetHeader - Get request header
	 *
	 * @param string $name Header name
	 * @return string Header string
	 */
	static function GetHeader($name = 'Authorization')
	{
		$arr = getallheaders();
		if(!empty($arr[$name]))
		{
			return $arr[$name];
		}
		return '';
	}

	/**
	 * Generate Uuid()
	 *
	 * @return string Uuid string
	 */
	static function Uuid()
	{
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0C2f ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
		);
	}

	/**
	 * Generate unique token
	 *
	 * @param integer $len Token length
	 * @return string Token string
	 */
	static function UniqueToken($len = 32)
	{
		return bin2hex(random_bytes($len));
	}
}