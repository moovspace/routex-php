<?php
namespace App\Core\Router;

abstract class Controller
{
	function ParseUri(): array {
		$url = rtrim(ltrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),'/'),'/');
		return explode('/',$url);
	}

	function UriParam($nr = 1): string {
		$nr = $nr - 1;
		$a = $this->ParseUri();
		if(!empty($a[$nr])){
			return $a[$nr];
		}
		return '';
	}

	function ParsePost(): array {
		return $_POST;
	}

	function ParseGet(): array {
		return $_GET;
	}

	function ParseInput(): string {
		return file_get_contents('php://input');
	}

	function ParseBearerToken(): string {
		return trim(str_replace('Bearer ', '', $this->ParseHeader('Authorization')));
	}

	function ParseHeader(string $name = 'Authorization'): string {
		$arr = getallheaders();
		if(!empty($arr[$name])){
			return $arr[$name];
		}
		return '';
	}

	function ParseHeaders() {
		return getallheaders();
	}

	function ValidEmail(string $email): int {
		if(preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) != 1)
		{
			return 0;
		}
		return 1;
	}
}
