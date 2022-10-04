<?php

	if(dbGallery::getById($_GET['idGallery'])->changeGalleryPosition($_GET['position'])) {
		echo json_encode(array('type' =>'success'));
	} else {
		echo json_encode(array('type' =>'error'));
	}
?>
