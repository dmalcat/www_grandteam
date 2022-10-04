<?php

//print_p($_POST);

if ($dbUser->id) {
	$dbDotaz = dbDotaz::getById($_POST["idDotaz"]);
	if($dbDotaz) {
		$dbDotaz->setAnswer($_POST["answer"]);
		$dbDotaz->setStatus(dbDotaz::STATUS_DEFFERED);
		$m = new MailSend(DOTAZ_EMAIL_ANSWERED_INFO);
		$m->sendDotazAnswered($dbDotaz);
		echo "Odpověd byla uložena";
	} else {
		throw new Exception("Nepodarilo se dohledat dotaz " . $_POST["idDotaz"]);
	}
} else {
	echo "Nejste přihlášen.";
}
?>