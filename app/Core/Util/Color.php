<?php
namespace App\Core\Util;

class Color
{
	static function RandHex()
	{
		return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	}
}