<?php
class Log_Decorator_Sms implements Log_Decorator_Interface
{
    public function decorate($hash, $userId, $date, $title, $message, $type, $file, $line)
    {
        if($message instanceof Exception){
		    $message = $message->getMessage();
        }elseif(is_object($message)){
            $message = (array)$message;
        }
        
        if(is_array($message)){
            $temp = array();
            foreach ($message as $index => $value) {
                $temp[] = $index . '=>' . $value;
            }
            $message = '(' . implode(',', $temp) . ')';
        }

        $date = str_pad(date('Y-m-d H:i:s', $date). ';', 15, ' ');
        $message = "$hash;$date;$title;$message;";
        
        return $message;
    }
}
