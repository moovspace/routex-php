<?php
namespace App\Core\Img;

use Exception;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine;

class Image
{
    protected $Path = '';
    protected $Extension = '';
    protected $RawImage = null;
    protected $Size = null;

    function Load($path)
    {
        // Path
        $this->Path = $path;
        // File
        $this->Extension = $this->FileExtension($this->Path);
        // Image
        $image = new Imagine();
        $this->RawImage = $image->open($this->Path);
        // Size
        $this->Size = $this->RawImage->getSize();

        return $this;
    }

    function FileExists($path)
    {
        if(!file_exists($path))
        {
            throw new Exception("ERR_FILE_PATH", 1);
        }
    }

    function FileExtension($path)
    {
        $this->FileExists($path);

        return pathinfo($path, PATHINFO_EXTENSION);
    }

    function ResizeImage(int $width, int $height = 0)
    {
        // Image width
        $ratio = $width / $this->Size->getWidth();

        // Auto resize
        if($height == 0)
        {
            $height = $ratio * $this->Size->getHeight();
        }

        $this->RawImage->resize(new Box($width, $height), ImageInterface::FILTER_LANCZOS);

        return $this;
    }

    function Crop($width, $height, $start_width = 0, $start_height = 0)
    {
        $this->RawImage->crop(new Point($start_width, $start_height), new Box($width, $height));

        return $this;
    }

    function Save($path, $flatten = true)
    {
		if($flatten) {
			$this->RawImage->save($path, array('flatten' => true));
		}else {
			$this->RawImage->save($path, array('flatten' => false));
		}

        return $this;
    }

    function Show($type = 'jpg')
    {
        ob_end_clean();

        if($type == 'png' || $type == 'gif' || $type == 'webp')
        {
            $this->RawImage->show($type);
        }
        else
        {
            $this->RawImage->show('jpg');
        }
    }

    function SaveQualityPng($path, $quality = 9)
    {
        if($quality < 0 || $quality > 9)
        {
            $quality = 9;
        }
        $this->RawImage->save($path, array('png_compression_level' => $quality, 'flatten' => false)); // from 0 to 9
    }

    function SaveQualityJpg($path, $quality  = 100)
    {
        if($quality < 0 || $quality > 100)
        {
            $quality = 100;
        }
        $this->RawImage->save($path, array('jpeg_quality' => $quality, 'flatten' => false)); // from 0 to 100
    }
}

/*
use App\Core\Img\Image;

$img = new Image();
// Resize and save
$img->Load('media/img/img.png')->ResizeImage(50,0)->Save('/tmp/img-save.jpg');
// Resize and show image
$img->Load('media/img/error.jpg')->ResizeImage(400,0)->Show('png');
// Crop
$img->Load('media/img/error.jpg')->Crop(50,50,0,0)->Show('png');
*/