<?php

// 	$CONTENT->set_content_type(4);$CONTENT->limit = null;	// jak na
// 	$p_jak_na = $CONTENT->get_content_categories($only_parents = true, $only_visible = true, $id_parent = 6, $remove_categories = false, $only_categories = true);

if ($_REQUEST["search_full"]) {
    Session::set('needle', $_REQUEST["search_full"]);
    header('Location: /hledat');
}

$needle = Session::get('needle');

if ($needle) {
    $p_search_results["content"] = $CONTENT->search_content(utf2ascii($needle), $id_parent = null, $p_fields = null, true, dbContentCategory::getLang()->id);
} else {
    unset($p_search_results);
}



$SMARTY->assign("p_search_results", $p_search_results);
$SMARTY->assign('needle', $needle);

$page_content = "hledat/hledat.tpl";
include(PROJECT_DIR . "res/display.php");
?>