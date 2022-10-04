<?php


if ($_POST["hideTranslate"]) {
	Translate::hide($_POST['id']);
}

if ($_POST["doTranslate"]) {
	Translate::set($_POST['id'], $_POST['cs'], $_POST['sk'], $_POST['de']);
}

$SMARTY->assign('pTranslates', Translate::getAll(true));
?>
