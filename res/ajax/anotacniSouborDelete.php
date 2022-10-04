<?php

if (dbContentCategory::getById($_POST["idContentCategory"])->FileDelete($_POST["fileIndex"])) {
	echo json_encode(array("type" => "success", "value" => "Soubor smazán."));
} else {
	echo json_encode(array("type" => "error", "value" => "Došlo k chybě při mazání souboru."));
}
?>