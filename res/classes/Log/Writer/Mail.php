<?php
class Log_Writer_Mail extends Log_Writer_Abstract
{
    protected $_recipinets = array();
    
    protected $_from = '';
    
    protected $_subject = null;
    
    public function __construct(Config $config)
    {
        $this->_recipinets = explode('|', $config->recipients);
        $this->_from = $config->from;
        if($config->decorator){
            $this->_decorator = $config->decorator;
        }
        // pokud je v configu nastaveny subject napriklad vyjimky, tak vkladat
        if($config->subject){
            $this->_subject = $config->subject;
        }
    }
    
    public function log($hash, $userId, $date, $title, $message, $type, $file, $line)
    {
        $message = $this->getDecorator()->decorate($hash, $userId, $date, $title, $message, $type, $file, $line);
        
        foreach ($this->_recipinets as $recipient) {
            if($recipient){
                $email = new PHPMailerLite();
                $email->CharSet = "utf-8";
                $email->SetFrom($this->_from);
    			$email->Subject = ($this->_subject ? $this->_subject : $title) ." ". Registry::getDomain();
    			$email->AddAddress($recipient);
    			$email->MsgHTML($message);
			    $email->Send();
            }
        }
        
    }
}