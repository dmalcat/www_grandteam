<?php

if ($_REQUEST["id_transport"]) {
	if ($_REQUEST["transport_do_edit"])
		$SHOP->transport_edit($_REQUEST["id_transport"], $_REQUEST["name"], $_REQUEST["price"], $_REQUEST["id_dph"], $_REQUEST["visible"], $_REQUEST["free_after"], $_REQUEST["description"]);
	if ($_REQUEST["transport_do_delete"])
		$SHOP->transport_delete($_REQUEST["id_transport"], $_REQUEST["name"], $_REQUEST["price"], $_REQUEST["id_dph"], $_REQUEST["visible"]);
}
if ($_REQUEST["transport_do_insert"])
	$SHOP->transport_add($_REQUEST["name"], $_REQUEST["price"], $_REQUEST["id_dph"], $_REQUEST["visible"], $_REQUEST["free_after"], $SHOP->getLanguage());


$s_dph = $SHOP->get_dph_for_select();
$p_transports = $SHOP->get_transports();

/* @var $SMARTY Smarty */
$SMARTY->assign('s_dph', $s_dph);
$SMARTY->assign('p_transports', $p_transports);
?>