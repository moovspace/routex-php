<?php
namespace App\Core\Cache;

class Cache
{
	protected $CacheDir = 'cacheapp';

	function Set(string $hash, string $str)
	{
		$f = $this->File($hash);
		return file_put_contents($f, serialize($str));
	}

	function Get(string $hash)
	{
		$f = $this->File($hash);
		if(file_exists($f)){
			return unserialize(file_get_contents($f));
		}
		return '';
	}

	function Dir($name)
	{
		if(!empty($name)){ $this->CacheDir = md5($name); }
	}

	protected function File($hash)
	{
		$hash = md5($hash);
		return $this->Tmp().$hash.'.thx';
	}

	protected function Tmp()
	{
		$dir = rtrim(ltrim($this->CacheDir,'/'),'/');
		$path = "/tmp/".$dir;
		if(!file_exists($path)){
			mkdir($path,2770,true);
		}
		return $path.'/';
	}
}