<?php
namespace App\Core\Mail;

use Exception;
use App\Config\AppConfig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class SendEmail
{
	static function Send($email, $subject, $html, $files = [], $inline = [])
	{
		// Validate
		Email::IsValidEmail($email);
		Email::IsValidEmail(AppConfig::SMTP_FROM_EMAIL);
		// Sent
		return self::MailerSmtp($email, $subject, $html, $files, $inline, AppConfig::SMTP_FROM_EMAIL, AppConfig::SMTP_FROM_USER, AppConfig::SMTP_USER, AppConfig::SMTP_PASS, AppConfig::SMTP_HOST, AppConfig::SMTP_TLS, AppConfig::SMTP_AUTH, AppConfig::SMTP_PORT, AppConfig::SMTP_DEBUG);
	}

	static function MailerSmtp($email, $subject, $html, $files, $inline, $from_email, $from_user, $smtpUser, $smtpPass, $smtpHost, $smtpTls = false, $smtpAuth = false, $smtpPort = 25, $smtpDebug = 0)
	{
		$m = new PHPMailer(true); // Passing `true` enables exceptions
		$m->SMTPDebug = (int) $smtpDebug;
		$m->isSMTP();
		$m->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
		$m->CharSet = "UTF-8";
		$m->Host = $smtpHost;
		$m->Port = $smtpPort;
		$m->SMTPAuth = $smtpAuth;
		$m->Username = $smtpUser;
		$m->Password = $smtpPass;
		// Ssl
		if($smtpTls == true) {
			$m->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
		}
		$m->setFrom($from_email, $from_user);
		$m->addReplyTo($from_email, $from_user);
		$m->addAddress($email);
		$m->Subject = $subject;
		$m->isHTML(true); // Set email format to HTML
		$m->Body = $html;
		$m->AltBody = 'Change to html view.';
		// Add files from array
		foreach ($files as $path) {
			if(file_exists($path)) { $m->addAttachment($path); }
		}
		// Add inline images <img src="cid:img-name">
		foreach ($inline as $cid => $path) {
			if(file_exists($path)) { $m->AddEmbeddedImage($path, $cid, basename($path)); }
		}
		// Send
		if (!$m->send()) { return 0; }
		return 1;
	}
}
?>