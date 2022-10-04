<?php

if (dbCalendar::getById($_POST["idCalendar"])->ImageDelete()) {
	echo json_encode(array("type" => "success", "value" => "Obrázek smazán."));
} else {
	echo json_encode(array("type" => "error", "value" => "Došlo k chybě při mazání obrázku."));
}
?>