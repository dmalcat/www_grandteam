<?php

if ($_POST["do_kod_add"]) {
	if (Kupon_3n::addKod($_POST["code"], $_POST["name"], $_POST["price"], $_POST["percent"], $_POST["valid_from"], $_POST["valid_to"], $_POST["count"], $_POST["visible"], $_POST["type"])) {
		$success_message = "Kód byl úspěšně vložen.";
	} else {
		$error_message = "Při vkládání kódu došlo k chybě.";
	}
}
if ($_POST["do_kod_delete"]) {
	if (Kupon_3n::deleteKod($_POST["id"])) {
		$success_message = "Kód byl úspěšně smazán.";
	} else {
		$error_message = "Při mazání kódu došlo k chybě. Pravděpodobně byl již použit";
	}
}
if ($_POST["do_kod_edit"]) {
	if (Kupon_3n::editKod($_POST["id"], $_POST["code"], $_POST["name"], $_POST["price"], $_POST["percent"], $_POST["valid_from"], $_POST["valid_to"], $_POST["count"], $_POST["visible"], $_POST["type"])) {
		$success_message = "Kód byl úspěšně upraven.";
	} else {
		$error_message = "Při úpravě kódu došlo k chybě.";
	}
}


$pKupony = Kupon_3n::getAll();
//print_p($_POST);
//print_p($pKupony);

$SMARTY->assign("pKupony", $pKupony);
?>