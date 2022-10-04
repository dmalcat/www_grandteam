<?php
class Log_Writer_Db extends Log_Writer_Abstract
{

    public function __construct(Config $config) {
    }
    
    public function log($hash, $userId, $date, $title, $message, $type, $file, $line) {
    }
}