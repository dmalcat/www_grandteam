<?php

if (isset($_POST["doAddEmail"])) {
	if (dbI::query("SELECT email FROM s3n_emails WHERE email = %s", $_POST["email"])->fetchSingle()) {
		Message::error("Tento email je již registrován.");
	} else {
		dbI::query("INSERT INTO s3n_emails (jmeno, email, `date`) VALUES (%s, %s, NOW())", $_POST["jmeno"], $_POST["email"])->insert();
		$m = new MailSend("info@3nicom.cz");
		$m->sendEmailRegistered($_POST["jmeno"], $_POST["email"]);
		Message::success("Váš email byl zařazen do databáze. Děkujeme", "");
	}
}

?>