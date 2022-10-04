<?php

$APP = new App($_GET["vin"]);
echo json_encode($APP->checkVin());
