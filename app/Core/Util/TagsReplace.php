<?php
namespace App\Core\Util;

use DOMDocument;

class TagsReplace
{
	static function Text($str) {
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

	static function Sample() {
		return '
		Tag [h1]Hello text[/h1]
		Link [a href="https://do.do/url" [>] Hello link[/a]
		Hello imag [img src="https://do.do/imahe.png" [>]
		Div [div class="" [>] Hello text[/div]
		';
	}
}