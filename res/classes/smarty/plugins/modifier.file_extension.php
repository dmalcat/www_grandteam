<?php
function smarty_modifier_file_extension($file,$images_path = null, $add_path = null){
// 	print_p(PROJECT_DIR.$images_path."/".$add_path."/".$file);

	$path_parts = pathinfo(PROJECT_DIR.$images_path."/".$add_path."/".$file);
	$extension = $path_parts['extension'];

	return strtolower($extension);

// 	if (is_file(PROJECT_DIR.$images_path."/".$add_path."/".$file)) return true;
// 	return false;
}
?>