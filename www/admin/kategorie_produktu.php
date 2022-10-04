<?php

//print_p(dbCategory::getById(468)->getSubCategories());

$idCategory = find_url_key_after('kategorie_produktu');
if($idCategory) {
	$dbCategory = dbCategory::getById($idCategory);
}

require_once "HTTP/Upload.php";
$upload = new HTTP_Upload("en");
$file = $upload->getFiles("f");

if ($_REQUEST["category_main_do_insert"]) {
	if ($id_category_inserted = dbCategory::create($_REQUEST["name"], $_REQUEST["description"], $_REQUEST["description2"], $_REQUEST["category_tip"], $_REQUEST["parent_id"], $category_type, $_REQUEST["priority"], $_REQUEST["sleva"])) {
		$success_message = "Kategorie vložena";
	} else {
		$error_message = "Chyba při vkládání kategorie";
	}
}

if ($_REQUEST["category_main_do_edit"]) {
	if ($_REQUEST["parent_id"] AND is_array($_REQUEST["category_visible"])) {
		$dbParentCategory = dbCategory::getById($_REQUEST["parent_id"]);
		if ($dbParentCategory->visible) {
			$dbCategory->edit($_REQUEST["name"], $_REQUEST["name_sk"], $_REQUEST["name_de"], $_REQUEST["description"], $_REQUEST["description2"], $_REQUEST["category_tip"], $_REQUEST["parent_id"], is_array($_REQUEST["category_visible"]) ? 1 : 0, $_REQUEST["meta_description"], $_REQUEST["meta_keywords"], $_REQUEST["meta_title"], $_REQUEST["priority"], $_REQUEST["sleva"]);
		} else {
			$error_message = "Chyba při úpravě viditelnosti kategorie - nadřazená kategorie je skryta.";
		}
	} else {
		if ($dbCategory->edit($_REQUEST["name"], $_REQUEST["name_sk"], $_REQUEST["name_de"], $_REQUEST["description"], $_REQUEST["description2"], $_REQUEST["category_tip"], $_REQUEST["parent_id"], is_array($_REQUEST["category_visible"]) ? 1 : 0, $_REQUEST["meta_description"], $_REQUEST["meta_keywords"], $_REQUEST["meta_title"], $_REQUEST["priority"], $_REQUEST["sleva"])) {
			$success_message = "Kategorie upravena";
		} else {
			$error_message = "Chyba při úpravě kategorie";
		}
	}
}

if ($_REQUEST["category_main_do_delete"]) {
	if ($SHOP->category_main_delete($_REQUEST["id_category"])) {
		$success_message = "Kategorie smazána";
	} else {
		$error_message = "Chyba při mazání kategorie";
	}
}

$id_category_tmp = $_REQUEST["id_category"] ? $_REQUEST["id_category"] : $id_category_inserted;
if ($file->isValid() AND $_FILES["f"]["name"]) {
	$file->setName($id_category_tmp . "." . $file->getProp("ext"));
	$moved = $file->moveTo(PROJECT_DIR . "images_categories/");
	if (!PEAR::isError($moved)) {
		$SHOP->category_set_image($id_category_tmp, $id_category_tmp . "." . $file->getProp("ext"));
	} else {
		echo $moved->getMessage();
	}
} elseif ($file->isMissing()) {
	//echo "Chybí obrázek kategorie.";
} elseif ($file->isError()) {
	echo $file->errorMsg();
}

if ($_REQUEST["delete_category_image"]) {
	$dbCategory->delete();
}


if($idCategory) {	// radeji pro pripad, ze doslo k uprave
	$dbCategory = dbCategory::getById($idCategory);
}
$SMARTY->assign('dbCategory', $dbCategory);

?>