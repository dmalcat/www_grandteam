<?php
class Log_Provider
{
    /**
     * @var string
     */
    protected $_name = null;

    /**
     * @var Config
     */
    protected $_config = array();

    /**
     * @var array of Log_Writer_Abstract
     */
    protected $_writers = array();
    
    public function __construct(Config $config, $name)
    {
        $this->_name = $name;
        $this->_config = $config;
    }
    
    /**
     * Pripravi dalsi potrebne udaje (cas, id uzivatele, hash)
     *
     * @param string|array|Exception $message
     * @param string $title
     * @param string $type
     */
    public function log($message, $title, $type = Log::TYPE_INFO) {
    	global $USER;
        $writers = array();
        // zavolam vsechny writery (sms, mail, ...) a predam do nich informaci
        foreach ($this->_getWritersByType($type) as $writer) {
            $writers[] = $writer;
        }
        
        
        if(count($writers)){
            $date = time();
            $userId = isset($USER->data["id_user"]) ? $USER->data["id_user"].":".$USER->data["username"] : "guest";
            // vytvori nahodny retezec dlouhy sest znaku
            // vytvoreny z malych pismen a cislic
            $hash = Helper_Hash::getRandomString(10, array(
                                                          Helper_Hash::RANDOM_CHARACTER_SMALL_LETTERS,
                                                          Helper_Hash::RANDOM_CHARACTER_NUMBERS
                                                 ));
            $backtrace = debug_backtrace();
            
            $file = null;
            $line = null;
            foreach ($backtrace as $trace) {
                if(isset($trace['class']) && $trace['class'] != 'Log_Provider'){
                    $file = isset($trace['file']) ? $trace['file'] : null;
                    $line = isset($trace['line']) ? $trace['line'] : null;
                    break;
                }
            }
            
            // zavolam vsechny writery (sms, mail, ...) a predam do nich informaci
            foreach ($writers as $writer) {
                $writer->log($hash, $userId, $date, $title, $message, $type, $file, $line);
            }
        }
    }
    
    /**
     * Podle typu (info, debug, error) vybere ktere writery (firebug, file, mail) se maji pouzit
     *
     * @param string $type konstanty z tridy Log
     * @return array of Log_Writer_Abstract
     */
    protected function _getWritersByType($type)
    {
        if(!isset($this->_writers[$type])){
            $createdWriters = array();
            
            foreach ($this->_config->toArray() as $config) {
                if(!$this->_isWriterAllowed($config, $type)){
                    continue;
                }
                $writerClassName = 'Log_Writer_' . ucfirst($config['writer']);
                $writer = new $writerClassName(new Config($config));
                if(!$writer instanceof Log_Writer_Abstract){
                    throw new Exception("Writer '$writerClassName' musi dedit od Log_Writer_Abstract");
                }
                $createdWriters[] = $writer;
            }
            
            $this->_writers[$type] = $createdWriters;
        }
        return $this->_writers[$type];
    }
    
    /**
     * @param string $writerName
     * @param string $config
     * @return bool
     */
    protected function _isWriterAllowed($config, $type){
        if(!isset($config['enabled']) || !$config['enabled']){
            return false;
        }
        
        if(!isset($config['type'])){
            return false;
        }
        
        
        if(!isset($config['writer'])){
            return false;
        }
        
        
        $types = explode('|', $config['type']);
        if( !in_array($type, $types) ){
            return false;
        }
        
        
        // pokud je zadan pocet logu za urcity cas, tak budu prohledavat cache
        if(isset($config['logsPerTime'])){
        	
            list($maxNumOfLogs, $interval) = explode(',', $config['logsPerTime']);
            $cacheName = $this->_name . '_' . $type . '_' . $config['writer'];
            
            // inicializace
            if(!Cache::get($cacheName)){
                Cache::set($cacheName, 1, (int)$interval);
                
            }
            
            // pokud jsem v danem intervalu, napr. 3600s vycerpal pocet lognuti, tak preskakuji
            $logCount = Cache::get($cacheName);
            if($logCount > $maxNumOfLogs){
                return false;
            }
            // pokud jeste muzu logovat, tak zvysim cache o 1 a vratim true
            Cache::increment($cacheName);
        }
        // pokud je zadan pocet logu za urcity cas, tak budu prohledavat cache
        if(isset($config['rules'])){
            $rules = explode('|', $config['rules']);
            
            foreach ($rules as $ruleName) {
                $ruleName = 'Log_Rule_' . ucfirst($ruleName);
                $rule = new $ruleName();
                if(!$rule instanceof Log_Rule_Abstract){
                    throw new Exception("Writer '$ruleName' musi dedit od Log_Writer_Abstract");
                }
                if(!$rule->isAllowed()){
                    return false;
                }
            }
            
        }
        return true;
    }
}