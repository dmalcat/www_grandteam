<?php

foreach ($_GET["data"] as $row) {
    $name = str_replace('[]', '', $row["name"]);
    $data[$name][] = $row["value"];
}
foreach ($data as $key => $value) {
    if (in_array($_GET["idCT"], array(7, 8))) {
        dbContentCategory::setFilterCt($_GET["idCT"]);
    }
    dbContentCategory::setFilter($key, $value);
}
//print_p($data);


$filtr = dbContentCategory::getParamValues();
//$filtr["znacka"] = $CM->getZnacky();
//$filtr["model"] = $CM->getModely();
//$filtr["motor"] = $CM->getMotor();
//$filtr["provedeni"] = $CM->getProvedeni();

echo json_encode($filtr);

//print_p($filtr);
//print_p($CM);
