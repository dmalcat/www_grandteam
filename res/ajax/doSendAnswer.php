<?php

if ($dbUser->id) {
	$dbDotaz = dbDotaz::getById($_POST["idDotaz"]);
	if($dbDotaz) {
		$dbDotaz->setAnswer($_POST["answer"]);
		$dbDotaz->setStatus(dbDotaz::STATUS_ANSWERED);
//		$m = new MailSend($dbDotaz->getOwner()->getPropertyValue("email"));
		$m = new MailSend($dbDotaz->from_email);
		$m->sendDotazSendAnswered($dbDotaz);
		echo "Odpověd byla uložena a odeslána";
	} else {
		throw new Exception("Nepodarilo se dohledat dotaz " . $_POST["idDotaz"]);
	}
} else {
	echo "Nejste přihlášen.";
}
?>