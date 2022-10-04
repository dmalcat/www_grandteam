<?php
/**
 * Trida pro logovani

 * @author jhajek
 * @see http://wiki.mobilbonus.cz/doku.php?id=rajknih:dokumentace:log
 */
class Log
{
    const TYPE_DEBUG = 'debug';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';
    
    /**
     * @var Config
     */
    static protected $_config = null;

    /**
     * @var array of Log_Provider
     */
    static protected $_providers = array();

    /**
     * Inicializace logovani
     *
     * @param Config $config
     */
    static public function init(Config $config)
    {
        self::$_config = $config;
    }
 
    /**
     *
     *
     * @param string $name
     * @return Log_Provider
     * @throws Exception
     */
    static public function getProvider($name)
    {
        // pokud provider s prislusnym jmenem pouzit, tak vo vytvorim a ulozim pro dalsi pouziti
        if(!isset(self::$_providers[$name])){
            if(self::$_config->provider){
                foreach (self::$_config->provider as $providerName => $writers) {
                    if($providerName == $name){
                        self::$_providers[$name] = new Log_Provider($writers, $providerName);
                        break;
                    }
                }
            }
        }
        if(isset(self::$_providers[$name])){
            return self::$_providers[$name];
        }
        return null;
    }
    
    /**
     * Pomocna funkce,
     * Pouzije providera 'debug'
     *
     * @param string $message
     * @param string $title
     * @param string $type
     */
    static public function debug($message, $title = null, $type = self::TYPE_DEBUG)
    {
        $provider = self::getProvider('debug');
        if($provider){
            $provider->log($message, $title, $type);
        }
    }
    
    /**
     * Vypise do hlavicky data pripravena pro firebug
     */
    static public function flushFirebug()
    {
        Log_Writer_Firebug::flush();
    }
}
