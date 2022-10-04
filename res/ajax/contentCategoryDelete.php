<?php
	$CONTENT = new Content_3n($DB);
	if($_POST['idContentCategory']) {

		if($CONTENT->content_category_delete($_POST['idContentCategory'])) {
			echo json_encode(array("type" => "success", "value" => "Článek smazán."));
		} else {
			echo json_encode(array("type" => "error", "value" => "Došlo k chybě při mazání článku."));
		}
	}
?>