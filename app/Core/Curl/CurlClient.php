<?php
namespace App\Core\Curl;
use Exception;
use CurlFile;

/**
 * CurlClient
 * Send get, post, json, files, request with/without tls/ssl
 */
class CurlClient
{
    protected $Curl;
    protected $Port = 0;
    protected $Url = "localhost";
    protected $Method = "GET";
    protected $Timeout = 60;
    protected $ConnectionTimeout = 10;
    protected $FollowLocation = true;
    protected $VerifySsl = true;
    protected $Json = false;
    protected $Headers = array();
    protected $Files = array();
    protected $Data = array();
    protected $Token = "";
    protected $InputFileName = "files";
    protected $Params = '';
    protected $Gzip = true;
    protected $Http2 = true;
    protected $Session = false;
    protected $ShowHeader = false;
    // Proxy
    protected $ProxyHost = "";
    protected $ProxyPort = "";
    protected $ProxyUser = "";
    protected $ProxyPass = "";

    /**
     * Init curl
     */
    function __construct(){
        $this->Curl = curl_init();
    }

    /**
     * Add port
     *
     * @param integer $port Port number
     * @return void
     */
    function AddPort($port = 0){
        if($port > 0){
            $this->Port = $port;
        }
    }

    /**
     * Add curl url
     *
     * @param string $url
     * @return void
     */
    function AddUrl($url = "localhost"){
        $this->Url = $url;
    }

    /**
     * Add header token
     * Authorization:
     * App-Key:
     *
     * @param string $token String value
     * @return void
     */
    function AddToken($token = ""){
        $this->Token = $token;
    }

    /**
     * Add header
     *
     * @param string $str Header string
     * @return void
     */
    function AddHeader($str){
        $this->Headers[] = $str;
    }

    /**
     * Add POST data
     *
     * @param string $name Name
     * @param string/array $value Value
     * @return void
     */
    function AddData($name, $value){
        if(!empty($name) && strlen($name) > 0){
            $this->Data[$name] = $value;
        }
    }

    /**
     * Add files to upload
     *
     * @param string $path Path to file
     * @return void
     */
    function AddFile($path){
        if(file_exists($path)){
            $this->Files[] = $path;
        }
    }

    /**
     * Enable session cookies
     *
     * @return void
     */
    function SetEnableSession(){
        $this->Session = true;
    }

    /**
     * Set curl method
     *
     * @param string $name Http request method: GET, POST, PUT, DELETE
     * @return void
     */
    function SetMethod($name = "GET"){
        $this->Method = "GET";
        if($name == "POST" || $name == "PUT" || $name == "DELETE"){
            $this->Method = $name;
        }
    }

    /**
     * Set send as json header
     *
     * @return void
     */
    function SetJson(){
        $this->Json = true;
    }

    /**
     * Disable http2 protocol
     *
     * @return void
     */
    function SetHttp1(){
        $this->Http2 = false;
    }

    /**
     * Disable gzip
     *
     * @return void
     */
    function SetDisableGzip(){
        $this->Gzip = false;
    }

    /**
     * Show headers
     *
     * @return void
     */
    function SetShowHeader(){
        $this->ShowHeader = true;
    }

    /**
     * Allow self signed
     *
     * @return void
     */
    function SetAllowSelfsigned(){
        $this->VerifySsl = false;
    }

    /**
     * Set upload form input file: name="", default: files
     *
     * @param string $name Input file name
     * @return void
     */
    function SetInputFileName($name){
        if(!empty($name) && strlen($name) > 0){
            $this->InputFileName = $name;
        }
    }

    /**
     * Enable proxy
     *
     * @param string $host Host
     * @param string $port Port
     * @param string $user Username
     * @param string $pass Password
     * @return void
     */
    function SetProxy($host = "", $port = "", $user = "", $pass = "")
    {
        $this->ProxyHost = $host;
        $this->ProxyPort = $port;
        $this->ProxyUser = $user;
        $this->ProxyPass = $pass;
    }

