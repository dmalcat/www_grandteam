<?php
class Log_Writer_Sms extends Log_Writer_Abstract
{
    protected $_recipients = array();
    
    public function __construct(Config $config) {
        foreach (explode('|', $config->recipients) as $recipient) {
            list($msisdn, $operatorId) = explode(';', $recipient);
            $this->_recipients[] = array($msisdn, $operator);
        }
    }
    
    public function log($hash, $userId, $date, $title, $message, $type, $file, $line){
    	require_once PROJECT_DIR . "res/classes/Unserializer.php";
		require_once PROJECT_DIR . "res/classes/CSMSConnect.php";
        $message = $this->getDecorator()->decorate($hash, $userId, $date, $title, $message, $type, $file, $line);
    	    
        foreach ($this->_recipients as $recipient) {
            list($msisdn, $operator) = $recipient;
			if($msisdn) {
				
				$sms = new CSMSConnect();
				$res = $sms->Create(SMSBRANA_LOGIN,SMSBRANA_PASS_HASH,2); // inicializace a prihlaseni login, heslo, typ zabezpeceni
				$pAnswer = $sms->Send_SMS($msisdn, mb_substr($message, 0, 160, 'UTF-8'));
				
				$sms->Logout();
				if($pAnswer["err"] == 0) {
					$success_message = "SMS Úspěšně odeslána !<br/>Cena sms: ".$pAnswer["price"]." Kč <br/>Odeslaných sms: ".$pAnswer["sms_count"]." <br/>Zbývá kredit: ".$pAnswer["credit"]." ";
				} else {
					
					throw new Exception("Došlo k chybě při odeslání sms. SMS neodeslána.<br/>Kontaktujtesprávce. Číslo chyby: ".$pAnswer["err"]);
				}
			} else {
				throw new Exception("Není uveden tel. kontakt. SMS neodeslána.");
			}
		}
//            Ps::SendSMS($operator, $msisdn, mb_substr($message, 0, 160, 'UTF-8'));
	
    }
}