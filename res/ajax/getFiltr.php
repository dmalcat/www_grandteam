<?php

$CM = new Filter();

foreach ($_POST["data"] as $row) {
    $name = str_replace('[]', '', $row["name"]);
    $data[$name][] = $row["value"];
}


if ($data["znacka"]) {
    $CM->setZnacka($data["znacka"]);
}
if ($data["model"]) {
    $CM->setModel($data["model"]);
}
if ($data["rok_from"][0]) {
    $CM->setRokFrom($data["rok_from"][0]);
}
if ($data["rok_to"][0]) {
    $CM->setRokTo($data["rok_to"][0]);
}
if ($data["price_from"][0]) {
    $CM->setPriceFrom($data["price_from"][0]);
}
if ($data["price_to"][0]) {
    $CM->setPriceTo($data["price_to"][0]);
}


$filtr = array();
$filtr["znacka"] = $CM->getZnacky();
$filtr["model"] = $CM->getModely();
$filtr["cars"] = $CM->getCarsCount();
$filtr["rok"]["from"] = $CM->getRokFrom();
$filtr["rok"]["to"] = $CM->getRokTo();
$filtr["price"]["from"] = $CM->getPriceFrom();
$filtr["price"]["to"] = $CM->getPriceTo();

echo json_encode($filtr);

//print_p($filtr);
//print_p($CM);
