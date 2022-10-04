<?php
//print_p($_FILES);
//print_p($_POST);
//die();
if ($_FILES["file"]) Gallery_3n::file_edit($_REQUEST['idImage'], $_REQUEST['file']["name"], $_REQUEST["description"], $_REQUEST["url"], $_REQUEST["priority"], $_REQUEST["visible"]);
//echo dbI::getLastSQL();

$idGallery = find_url_key_after("editace_dokumentu");
if ($idGallery) {
	$dbGallery = dbGallery::getById($idGallery);
	$dbGallery->sortImages();
}

if ($_FILES["file"]) {
//	$dbGallery->fileAdd(basename($_FILES['file']['name']), '', '', 100, 1);
}
//if ($_FILES["image"]) {
//	$dbGallery->fileAdd(basename($_FILES['image']['name']), '', '', 100, 1);
//}


//print_p($dbGallery->getImages(false));

$SMARTY->assign('dbGallery', $dbGallery);
?>