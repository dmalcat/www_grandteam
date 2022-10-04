<?php
class Log_Decorator_SmsOrders implements Log_Decorator_Interface
{
    public function decorate($hash, $userId, $date, $title, $message, $type, $file, $line)
    {
		$text = str_pad(date("d.m.Y H:i:s", $date) . ": ", 22) . $title . "\n";
		$text .= str_pad('', 30, '-') ."\n";
		foreach ($message as $name => $value){
			if(is_array($value) || is_object($value)){
				$value = print_r($value, 1);
			}
			$text .= $name . ': ' . $value . "\n";
		}
		$text .= "\n";
		return $text;
    }
}
