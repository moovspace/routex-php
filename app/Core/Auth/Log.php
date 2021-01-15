<?php
namespace App\Core\Auth;

use Exception;
use App\Core\Mysql\Db;

class Log
{
	static function Now(int $uid = 0, string $ip, string $info = '')
	{
		if(empty($info)) {
			$info = $_SERVER['HTTP_USER_AGENT'];
		}

		$arr = [
			':uid' => $uid,
			':ip' => $ip,
			':info' => self::Strip($info)
		];

		$sql = 'INSERT INTO user_login(rf_user_id,ip,info) VALUES(:uid,:ip,:info)';

		return Db::Query($sql,$arr)->LastInsertId();
	}

	static function Strip($str)
	{
		return strip_tags($str);
	}
}