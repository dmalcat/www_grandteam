<?php
class Log_Writer_Firebug extends Log_Writer_Abstract
{
    static $_index = 0;
    
    static protected $_fireLogs = array();
    
    public function __construct(Config $config)
    {
    }
    
    public function log($hash, $userId, $date, $title, $message, $type, $file, $line) {
        $fireLogs = self::$_fireLogs;
        $currentLevel = &$fireLogs;
        
        if(!$title){
            $title = 'default';
        }

        $explode = explode('->', $title);
        
        foreach ($explode as $index => $path) {
            if(!array_key_exists($path, $currentLevel)){
                $currentLevel[$path]['messages'] = array();
                $currentLevel[$path]['sub'] = array();
            }
                
            if($index == count($explode) - 1){
                $currentLevel = &$currentLevel[$path];
            }else{
                $currentLevel = &$currentLevel[$path]['sub'];
            }
        }
        
        $currentLevel['messages'][] = array($type, $message, $file, $line);
        self::$_fireLogs = $fireLogs;
        
    }
    
    static public function flush()
    {
// 	    header('X-Wf-Protocol-log: http://meta.wildfirehq.org/Protocol/JsonStream/0.2');
//         header('X-Wf-log-Plugin-1: http://meta.firephp.org/Wildfire/Plugin/FirePHP/Library-FirePHPCore/0.2.0');
//         header('X-Wf-log-Structure-1: http://meta.firephp.org/Wildfire/Structure/FirePHP/FirebugConsole/0.1');
// 		self::_printFireLogs(self::$_fireLogs);
    }
    
    static protected function _printFireLogs($array)
    {
        foreach ($array as $label => $item) {
		    self::_addHeader(array(array('Type' => 'GROUP_START', 'Label' => $label, 'Collapsed' => self::_isImportant($item) ? '' : 'true')));
		    foreach ($item['messages'] as $message) {
		        list($type, $text, $file, $line) = $message;
	            if($text instanceof Exception){
	                $exception = $text;
	                $trace = array();
	                foreach ($exception->getTrace() as $temp) {
	                    $trace[] = array(
	                                'file' => isset($temp['file']) ? $temp['file'] : '',
	                                'line' => isset($temp['line']) ? $temp['line'] : '',
	                                'function' => isset($temp['function']) ? $temp['function'] : '',
	                               );
	                }
	                $info = array( "Class" => "Exception", 'Message' => $exception->getMessage(), 'File' => $exception->getFile(), "Line" => $exception->getLine(), "Type" => "throw", 'Trace' => $trace);
	                self::_addHeader(array(array('Type' => 'EXCEPTION'), $info));
	            }else{
        		    switch ($type){
        		        case Log::TYPE_DEBUG: $type = 'LOG'; break;
        		        case Log::TYPE_INFO: $type = 'INFO'; break;
        		        case Log::TYPE_WARNING: $type = 'WARN'; break;
        		        case Log::TYPE_ERROR: $type = 'ERROR'; break;
        		    }
        		    self::_addHeader(array(array('Type' => $type , 'Label' => '', 'File' => $file, 'Line' => $line), $text));
	            }
	    		
		    }
	        self::_printFireLogs($item['sub']);
	        self::_addHeader(array(array("Type" => "GROUP_END")));
		}
    }
    
    static protected function _addHeader($string)
    {
        static $i = 0;
        $i++;
        $string = json_encode($string);
        $string = mb_substr($string, 0, 4990, 'UTF-8');
        header("X-Wf-log-1-1-$i: |$string|");
    }
    
    static protected function _isImportant($item)
    {
        foreach ($item['messages'] as $message) {
	        list($type, $text) = $message;
		    switch ($type){
		        case Log::TYPE_WARNING:
		        case Log::TYPE_ERROR:
		                return true;
		            break;
		    }
	    }
	    if(isset($item['sub'])){
	        foreach ($item['sub'] as $subItem) {
                $sub = self::_isImportant($subItem);
                if($sub){
                    return true;
                }
	        }
	    }
	    return false;
    }
    
}