<?php
namespace App\Core\Auth;

use Exception;
use App\Core\Mysql\Db;
use App\Core\Auth\Token;

/**
 * Auth class
 */
class Auth
{
	/**
	 * Create new token in database
	 *
	 * @param integer $id User id
	 * @param integer $hours Expiration time in hours
	 * @param integer $token_length Token length
	 * @return object Return user token object
	 */
	static function Token(int $id, int $hours = 1, int $token_length = 32)
	{
		return Token::Update($id, $hours, $token_length);
	}

	/**
	 * Create new uuid token in database
	 *
	 * @param integer $id User id
	 * @param integer $hours Expiration time in hours
	 * @return object Return user token object
	 */
	static function TokenUuid(int $id, int $hours = 1)
	{
		return Token::UpdateUuid($id, $hours);
	}

	/**
	 * Get - Get user from database
	 *
	 * @param string $email User email addres
	 * @return object User object with data from database
	 */
	static function Get(string $email)
	{
		$arr = [
			':email' => $email
		];

		$sql = 'SELECT * FROM user WHERE email = :email LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}

	/**
	 * GetWithId - Get user from database
	 *
	 * @param string $email User id
	 * @return object User object with data from database
	 */
	static function GetWithId(int $id)
	{
		$arr = [
			':id' => $id
		];

		$sql = 'SELECT * FROM user WHERE id = :id LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}

	/**
	 * Create - Create user in mysql table
	 *
	 * @param string $email User email unique. Validate email addres before inserting.
	 * @param string $pass User password
	 * @param string $ip User ip address
	 * @param int $active If user activated 1
	 * @return int Created user id or 0
	 */
	static function Create(string $email, string $pass, string $ip = '', string $algo = 'md5', int $active = 0)
	{
		$arr = [
			':email' => $email,
			':pass' => self::PassHash($pass,$algo),
			':ip' => $ip,
			':active' => $active
		];

		$sql = 'INSERT INTO user(email,pass,ip,active) VALUES(:email,:pass,:ip,:active)';

		return Db::Query($sql,$arr)->LastInsertId();
	}

	/**
	 * UpdateColumn - Update data in user table
	 *
	 * @param string $field Column name
	 * @param string $value Inserted value value
	 * @param integer $user_id User id
	 * @return integer Affected rows
	 */
	static function UpdateColumn(string $field, string $value, int $user_id): int
	{
		$field = preg_replace("/[^a-zA-z0-9_]/","",$field);

		$arr = [
			':id' => $user_id,
			':value' => $value
		];

		$sql = 'UPDATE user SET '.$field.' = :value WHERE id = :id';

		return Db::Query($sql,$arr)->RowCount();
	}

	/**
	 * IsAuthorized - Validate request authorization header token
	 *
	 * Authorization: Bearer token-123456
	 * curl -X GET http://domain.xx -H "Authorization: Bearer 61e51229-f13c-11ea-9db7-7e44772edd6d"
	 *
	 * @return object Return user data or throw error
	 */
	static function IsAuthorized()
	{
		$token = Token::BearerToken();

		if(!empty($token))
		{
			$t = Token::Get($token); // Get token with hash
			$id = (int) $t->rf_user_id;
			$expires = (int) strtotime($t->expires);

			if($id <= 0)
			{
				throw new Exception("ERR_TOKEN", 1);
			}

			if($expires <= time())
			{
				throw new Exception("ERR_TOKEN_EXPIRED", 1);
			}

			$user = Auth::GetWithId($id); // Get user with id

			if(empty($user))
			{
				throw new Exception("ERR_USER", 1);
			}

			return $user;
		}

		throw new Exception("ERR_UNAUTHORIZED", 1);
	}

	/**
	 * PassHash - Create password hash
	 *
	 * @param string $pass Password string
	 * @param string $algo Hash algorithm
	 * @return string Hassed pass
	 */
	static function PassHash(string $pass, string $algo): string
	{
		if(!in_array($algo, hash_algos()))
		{
			throw new Exception("ERR_HASH_ALGO", 1);
		}

		return hash($algo, $pass);
	}
}