### Send email
Send email with phpmailer with inline images.
```php
<?php
use Exception;
use App\Core\Mail\SendEmail;

try
{
	$ok = SendEmail::Send('email@here.to', 'Subject', '<html>Html message here</html>');

	// Attachments
	$ok = SendEmail::Send(
		'email@here.to',
		'Message subject',
		'<html><body> Html message here </body></html>',
		['/path/to/foto.png', '/path/to/invoice.pdf']
	);

	// Inline images
	$ok = SendEmail::Send(
		'email@here.to',
		'Message subject',
		'<html><body>
			Inline image <img src="cid:img1">
			Next inline image <img src="cid:img2">
		</body></html>',
		[],
		['img1' => '/path/to/image.png', 'img2' => '/path/to/image.jpg']
	);
}
catch(Exception $e)
{
	echo $e->getMessage();
}
?>
```