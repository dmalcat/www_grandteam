<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty translate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     lower<br>
 * Purpose:  translates string from global $lang array
 * @link http://smarty.php.net/manual/en/language.modifier.lower.php
 *          lower (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param subarray
 * @return string
 */
function smarty_modifier_translate($string,$subarray = "text") {
    	global $lang;
	if ($lang[$subarray][$string]) {
		return $lang[$subarray][$string];
	} else {
    		return $string;
	}
}

?>
