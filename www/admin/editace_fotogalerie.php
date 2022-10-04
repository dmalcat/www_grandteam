<?php

$idGallery = find_url_key_after("editace_fotogalerie");
if ($idGallery) {
	$dbGallery = dbGallery::getById($idGallery);
//	$dbGallery->sortImages();
//	$dbGallery->sortDown(121);
}

if ($_FILES["image"]) {
//	$dbGallery->imageAdd(basename($_FILES['image']['name']), '', '', 100, 1);
	Gallery_3n::image_edit($_REQUEST['idImage'], $_REQUEST["image"]["name"], $_REQUEST["image"]["description"], $_REQUEST["image"]["url"], $_REQUEST["image"]["priority"], $_REQUEST["image"]["visible"]);
}


$SMARTY->assign('dbGallery', $dbGallery);
//	print_p($pGallery->IMAGES);
?>