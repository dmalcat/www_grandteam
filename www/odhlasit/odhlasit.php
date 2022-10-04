<?php

if($par_2) {
	$email = trim($par_2);
	$idEmail = dbI::query("SELECT id FROM s3n_emails WHERE email = %s", $email)->fetchSingle();
	if($idEmail) {
		dbI::query("DELETE FROM s3n_emails WHERE email = %s", $email)->result();
		Message::success("Váš email byl z databáze odstraněn.", "/");
	} else {
		Message::error("Uvedený email nebyl v databázi nalezen.", "/");
	}
}


require_once PROJECT_DIR . 'res/display.php';

?>