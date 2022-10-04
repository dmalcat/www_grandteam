<?php

/**
 * Smarty plugin
 * 
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty ternary modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     ternary<br>
 * Purpose:  ternary if
 * 
 * @link 
 * @author leos
 * @param true value $ 
 * @param false value $ 
 * @return string 
 */
function smarty_modifier_if($bool, $string_true, $string_false) {
	return $bool ? $string_true : $string_false;
}

?>