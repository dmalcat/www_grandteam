<?php

//print_p($_POST);

if ($_REQUEST["id_map"]) {
	if ($_REQUEST["transport_map_payment_do_edit"]) $SHOP->transport_map_payment_edit($_REQUEST["id_map"], $_REQUEST["id_transport"], $_REQUEST["id_payment"], $_REQUEST["default"]);
	if ($_REQUEST["transport_map_payment_do_delete"]) $SHOP->transport_map_payment_delete($_REQUEST["id_map"]);
}
if ($_REQUEST["transport_map_payment_do_insert"]) $SHOP->transport_map_payment_add($_REQUEST["id_transport"], $_REQUEST["id_payment"], $_REQUEST["default"]);

$s_transports = $SHOP->get_transports_for_select();
$s_payments = $SHOP->get_payments_for_select();
$p_transport_map_payment = $SHOP->get_transport_map_payment();


$SMARTY->assign('s_transports', $s_transports);
$SMARTY->assign('s_payments', $s_payments);
$SMARTY->assign('p_transport_map_payment', $p_transport_map_payment);

?>