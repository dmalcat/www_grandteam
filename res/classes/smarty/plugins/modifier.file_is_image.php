<?php
function smarty_modifier_file_is_image($file,$images_path = null, $add_path = null){
// 	print_p(PROJECT_DIR.$images_path."/".$add_path."/".$file);

	$path_parts = pathinfo(PROJECT_DIR.$images_path."/".$add_path."/".$file);
	$extension = $path_parts['extension'];

	$image_extensions = array("jpg","gif","jpeg","bmp");
	if (in_array(strtolower($extension), $image_extensions)) {
		return true;
	} else {
		return false;
	}

	return $extension;

// 	if (is_file(PROJECT_DIR.$images_path."/".$add_path."/".$file)) return true;
// 	return false;
}
?>