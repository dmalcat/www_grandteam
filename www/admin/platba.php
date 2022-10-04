<?php


if ($_REQUEST["id_payment"]) {
	if ($_REQUEST["payment_do_edit"])
		$SHOP->payment_edit($_REQUEST["id_payment"], $_REQUEST["name"], $_REQUEST["description"], $_REQUEST["price"], $_REQUEST["account"], $_REQUEST["bank"], $_REQUEST["id_payment_type"], $_REQUEST["visible"]);
	if ($_REQUEST["payment_do_delete"])
		$SHOP->payment_delete($_REQUEST["id_payment"]);
}
if ($_POST["payment_do_insert"]) {
	$SHOP->payment_add($_REQUEST["name"], $_REQUEST["description"], $_REQUEST["price"], $_REQUEST["account"], $_REQUEST["bank"], $_REQUEST["id_payment_type"], $_REQUEST["visible"]);
}
	


$s_payment_types = $SHOP->get_payment_types_for_select();
$p_payments = $SHOP->get_payments();

/* @var $SMARTY Smarty */
$SMARTY->assign('s_payment_types', $s_payment_types);
$SMARTY->assign('p_payments', $p_payments);
?>