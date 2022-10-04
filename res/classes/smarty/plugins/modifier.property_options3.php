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
function smarty_modifier_property_options3($prop_name, $id_object_type = 1) {
	$id_object_type = (int)$id_object_type;
	if (!$id_object_type) $id_object_type = 1;
	global $DB;
	$prop_type = $DB->getone("select prop_type from s3n_property WHERE prop_name = '$prop_name'");
	check($prop_type);

// 	print_r($id_object_type);

	$sql = "SELECT pe.id_enumeration, pe.display_value FROM s3n_property_enumeration pe, s3n_property p WHERE p.id_property = pe.id_property and p.prop_name = '$prop_name'";
	if ($id_object_type) $sql .= " AND (id_object_type = $id_object_type OR id_object_type is null)";
	$sql .= " order by priority DESC";
	$res = $DB->getassoc($sql);
	check($res);
	
// 	print_p($res,$id_object_type);

	if (count($res)) {
		if ($prop_type == "E_SELECT") $res[""] = "";
		ksort($res);
// 		print_p($res);
		return $res;
	} else {
		return false;
	}



	if ($array == null) return null;
	if (!is_array($array)) return $array;



	return $res;

}

?>
