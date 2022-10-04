<?php
class Helper_Url
{
    /**
     * zakaz vytvareni instanci
     *
     */
    private function __construct()
    {}

    public static function getCurrentURL () {
        $pageURL = 'http';
        if( isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ){
            $pageURL .= "s";
        }
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"];
        if( $_SERVER["SERVER_PORT"] != "80" ){
            $pageURL .= ":" . $_SERVER["SERVER_PORT"];
        }
        $pageURL .= $_SERVER["REQUEST_URI"];
        return $pageURL;
    }
    
    static public function threat($url)
    {
        $url = trim($url);
        if (!preg_match('#^((https?|ftp)://)|(www)#', $url)) {
            $host  = (isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'');
            $proto = (isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=="off") ? 'https' : 'http';
            $port  = (isset($_SERVER['SERVER_PORT'])?$_SERVER['SERVER_PORT']:80);
            $uri   = $proto . '://' . $host;
            if ((('http' == $proto) && (80 != $port)) || (('https' == $proto) && (443 != $port))) {
                // do not append if HTTP_HOST already contains port
                if (strrchr($host, ':') === false) {
                    $uri .= ':' . $port;
                }
            }
            $url = $uri . '/' . trim($url, '/') . '/';
        }
        return $url;
    }
}