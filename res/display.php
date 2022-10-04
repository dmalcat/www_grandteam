<?php

	require_once(PROJECT_DIR."res/smarty_assign.php");
//	FB::setEnabled(true);
	if($_GET['page']) {
		Header( "HTTP/1.1 301 Moved Permanently" );
		Header( "Location: /" ); 
		$page = '';
		exit();
	}
	$SMARTY->display($page ? $page : "main.tpl");
 	require "done.php";

//	echo '<div style="clear: both">&nbsp;</div>';
//	print_p($SMARTY->getTemplateVars(), 'Smarty Variables');

?>