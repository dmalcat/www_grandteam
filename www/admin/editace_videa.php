<?php

$idGallery = find_url_key_after("editace_videa");
if ($idGallery) {
	$dbGallery = dbGallery::getById($idGallery);
//	print_p($dbGallery->getImages());
}
//print_p($_POST);
//print_p($_FILES);
//die();
if ($_FILES["video"]) {
//	$dbGallery->imageAdd(basename($_FILES['image']['name']), '', '', 100, 1);
//	Gallery_3n::image_edit($_REQUEST['idImage'], $_REQUEST["image"]["name"], $_REQUEST["image"]["description"], $_REQUEST["image"]["url"], $_REQUEST["image"]["priority"], $_REQUEST["image"]["visible"]);
	Gallery_3n::video_edit($_REQUEST['idImage'], $_REQUEST['video']["name"], $_REQUEST["description"], $_REQUEST["url"], $_REQUEST["priority"], $_REQUEST["visible"]);
//	$dbGallery->videoAdd(basename($_FILES['Filedata']['name']), '', '', 100, 1);
}

$SMARTY->assign('dbGallery', $dbGallery);
?>