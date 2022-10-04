<?php

if (count($_POST) && isset($_POST['edit'])) {
	foreach ($_POST['kurz'] as $idMeny => $kurz) {
		$SHOP->nastavKurzMeny($kurz, $idMeny);
	}
}

$meny = $SHOP->vratVsechnyMeny();
$SMARTY->assign('meny', $meny);
?>