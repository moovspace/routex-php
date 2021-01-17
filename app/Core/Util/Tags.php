<?php
namespace App\Core\Util;

use DOMDocument;

class Tags
{
	/**
	 * Strip html and php tags from array
	 * eg. POST, GET
	 *
	 * @param Array $arr Array GET, POST
	 * @return void
	 */
	static function Strip(array &$arr)
	{
		if(!empty($arr)) {
			foreach ($arr as $k => &$v) {
				if(is_array($v)) {
					self::Strip($v);
				} else {
					$arr[$k] = strip_tags($v);
				}
			}
		}
	}

	/**
	 * Close html tags
	 *
	 * @param string $html Html string
	 * @return string Html with closed tags
	 */
	static function Close(string $html)
	{
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->encoding='UTF-8';
		$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		return $doc->saveHTML();
	}
}