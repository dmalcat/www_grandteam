<?php

if($_POST['doGalleryAdd'] || $_POST['doGalleryAddEdit']) {
	$idGallery = dbGallery::add($_POST['name'], $_POST['name'], $_POST['annotation'], $_POST['descriptionPlain'] ? $_POST['descriptionPlain'] : $_POST['description'], $_POST['id_gallery_type'], '1', $_POST['id_gallery_template'] ? $_POST['id_gallery_template'] : dbGallery::TYPE_FILES, $_POST["id_category"], $_POST['datum'], $_POST['visible_from'], $_POST['visible_to']);
	if($idGallery) {
		if($_POST['doGalleryAddEdit']) {
			header("Location: /admin/editace_dokumentu/".$idGallery); exit();
		} else {
			header("Location: /admin/dokumenty/".$idGallery); exit();
		}
	} else {
		throw new Exception("Doslo k chybe pri vytvareni dokumentů");
	}
}

if($_POST["id"]) $idGallery = $_POST["id"];
if(!$idGallery) $idGallery = find_url_key_after('dokumenty');


if($_POST['doGalleryEdit'] && $idGallery) {
	$dbGAllery = dbGallery::getById($idGallery);
	$dbGAllery->edit($_POST['name'], $_POST['name'], $_POST['descriptionPlain'] ? $_POST['descriptionPlain'] : $_POST['description'], $_POST['id_gallery_type'], '1', $_POST['id_gallery_template'], $_POST["id_category"], $_POST['datum'], $_POST['visible_from'], $_POST['visible_to']);
}

if($_POST["doGalleryDelete"] && $idGallery) {
	if(dbGallery::delete($idGallery)) {
		header("Location: /admin/seznam_dokumentu");
		exit();
	} else {
		$error_message = "Došlo k problému při mazání dokumentu";
	}
}

if($idGallery) {
	$dbGAllery = dbGallery::getById($idGallery);
}

$SMARTY->assign('dbGallery', $dbGAllery);

?>