<?php
namespace App\Core\Http;

class HttpHeader
{
	static function Json()
	{
		header("Content-Type: application/json; charset=utf-8");
	}

	static function Html()
	{
		header('Content-type: text/html; charset=utf-8');
	}

	static function NoCache()
	{
		header("Expires: Sun, 25 Jul 1997 06:02:34 GMT");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
	}

	static function Redirect($url)
	{
		header('Location: ' . $url);
	}

	static function FromString($header)
	{
		header($header);
	}
}