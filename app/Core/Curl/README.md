### Include composer library in php
```php
// Import CurlClient class
use App\Core\Curl\CurlClient;
// Errors
use Exception;
```

### How to send json data with CurlClient
```Php
try
{
    // Init Curl
    $curl = new CurlClient();

    // Host
    $curl->AddUrl("https://router.xx/api.php");

    // Method POST (default method GET)
    $curl->SetMethod("POST");

    // Send as Json string
    $curl->SetJson();

    // Add token (optional)
    $curl->AddToken('token-hash-here-123');

    // Data
    $curl->AddData("username","Max");
    $curl->AddData("email","ho@email.xx");

    // Force ssl
    $curl->SetAllowSelfsigned();

    // Send data and get response
    echo $curl->Send();

    // Errors
    // echo $curl->Error;

    // Status code
    // echo $curl->StatusCode

}
catch(Exception $e)
{
    echo $e->getMessage();
}
?>
```

### How to send data and upload files with CurlClient
```Php
try
{
    // Init Curl
    $curl = new CurlClient();

    // Host
    $curl->AddUrl("https://router.xx/api.php");

    // Method POST
    $curl->SetMethod("POST");

    // Some data (optional)
    $curl->AddData("user_id","777");

    // Add files
    $curl->AddFile("/path/to/img1.jpg");
    $curl->AddFile("/path/to/img2.jpg");

    // Send data and get response
    echo $curl->Send();
}
catch(Exception $e)
{
    echo $e->getMessage();
}
?>
```

### Get request header
Get Authorization header bearer token.
```php
<?php
use App\Core\Curl\HttpHeader;

try
{
    // Get request bearer token
    $token = HttpHeader::BearerToken();
}
catch(Exception $e)
{
    echo $e->getMessage();
}
?>
```