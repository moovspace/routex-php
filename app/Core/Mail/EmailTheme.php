<?php
namespace App\Core\Mail;

use DOMDocument;

class EmailTheme
{
	static function Get($path, $data)
	{
		if(file_exists($path))
		{
			$txt = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/'.ltrim($path,'/'));
			return self::CloseTags(self::ReplaceTags($txt, $data));
		}
		else
		{
			return 'Email theme does not exists: ' .$path;
		}
	}

	static function ReplaceTags($html, $arr)
	{
		$h = $html;
		foreach ($arr as $k => $v)
		{
			$h = str_replace($k, $v, $h);
		}
		return $h;
	}

	static function CloseTags($html = '<h1>He <a href=""> llo </h1>')
	{
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->encoding='UTF-8';
		$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
		return $doc->saveHTML();
	}

	static function HtmlEntitiesToUtf8($html)
	{
		return mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
	}
}