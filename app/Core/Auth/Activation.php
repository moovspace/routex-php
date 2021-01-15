<?php
namespace App\Core\Auth;

use Exception;
use App\Core\Mysql\Db;

/**
 * Activation class
 */
class Activation
{
	static function Create(int $id, string $code, string $ip = ''): int
	{
		$arr = [
			':id' => $id,
			':code' => $code,
			':ip' => $ip,
			':upcode' => $code,
			':upip' => $ip
		];

		$sql = 'INSERT INTO user_activation(rf_user_id,code,ip,time) VALUES(:id,:code,:ip,NOW()) ON DUPLICATE KEY UPDATE code = :upcode, ip = :upip';

		return (int) Db::Query($sql,$arr)->RowCount();
	}

	static function Get(int $id)
	{
		$arr = [
			':id' => $id
		];

		$sql = 'SELECT * FROM user_activation WHERE rf_user_id = :id LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}

	static function GetWithCode(string $code)
	{
		$arr = [
			':code' => $code
		];

		$sql = 'SELECT * FROM user_activation WHERE code = :code LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}

	static function Delete(int $id)
	{
		$arr = [
			':id' => $id
		];

		$sql = 'DELETE FROM user_activation WHERE rf_user_id = :id LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}

	static function DeleteWithCode(int $code)
	{
		$arr = [
			':code' => $code
		];

		$sql = 'DELETE FROM user_activation WHERE code = :code LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}
}