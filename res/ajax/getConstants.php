<?php



foreach (dbConstant::getAll() as $constant) {
	$res[] = array('id' => $constant->id_constant, 'name' => $constant->name, 'value' => $constant->value);
}
//print_p($res);

	echo json_encode(array(
		'success' => true,
		'celkem' => count($res),
		'produkty' => $res
	));

?>