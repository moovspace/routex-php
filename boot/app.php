<?php
// Timezone
date_default_timezone_set('Etc/UTC'); // Or set Europe/Wasraw

// Charset
ini_set('default_charset', 'utf-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_regex_encoding('UTF-8');

// Execution time (0 - unlimited)
set_time_limit(600);

// Show erors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

// Session lifetimes
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);

// Session cookie
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => '.'.$_SERVER["HTTP_HOST"],
    'secure' => isset($_SERVER["HTTPS"]),
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Composer autoload
$autoload = __DIR__.'/../vendor/autoload.php';

if(!file_exists($autoload)) {
    die('Create composer autoload first! Install composer and run command: "composer update" in document root directory.');
} else {
    require_once $autoload;
}

// Session always after autoload
session_start();

// Router global (do not delete)
global $r;
?>
