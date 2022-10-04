<?php
class Helper_Curl
{
    protected $_options = array();
    
    protected $_defaultOptions = array(
                                    CURLOPT_POST => 1,
                                    CURLOPT_RETURNTRANSFER => true,     // return web page
                                    CURLOPT_HEADER         => false,    // don't return headers
                                    CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                                    CURLOPT_ENCODING       => "",       // handle all encodings
                                    CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                                    CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                                    CURLOPT_TIMEOUT        => 120,      // timeout on response
                                    CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
                                );
    
    protected $_url = null;
    
    protected $_execResult = null;
    
    public function __construct($url){
        $this->_url = $url;
    }
    
    public function setPostData(array $post = array()){
        $this->_options[CURLOPT_POSTFIELDS] = http_build_query($post);
    }
    
    public function setOptions(array $options = array()){
        $this->_options = $options;
    }
    
    /**
     * @param string $url
     * @param array $post
     * @param array $options
     * @return string
     */
    public function getContent() {
        if($this->_execResult == null){
            $this->doExec();
        }
        return $this->_execResult['content'];
    }
    
    public function getHttpCode() {
        if($this->_execResult == null){
            $this->doExec();
        }
        return $this->_execResult['httpCode'];
    }
    
    public function doExec(){
        $exec = array();
        $ch      = curl_init( $this->_url );
        curl_setopt_array( $ch, $this->_options + $this->_defaultOptions );
        $exec['content'] = curl_exec( $ch );
        $exec['httpCode']  = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        $this->_execResult = $exec;
    }
}
