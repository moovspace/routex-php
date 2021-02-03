# Rest Api Php Router
Php router for rest api with composer.
 - Php router class
 - Db class - Mysql pdo with redis cache
 - Send email class with phpmailer
 - Curl class for api requests
 - Shopping Cart with addons
 - Authentication, bearer token, validation
 - Image manipulation (resize, crop, save, show, download, upload)
 - Language translation with json files
 - Composer project package
 - Php MVC
 - PhpUnit tests

### Install with git
```sh
# get with git
git clone https://github.com/moovspace/routex-php.git /var/www/html/router.xx

# permissions
chown -R your-user-name:www-data /var/www/html/router.xx
chmod -R 2775 /var/www/html/router.xx

# update composer
cd /var/www/html/router.xx
composer update
composer dump-autoload -o
```

### Install with composer
```sh
# cache clear
composer clearcache

# create new project in dir v1.0
composer create-project --no-dev moovspace/routex-php=1.0 /var/www/html/router.xx

# create new project in dir v1.0
composer create-project --no-dev moovspace/routex-php /var/www/html/router.xx 1.0 --prefer-dist

# permissions
chown -R your-user-name:www-data /var/www/html/router.xx
chmod -R 2775 /var/www/html/router.xx
```

### Dirs
```sh
# App php controllers, views, models
/app/Http

# Routes
/routes/web.php

# Server document root (alow symlinks)
/public
```

### Run in browser
```
php -S localhost:8000 -t /var/www/html/router.xx/public
```

### Local host domain
nano /etc/hosts
```
# Add line
127.0.0.1 www.router.xx router.xx
```

### Run with Nginx virtualhost
nano /etc/nginx/sites-available/default
```
# Add to file
# /etc/nginx/sites-available/default

server {
    listen 80;
    listen [::]:80;
    server_name router.xx;
    root /var/www/html/router.xx/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?url=$uri&$args;
    }

    location ~ \.php$ {
        # don't cache it
        proxy_no_cache 1;
        proxy_cache_bypass 1;
        expires -1;

        # Php-fpm
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }

    disable_symlinks off;
    client_max_body_size 100M;

    # Tls redirect
    # return 301 https://$host$request_uri;
    # return 301 https://router.xx$request_uri;
}
```

### Mysql database
```sh
# import database
mysql -u root -p < /var/www/html/router.xx/install/sql/app.sql
```

### Routex app routes
```php
<?php
// Redirect (delete line below)
// $r->Redirect('/','/demo');

// Homepage
$r->Set('/', 'App/Http/Controller/Demo', 'Index');

// Default methods GET, POST, PUT, DELETE
$r->Set('/demo', 'App/Http/Controller/Demo', 'Index');

// Only POST, GET request
$r->Set('/home/{id}', 'App/Http/Controller/Demo', 'Index', ['POST', 'GET']);

// Only POST, GET request
$r->Set('/home/{id}/book/{name}', 'App/Http/Controller/Demo', 'Index', ['POST', 'GET']);

// Function
$r->Set('/phpversion', function(){
    echo phpversion();
});

// Show error page, redirect, throw exception or show json error here
$r->ErrorPage();
?>
```

### Routex page controller
```php
<?php
namespace App\Http\Controller;

use Exception;
use App\Http\Model\DemoModel;

class Demo
{
	function Index()
	{
		try
		{
			// Router
			global $r;

			// Get url param if exists
			$id = $r->GetParam('{id}');
			$name = $r->GetParam('{name}');

			// Rows
			$users = DemoModel::Users(2);

			// Send email
			$sent = DemoModel::Mail();

			// Post request
			$obj =  json_decode(DemoModel::CurlPostJson());

			// Show as json
			DemoModel::AddJsonHeader();

			// Json response
			return json_encode( [ 'info' => 'REST API Php router works awesome! ', 'sent' => $sent, 'data' => $obj, 'id' => (int) $id, 'name' => $name, 'users' => $users ] );
		}
		catch (Exception $e)
		{
			throw $e;
			// echo $e->getMessage()
		}
	}
}
```

### Routex page model
Example with mysql database, send email with smtp, curl requests
```php
<?php
namespace App\Http\Model;

use Exception;
use App\Core\Mysql\Db;
use App\Core\Mail\SendEmail;
use App\Core\Curl\CurlClient;

class DemoModel
{
	static function AddJsonHeader()
	{
		header("Content-Type: application/json");
	}

	/**
	 * Get users from database
	 *
	 * @param integer $limit Limit records
	 * @return mixed Users list
	 */
	static function Users(int $limit = 1)
	{
		// Mysql
		$rows = Db::Query('SELECT * FROM user LIMIT ' . $limit, [])->FetchAllObj();

		// Mysql Redis Cache
		// $rows = Db::QueryCache('SELECT * FROM user LIMIT ' . $limit, []);

		// Return rows
		return $rows;
	}

	/**
	 * Send email
	 *
	 * @return int Return 1 or 0
	 */
	static function Mail()
	{
		return SendEmail::Send('mail@woo.xx', 'E-mail subject', 'Hello world!');
	}

	/**
	 * Send data with curl
	 *
	 * @return mixed Request response
	 */
	static function CurlPostJson()
	{
		try
		{
			// Init Curl
			$curl = new CurlClient();
			// Host
			$curl->AddUrl("http://router.xx/api.php");
			$curl->SetMethod("POST");
			$curl->SetJson();
			$curl->SetAllowSelfsigned();
			// Optional token
			$curl->AddToken('token-hash-here-123');
			// Data
			$curl->AddData("username","Max");
			$curl->AddData("email","ho@email.xx");
			// Send data and get response
			$data = $curl->Send();
			// Errors
			// echo $curl->Error;
			// Status code
			// echo $curl->StatusCode

		}
		catch(Exception $e)
		{
			throw $e;
			// echo $e->getMessage()
		}

		return $data;
	}
}
```

### PhpUnit tests
```sh
# Go to dir
cd /var/www/html/router.xx

# Run tests
./vendor/bin/phpunit tests/app
./vendor/bin/phpunit --testdox tests/app
```


### Curl examples
```
# Upload
curl -i -H "Authorization: Bearer password" -F 'file=@/path/to/img.jpg' http://router.xx

# Get
curl -X GET http://router.xx?id=777&name=Pola

# GET
curl -X GET http://router.xx -H "Authorization: Bearer 61e51229-f13c-11ea-9db7-7e44772edd6d"

# POST, PUT
curl -X POST http://router.xx -H "Authorization: Bearer 61e51229-f13c-11ea-9db7-7e44772edd6d"

# POST cookie
curl -v --cookie cookie.txt -X POST http://router.xx/api/userinfo -H "Authorization: Bearer 61e51229-f13c-11ea-9db7-7e44772edd6d"

# Login
curl -X POST -d "email=5f567a7968930@woo.xx&pass=password" http://router.xx/api/auth

# Form data
-d "id=123&name=Jimbo" -H "Content-Type: application/x-www-form-urlencoded"

# Json data
-d '{"key1":"value1", "key2":"value2"}' -H "Content-Type: application/json"

# Json
curl -H "Authorization: Bearer token-123456" -H "Content-Type: application/json" http://router.xx

curl -i -H "Authorization: Bearer token-123456" -H "Accept: application/json" -H "Content-Type: application/json" http://router.xx
```
