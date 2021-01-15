<?php
namespace App\Config;

class AppConfig
{
	// Smtp (default localhost without pass)
	const SMTP_USER = '';
	const SMTP_PASS = '';
	const SMTP_HOST = '127.0.0.1';
	const SMTP_PORT = 25; // 25, 587, 465
	const SMTP_FROM_EMAIL = 'no-reply@woo.xx';
	const SMTP_FROM_USER = 'Welcome';
	const SMTP_TLS = false; // true - enabled ssl connection
	const SMTP_AUTH = false; // true - enabled authentication
	const SMTP_DEBUG = 0; // Or 1 - enabled

	// Domain host
	const HOST = 'router.xx';
	const IMAGES_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

	// SmsApi
	const SMSAPI_TOKEN = '';
	const SMSAPI_NOTIFIY_NUMBER = '';
}