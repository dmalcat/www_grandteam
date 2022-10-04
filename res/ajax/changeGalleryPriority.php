<?php

if (dbI::query("UPDATE s3n_content_category_map_gallery SET priority = %i WHERE id_content_map_gallery = %i", $_GET["priority"], $_GET["idMap"])->result()) {
	echo json_encode(array('type' => 'success'));
} else {
	echo json_encode(array('type' => 'error'));
}
?>
