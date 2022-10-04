<?php

$constanty = json_decode($_POST['produkty']);
if(count($constanty) > 1) {
	foreach ((array)$constanty as $constant) {
		dbConstant::setById($constant->id, $constant->value);
	}
} else {
	dbConstant::setById($constanty->id, $constanty->value);
}


foreach (dbConstant::getAll() as $constant) {
	$res[] = array('id' => $constant->id_constant, 'name' => $constant->name, 'value' => $constant->value);
}
echo json_encode(array('success' => true, 'message' => 'Ok', 'produkty' => $constanty));

?>
