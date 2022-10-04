<?php

if (dbCategory::getById($_POST["idCategory"])->FileDelete($_POST["fileIndex"])) {
	echo json_encode(array("type" => "success", "value" => "Soubor smazán."));
} else {
	echo json_encode(array("type" => "error", "value" => "Došlo k chybě při mazání souboru."));
}
?>