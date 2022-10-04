<?php

/* @var $dbEshop dbEshop */
/* @var $dbCC dbContentCategory */
/* @var $dbCCs dbContentCategory|array */

if (($dbCC || count($dbCCs))) { // textova stranka, nebo seznam clanku
    if (file_exists(PROJECT_DIR . 'templates/pages/' . $dbCC->seoname . '.tpl')) {
        $page_content = "pages/" . $dbCC->seoname . '.tpl';
        $dbCCs = dbContentCategory::getAllRecursively(1, $dbCC->id)->sort('id_parent');
    } else {
        $page_content = "content/content.tpl";
    }
    $meta_title = $dbCC->name . " | " . Registry::getDomainName();
    $meta_keywords = $dbCC->name . " | " . Registry::getDomainName();
    $meta_description = $dbCC->name . " | " . Registry::getDomainName();
} else { // homepage nebo shop
    if ((ENABLE_SHOP && ( $p_category_selected || $search_condition || $p_items_result || $p_item) && $par_1 != "home")) { // eshop
        if ($p_item) { // shop detail
            $meta_title = $p_item["nazev"]["PROP_VALUE"] . " | " . Registry::getDomainName();
            $meta_description = $p_item["nazev"]["PROP_VALUE"] . "," . $p_item["funkce"]["PROP_VALUE"];
            $meta_keywords = str_replace(" ", " ", html_entity_decode($p_item["nazev"]["PROP_VALUE"] . ", " . $p_main_categories[$selected_category_id]->meta_keywords, ENT_COMPAT, "UTF-8"));
            $page_content = "detail.tpl";
        } else {// shop list
            // 			$meta_title = $p_category_names[$final_category_id]->meta_title ? $p_category_names[$final_category_id]->meta_title : $p_category_names[$final_category_id];
            $meta_title = $p_category_names[$final_category_id] . " | " . Registry::getDomainName();
            $meta_description = $p_main_categories[$selected_category_id]->meta_description;
            $meta_keywords = $p_main_categories[$selected_category_id]->meta_keywords;
            $page_content = "list.tpl";
        }
    } else { //homepage
        $meta_title = $dbEshop->meta_title . " | " . Registry::getDomainName();
        $meta_description = $dbEshop->meta_description . " - " . Registry::getDomainName();
        $meta_keywords = $dbEshop->meta_keywords . " ," . Registry::getDomainName();
        if (FORCE_HOMEPAGE OR ! $template && false) { // v kazdem pripade pro homepage budeme pouzivat homepage.tpl
            $page_content = "homepage/homepage.tpl";
        } else {
            $page_content = "content/" . $template;
        }
        $pTop = dbContentCategory::getHomepage(TRUE, 3, $excludeIdCt);
    }
}
include(PROJECT_DIR . "res/display.php");
?>
