<?php

if (isset($_POST["search_full"])) {
	$_SESSION["search_full"] = $_POST["search_full"];
}
$_POST["search_full"] = $_SESSION["search_full"];
$p_search_results = dbContentCategory::searchFull($_POST["search_full"])->page();


$SMARTY->assign("p_search_results", $p_search_results);


$page_content = "hledat/hledat.tpl";
include(PROJECT_DIR . "res/display.php");
?>