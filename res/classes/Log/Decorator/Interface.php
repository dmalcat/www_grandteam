<?php
interface Log_Decorator_Interface
{
    public function decorate($hash, $userId, $date, $title, $message, $type, $file, $line);
}
