<?php


if(dbContentCategory::getById($_GET['idContentCategory'])->mapGallery($_GET['idGAllery'], $_GET['priority'], $_GET['position'])) {
	echo json_encode(array("type" => "success"));
} else {
	echo json_encode(array("type" => "error"));
}

?>
