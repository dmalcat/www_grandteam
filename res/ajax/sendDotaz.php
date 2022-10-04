<?php

/* @var $dbUser dbUser */

//print_p($_GET);
//die();
//print_p($_GET["recipient"]);
if ($dbUser || true) {
	$dbDotaz = dbDotaz::create(array(
				"id_user" => $dbUser->id,
				"id_editor" => $_GET["recipient"],
				"from_email" => $_GET["email"],
//				"to_email" => dbContentCategory::getById($_GET["recipient"])->external_url,	
				"to_email" => dbDotaz::getSendTo(),
				"text" => $_GET["text"],
	));
	if ($dbDotaz) {
		$dbDotaz->send();
		$res = array("type" => "success", "value" => "Váš dotaz byl odeslán.");
	} else {
		$res = array("type" => "error", "value" => "Došlo k problému při odeslání dotazu.");
	}
} else {
	$res = array("type" => "error", "value" => "Pro odeslání dotazu je třeba se přihlásit.");
}

echo json_encode($res);
exit();
?>