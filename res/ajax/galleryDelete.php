<?php

if (dbGallery::delete($_POST['idGallery'])) {
	echo json_encode(array('type' => 'success', 'value' => 'galerie byla smazána'));
} else {
	echo json_encode(array('type' => 'error', 'value' => 'Došlo k chybě při mazání galerie'));
}
?>
