<?php
	$dbGallery = dbGallery::getById($_GET['idGallery']);
	switch ($_GET['direction']) {
		case 'up':
			$res = $dbGallery->sortImageUp($_GET['idGalleryImage']);
			break;
		case 'down':
			$res = $dbGallery->sortImageDown($_GET['idGalleryImage']);
			break;
	}
	echo json_encode($res);
?>