    /**
     * Send curl data
     *
     * @return void
     */
    function Send(){
        // Port
        if($this->Port > 0){
            curl_setopt($this->Curl, CURLOPT_PORT, $this->Port);
        }
        // GET url params
        if($this->Method == "GET"){
            $this->Params = http_build_query($this->Data);
            curl_setopt($this->Curl, CURLOPT_URL, $this->Url.'?'.$this->Params);
        }else{
            curl_setopt($this->Curl, CURLOPT_URL, $this->Url);
        }
        // Gzip encoding
        if($this->Gzip == true){
            curl_setopt($this->Curl, CURLOPT_ENCODING, 'gzip');
        }
        // Http2
        if($this->Http2 == true){
            curl_setopt($this->Curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        }
        // Show header
        if($this->ShowHeader == true){
            curl_setopt($this->Curl, CURLOPT_HEADER, true);
        }
        curl_setopt($this->Curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->Curl, CURLOPT_CUSTOMREQUEST, $this->Method);
        curl_setopt($this->Curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->Curl, CURLOPT_FOLLOWLOCATION, $this->FollowLocation);
        curl_setopt($this->Curl, CURLOPT_CONNECTTIMEOUT, $this->ConnectionTimeout);
        curl_setopt($this->Curl, CURLOPT_TIMEOUT, $this->Timeout);
        curl_setopt($this->Curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($this->Curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-GB; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)");

        // Proxy
        if (!empty($this->ProxyHost) && !empty($this->ProxyPort)) {
            curl_setopt($this->Curl, CURLOPT_PROXY, $this->ProxyHost.':'.$this->ProxyPort);
            if (!empty($this->ProxyUser) && !empty($this->ProxyPass)) {
                curl_setopt($this->Curl, CURLOPT_PROXYUSERPWD, $this->ProxyUser.':'.$this->ProxyPass);
            }
        }

        // Add files
        if($this->Method == "POST" && $this->Json == false){
            // Add files
            foreach ($this->Files as $k => $v) {
                $f = realpath($v);
                if(file_exists($f)){
                    $fc = new CurlFile($f, mime_content_type($f), basename($f));
                    // For -> $_FILES["files"];
                    $this->Data[$this->InputFileName."[".$k."]"] = $fc;
                }
            }
        }

        // Not GET
        if($this->Method != "GET"){
            curl_setopt($this->Curl, CURLOPT_POST, 1);

            // Json headers
            if($this->Json == true){
                curl_setopt($this->Curl, CURLOPT_POSTFIELDS, json_encode($this->Data));
                $this->Headers[] = 'Content-Type: application/json';
                $this->Headers[] = 'Content-Length: ' . strlen(json_encode($this->Data));
            }else{
                if(count($this->Files) > 0){
                    curl_setopt($this->Curl, CURLOPT_POSTFIELDS, $this->Data);
                }else{
                    curl_setopt($this->Curl, CURLOPT_POSTFIELDS, http_build_query($this->Data));
                    $this->Headers[] = 'Content-Type: application/x-www-form-urlencoded';
                }
            }
        }

        // Set token
        if(!empty($this->Token)){
            $this->Headers[] = 'Authorization: Bearer '.$this->Token;
            $this->Headers[] = 'App-Key: '.$this->Token;
        }

        // Add headers
        if(!empty($this->Headers)){
            curl_setopt($this->Curl, CURLOPT_HTTPHEADER, $this->Headers);
        }

        // Ssl/Tls
        if($this->VerifySsl == true){
	    curl_setopt($this->Curl, CURLOPT_SSL_VERIFYHOST, 2);
	    curl_setopt($this->Curl, CURLOPT_SSL_VERIFYPEER, 1);
        }else{
            curl_setopt($this->Curl, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($this->Curl, CURLOPT_SSL_VERIFYPEER, 0);
        }

        // Session
        if($this->Session){
            curl_setopt($this->Curl, CURLOPT_COOKIESESSION, true );
            curl_setopt($this->Curl, CURLOPT_COOKIEJAR, 'cookies.txt');
            curl_setopt($this->Curl, CURLOPT_COOKIEFILE, 'cookies.txt');
        }

        // Execute
        $this->Result = curl_exec($this->Curl);

        // Error code
        $this->StatusCode = curl_getinfo($this->Curl, CURLINFO_HTTP_CODE);

        // Error message
        if (curl_errno($this->Curl)) {
            $this->Error = curl_error($this->Curl);
            throw new Exception('CURL_ERROR '.$this->Error, $this->StatusCode);
        }
        curl_close($this->Curl);

        // Response
        return $this->Result;
    }
}
?>