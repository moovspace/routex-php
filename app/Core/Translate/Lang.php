<?php
namespace App\Core\Translate;

use Exception;
use App\Config\AppConfig;
use App\Core\Mysql\Db;
use App\Core\Singleton\Singleton;

/**
 * Translation class from mysql
 */
class Lang extends Singleton
{
	static protected $Lang = [];
	static protected $CurrLang = 'en';

	static function Get()
	{
		$lang = self::CurrentLang();

		if(strlen($lang) == 2)
		{
			if(empty(self::$Lang) || $lang != self::$CurrLang)
			{
				$sql = 'SELECT hash,txt FROM translate WHERE lang_code = :lang';
				$arr = [':lang' => $lang];
				self::$Lang = self::Convert(Db::Query($sql,$arr)->FetchAll());
			}

			self::$CurrLang = $lang;
		}
	}

	static function Convert($arr)
	{
		$a = [];
		foreach ($arr as $v)
		{
			$k = trim($v['hash']);
			$a[$k] = $v['txt'];
		}
		return $a;
	}

	/**
	 * Translate hash
	 *
	 * @param string $hash Hash string
	 * @return string Translated text
	 */
	static function Trans($hash)
	{
		self::GetInstance();
		self::Get();

		if (!array_key_exists($hash, self::$Lang))
		{
			return $hash;
		}

		return self::$Lang[$hash];
	}

	static function CurrentLang()
	{
		$l = AppConfig::LANG[0];
		if(!empty($_SESSION['lang']) && strlen($_SESSION['lang']) == 2)
		{
			$l = $_SESSION['lang'];
		}
		return $l;
	}

	static function ChangeLang()
	{
		$arr = AppConfig::LANG;
		if(!empty($_GET['lang']) && in_array($_GET['lang'], $arr)) {
			$_SESSION['lang'] = $_GET['lang'];
		}
	}

	static function Links()
	{
		$ht = '<div class="langbox">';
		foreach (AppConfig::LANG as $v) {
			$ht .= '<a href="?lang='.$v.'" class="lang" title="'.ucfirst($v).'"> '.strtoupper($v).' </a>';
		}
		return $ht . '</div>';
	}
}