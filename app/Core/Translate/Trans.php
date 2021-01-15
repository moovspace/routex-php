<?php
namespace App\Core\Translate;

use Exception;

/**
 * Translation class
 * Load file lang-{LANG_CODE}.lng
 * Load default file lang-en.lng
 */
class Trans
{
	public $Json = [];

	/**
	 * Load translate json file
	 * File: lang-{lang_code}.lng
	 * {"EMAIL_ERROR": "Podaj poprwany adres e-mail!", "PASS_ERROR": "Podaj swoje hasło!"}
	 *
	 * Change lang with (GET, SESSION):
	 * /login?lang=pl
	 * $_SESSION['lang'] = 'pl'
	 *
	 * @param string $folder_path Absolute path to folder
	 * @param string $lang Language short code: pl, en ...
	 */
	function __construct($folder_path = '/app/Core/Translate/Lang', $lang = 'en')
	{
		// Load lang code
		$lang = self::LangAutoload($lang);

		// Load file
		$folder_path = rtrim($folder_path,'/');
		$file = $_SERVER['DOCUMENT_ROOT'].$folder_path.'/lang-'.$lang.'.lng';

		if(file_exists($file))
		{
			$this->Json = json_decode(file_get_contents($file), true);
			// print_r($this->Json);
		}
		else
		{
			// Default file
			$file = $_SERVER['DOCUMENT_ROOT'].$folder_path.'/lang-en.lng';

			if(file_exists($file))
			{
				$this->Json = json_decode(file_get_contents($file), true);
			}
			else
			{
				throw new Exception("Translation file does not exists.", 1);
			}
		}

		// Json format error
		if(!empty(json_last_error_msg()) && JSON_ERROR_NONE != json_last_error_msg()){
			throw new Exception("Translate .lng file json format error: " . json_last_error_msg(), 3);
		}
	}

	/**
	 * Load language code from SESSION or GET
	 *
	 * @return string return language code: en
	 */
	static function LangAutoload($lang = 'en')
	{
		// Auto change language from GET lang param
		if(!empty($_GET['lang'])){
			$lang = $_SESSION['lang'] = $_GET['lang'];
		}else{
			// Auto change language from SESSION lang param
			if(!empty($_SESSION['lang'])){
				$lang = $_SESSION['lang'];
			}
		}
		return strtolower($lang);
	}

	/**
	 * Get KEY_ID_NAME transpaltion
	 *
	 * @param string $id Unique json array key name
	 * @return void
	 */
	function Get($id)
	{
		if(array_key_exists($id, $this->Json))
		{
			return $this->Json[$id];
		}
		else
		{
			return "[TRANS_ERR_HASH]: " . $id;
		}
	}
}
?>