<?php

	$res = dbContentCategory::searchFull($_GET['term']);
	$cnt = 0;
	foreach($res AS $dbCC) {
		$menu = "clanek";
		if($dbCC->menu) $menu = "menu";
//		$retVal[] = '<a href="/admin/'.$menu.'/'.$dbCC->id.'" id="vyhledani_'.$dbCC->id.'">'.$dbCC->name.'</a>';
		$retVal[$cnt]["id"] = $dbCC->id;
		$retVal[$cnt]["value"] = $dbCC->url;
		$retVal[$cnt]["label"] = $dbCC->name;
		$cnt++;
	}

//echo implode('<br />', $retVal);
	echo json_encode($retVal);

?>
