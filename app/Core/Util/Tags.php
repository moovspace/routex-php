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

	/**
	 * Replace to html tags
	 *
	 * @param string $str Text with [h1], ... tags
	 * @return string Html content
	 */
	static function Replace($str) {
		$tags = [];
		$str = strip_tags($str);
		$str = preg_replace_callback('~(\[\/?[a-z]+[0-9]?+\]?|\[>\])~i',
		function ($match) use (&$tags)
		{
			$m = '';
			array_push($tags, $match[1]);
			if($match[1] === '[>]') {
				return '>';
			} else {
				$m = str_replace('[','<', $match[1]);
				return str_replace(']','>', $m);
			}
		},
		$str);
		return $str;
	}

	static function ReplaceSample() {
		return '
		Tag [h1]Hello text[/h1]
		Link [a href="https://do.do/url" [>] Hello link[/a]
		Hello imag [img src="https://do.do/imahe.png" [>]
		Div [div class="" [>] Hello text[/div]
		';
	}

	function Slug($str, $replace = "-")
	{
		$str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$charsArr = array('^', "'", '"', '`', '~');
        $str = str_replace($charsArr, '', $str);
        $return = trim(preg_replace('# +#',' ',preg_replace('/[^a-zA-Z0-9\s]/','',strtolower($str))));
        return str_replace(' ', $replace, $return);
    }
}