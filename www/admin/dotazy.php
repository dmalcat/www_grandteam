<?php

/* @var $dbUser dbUser */

	if($dbUser->isAdmin()) {
		$pDotazy = dbDotaz::getAll();	
	} else {
		$pDotazy = dbDotaz::getByIdEditor($dbUser->id);	
	}
	
	$SMARTY->assign("pDotazy", $pDotazy);

?>