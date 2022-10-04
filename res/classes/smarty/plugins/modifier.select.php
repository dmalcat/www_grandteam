<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty array enum values
 *
 * Type:     modifier<br>
 * Name:     enum_values<br>
 * Purpose:  convert array with key array passable to smarty inputs
 * @author   pulkrabek@3nicom.cz
 * @param array
 * @return array | string
 */
function smarty_modifier_select($array, $value, $label, $empty = false) {
	if ($array == null) return null;
	$result = array();
	if($empty) $result[] = $empty;
	foreach($array AS $item) {
		$result[$item->$value] = $item->$label;
	}
	return $result;
}

?>
