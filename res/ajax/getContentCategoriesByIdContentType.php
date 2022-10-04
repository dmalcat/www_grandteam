<?php
	$idContentType = $_REQUEST["id"];
	$CONTENT = new Content_3n($DB, "cs", "s3n_");
	$CONTENT->set_content_type($idContentType);

	$pContentCategories = $CONTENT->get_content_categories($only_parents = false, $only_visible = false, null);
	echo json_encode($pContentCategories)
?>
