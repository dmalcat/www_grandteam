<?php

if (dbContentCategory::getById($_POST["idContentCategory"])->ImageDelete($_POST["imageIndex"])) {
	echo json_encode(array("type" => "success", "value" => "Obrázek smazán."));
} else {
	echo json_encode(array("type" => "error", "value" => "Došlo k chybě při mazání obrázku."));
}
?>