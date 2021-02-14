<?php
namespace App\Core\Auth;

use Exception;
use App\Core\Mysql\Db;

/**
 * User Info class
 */
class UserInfo
{
	/**
	 * GetWithId - Get user_info from database
	 *
	 * @param string $email User id
	 * @return object User object with data from database
	 */
	static function GetWithId(int $id)
	{
		$arr = [
			':id' => $id
		];

		$sql = 'SELECT * FROM user_info WHERE rf_user_id = :id LIMIT 1';

		return Db::Query($sql,$arr)->FetchObj();
	}

	/**
	 * UpdateColumn - Update data in user_info table
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

		$sql = 'UPDATE user_info SET '.$field.' = :value WHERE rf_user_id = :id';

		return Db::Query($sql,$arr)->RowCount();
	}
}