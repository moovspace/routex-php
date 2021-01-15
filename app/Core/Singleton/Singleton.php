<?php
declare(strict_types=1);
namespace App\Core\Singleton;

class Singleton
{
	protected static $instance = null;
	// protected static ?Singleton $instance = null; // php 7.4, Singleton or nullable

	public static function GetInstance(): self
	{
		if (static::$instance === null) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/* prevent */
	protected function __construct(){}
	protected function __clone(){}
	protected function __wakeup(){}
}