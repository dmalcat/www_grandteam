<?php


if($_GET["search"]) {
	$_GET["search"] = str_replace("flop", "", $_GET["search"]);
	echo json_encode(array("result" => dbI::query("SELECT CONCAT_WS(' ', prodejna, adresa) AS displayName, prodejny.* FROM prodejny WHERE (oznaceni LIKE '%".$_GET["search"]."%' OR prodejna LIKE '%".$_GET["search"]."%' OR adresa LIKE '%".$_GET["search"]."%') AND skupina = 'A' AND visible = 1 ")->fetchAll()));
}