<?php
/**
 *
 * @author jhajek
 */
class Config implements IteratorAggregate
{
    protected $_sectionData = array();
    
    protected $_rawData = array();
    
    protected $_mergeDiff = array();
    
    protected $_selected = null;
    
    protected $_lock = true;
    
    /**
     * Vytvori konfiguracni soubor
     *
     * @param array|string $data pokud je string, pocitam s tim, ze je to cesta k souboru
     * @param string|array $selected vyber sekce napr. development
     */
    public function __construct ($data, $selected = null, $arrayOfFiles = false)
    {
        $this->_selected = (array)$selected;
        
        
        if($arrayOfFiles){
            $temp = array();
            foreach ($data as $file) {
                 $temp = Helper_Iterable::arrayPlusArray($this->_parseIniFile($file), $temp);
            }
            self::_processData($temp);
        }elseif(is_string($data)){
        	
            $data = $this->_parseIniFile($data);
            self::_processData($data);
        }elseif(is_array($data)){
            $this->_sectionData = $data;
        }else{
            throw new Exception("Nespravny typ dat pro vytvoreni configu");
        }
    }
    
    public function __get($name)
    {
        if(!array_key_exists($name, $this->_sectionData)){
            return null;
        }
        $data = $this->_sectionData[$name];
        if(is_array($data)){
            $clone = clone $this;
            $clone->setData($this->_sectionData[$name]);
            $this->_sectionData[$name] = $clone;
            return $clone;
        }else{
            return $data;
        }
    }
    
    public function __clone()
    {
        $this->_rawData = null;
    }
    
    public function lock(){
        $this->_lock = true;
    }
    
    public function unlock(){
        $this->_lock = false;
    }
    
    public function __set($name, $value)
    {
        if($this->_lock){
            throw new Exception('Do konfiguračního souboru není možné zapisovat');
        }
        $this->_sectionData[$name] = $value;
    }
    
    public function setData($data)
    {
        $this->_sectionData = $data;
    }
    
    public function toArray()
    {
        $return = array();
        foreach ($this->_sectionData as $name => $value) {
            if($value instanceof Config){
                $return[$name] = $value->toArray();
            }else{
                $return[$name] = $value;
            }
        }
        return $return;
    }
    
    public function getMergeDiff()
    {
        return $this->_mergeDiff;
    }
    
    
    public function getSelected()
    {
        return $this->_selected;
    }
    
    /**
     * Vrat iterator
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        $return = array();
        foreach ($this->_sectionData as $name => $value) {
            $return[$name] = $this->$name;
        }
        return new ArrayIterator($return);
    }
    
    /**
     * Prida dalsi konfiguracni soubor
     *
     * @param string $configPath
     */
    public function mergeFile($configPath, $logDiff = false)
    {
        if($this->_rawData){
            // nactu data ze souboru
            $newRawData = $this->_parseIniFile($configPath);
            
            if($logDiff){
                // udelam si rozdil oproti predchozi verzi
                $this->_mergeDiff = $this->_mergeConfigDiff($newRawData, $this->_rawData);
            }
            
            // spojim pole
            $mergeRawData = Helper_Iterable::arrayPlusArray($newRawData, $this->_rawData);
            
            self::_processData($mergeRawData);
        }else{
            throw new Exception('Spojit lze pouze hlavni konfiguracni soubor');
        }
    }
    
    /**
     * podle zadanych parametru, napr.
     * array(
     *		'default',
     *		'mode' => 'development',
     *		'section' => 'web',
     *		'defaultProvider',
     *		'provider' => 'rajknihcz',
     * )
     * vrati pole vsech konfiguracnich parametru
     *
     * @param array $params
     * @return array
     */
    static public function generateListOfParams($params){
        $config = new self(PROJECT_CONFIG_DIR . 'config.ini', $params);

        $config->mergeFile(PROJECT_CONFIG_DIR . 'brands.ini');
        $config->mergeFile(PROJECT_CONFIG_DIR . 'logs.ini');
        
        $return = self::_generateListOfParams($config->toArray(), '', array());
        ksort($return);
        return $return;
    }
    
    static protected function _generateListOfParams($config, $parentName, $return){
        foreach ($config as $name => $value) {
            $name = $parentName ? ($parentName . '->' . $name) : $name;
            if(is_array($value)){
                $return = self::_generateListOfParams($value, $name, $return);
            }else{
                $return[$name] = $value;
            }
        }
        return $return;
    }
    
    static public function getValuesForAllBrands($overrideConstructParams = array(), $requiredValues = array()){
        $bootstrapConfig = Registry::getBootstrapConfig();
        
        $brandConfigParams = array();
        
        foreach ($bootstrapConfig->providers as $providerName => $providerInfo) {
            $temp = array(
						'default',
                        'branch' => Registry::getGitBranchName(),
						'mode' => 'development',
						'section' => 'web',
						'defaultProvider',
						'provider' => $providerName,
                    );
           foreach ($overrideConstructParams  as $index => $value) {
               $temp[$index] = $value;
           }
           $brandConfigParams[] = $temp;
        }
        
        return self::getValuesByContstructSettings($brandConfigParams, $requiredValues);
    }
    
