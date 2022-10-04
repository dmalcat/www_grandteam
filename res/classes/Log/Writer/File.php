<?php
class Log_Writer_File extends Log_Writer_Abstract
{
    protected $_paths = array();
    
    /**
     * pri prvnim lognuti udela lajnu, aby bylo poznat kde konci jeden prubeh
     * @var bool
     */
    protected static $_openFiles = array();
    
    public function __construct(Config $config)
    {
        if(!$config->path){
            throw new Exception('Chybi parametr path');
        }
        foreach (explode('|', $config->path) as $path) {
            if($path){
                $this->_paths[] = PROJECT_DIR . Registry::getConfig()->log->fileBaseDir . $path;
            }
        }
        if($config->decorator){
            $this->_decorator = $config->decorator;
        }
    }
    
    public function log($hash, $userId, $date, $title, $message, $type, $file, $line)
    {
        $text = $this->getDecorator()->decorate($hash, $userId, $date, $title, $message, $type, $file, $line);
        
        foreach ($this->_paths as $path) {
            if(false !== strpos($path, '%date%')){
                $path = str_replace('%date%', date("Y-m-d"), $path);
            }
            $pos = strrpos($path, '/');
            $dir = substr($path, 0, $pos + 1);
            $file = substr($path, $pos + 1);
            
            $path = realpath($dir) . "/" . $file;
            
            if(!isset(self::$_openFiles[$path])){
                self::$_openFiles[$path] = 1;
                $f = fopen($path, 'a');
                chmod($path, 0777);
                fwrite($f, "\n" . str_pad('', 80, '*') .  "\n\n");
                fclose($f);
            }
            
            $f = fopen($path, 'a');
            fwrite($f, $text);
            fclose($f);
        }
    }

}