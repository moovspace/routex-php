### Image manipulation
```php
use App\Core\Img\Image;

$img = new Image();
// Resize and save
$img->Load('media/img/img.png')->ResizeImage(50,0)->Save('/tmp/img-save.jpg');
// Resize and show image
$img->Load('media/img/error.jpg')->ResizeImage(400,0)->Show('png');
// Crop
$img->Load('media/img/error.jpg')->Crop(50,50,0,0)->Show('png');
```

### Download
```php
<?php
use App\Core\Img\Download;

try{
	// Set download speed
	$d = new Download(1);

	// Allow only with extensions
	// $d->AddExtension('jpg');
	// $d->AddExtension('png');
	// $d->AddExtension('route');

	// Download from browser
	$d->DownloadFile("route/user-route.route");

}catch(Exception $e){
	echo $e->getMessage() .' '. $e->getCode();
}
```

### Upload api
```sh
# Upload
curl -i -H "Authorization: Bearer password" -F 'file=@/var/www/html/domain.xx/media/img.jpg' http://domain.xx
```