<?php

/* @var $dbUser dbUser */

if ($dbUser->isAdmin() || $dbUser->isAllowed("UZIVATELE")) {
	$dbUserTmp = dbUser::getById($_GET["idUser"]);
	if ($dbUserTmp && $dbUserTmp->setEnabled($_GET["state"])) {
		$res = array("type" => "success", "value" => "Uživatel byl aktivován.");
		if ($_GET["state"]) {
			$m = new MailSend($dbUserTmp->getPropertyValue("email"));
			$m->sendRegistraceConfirm();
		}
	} else {
		$res = array("type" => "error", "value" => "Došlo k problému aktivaci uživatele.");
	}
} else {
	$res = array("type" => "error", "value" => "Nedostatecne opravneni pro aktivovani uzivatele.");
}
echo json_encode($res);
exit();
?>