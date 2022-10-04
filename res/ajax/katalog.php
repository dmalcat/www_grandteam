<?php

$pKatalog = dbI::query("SELECT * FROM katalog WHERE nazev LIKE '%{$_GET["q"]}%' LIMIT 0,100")->fetchAll("dbKatalog");
echo json_encode(["data" => $pKatalog]);
