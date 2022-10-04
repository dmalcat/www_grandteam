<?

class Log_Rule_ExcludeTestUsers extends Log_Rule_Abstract{

    /**
     * (non-PHPdoc)
     * @see Log_Rule_Abstract::isAllowed()
     */
    public function isAllowed(){
        $session = Registry::getSession();
        if($session->id_user){
            // zabbix, zabbix@wooky.cz
            $excludedIds = array(294, 150220);
            if(in_array($session->id_user, $excludedIds)){
                return false;
            }
            return true;
        }
        
        return true;
    }

}