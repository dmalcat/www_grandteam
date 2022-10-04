<?php
class Log_Decorator_Text implements Log_Decorator_Interface
{
    public function decorate($hash, $userId, $date, $title, $message, $type, $file, $line)
    {
        if($message instanceof Exception){
            $exception = $message;
            $message = '';
            while ($exception){
                $line = $exception->getLine();
                $file = $exception->getFile();
                $trace = $exception->getTraceAsString();
                $exceptionMessage = $exception->getMessage();
    		    $message .= "\nException \n-------------\n Message: $exceptionMessage \nFile: $file \nLine: $line \nTrace:\n $trace \n";
    		    
    		    $exception = $exception->getPrevious();
            }
        }
        
        if(!is_string($message)){
            $message = print_r($message, 1);
        }
        
        $text = str_pad('', 60, '-') . "\n";
        $text .= "Hash: $hash \n";
        $text .= "Time: ". date("d.m.Y H:i:s", $date) . "\n";
        $text .= "Title: $title \n";
        $text .= "Message:\n";
        $text .= "$message \n";
        $text .= "----------\n";
		$text .= "Type: $type \n";
		$text .= "User: $userId \n";
		$text .= "IP: {$_SERVER["REMOTE_ADDR"]} \n";
		$text .= "URL: " . Helper_Url::getCurrentURL() . "\n";
		
		$text .= "Konfigurace:\n";
		foreach(Registry::getConfig()->getSelected() as $index => $value){
		    $text .= "\t\t" . $index . " => " . $value . "\n";
		}
		
		$text .= "Dump:\n";
		$text .= "GET:\n";
		$text .= print_r($_GET,  1);
		$text .= "\n";
		$text .= "POST:\n";
		$text .= print_r($_POST,  1);
		$text .= "\n";
		$text .= "SESSION:\n";
		$text .= print_r($_SESSION,  1);
		$text .= "\n";
		return $text;
    }
}
