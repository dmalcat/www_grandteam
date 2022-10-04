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
function smarty_modifier_enum_values($array)
{
	//print_p($array);
	if ($array == null) return null;
	
	if (!is_array($array)) return $array;

	foreach($array AS $key=>$item) {
		$result[] = $item["id_enumeration"];
	}
	if (count($array) == 1) {
		return	$result[0];	//radio atd
	} else {
			//print_p($result);
    		return $result;
	}
}

?>
