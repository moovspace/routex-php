<?php
namespace App\Core\Img;

use Exception;

class Upload
{
    protected $Ip = [];
    protected $AllowedExt = ['jpg','png','gif'];
    protected $Dir = 'files';
    protected $Pass = '';
    protected $AttrFile = 'file';
    protected $MaxSize = 50000; // bajtów - 50kb

    function __construct(string $pass = 'password', array $ip = ['127.0.0.1'], string $attr_file = 'file')
    {
        // Init
        $this->Ip = (array) $ip;
        $this->Pass = $pass;
        $this->AttrFile = $attr_file;

        // Validate
        $this->IsValidIp();
        $this->IsValidPass();
    }

    function Dir($name = 'files')
    {
        $this->Dir = $name;
    }

    function MaxSizeMb($mb)
    {
        $this->MaxSize = ((int) $mb * (1024 * 1024)) + 50000;
    }

    function FileExt(array $arr)
    {
        $this->AllowedExt = $arr;
    }

    protected function IsValidExt($ext)
    {
        if(!in_array($ext, $this->AllowedExt))
        {
            throw new Exception("ERR_FILE_EXT", 1);
        }
    }

    protected function IsValidIp()
    {
        if(!in_array($_SERVER['REMOTE_ADDR'], $this->Ip))
        {
            throw new Exception("ERR_USER_IP", 1);
        }
    }

    protected function IsValidPass()
    {
        if($this->GetToken() != $this->Pass)
        {
            throw new Exception("ERR_USER_PASS", 1);
        }
    }

    protected function GetHeader($name = 'Authorization')
    {
        $arr = getallheaders();
        if(!empty($arr[$name]))
        {
            return $arr[$name];
        }
        return '';
    }

    function GetToken()
    {
        return trim(str_replace('Bearer', '', self::GetHeader()));
    }

    function Upload()
    {
        if($_FILES[$this->AttrFile]['size'] > $this->MaxSize)
        {
            throw new Exception("ERR_FILE_SIZE", 1);
        }

        if(!empty($_FILES[$this->AttrFile]))
        {
            // print_r($_FILES);

            if($_FILES[$this->AttrFile]['error'] == 0)
            {
                $date = date('Y-m-d-H', time());
                $dir = 'media/'.$this->Dir.'/'.$date;
                @mkdir($dir, 0777, true);

                if(is_dir($dir))
                {
                    $ext = pathinfo($_FILES[$this->AttrFile]['name'], PATHINFO_EXTENSION);
                    $dest = $dir.'/'.uniqid().'.'.$ext;
                    // Test extension
                    $this->IsValidExt($ext);
                    // Upload
                    $ok = move_uploaded_file($_FILES[$this->AttrFile]['tmp_name'], $dest);
                    if($ok > 0)
                    {
                        return $dest;
                    }
                }
            }
        }

        throw new Exception("ERR_FILE_UPLOAD", 1);
    }
}

/*
# Upload
curl -i -H "Authorization: Bearer password" -F 'file=@/var/www/html/domain.xx/media/img.jpg' http://domain.xx

# Post Json
curl -i -X POST -d '{"key1":"value1", "key2":"value2"}' -H "Authorization: Bearer token-777" -H "Accept: application/json" -H "Content-Type: application/json" http://domain.xx

# Post Json no headers
curl -X POST -d '{"key1":"value1", "key2":"value2"}' -H "Authorization: Bearer token-123456" -H "Accept: application/json" -H "Content-Type: application/json" http://domain.xx

# Get
curl -X GET http://domain.xx?id=777
*/