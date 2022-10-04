<?php

/* @var $dbUser dbUser */


if (dbContentCategory::getBySeoName($par_1)) {
    Session::set("selected_category", "");
    Session::set("search_condition", "");
    $selected_category = null;
    $id_content_type = $CONTENT->get_id_content_type_by_seoname($par_1);
    $p_tmp_content_type = $CONTENT->get_content_type_detail($id_content_type);
    for ($i = 1; $i <= CONTENT_DEEP; $i++) {
        if (dbContentCategory::getBySeoName(${"par_" . $i})) {
            $id_content_category = dbContentCategory::getBySeoName(${"par_" . $i})->id;
            $CONTENT->set_content_type($id_content_type);
            $p_content_selected[$p_tmp_content_type->seo_name][$i - 1] = $id_content_category;
        }
    }
}



$selected_id_content_category = $p_content_selected[$p_tmp_content_type->seo_name][count($p_content_selected[$p_tmp_content_type->seo_name]) - 1];
if (!$selected_id_content_category) {
//	$selected_id_content_category = reset(dbContentCategory::getHomepage())->id;
}

if ($selected_id_content_category) {
    $dbCC = dbContentCategory::getById($selected_id_content_category);
//    $dbCCs = dbContentCategory::getAllRecursively(1, $selected_id_content_category)->sort('id_parent');
    $dbC = $dbCC->getContent();
    $dbCT = $dbCC->getContentType(); // informace o vybranem menu
    $template = $p_content->template->template_tpl;
    if (!$template) {
        $template = "content.tpl";
    }
}

if ($_GET["p"]) {
    dbContentCategory::setPage($_GET["p"]);
//	$offset = $_GET["pg"] = 1;
//	$limit = dbArray::$parPage;
//	$SMARTY->assign("offset", $offset);
//	$SMARTY->assign("limit", $limit);
}
?>