<?php

	$res = dbContentCategory::searchFull($_GET['term']);
	$cnt = 0;
	foreach($res AS $dbCC) {
		$menu = "clanek";
		if($dbCC->menu) $menu = "menu";
//		$retVal[] = '<a href="/admin/'.$menu.'/'.$dbCC->id.'" id="vyhledani_'.$dbCC->id.'">'.$dbCC->name.'</a>';
		$retVal[$cnt]["id"] = $dbCC->id;
		$retVal[$cnt]["value"] = '/admin/'.$menu.'/'.$dbCC->id;
		$retVal[$cnt]["url"] = $dbCC->getUrl();
		$retVal[$cnt]["label"] = $dbCC->name;
		$navigation = '';
		$pNavigation = $dbCC->getNavigation();
		foreach ((array)$pNavigation as $value) {
			$navigation .= $value->name . ' -> ';
		}
		$navigation = substr($navigation, 0, -3);
		$retVal[$cnt]["label"] = $navigation;
		$cnt++;
	}

//echo implode('<br />', $retVal);
	echo json_encode($retVal);

?>