    /**
     * funkce pro porovnavani parametru, jako prvni se zadaji parametry pro vytvoreni configu
     * druhy parametr jsou pozadovane parametry
     *
     * takze, kdyz se jako prvni parametr daji konfigurace pro vsechny brandy a druhy bude array('idEshop')
     * tak vypise id eshopu pro vsechny brandy
     *
     * da se pouzit funkce getValuesForAllBrands ktera pripravi parametry pro vytvoreni configu za vas
     *
     * @param array $constructParams
     * @param array $requiredValues pole parametru, davat s . jako ini souboru
     * @return array
     */
    static public function getValuesByContstructSettings($constructParams = array(), $requiredValues = array()){
        $return = array();
        
        foreach ($constructParams as $params) {
            $config = new self(PROJECT_CONFIG_DIR . 'config.ini', $params);
            $config->mergeFile(PROJECT_CONFIG_DIR . 'brands.ini');
            $config->mergeFile(PROJECT_CONFIG_DIR . 'logs.ini');
            
            $paramsName = array();
            foreach ($params as $index => $value) {
                $paramsName[] = "$index:$value";
            }
            $paramsName =  implode('|', $paramsName);
            
            $return[$paramsName] = array();
            
            foreach ($requiredValues as $requiredValue) {
                $temp = $config;
                foreach (explode('.', $requiredValue) as $value) {
                    $temp = $temp->$value;
                }
                if($temp){
                    if($temp instanceof self){
                        $return[$paramsName][$requiredValue] = $temp->toArray();
                    }else{
                        $return[$paramsName][$requiredValue] = $temp;
                    }
                }else{
                    $return[$paramsName][$requiredValue] = '!!! nenalezeno !!!';
                }
            }
        }
        return $return;
    }
    
    /**
     * vrati pole ve kterem budou rozdily noveho a stareho nastaveni
     *
     * @param array $newArray
     * @param array $oldArray
     * @return array
     */
    protected function _mergeConfigDiff($newArray, $oldArray)
    {
        $return = array();
        foreach ($newArray as $index => $value) {
            if(!array_key_exists($index, $oldArray)){
                $return[$index] = $value;
            }else{
                $oldValue = $oldArray[$index];
                if(is_array($value) && is_array($oldValue)){
                    $return[$index] = $this->_mergeConfigDiff($value, $oldValue);
                }else{
                    $return[$index] = "$value ($oldValue)";
                }
            }
        }
        return $return;
    }
    
    protected function _processData($data){
        $this->_rawData = $data;
            
        $temp = array();
        
        foreach ( $data as $sectionName => $params ){
            $temp[$sectionName] = $this->_parseParams($params);
        }
        $data = $temp;
        $this->_saveSelected($data);
    }

    protected function _parseParams ($params)
    {
        $temp = array();
        foreach ($params as $name => $value) {
            $explode = explode('.', $name);
            $a = &$temp;
            foreach ($explode as $part) {
                if (isset($a[$part])) {
                    if (! is_array($a[$part])) {
                        throw new Exception('asd');
                    }
                } else {
                    $a[$part] = null;
                }
                $a = &$a[$part];
            }
            $a = $this->_threadValue($value);
            
        }
        return $temp;
    }

    protected function _threadValue ($value) {
        if( is_array($value) ){
            foreach ( $value as $index => $forValue ){
                $value[$index] = $this->_threadValue($forValue);
            }
        }else{
            if( is_numeric($value) ){
                if( intval($value) == $value ){
                    $value = (int) $value;
                }else{
                    $value = (float) $value;
                }
            }elseif( is_string($value) ){
                if( false !== strpos($value, '::') ){
                    $value = constant($value);
                }
            }
        }
        return $value;
    }
    
    protected function _saveSelected($data) {
    	
        $selected = $this->_selected;
        $sectionData = array();
        foreach ($selected as $index => $value) {
            
            // pokud bylo zadano array('bootstrap')
            // tak nazev sekce je bootstrap a jeji cast bude null
            // takze v configu nebude prefix napr. development.debug = 1, ale jen debug = 1
            if(is_integer($index)){
            	
                $sectionName = $value;
                $sectionPart = null;
            // pokud bylo zadano array('mode' => 'development')
            // tak nazev sekce bude mode a jeji cast bude development
            // takze v configu bude prefix napr. develompent.debug = 1
            }else{
            	
                $sectionName = $index;
                $sectionPart = $value;
            }
            
            if(!array_key_exists($sectionName, $data)){
                throw new Exception("Sekce '$sectionName' neexistuje");
            }
            $temp = array();

            if($sectionPart === null){
                $temp = Helper_Iterable::arrayPlusArray($data[$sectionName], $temp);
            }else{
                $temp = $this->_saveParam($data[$sectionName], $temp);
                if( array_key_exists("$sectionName:$value", $data) ){
                    $temp = $this->_saveParam($data["$sectionName:$value"], $temp);
                }
            }
            if(count($sectionData)){
                $sectionData = Helper_Iterable::arrayPlusArray($temp, $sectionData);
            }else{
                $sectionData = $temp;
            }
        }
        
        $this->_sectionData = $sectionData;
    }
    
    protected function _saveParam($data, $temp) {
        foreach ($data as $propertyName => $propertyValue) {
            $explode = explode(':', $propertyName);
            $propertyName = array_pop($explode);
            
            if($this->_isConstrainValid($explode)){
                $temp = Helper_Iterable::arrayPlusArray(array($propertyName => $propertyValue), $temp);
            }
        }
        return $temp;
    }
    
    protected function _isConstrainValid ($explode) {
        if(count($explode)) {
            foreach ( $explode as $item ){
                if(!in_array($item, $this->_selected)){
                    return false;
                }
            }
            return true;
        }
        return true;
    }
    
    
    protected function _parseIniFile($path){
        return parse_ini_file($path, true);
    }
}
