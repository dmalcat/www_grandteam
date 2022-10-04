<?php

	$res = dbGallery::searchFull($_GET['term']);
	$cnt = 0;
	foreach($res AS $dbGallery) {
		$retVal[$cnt]["id"] = $dbGallery->id;
		$retVal[$cnt]["value"] = '/admin/fotogalerie/'.$dbGallery->id;
		$retVal[$cnt]["label"] = $dbGallery->name;
		$cnt++;
	}

//echo implode('<br />', $retVal);
	echo json_encode($retVal);

?>
