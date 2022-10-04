<?php
class Log_Decorator_Line implements Log_Decorator_Interface
{
    public function decorate($hash, $userId, $date, $title, $message, $type, $file, $line){
    	
        if($message instanceof Exception){
		    $message = $message->getMessage();
        }
        
        if(!is_string($message)){
            $message = print_r($message, 1);
        }

        $type = str_pad($type . ';', 10, ' ');
        $date = str_pad(date('Y-m-d H:i:s', $date). ';', 15, ' ');
        $domain = Registry::getDomain();
//        $message = "$hash;\t$domain\t$userId;\t$date\t$type\t$title;\t$message\n";
        $message = $domain."->".$userId."->".$type."->".$title."->".$message;
        
        
        return $message;
    }
}
