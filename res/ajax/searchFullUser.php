<?php

	$res = dbUser::searchFull($_GET['term']);
	$cnt = 0;
	foreach($res AS $dbUser) {
		$retVal[$cnt]["id"] = $dbUser->id;
		$retVal[$cnt]["value"] = '/admin/uzivatele/id_user/'.$dbUser->id;
		$retVal[$cnt]["label"] = $dbUser->login . " ( " . $dbUser->getPropertyValue("firma") ." " . $dbUser->getPropertyValue('jmeno') ." " .$dbUser->getPropertyValue('prijmeni'). " )";
		$cnt++;
	}

//echo implode('<br />', $retVal);
	echo json_encode($retVal);

?>
