<?php

//print_p($_POST);
//die();

if($_POST['doGalleryAdd'] || $_POST['doGalleryAddEdit']) {
	$idGallery = dbGallery::add($_POST['name'], $_POST['name'], $_POST["annotation"], $_POST['descriptionPlain'] ? $_POST['descriptionPlain'] : $_POST['description'], $_POST['id_gallery_type'], '1', $_POST['id_gallery_template'], $_POST["id_category"], $_POST['datum'], $_POST['visible_from'], $_POST['visible_to']);
	if($idGallery) {
		if($_POST['doGalleryAddEdit']) {
			header("Location: /admin/editace_fotogalerie/".$idGallery); exit();
		} else {
			header("Location: /admin/fotogalerie/".$idGallery); exit();
		}
	} else {
		throw new Exception("Doslo k chybe pri vytvareni fotogalerie");
	}
}

if($_POST["id"]) $idGallery = $_POST["id"];
if(!$idGallery) $idGallery = find_url_key_after('fotogalerie');


if($_POST['doGalleryEdit'] && $idGallery) {
	$dbGAllery = dbGallery::getById($idGallery);
	$dbGAllery->edit($_POST['name'], $_POST['name'], $_POST["annotation"], $_POST['descriptionPlain'] ? $_POST['descriptionPlain'] : $_POST['description'], $_POST['id_gallery_type'], '1', $_POST['id_gallery_template'], $_POST["id_category"], $_POST['datum'], $_POST['visible_from'], $_POST['visible_to']);
	if(isset($_POST["id_parent"])) {
		$dbGAllery->setParent($_POST["id_parent"]);
	}
	Message::success("Galerie byla upravena.", "/admin/fotogalerie/" . $idGallery) ;

}

if($_POST["doGalleryDelete"] && $idGallery) {
	if(dbGallery::delete($idGallery)) {
		header("Location: /admin/seznam_fotogalerii");
		exit();
	} else {
		$error_message = "Došlo k problému při mazání fotogalerie";
	}
}

if($idGallery) {
	$dbGAllery = dbGallery::getById($idGallery);
//	print_p($dbGAllery);
}

//FB::info($dbGAllery,"dbGallery");
$SMARTY->assign('dbGallery', $dbGAllery);
?>