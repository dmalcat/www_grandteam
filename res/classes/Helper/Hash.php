<?php
class Helper_Hash
{
    const RANDOM_CHARACTER_SMALL_LETTERS = 0;
    const RANDOM_CHARACTER_LARGE_LETTERS = 1;
    const RANDOM_CHARACTER_NUMBERS = 2;

    /**
     * Vrati nahodny znak
     * pokud je promenna $vcetneCisel == true vybira se i z cisel
     *
     * @param bool $vcetneCisel
     * @return string
     */
    static public function getRandomChar($sets = null)
    {
		$selected = array();
		if($sets == null){
			$sets = array(
			           self::RANDOM_CHARACTER_SMALL_LETTERS,
			           self::RANDOM_CHARACTER_LARGE_LETTERS,
			           self::RANDOM_CHARACTER_NUMBERS,
			        );
		}
		$sets = (array)$sets;
		foreach($sets as $set) {
			switch($set){
				case self::RANDOM_CHARACTER_SMALL_LETTERS:
					$selected[] = array(
					               "a", "b", "c", "d", "e", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"
					             );
					break;
				case self::RANDOM_CHARACTER_LARGE_LETTERS:
					$selected[] = array(
					               "A", "B", "C", "D", "E", "F", "G", "H", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
				                 );
					break;
				case self::RANDOM_CHARACTER_NUMBERS:
					$selected[] = array(
					               "1", "2", "3", "4", "5", "6", "7", "8", "9", "0"
				                 );
					break;
			}
		}

    	$temp = array();
    	foreach ($selected as $set) {
    		$temp = array_merge($temp, $set);
    	}
    	if(count($temp) < 1){
    		return "";
    	}

        $x = mt_rand(0, count($temp)-1);
        return $temp[$x];
    }

    /**
     * Vrati retezec sestaveny z pismen a cisel o zadane delce
     *
     * @param int $delka
     * @return string
     */
    static public function getRandomString($length = 0, $sets = null)
    {
        $ret = '';
        for ($i = 0; $i < $length; $i++){
            $ret .= self::getRandomChar($sets);
        }
        return $ret;
    }
}