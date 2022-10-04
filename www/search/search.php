<?php

$pResult = dbContentCategory::search($_GET["znacka"], $_GET["model"], $_GET["motor"], $_GET["provedeni"], $_GET["rok_from"], $_GET["rok_to"], $_GET["fulltext"], $_GET["idCT"]);
//print_p($pResult);
$SMARTY->assign("pResult", $pResult);
$page_content = "pages/search.tpl";
include(PROJECT_DIR . "res/display.php");
