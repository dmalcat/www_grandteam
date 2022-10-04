<?php

$id_prodejna = $_REQUEST["id_prodejna"]; // uz by to nikde nemelo byt, ale preventivne
if (!$id_prodejna) $id_prodejna = find_url_key_after("id_prodejna", "");  //  prodejnas




if ($id_prodejna) {
	$dbProdejna = dbProdejna::getById($id_prodejna);
}

if ($_POST["doProdejna"]) {
	unset($_POST["doProdejna"]);
	unset($_POST["id_prodejna"]);
	if ($dbProdejna) { //upravujeme
		$dbProdejna->edit($_POST);
		Message::success("Prodejna upravena", "/admin/prodejny");
	} else {
		$dbProdejna = dbProdejna::create($_POST);
		Message::success("Prodejna založena", "/admin/prodejny");
	}
}

$id_prodejna_to_delete = find_url_key_after("id_prodejna_to_delete", "");  //  mazeme

if ($_REQUEST["prodejna_do_insert"]) {
	$dbProdejnaInserted = dbProdejna::create(array($_POST));
	if ($dbProdejnaInserted) {
		header("Location: /admin/prodejny/id_prodejna/" . $dbProdejnaInserted->id);
		exit();
	} else {
		Message::error("Došlo k chybě při zakládání prodejny.");
	};
}
if ($id_prodejna_to_delete && is_numeric($id_prodejna_to_delete)) dbProdejna::delete($id_prodejna_to_delete);

$dbProdejny = dbProdejna::getAll();

$SMARTY->assign("dbProdejna", $dbProdejna);
$SMARTY->assign("dbProdejny", $dbProdejny);
?>