<?php

if (dbContentCategory::getById($_GET['idContentCategory'])->videoDelete($_GET['index'])) {
	echo json_encode(array('type' => 'success', 'value' => 'Video smazáno.'));
} else {
	echo json_encode(array('type' => 'error', 'value' => 'Došlo k chybě při mazání videa'));
}
?>
