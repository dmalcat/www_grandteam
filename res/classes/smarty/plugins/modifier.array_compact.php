<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty array compact plugin
 *
 * Type:     modifier<br>
 * Name:     array compact<br>
 * Purpose:  convert array with key to array without
 * @author   pulkrabek@3nicom.cz
 * @param array
 * @return array
 */
function smarty_modifier_array_compact($array,$add_emty = false)
{
// 	print_p($array);
	if ($add_emty) $result[0] = $add_emty;
	if (!is_array($array)) return null;
	foreach($array AS $key=>$item) {
		$keys = array_keys($item);
		//$result[$item["id_enumeration"]] = $item["value"];
		$result[$item[$keys[0]]] = $item[$keys[1]];
	}
    return $result;
}

?>
