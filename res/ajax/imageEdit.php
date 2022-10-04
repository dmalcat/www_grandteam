<?php
	if(Gallery_3n::image_edit($_POST["idImage"], $_POST['name'], $_POST['description'], $_POST['url'], $_POST['priority'], $_POST['visible'] == "true" ? true : false, $_POST['author'])) {
		echo json_encode(array("type" => "success", "value" => "Úpravy uloženy"));
	} else {
		echo json_encode(array("type" => "error", "value" => "Došlo k chybě při úpravěí fotografie."));
	}

?>
