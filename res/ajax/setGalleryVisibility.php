<?php

$dbGallery = dbGallery::getById($_GET['idGallery']);
return $dbGallery->setVisibility($_GET['visible']);
?>
