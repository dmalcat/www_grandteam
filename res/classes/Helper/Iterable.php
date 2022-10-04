<?php
class Helper_Iterable
{
    /**
     * zakaz vytvareni instanci
     *
     */
    private function __construct()
    {}

    /**
     * Pokud zadaná hodnota není pole převede ho na ní. Požívám často u SQL dotazů
     * Kdy múže být zadáno jedno nebo více id a ja použiju vždy 'id IN(' . implode(',', $pole . ')'
     * Protoze si promennou prevedu na pole
     * Převádí se i vnorene pole nebo stdTřídy
     *
     * @param mixed $data
     * @return array
     */
    static public function toArray ($data = array())
    {
    	if(!is_array($data) && !$data instanceof ArrayIterator ){
    	    $data = array($data);
    	}
        return $data;
    }
    
    static public function arrayPlusArray($array, $array2)
    {
        foreach ($array2 as $index => $value) {
            if(array_key_exists($index, $array)){
                if(is_array($value) && is_array($array[$index])){
                    $array[$index] = self::arrayPlusArray($array[$index], $value);
                }
            }else{
                $array[$index] = $value;
            }
        }
        return $array;
    }
}
