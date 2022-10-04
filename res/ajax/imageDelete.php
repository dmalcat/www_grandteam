<?php
	if(Gallery_3n::image_delete($_POST["idImage"], $_POST['name'], $_POST['description'], $_POST['url'], $_POST['priority'], $_POST['visible'] == "true" ? true : false)) {
		echo json_encode(array("type" => "success", "value" => "Úspěšně smazáno."));
	} else {
		echo json_encode(array("type" => "error", "value" => "Došlo k chybě při mazání fotografie."));
	}

?>
