<?php
function smarty_modifier_exists($file,$images_path = null, $add_path = null){
// 	print_p(PROJECT_DIR.$images_path."/".$add_path."/".$file);
	if (is_file(PROJECT_DIR.$images_path."/".$add_path."/".$file)) return true;
	return false;
}
?>