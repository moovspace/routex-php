<?php
namespace App\Core\Curl;

/**
 * HttpHeader
 * curl -i -H "Authorization: Bearer token-123456" -H "Accept: application/json" -H "Content-Type: application/json" http://novo.xx
 * curl -H "Authorization: Bearer token-123456" -H "Accept: application/json" -H "Content-Type: application/json" http://novo.xx
 * curl -X GET
 */
class HttpHeader
{
    /**
     * Get header Authorization token
     *
     * @return string
     */
    static function BearerToken()
    {
        return trim(str_replace('Bearer', '', self::GetHeader()));
    }

    /**
     * Get request header
     *
     * @param string $name Header name
     * @return void
     */
    static function GetHeader($name = 'Authorization')
    {
        $arr = getallheaders();
        if(!empty($arr[$name]))
        {
            return $arr[$name];
        }
        return '';
    }
}