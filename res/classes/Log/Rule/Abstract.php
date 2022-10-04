<?php
abstract class Log_Rule_Abstract
{
    /**
     * @return bool
     */
    abstract public function isAllowed();
}