<?php
abstract class Log_Writer_Abstract
{
    /**
     * Pole uz vytvorenych dekoratoru
     *
     * @var array
     */
	static protected $_decorators = array();

    /**
     * Konkretni dekorator
     * @var string
     */
    protected $_decorator = 'Line';
    
    abstract public function __construct(Config $config);
    
    abstract public function log($hash, $userId, $date, $title, $message, $type, $file, $line);
    
    protected function getDecorator() {
    	
        // pokud je nazev retezec, tak dekorator jeste nebyl prirazen do teto instance
        if (is_string($this->_decorator)) {
            // zjistim jestli uz nebyl dekorator nekdy pouzity
            // pokud ne tak ho vytvorim a ulozim do staticke promenne
            if (! array_key_exists($this->_decorator, self::$_decorators)) {
                $decoratorName = 'Log_Decorator_' . ucfirst($this->_decorator);
                self::$_decorators[$this->_decorator] = new $decoratorName();
            }
            // priradim do teto tridy dekorator podle jmena
            $this->_decorator = self::$_decorators[$this->_decorator];
        }
        return $this->_decorator;
    }

}