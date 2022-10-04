<?php

if ($_GET['idContentCategory']) {
	if (Content_3n::setContentCategoryHP($_GET['idContentCategory'], $_GET['state'])) {
		echo json_encode(array("type" => "success", "value" => "Článek označen."));
	} else {
		echo json_encode(array("type" => "error", "value" => "Došlo k chybě při označení článku."));
	}
}
?>
